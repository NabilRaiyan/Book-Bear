<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // generate 100 books with each book have atleast 5 and max 30 reviews
        Book::factory(33)->create()->each(function($book){
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)
                ->good()
                ->for($book)
                ->create();
        });

        Book::factory(33)->create()->each(function($book){
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)
                ->average()
                ->for($book)
                ->create();
        });

        Book::factory(34)->create()->each(function($book){
            $numReviews = random_int(5, 30);
            Review::factory()->count($numReviews)
                ->bad()
                ->for($book)
                ->create();
        });
    }
}
