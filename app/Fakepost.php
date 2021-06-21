<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// Lo slug nel fillable non da problemi di sicurezza
class Fakepost extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author'
    ];
}
        
