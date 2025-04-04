<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
    ];

    public function previews() // This method defines a one-to-many relationship between the Book and Preview models.
    {
        return $this->hasMany(Preview::class);
    }

    public function authors() // This method defines a one-to-many relationship between the Book and Author models.
    {
        return $this->belongsToMany(Author::class, 'author_book');
    }

    //scope to get books with good previews
    public function scopeTitle(Builder $query, string $title)
    {
        return $query->where('title', 'like', '%'.$title.'%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null)
    {
        return $query->withCount([
            'previews' => fn (Builder $q)=> $this->dateRangeFilter($q, $from, $to)
            // 'reviews' => function ($query) use ($from, $to) {
            //     if($from && !$to)
            //         $query->where('created_at', '>=', $from);
            //     elseif(!$from && $to)
            //         $query->where('created_at', '<=', $to);
            //     elseif($from && $to)
            //     $query->whereBetween('created_at', [$from, $to]);
            // }
        ])
            ->orderByDesc('previews_count');
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null)
    {
        return $query->withAvg([
            'previews' =>
                fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
            ],
            'rating'
            )
            ->orderByDesc('previews_avg_rating');
    }



    public function scopePopularLastMonth(Builder $query)
    {
        return $query->popular(now()->subMonth(), now())
            ->highestRated(now()->subMonth(), now())
            ->minReviews(5);
    }

    public function scopePopularLast6Months(Builder $query)
    {
        return $query->popular(now()->subMonth(6), now())
        ->highestRated(now()->subMonth(6), now())
        ->minReviews(2);
    }

    public function scopeHighestRatedLastMonth(Builder $query)
    {
        return $query->highestRated(now()->subMonth(), now())
        ->popular(now()->subMonth(), now())
        ->minReviews(1);
    }
    public function scopeHighestRatedLast6Month(Builder $query)
    {
        return $query->highestRated(now()->subMonth(6), now())
        ->popular(now()->subMonth(6), now())
        ->minReviews(1);
    }

    private function dateRangeFilter(Builder $query, $from, $to)
    {
        if($from && !$to)
            $query->where('created_at', '>=', $from);
        elseif(!$from && $to)
            $query->where('created_at', '<=', $to);
        elseif($from && $to)
            $query->whereBetween('created_at', [$from, $to]);
    }
}

