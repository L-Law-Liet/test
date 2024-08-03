<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::insert([
            ['name_ru' => 'Среднее образование', 'name_en' => 'Middle education'],
            ['name_ru' => 'Высшее образование', 'name_en' => 'High education'],
        ]);
    }
}
