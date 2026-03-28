<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $locale = $request->user()?->locale ?? app()->getLocale();
        $translations = [];
        $langFile = lang_path("{$locale}.json");
        if (file_exists($langFile)) {
            $translations = json_decode(file_get_contents($langFile), true) ?? [];
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'locale' => $locale,
            'translations' => $translations,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'impersonationStack' => fn () => $request->session()->get('impersonation_stack', []),
            'activeSchoolYear' => fn () => \App\Models\SchoolYear::active(),
            'allSchoolYears' => fn () => ($request->user() && in_array($request->user()->role, ['admin', 'teacher', 'superadmin']))
                ? \App\Models\SchoolYear::orderByDesc('id')->get()
                : [],
            'selectedSchoolYearId' => fn () => $request->session()->get('selected_school_year_id', \App\Models\SchoolYear::active()?->id),
            'notifications' => fn () => $request->user()
                ? \App\Models\Notification::where('user_id', $request->user()->id)
                    ->where('read', false)
                    ->latest()
                    ->take(10)
                    ->get()
                : [],
            'unreadNotificationsCount' => fn () => $request->user()
                ? \App\Models\Notification::where('user_id', $request->user()->id)
                    ->where('read', false)
                    ->count()
                : 0,
            'unreadMessagesCount' => fn () => $request->user()
                ? (function () use ($request) {
                    $user = $request->user();
                    $gradeIds = $user->role === 'student'
                        ? $user->grades()->pluck('grades.id')
                        : collect();

                    return \App\Models\Message::notDeletedBy($user->id)->where(function ($q) use ($user, $gradeIds) {
                        $q->where('recipient_id', $user->id);
                        if ($gradeIds->isNotEmpty()) {
                            $q->orWhere(function ($q2) use ($gradeIds) {
                                $q2->where('is_broadcast', true)->whereIn('grade_id', $gradeIds);
                            });
                        }
                    })
                        ->whereDoesntHave('reads', fn ($q) => $q->where('user_id', $user->id))
                        ->count();
                })()
                : 0,
        ];
    }
}
