<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add is_assignment flag to lessons
        Schema::table('lessons', function (Blueprint $table) {
            $table->boolean('is_assignment')->default(false)->after('order');
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_grade_id')->constrained('course_grade')->cascadeOnDelete();
            $table->longText('content');
            $table->enum('status', ['submitted', 'reviewed', 'graded', 'returned'])->default('submitted');
            $table->integer('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'lesson_id', 'course_grade_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('is_assignment');
        });
    }
};
