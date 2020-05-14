<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'created_at', 'ad_id', 'path'
    ];


    public function ad() {
        return $this->belongsTo('App\Models\Ad');
    }
}
