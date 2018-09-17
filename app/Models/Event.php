<?php

namespace App\Models;


class Event extends \Eloquent
{

    protected $fillable = [
        'content',
        'action',
        'before',
        'after',
        'user_id',
        'content_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
