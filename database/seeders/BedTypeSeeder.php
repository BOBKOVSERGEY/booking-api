<?php

namespace Database\Seeders;

use App\Models\BedType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BedType::query()->create([
            'name' => 'Single bed'
        ]);
        BedType::query()->create([
            'name' => 'Large double bed'
        ]);
        BedType::query()->create([
            'name' => 'Extra large double bed'
        ]);
        BedType::query()->create([
            'name' => 'Sofa bed'
        ]);
    }
}
