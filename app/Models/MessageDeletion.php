<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageDeletion extends Model
{
    public $timestamps = false;
    protected $fillable = ['message_id', 'user_id', 'deleted_at'];

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }
}
