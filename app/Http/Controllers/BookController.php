<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request -> input('title');
        $filter = $request->input('filter', '');

        $books = Book::when(
            $title,
            fn($query, $title) => $query->SearchTitle($title)
        );

        // running queries based on the user choise
        $books = match($filter){
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6month' => $books->popularLast6Month(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6month' => $books->highestRatedLast6Month(),
            default => $books->latest()
        };

        // running the queries and store it inside books var
        // cache the result
        $cacheKey = 'books:' . $filter . ':' . $title;
        $books = cache()->remember($cacheKey, 3600, fn() => $books->get());

        return view('books.index', ['books' => $books]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $cacheKey = 'book:' . $book->id;

        // loading latest reviews to oldest reviews and caching
        $book = cache()->remember($cacheKey, 3600, fn() => $book -> load([
            'review' => fn($query) => $query->latest()
        ]));

        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
