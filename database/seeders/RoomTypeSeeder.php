<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomType::query()->create([
            'name' => 'Bedroom'
        ]);
        RoomType::query()->create([
            'name' => 'Living room'
        ]);
    }
}
