<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug'
    ];

    public function posts() 
    {   
        // Il model a cui fa riferimento
        // È connesso a più posts
        return $this->belongsToMany('App\Fakepost');
    }
}
