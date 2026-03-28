<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('subchapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Add subchapter_id to lessons
        Schema::table('lessons', function (Blueprint $table) {
            $table->foreignId('subchapter_id')->nullable()->after('course_id')->constrained()->cascadeOnDelete();
        });

        // Migrate existing lessons: create a default chapter+subchapter per course
        $courses = \App\Models\Course::with('lessons')->get();
        foreach ($courses as $course) {
            if ($course->lessons->isEmpty()) continue;

            $chapter = \App\Models\Chapter::create([
                'course_id' => $course->id,
                'title' => 'Poglavlje 1',
                'order' => 1,
            ]);

            $subchapter = \App\Models\Subchapter::create([
                'chapter_id' => $chapter->id,
                'title' => 'Potpoglavlje 1',
                'order' => 1,
            ]);

            $course->lessons()->update(['subchapter_id' => $subchapter->id]);
        }
    }

    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropConstrainedForeignId('subchapter_id');
        });
        Schema::dropIfExists('subchapters');
        Schema::dropIfExists('chapters');
    }
};
