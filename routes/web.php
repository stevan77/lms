<?php

use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseGradeController;
use App\Http\Controllers\CourseViewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubchapterController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SuperadminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentProgressController;
use App\Http\Controllers\TeacherController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Public enrollment route
Route::get('/enroll/{token}', [EnrollmentController::class, 'show'])->name('enroll.show');
Route::post('/enroll/{token}', [EnrollmentController::class, 'store'])->name('enroll.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/language', [LanguageController::class, 'update'])->name('language.update');
    Route::post('/switch-school-year', function (\Illuminate\Http\Request $request) {
        $request->validate(['school_year_id' => 'required|exists:school_years,id']);
        $request->session()->put('selected_school_year_id', $request->school_year_id);
        return back();
    })->name('switch-school-year');

    // Notifications
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');

    // Messages
    Route::get('/messages', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Impersonation
    Route::post('/impersonate/{user}', [ImpersonationController::class, 'start'])->name('impersonate.start');
    Route::post('/impersonate-leave/{index?}', [ImpersonationController::class, 'leave'])->name('impersonate.leave');

    // Superadmin routes
    Route::middleware('role:superadmin')->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::resource('schools', SchoolController::class);
        Route::get('schools/{school}/assign-admin', [SchoolController::class, 'assignAdmin'])->name('schools.assign-admin');
        Route::post('schools/{school}/assign-admin', [SchoolController::class, 'storeAdmin'])->name('schools.store-admin');
        Route::post('schools/copy-course', [SchoolController::class, 'copyCourse'])->name('schools.copy-course');
        Route::get('superadmins', [SuperadminController::class, 'index'])->name('superadmins.index');
        Route::get('superadmins/create', [SuperadminController::class, 'create'])->name('superadmins.create');
        Route::post('superadmins', [SuperadminController::class, 'store'])->name('superadmins.store');
        Route::delete('superadmins/{superadmin}', [SuperadminController::class, 'destroy'])->name('superadmins.destroy');
        Route::get('school-years', [SchoolYearController::class, 'index'])->name('school-years.index');
        Route::get('school-years/preview', [SchoolYearController::class, 'preview'])->name('school-years.preview');
        Route::post('school-years/close', [SchoolYearController::class, 'closeYear'])->name('school-years.close');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('grades', GradeController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::get('courses/{course}/export', [CourseController::class, 'export'])->name('courses.export');
        Route::post('courses/{course}/export', [CourseController::class, 'exportDownload'])->name('courses.export.download');
        Route::post('courses/{course}/import', [CourseController::class, 'import'])->name('courses.import');
        Route::get('courses/{course}/structure', [CourseController::class, 'structure'])->name('courses.structure');
        Route::post('course-grades', [CourseGradeController::class, 'store'])->name('course-grades.store');
        Route::delete('course-grades/{courseGrade}', [CourseGradeController::class, 'destroy'])->name('course-grades.destroy');
    });

    // Image upload (teachers + admins)
    Route::post('upload-image', [ImageUploadController::class, 'store'])->name('upload-image');

    // Teacher routes
    Route::middleware('role:teacher')->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('submissions', [SubmissionController::class, 'all'])->name('submissions.all');
        Route::get('courses/{course}/lessons', [LessonController::class, 'index'])->name('lessons.index');
        Route::get('courses/{course}/preview', [LessonController::class, 'preview'])->name('courses.preview');
        Route::get('subchapters/{subchapter}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
        Route::post('subchapters/{subchapter}/lessons', [LessonController::class, 'store'])->name('lessons.store');
        Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::post('courses/{course}/chapters', [ChapterController::class, 'store'])->name('chapters.store');
        Route::put('chapters/{chapter}', [ChapterController::class, 'update'])->name('chapters.update');
        Route::delete('chapters/{chapter}', [ChapterController::class, 'destroy'])->name('chapters.destroy');
        Route::post('chapters/{chapter}/subchapters', [SubchapterController::class, 'store'])->name('subchapters.store');
        Route::put('subchapters/{subchapter}', [SubchapterController::class, 'update'])->name('subchapters.update');
        Route::delete('subchapters/{subchapter}', [SubchapterController::class, 'destroy'])->name('subchapters.destroy');
        Route::post('reorder', [LessonController::class, 'reorder'])->name('reorder');
        Route::get('progress/{courseGrade}', [StudentProgressController::class, 'index'])->name('progress.index');
        Route::get('submissions/{lesson}/{courseGrade}', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::put('submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    });

    // Student routes
    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('submissions', [SubmissionController::class, 'studentAll'])->name('submissions.all');
        Route::get('courses', [CourseViewController::class, 'index'])->name('courses.index');
        Route::get('courses/{courseGrade}', [CourseViewController::class, 'show'])->name('courses.show');
        Route::post('progress/{lesson}/{courseGrade}', [StudentProgressController::class, 'update'])->name('progress.update');
        Route::post('submissions/{lesson}/{courseGrade}', [SubmissionController::class, 'store'])->name('submissions.store');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
