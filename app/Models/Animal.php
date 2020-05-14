<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{

    protected $guarded = ['id', 'updated_at']; // species_type ?

    public function race() {
        return $this->belongsTo('App\Models\Race');
    }

    public function categoryType() {
        return $this->morphOne('App\Models\Category', 'categorization');
    }

    public function post() {
        return $this->hasOne('App\Models\Ad');
    }
}
