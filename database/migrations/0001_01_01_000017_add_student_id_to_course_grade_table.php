<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_grade', function (Blueprint $table) {
            $table->foreignId('grade_id')->nullable()->change();
            $table->foreignId('student_id')->nullable()->after('grade_id')->constrained('users')->cascadeOnDelete();
            $table->unique(['course_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::table('course_grade', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropUnique(['course_id', 'student_id']);
            $table->dropColumn('student_id');
            $table->foreignId('grade_id')->nullable(false)->change();
        });
    }
};
