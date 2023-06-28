<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->create(['name' => 'Administrator']);
        Role::query()->create(['name' => 'Property Owner']);
        Role::query()->create(['name' => 'Simple User']);
    }
}
