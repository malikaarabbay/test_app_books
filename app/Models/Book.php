<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'cover_url'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genre');
    }
}
