<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Country;
use App\Models\Education;
use App\Models\Question;
use App\Models\Sphere;
use App\Models\University;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{
    public function test()
    {
//        Question::create(['body' => 'q/img.png', 'options' => ['q/img.png', ''], 'answer' => 1, 'score' => 1]);
        $qs = Question::all();
        $countries = Country::orderBy('name_ru')->get();
        $educations = Education::all();
        $spheres = Sphere::all();
        $universities = University::query()->limit(10)->get();
        $tops = User::orderByDesc('score')->limit(20)->with('country')->get();
        $users = User::latest()->limit(20)->with('country')->get();
        return view('welcome', compact('qs', 'countries', 'educations', 'spheres', 'universities', 'users', 'tops'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $qs = $data['qs'];
        unset($data['qs']);
        $data['score'] = $this->score($data['time'], $qs);
        $data['password'] = Hash::make('123456789');
        User::create($data);
        return redirect()->route('test');
    }

    private function score(int $time, array $qs) {
        $score = 90;
        $corrects = 0;
        $questions = Question::all();
        foreach ($questions as $index => $question) {
            $userAnswer = $qs[$index];
            if ($userAnswer == $question->answer) {
                $score += $question->score;
                $corrects++;
            } else {
                $score -= ($question->score * 1.2 + (6 - $question->score / 2) );
            }
        }
        $limit = 30*60*1000;
        if ($time > $limit) {
            $penalty = min(30, (($time - $limit) / $limit));
            $score -= $penalty;
        }
        if ($score < 70) {
            if ($corrects > 30) {
                $score = 110 - rand(1, 9);
            } elseif ($corrects > 25) {
                $score = 100 - rand(1, 9);
            } elseif($corrects > 20) {
                $score = 90 - rand(1, 9);
            } elseif($corrects > 10) {
                $score = 80 - rand(1, 9);
            }
        }
        if ($score < 60) {
            $score = 60;
        }
        return $score;
    }
}
