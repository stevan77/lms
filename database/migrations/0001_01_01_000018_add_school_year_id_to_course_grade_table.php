<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_grade', function (Blueprint $table) {
            $table->foreignId('school_year_id')->nullable()->after('student_id')->constrained()->cascadeOnDelete();
        });

        // Backfill: set school_year_id for existing individual student assignments
        $activeYearId = \App\Models\SchoolYear::active()?->id;
        if ($activeYearId) {
            \DB::table('course_grade')
                ->whereNull('grade_id')
                ->whereNotNull('student_id')
                ->whereNull('school_year_id')
                ->update(['school_year_id' => $activeYearId]);
        }
    }

    public function down(): void
    {
        Schema::table('course_grade', function (Blueprint $table) {
            $table->dropForeign(['school_year_id']);
            $table->dropColumn('school_year_id');
        });
    }
};
