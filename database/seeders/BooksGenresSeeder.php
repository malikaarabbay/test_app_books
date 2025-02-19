<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksGenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Получаем все книги и жанров
        $books = Book::all();
        $genres = Genre::all();

        // Проверяем, есть ли данные в таблицах
        if ($books->isEmpty() || $genres->isEmpty()) {
            $this->command->warn('Нет книг или жанров для связи!');
            return;
        }

        // Привязываем к каждому жанру случайных книг
        foreach ($genres as $genre) {
            $randomGenres = $genres->random(rand(1, 3))->pluck('id')->toArray();
            $genre->books()->sync($randomGenres);
        }

        $this->command->info('Таблица book_genre заполнена!');
    }
}
