<?php

namespace App\Services;

use App\Models\Book;
use App\Traits\FileUploadTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;

class BookService
{
    use FileUploadTrait;

    public static $statuses = [
        'not_published',
        'published',
    ];

    // Путь к дефолтной обложке
    protected $defaultCoverUrl = '/uploads/default_cover.jpg';

    // Создание новой книги
    public function create($data, ?UploadedFile $coverImage = null): Book
    {
        // Если изображение предоставлено, загружаем его и генерируем URL
        if ($coverImage) {
            $coverImage = $this->uploadImage($data, 'cover_image');
            $data['cover_url'] = $coverImage; // Сохраняем только URL
        } else {
            // Если изображение не было предоставлено, используем дефолтную обложку
            $data['cover_url'] = $this->defaultCoverUrl;
        }

        return Book::create($data);
    }

    // Получение всех книг
    public function getAll(): Collection
    {
        return Book::all();
    }

    // Получение книги по ID
    public function getById(int $id): ?Book
    {
        return Book::find($id);
    }

    // Обновление данных книги
    public function update(Book $book, $data, ?UploadedFile $coverImage = null): Book
    {
        // Если изображение предоставлено, обновляем ссылку
        if ($coverImage) {
            // Загружаем новое изображение и генерируем URL
            $coverImage = $this->uploadImage($data, 'cover_image', $book->cover_url == $this->defaultCoverUrl ? '' : $book->cover_url);
            $data['cover_url'] = $coverImage;
        }

        $book->update($data);
        return $book;
    }

    // Удаление книги
    public function delete(Book $book): void
    {
        if ($book->cover_url !== $this->defaultCoverUrl ) {
            $this->removeImage($book->cover_url);
        }

        $book->delete();
    }

    // Смена статуса книги
    public function changeStatus(Book $book, string $status): Book
    {
        // Проверяем, что статус корректен, используя публичный массив
        if (!in_array($status, self::$statuses)) {
            throw new \InvalidArgumentException("Invalid status provided.");
        }

        // Меняем статус и сохраняем
        $book->status = $status;
        $book->save();

        return $book;
    }

}
