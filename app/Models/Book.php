<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public function review(){
        // creating oneToMany relation with book schema
        return $this->hasMany(Review::class);
    }
}
