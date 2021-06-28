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
        'author',
        'cover',
        'category_id'
    ];

    public function category() 
    {   
        // Il model a cui fa riferimento
        // È connesso a una sola categoria
        return $this->belongsTo('App\Category');
    }
    
    public function tags() 
    {   
        // Il model a cui fa riferimento
        // È connesso a più tag
        return $this->belongsToMany('App\Tag');
    }
}