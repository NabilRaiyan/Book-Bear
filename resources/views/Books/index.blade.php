@extends('layouts.app')


@section('content')
    <h1 class="mt-10 mb-10 text-2xl">Books</h1>
    <form method="GET" action="{{ route('books.index')}}" class="flex items-center mb-8">
        <input name="title" type="text" class="mr-5 input h-10" placeholder="Search By Title" value="">
        <button class="btn h-10" type="submit">Search</button>
        <a href="{{ route('books.index')}}" class="ml-5 btn h-10">Clear</a>
    </form>

    <ul>
        @forelse ($books as $book )
        <li class="mb-4">
            <div class="book-item">
                <div
                class="flex flex-wrap items-center justify-between">
                <div class="w-full flex-grow sm:w-auto">
                    <a href="{{ route('books.show', $book)}}" class="book-title">{{ $book -> title}}</a>
                    <span class="book-author">by {{ $book->author}}</span>
                </div>
                <div>
                    <div class="book-rating">
                    {{ number_format($book->review_avg_rating , 1)}}
                    </div>
                    <div class="book-review-count">
                    out of {{ $book->review_count }} {{ Str::plural('review', $book->review_count)}}
                    </div>
                </div>
                </div>
            </div>
        </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index')}}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
        
    </ul>
@endsection