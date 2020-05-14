<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = [
        'created_at', 'updated_at', 'postId', 'personId', 'sessionId', 'eventStrength', 'eventType','userRegion',
    ];
}
