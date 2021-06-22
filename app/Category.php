<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function fakeposts()
    {
        // Il model a cui fa riferimento
        // È connessa a tanti post
        return $this->hasMany('App\Fakepost');
    }
    
}
