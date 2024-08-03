<?php

namespace Database\Seeders;

use App\Models\Sphere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SphereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sphere::insert([
            ['name_ru' => 'Медицина', 'name_en' => 'Medicine'],
            ['name_ru' => 'ИТ', 'name_en' => 'IT'],
        ]);
    }
}
