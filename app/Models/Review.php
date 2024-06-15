<?php

// importing model 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = ['review', 'rating'];
    public function book(){
        // defining each review belong to one book
        return $this->belongsTo(Book::class);
    }

    
    // if the value of revies changes then we forget the cache of reviews
    protected static function booted()
    {
        // caching
        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));

    }

}
