<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->string('enrollment_token', 64)->unique()->nullable()->after('section');
        });

        // Generate tokens for existing grades
        foreach (\App\Models\Grade::all() as $grade) {
            $grade->update(['enrollment_token' => Str::random(32)]);
        }
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('enrollment_token');
        });
    }
};
