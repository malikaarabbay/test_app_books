<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            [
                "id" => 1,
                "name" => "Детектив",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
            [
                "id" => 2,
                "name" => "Фантастика",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
            [
                "id" => 3,
                "name" => "Фэнтези",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
            [
                "id" => 4,
                "name" => "Триллер",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
            [
                "id" => 5,
                "name" => "Исторический роман",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
            [
                "id" => 6,
                "name" => "Автобиография",
                "created_at" => "2025-02-18 10:00:00",
                "updated_at" => "2025-02-18 10:00:00",
            ],
        ];
        DB::table('genres')->insert($genres);
    }
}
