<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // fillable attributes
    protected $guarded = [];

    // Relationships
    public function todos() {
        return $this->belongsToMany('App\Todo');
    }

    // Mutators
    // public function setTagNameAttribute($value) {
    //     $this->attibutes['tag_name'] = strtolower($value);
    // }

    // Accessors
    public function getTagNameAttribute($value) {
        return ucfirst($value);
    }
}
