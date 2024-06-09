<?php

// importing model
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;
    public function review(){
        // creating oneToMany relation with book schema
        return $this->hasMany(Review::class);
    }

    // query for search book
    public function scopeSearchTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    // getting popular books filtered by date
    public function scopePopular(Builder $query, $from = null, $to = null):Builder {
        return $query->withCount([
            'review' => fn(Builder $q)=>$this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('review_count', 'desc');
    }
    // getting books with highest rates

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder{
        return $query->withAvg([
            'review' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating')
            ->orderBy('review_avg_rating', 'desc');
    }
    private function dateRangeFilter(Builder $query, $from = null, $to = null){
        if ($from && !$to){
            $query->where('created_at', '>=', $from);
        }elseif(!$from && $to){
            $query->where('created_at', '<=', $to);
        }elseif($from && $to){
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    // getting min review books
    public function scopeMinReviews(Builder $query, int $minReviews):Builder{
        return $query->having('review_count', '>=', $minReviews);
    }


    // popular last month scope
    public function scopePopularLastMonth(Builder $query) : Builder {
        return $query->popular(now()->subMonth(), now())
        ->highestRated(now()->subMonth(), now())
        ->minReviews(2);
    }

    // popular last 6 month scope
    public function scopePopularLast6Month(Builder $query) : Builder {
        return $query->popular(now()->subMonths(6), now())
        ->highestRated(now()->subMonths(6), now())
        ->minReviews(3);
    }


    // highest rated last month scope
    public function scopeHighestRatedLastMonth(Builder $query) : Builder {
        return $query->highestRated(now()->subMonth(), now())
        ->popular(now()->subMonth(), now())
        ->minReviews(3);
    }

     // highest rated last 6 month scope
     public function scopeHighestRatedLast6Month(Builder $query) : Builder {
        return $query->highestRated(now()->subMonths(6), now())
        ->popular(now()->subMonths(6), now())
        ->minReviews(3);
    }
}
