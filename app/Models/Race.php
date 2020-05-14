<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $guarded = ['id', 'species'];

    public function animals() {
        return $this->hasMany('App\Models\Animal');
    }
}
