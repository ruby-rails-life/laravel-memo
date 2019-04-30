<?php

use Illuminate\Database\Seeder;
use App\Book;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::truncate();
        
        $book = new Book([
            'title' => '太陽の笑顔',
            'summary' => '微笑み'
        ]);
        $book->save();
    }
}
