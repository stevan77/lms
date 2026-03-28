<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $fillable = ['school_id', 'school_year_id', 'name', 'level', 'section', 'enrollment_token', 'locale'];

    protected static function booted(): void
    {
        static::creating(function (Grade $grade) {
            if (!$grade->enrollment_token) {
                $grade->enrollment_token = \Illuminate\Support\Str::random(32);
            }
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'student_grade', 'grade_id', 'student_id')->withTimestamps();
    }

    public function courseGrades(): HasMany
    {
        return $this->hasMany(CourseGrade::class);
    }
}
