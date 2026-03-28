<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. "2025/2026"
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Add school_year_id to grades
        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('school_year_id')->nullable()->after('school_id')->constrained('school_years')->nullOnDelete();
        });

        // Add status to users (for graduated etc)
        Schema::table('users', function (Blueprint $table) {
            $table->enum('student_status', ['active', 'graduated', 'transferred', 'inactive'])->default('active')->after('locale');
        });

        // Create default school year 2025/2026 and assign all grades
        $schoolYear = \App\Models\SchoolYear::create([
            'name' => '2025/2026',
            'start_date' => '2025-09-01',
            'end_date' => '2026-06-30',
            'is_active' => true,
        ]);

        \App\Models\Grade::whereNull('school_year_id')->update(['school_year_id' => $schoolYear->id]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('student_status');
        });
        Schema::table('grades', function (Blueprint $table) {
            $table->dropConstrainedForeignId('school_year_id');
        });
        Schema::dropIfExists('school_years');
    }
};
