<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        $path = 'q/';
        $img = '/img';
        $ext = '.png';
        for ($i = 1; $i < 41; $i++) {
            $pre = $path.$i.$img;
            $options = [];
            for ($j = 1; $j < 7; $j++) {
                $options[] = $pre."_$j".$ext;
            }
            $data[] = [
                'body' => $pre.$ext,
                'options' => json_encode($options),
                'answer' => 1,
                'score' => $this->getScore($i),
            ];
        }

        Question::insert($data);
    }

    private function getScore($i): int
    {
        if ($i < 21) {
            return 1;
        }
        if ($i < 26) {
            return 3;
        }
        if ($i < 34) {
            return 4;
        }
        if ($i < 38) {
            return 5;
        }
        return 6;
    }
}
