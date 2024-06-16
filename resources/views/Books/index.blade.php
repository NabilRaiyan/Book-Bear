@extends('layouts.app')


<!-- content section -->
@section('content')
    <h1 class="mt-10 mb-10 text-2xl">Books</h1>

    <!-- adding search field -->
    <form method="GET" action="{{ route('books.index')}}" class="flex items-center mb-8">
        <input name="title" type="text" class="mr-5 input h-10" placeholder="Search By Title" value="{{ request('title')}}">
        <input type="hidden" name="filter" value="{{ request('filter')}}" />
        <button class="btn h-10" type="submit">Search</button>
        <a href="{{ route('books.index')}}" class="ml-5 btn h-10">Clear</a>
    </form>

    <!-- popular book -->
    <div class="filter-container mb-4 flex">
        @php
            $filters = [
            '' => 'Latest',
            'popular_last_month' => "Popular Last Month",
            'popular_last_6month' => "Popular Last 6 Month",
            'highest_rated_last_month' => "Highest Rated Last Month",
            'highest_rated_last_6month' => "Highest Rated Last 6 Month",

            ];
        @endphp

        <!-- different filter url -->
        @foreach ($filters as $key => $label )
            <a href="{{ route('books.index', [...request()->query(),'filter' => $key])}}" class="{{ request('filter') === $key || (request('filter') === null && $key === '') ?  'filter-item-active' : 'filter-item'}}">
                {{ $label }}
            </a>
        @endforeach
    </div>

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
                    <x-star-rating :rating="$book->review_avg_rating" />

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