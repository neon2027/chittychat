<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'owner_id',
        'room_name',
        'description',
        'password',
        'is_private',
        'capacity',
    ];

    protected $hidden = ['password'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_users');
    }

    public function isPrivate()
    {
        return $this->is_private;
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
