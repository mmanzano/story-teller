<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $casts = [
        'private' => 'boolean',
        'in_front' => 'boolean',
        'anonymous' => 'boolean',
    ];

    protected $appends = [
        'author'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getAuthorAttribute()
    {
        if($this->anonymous) {
            return 'Anonymous';
        }

        return $this->user->name;
    }
}
