<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Preview extends Model
{
    use HasFactory;
    public function book() // This method defines an inverse one-to-many relationship between the Preview and Book models.
    {
        return $this->belongsTo(Book::class);
    }
}
