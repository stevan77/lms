<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'recipient_id', 'grade_id', 'course_grade_id',
        'subject', 'body', 'is_broadcast',
    ];

    protected function casts(): array
    {
        return ['is_broadcast' => 'boolean'];
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function courseGrade(): BelongsTo
    {
        return $this->belongsTo(CourseGrade::class);
    }

    public function reads(): HasMany
    {
        return $this->hasMany(MessageRead::class);
    }

    public function isReadBy(int $userId): bool
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }

    public function deletions(): HasMany
    {
        return $this->hasMany(MessageDeletion::class);
    }

    public function scopeNotDeletedBy($query, int $userId)
    {
        return $query->whereDoesntHave('deletions', fn ($q) => $q->where('user_id', $userId));
    }
}
