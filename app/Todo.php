<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    protected $attributes = [
        'completed' => false,
        'starred' => false,
        'user_id' => 1 // To be removed once integrated.
    ];
}
