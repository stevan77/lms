<?php

namespace App\Http\Controllers;

use App\Models\CourseGrade;
use App\Models\Grade;
use App\Models\Message;
use App\Models\MessageDeletion;
use App\Models\MessageRead;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MessageController extends Controller
{
    public function inbox(Request $request): Response
    {
        $user = $request->user();
        $filterStudent = $request->query('student');
        $filterGrade = $request->query('grade');

        $gradeIds = $user->role === 'student'
            ? $user->grades()->pluck('grades.id')
            : collect();

        $query = Message::notDeletedBy($user->id)->where(function ($q) use ($user, $gradeIds) {
            $q->where('recipient_id', $user->id);
            if ($gradeIds->isNotEmpty()) {
                $q->orWhere(function ($q2) use ($gradeIds) {
                    $q2->where('is_broadcast', true)->whereIn('grade_id', $gradeIds);
                });
            }
            if ($user->role === 'teacher') {
                $q->orWhere(function ($q2) use ($user) {
                    $q2->where('sender_id', $user->id);
                });
            }
        });

        // Filters (teacher only)
        if ($user->role === 'teacher') {
            if ($filterStudent) {
                $query->where(function ($q) use ($filterStudent) {
                    $q->where('sender_id', $filterStudent)
                      ->orWhere('recipient_id', $filterStudent);
                });
            }
            if ($filterGrade) {
                $query->where('grade_id', $filterGrade);
            }
        }

        $messages = $query
            ->with(['sender:id,name,email,role', 'recipient:id,name,email', 'grade:id,name'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // Read status
        $readIds = MessageRead::where('user_id', $user->id)
            ->whereIn('message_id', $messages->pluck('id'))
            ->pluck('message_id')
            ->toArray();

        $messages->getCollection()->transform(function ($msg) use ($readIds) {
            $msg->is_read = in_array($msg->id, $readIds);
            return $msg;
        });

        // Unread count
        $unreadCount = Message::notDeletedBy($user->id)->where(function ($q) use ($user, $gradeIds) {
            $q->where('recipient_id', $user->id);
            if ($gradeIds->isNotEmpty()) {
                $q->orWhere(function ($q2) use ($gradeIds) {
                    $q2->where('is_broadcast', true)->whereIn('grade_id', $gradeIds);
                });
            }
        })
            ->whereDoesntHave('reads', fn ($q) => $q->where('user_id', $user->id))
            ->count();

        // Build filter options for teacher: only students/grades that have messages
        $filterStudents = collect();
        $filterGrades = collect();

        if ($user->role === 'teacher') {
            // Students who sent messages to this teacher or received from
            $studentIds = Message::where(function ($q) use ($user) {
                $q->where('recipient_id', $user->id)
                  ->orWhere('sender_id', $user->id);
            })
                ->where('is_broadcast', false)
                ->get()
                ->flatMap(fn ($m) => [$m->sender_id, $m->recipient_id])
                ->filter(fn ($id) => $id !== $user->id)
                ->unique()
                ->values();

            $filterStudents = User::whereIn('id', $studentIds)
                ->where('role', 'student')
                ->select('id', 'name')
                ->get();

            // Grades that have broadcast messages
            $gradeIdsWithMessages = Message::where('sender_id', $user->id)
                ->where('is_broadcast', true)
                ->whereNotNull('grade_id')
                ->pluck('grade_id')
                ->unique();

            $filterGrades = Grade::whereIn('id', $gradeIdsWithMessages)
                ->select('id', 'name')
                ->get();
        }

        return Inertia::render('Messages/Inbox', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
            'filterStudents' => $filterStudents,
            'filterGrades' => $filterGrades,
            'currentFilterStudent' => $filterStudent,
            'currentFilterGrade' => $filterGrade,
        ]);
    }

    public function show(Request $request, Message $message): Response
    {
        $user = $request->user();

        $canView = $message->sender_id === $user->id
            || $message->recipient_id === $user->id
            || ($message->is_broadcast && $message->grade_id && $user->grades()->where('grades.id', $message->grade_id)->exists());

        abort_if(!$canView, 403);

        MessageRead::firstOrCreate([
            'message_id' => $message->id,
            'user_id' => $user->id,
        ], ['read_at' => now()]);

        // Mark related notifications as read
        Notification::where('user_id', $user->id)
            ->where('read', false)
            ->where('link', route('messages.show', $message->id))
            ->update(['read' => true, 'read_at' => now()]);

        $message->load(['sender:id,name,email,role', 'recipient:id,name,email', 'grade:id,name']);

        // Read receipts for teacher
        $readReceipts = [];
        if ($message->sender_id === $user->id && $user->role === 'teacher') {
            if ($message->is_broadcast && $message->grade_id) {
                // Broadcast: show all students in grade with read status
                $grade = Grade::with('students:id,name,email')->find($message->grade_id);
                $reads = $message->reads()->pluck('read_at', 'user_id')->toArray();
                $readReceipts = $grade->students->map(fn ($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                    'email' => $s->email,
                    'read_at' => $reads[$s->id] ?? null,
                ])->sortBy('name')->values();
            } elseif ($message->recipient_id) {
                // Direct message: show when recipient read it
                $read = $message->reads()->where('user_id', $message->recipient_id)->first();
                $readReceipts = collect([[
                    'id' => $message->recipient->id,
                    'name' => $message->recipient->name,
                    'email' => $message->recipient->email,
                    'read_at' => $read?->read_at,
                ]]);
            }
        }

        return Inertia::render('Messages/Show', [
            'message' => $message,
            'readReceipts' => $readReceipts,
        ]);
    }

    public function create(Request $request): Response
    {
        $user = $request->user();
        $recipients = collect();
        $grades = collect();

        if ($user->role === 'teacher') {
            $assignments = $user->teachingAssignments()->with(['grade.students', 'course'])->get()
                ->filter(fn ($cg) => $cg->grade && $cg->course);
            $grades = $assignments->map(fn ($cg) => [
                'id' => $cg->grade->id,
                'name' => $cg->course->name . ' - ' . $cg->grade->name,
                'course_grade_id' => $cg->id,
            ])->unique('id')->values();
            $studentIds = $assignments->pluck('grade.students')->flatten()->pluck('id')->unique();
            $recipients = User::whereIn('id', $studentIds)->select('id', 'name', 'email')->get();
        } elseif ($user->role === 'student') {
            $gradeIds = $user->grades()->pluck('grades.id');
            $teacherIds = CourseGrade::whereIn('grade_id', $gradeIds)->pluck('teacher_id')->unique();
            $recipients = User::whereIn('id', $teacherIds)->select('id', 'name', 'email')->get();
        }

        return Inertia::render('Messages/Create', [
            'recipients' => $recipients,
            'grades' => $grades,
            'userRole' => $user->role,
            'replyTo' => $request->query('reply_to'),
            'replySubject' => $request->query('subject'),
            'replyRecipient' => $request->query('recipient') ? User::select('id', 'name')->find($request->query('recipient')) : null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'recipient_id' => 'nullable|exists:users,id',
            'grade_id' => 'nullable|exists:grades,id',
            'is_broadcast' => 'boolean',
        ]);

        $isBroadcast = $request->boolean('is_broadcast');

        if ($isBroadcast && $validated['grade_id']) {
            $grade = Grade::findOrFail($validated['grade_id']);

            $message = Message::create([
                'sender_id' => $user->id,
                'recipient_id' => null,
                'grade_id' => $grade->id,
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'is_broadcast' => true,
            ]);

            $grade->students->each(function ($student) use ($user, $message) {
                Notification::send(
                    $student->id,
                    'new_message',
                    'Nova poruka od nastavnika',
                    "{$user->name}: {$message->subject}",
                    route('messages.show', $message->id)
                );
            });
        } else {
            abort_if(!$validated['recipient_id'], 422, 'Recipient is required.');

            $message = Message::create([
                'sender_id' => $user->id,
                'recipient_id' => $validated['recipient_id'],
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'is_broadcast' => false,
            ]);

            Notification::send(
                $validated['recipient_id'],
                'new_message',
                'Nova poruka',
                "{$user->name}: {$message->subject}",
                route('messages.show', $message->id)
            );
        }

        if ($request->boolean('stay_on_page')) {
            return back()->with('success', 'Message sent successfully.');
        }

        return redirect()->route('messages.inbox')->with('success', 'Message sent successfully.');
    }

    public function destroy(Request $request, Message $message): RedirectResponse
    {
        $user = $request->user();

        // User can delete messages they sent or received
        $canDelete = $message->sender_id === $user->id || $message->recipient_id === $user->id;

        // Students can delete broadcast messages from their inbox (just mark as read, don't actually delete)
        if (!$canDelete && $message->is_broadcast && $message->grade_id) {
            $canDelete = $user->grades()->where('grades.id', $message->grade_id)->exists();
        }

        abort_if(!$canDelete, 403);

        // Soft delete: hide for this user only
        MessageDeletion::firstOrCreate([
            'message_id' => $message->id,
            'user_id' => $user->id,
        ], ['deleted_at' => now()]);

        return redirect()->route('messages.inbox')->with('success', 'Message deleted.');
    }
}
