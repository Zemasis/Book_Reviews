@extends('layouts.app')

@section('content')
  <h1 class="mb-10 text-2xl">Books</h1>

  @if(isset($errors) && $errors->any())
  <ul class="px-4 py-2 bg-red-100">
      @foreach ($errors->all() as $error)
          <li class="text-red-600">{{ $error }}</li>
      @endforeach
  </ul>
  @endif

  <form method="GET" action="{{ route('books.index')}}" class="mb-4 flex items-center space-x-2">
    <input type="text" name="title" value="{{ request('title') }}" placeholder="Search by title" class="input" />
    <input type="hidden" name="filter" value="{{ request('filter') }}" />
    <button type="submit" class="btn">Search</button>
    <a href="{{route('books.index')}}" class="btn">Clear</a>
  </form>
  <div class="filter-container mb-4 flex">
    @php
        $filters = [
            '' => 'Latest',
            'popular' => 'Most Popular Last Month',
            'popular_last_month' => 'Most Popular Last 6 Months',
            'highest_rated_last_month' => 'Highly Rated Last Month',
            'highest_rated_last_6month' => 'Highly Rated Last 6 Months',
        ];
    @endphp
    @foreach ($filters as $key=>$label )
        <a href="{{ route('books.index', [...request()->query, 'filter' => $key])}}"
        class="{{ request('filter') == $key ? 'filter-item-active' : 'filter-item' }}">
            {{ $label }}
        </a>
    @endforeach
  </div>
  <ul>
    @forelse ($books as $book)
      <li class="mb-4">
        <div class="book-item">
          <div
            class="flex flex-wrap items-center justify-between">
            <div class="w-full flex-grow sm:w-auto">
              <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
              <span class="book-author">by {{ $book->author }}</span>
            </div>
            <div>
              <div class="book-rating">
                {{ number_format($book->reviews_avg_rating, 1) }}
              </div>
              <div class="book-review-count">
                out of {{ $book->reviews_count }} {{ Str::plural('preview', $book->reviews_count) }}
              </div>
            </div>
          </div>
        </div>
      </li>
    @empty
      <li class="mb-4">
        <div class="empty-book-item">
          <p class="empty-text">No books found</p>
          <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
        </div>
      </li>
    @endforelse
  </ul>
@endsection
