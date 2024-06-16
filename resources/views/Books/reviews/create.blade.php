@extends('layouts.app')

@section('content')

<h1 class="mb-10 text-2xl">Add review for {{$book->title}}</h1>

<form method="POST" action="{{route('books.reviews.store', $book)}}">
    @csrf
    <label for="review">Review</label>
    <textarea name="review" id="review" required class="input mb-4"></textarea>
    <label for="rating">Rating</label>
    <select name="rating" required id="rating" class="mb-4 input">
        <option value="">Select a rating</option>
        @for ($i = 1; $i <= 5; $i++)
            <option value="{{$i}}">{{$i}}</option>
        @endfor
    </select>
    <button type="submit" class="btn">Add Review</button>
</form>
@endsection