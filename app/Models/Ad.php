<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'created_at', 'updated_at', 'description', 'category_id', 'price', 'type_of_post', 'animal_id', 'user_id', 'title', 'user_position'
    ];

    public function post_category() {
        return $this->morphTo();
    }

    public function photos() {
        return $this->hasMany('App\Models\Photo');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function animal() {
        return $this->belongsTo('App\Models\Animal');
    }
}
