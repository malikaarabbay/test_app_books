<?php

namespace App\Services;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreService
{
    // Создание нового жанра
    public function create($data): Genre
    {
        $genre = Genre::create($data);

        if (!empty($data['books'])) {
            $genre->books()->sync($data['books']); // Создаем связи
        }

        return $genre;
    }

    // Обновление данных жанра
    public function update(Genre $genre, $data): Genre
    {
        $genre->update($data);

        if (!empty($data['books'])) {
            $genre->books()->sync($data['books']); // Обновляем связи
        }

        return $genre;
    }

    // Удаление жанра
    public function delete(Genre $genre): void
    {
        $genre->delete();
    }

    // Получение всех жанров
    public function getAll(): Collection
    {
        return Genre::all();
    }

    // Получение жанры по ID
    public function getById(int $id): ?Genre
    {
        return Genre::find($id);
    }
}
