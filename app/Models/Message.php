<?php

namespace App\Models;

use App\Events\MessageEvent;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'content',
        'type'
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($message) {
            MessageEvent::dispatch($message);
        });
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
