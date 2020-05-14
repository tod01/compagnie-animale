<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breeder extends User
{
    public function userProfile() {
        return $this->morphOne('App\Models\User', 'profile');
    }

    public $timestamps = false;
}
