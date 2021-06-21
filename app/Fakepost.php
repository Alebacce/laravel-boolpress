<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakepost extends Model
{
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author'
    ];
}
        
