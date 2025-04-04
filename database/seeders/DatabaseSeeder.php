<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Preview;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function ($book) {
            $numberOfPreviews = random_int(5, 30);
            Preview::factory($numberOfPreviews)->count($numberOfPreviews)->good()->for($book)->create();

        });
        Book::factory(33)->create()->each(function ($book) {
            $numberOfPreviews = random_int(5, 30);
            Preview::factory($numberOfPreviews)->count($numberOfPreviews)->average()->for($book)->create();

        });
        Book::factory(33)->create()->each(function ($book) {
            $numberOfPreviews = random_int(5, 30);
            Preview::factory($numberOfPreviews)->count($numberOfPreviews)->bad()->for($book)->create();

        });


    }
}
