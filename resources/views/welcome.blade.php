<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IQ TEST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">IQ TEST</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 20</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($tops as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <img width="60px" src="{{asset((!$user->country->flag) ? 'flags/img.png' : 'flags/'.$user->country->flag.'.svg')}}">
                                {{$user->name}}
                            </div>
                            <div>
                                IQ {{$user->score}}<br><small>{{$user->created}}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card p-2">
                <div id="startButton" class="text-center">
                    @if(session()->has('username'))
                        <div class="alert alert-info text-lg-center">
                            <p>Congratulations {{session('username')}}!</p>
                            <p>You scored {{session('score')}}.</p>
                        </div>
                    @endif
                    <button class="btn btn-outline-dark">Start</button>
                </div>
                <div>
                    <form id="form1" style="display: none" action="{{route('store')}}" method="post" class="p-3">
                        @csrf
                        <div id="qs" style="display: none" class="card-body text-center">
                            <h5 class="card-title"><span id="qi">1</span>/40</h5>
                            <div id="question-container" style="width: 100%; height: 500px">
                                @foreach($qs as $index => $question)
                                    <div class="question" data-question-index="{{ $index }}" style="{{ $index > 0 ? 'display:none;' : '' }}">
                                        <div class="d-flex justify-content-center mb-3">
                                            <div class="p-2">
                                                <img style="height: 30vh; max-width: 100%" src="{{ asset($question->body) }}" alt="Figure">
                                            </div>
                                        </div>
                                        <div class="row pb-4">
                                            @foreach($question->options as $i => $v)
                                                <div class="col-md-4 col-6">
                                                    <div class="p-2">
                                                        <input type="radio" name="answer_{{ $index }}" id="option_{{ $index }}_{{ $i }}" class="d-none">
                                                        <label onclick="selected({{$index}}, {{$i}})" for="option_{{ $index }}_{{ $i }}">
                                                            <img style="height: 90px; width: 90px" src="{{ asset($v) }}" alt="Option" class="img-fluid">
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-around">
                                <div>
                                    <button type="button" id="prev-button" class="btn btn-outline-light">
                                        <img width="20px" src="{{asset('icons/left.svg')}}" alt="">
                                    </button>
                                </div>
                                <div>
                                    <button type="button" id="next-button" class="btn btn-outline-light">
                                        <img width="20px" src="{{asset('icons/right.svg')}}" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="form" style="display: none">
                            <div class="p-2">
                                <label for="nameInput" class="form-label">Full name</label>
                                <input type="text" class="form-control" id="nameInput" name="name" required>
                            </div>
                            <div class="p-2">
                                <label for="ageInput" class="form-label">Age</label>
                                <input type="number" class="form-control" id="ageInput" name="age" min="1" required>
                            </div>
                            <div class="p-2">
                                <label for="emailInput" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailInput" name="email" required>
                            </div>
                            <input id="timeInput" type="text" hidden name="time" value="" required>
                            <input id="qsInput" type="hidden" name="qs" value="" required>
                            <div class="p-2">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option selected hidden></option>
                                    @foreach(\App\Models\User::GENDERS as $gender)
                                        <option value="{{$gender}}">{{$gender}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2">
                                <label class="form-label">Country</label>
                                <select name="country_id" class="form-select" required>
                                    <option selected hidden></option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2">
                                <label class="form-label">University</label>
                                <div class="input-group">
                                    <select name="university_id" class="form-select" id="inputGroupSelect04" required>
                                        <option selected hidden></option>
                                        @foreach($universities as $v)
                                            <option value="{{$v->id}}">{{$v->name_en}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-outline-dark" type="button">Search</button>
                                </div>
                            </div>
                            <div class="p-2">
                                <label class="form-label">Education</label>
                                <select name="education_id" class="form-select" required>
                                    <option selected hidden></option>
                                    @foreach($educations as $v)
                                        <option value="{{$v->id}}">{{$v->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2">
                                <label class="form-label">Sphere</label>
                                <select name="sphere_id" class="form-select" required>
                                    <option selected hidden></option>
                                    @foreach($spheres as $v)
                                        <option value="{{$v->id}}">{{$v->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="p-2">
                                <button id="buttonForm" class="btn btn-outline-dark" type="submit">Submit</button>
                                <button hidden id="submitForm" class="btn btn-outline-dark" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row my-4">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent 20</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <img width="60px" src="{{asset((!$user->country->flag) ? 'flags/img.png' : 'flags/'.$user->country->flag.'.svg')}}"> {{$user->name}}
                            </div>
                            <div>
                                IQ {{$user->score}}<br><small>{{$user->created}}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.question');

        document.getElementById('startButton').addEventListener('click', function() {
            document.getElementById('startButton').style.display = 'none'
            document.getElementById('form1').style.display = 'block'
            document.getElementById('qs').style.display = 'block'
            localStorage.setItem('started', (new Date()).getTime())
        })
        document.getElementById('prev-button').addEventListener('click', function() {
            if (currentQuestionIndex > 0) {
                questions[currentQuestionIndex].style.display = 'none';
                currentQuestionIndex--;
                questions[currentQuestionIndex].style.display = 'block';
                document.getElementById('qi').innerHTML = currentQuestionIndex + 1
            }
        })
        document.getElementById('next-button').addEventListener('click', function() {
            if (currentQuestionIndex < questions.length - 1) {
                questions[currentQuestionIndex].style.display = 'none';
                currentQuestionIndex++;
                questions[currentQuestionIndex].style.display = 'block';
                document.getElementById('qi').innerHTML = currentQuestionIndex + 1
            } else {
                localStorage.setItem('end', (new Date()).getTime())
                document.getElementById('qs').style.display = 'none'
                document.getElementById('form').style.display = 'block'
            }
        });
    });

    function selected(q, i) {
        let a = JSON.parse(localStorage.getItem('q')) ?? []
        a[q] = i
        localStorage.setItem('q', JSON.stringify(a))
        document.getElementById('next-button').click()
    }
    function stopDefAction(evt) {
        evt.preventDefault();
        document.getElementById('timeInput').value = localStorage.getItem('end') - localStorage.getItem('started')
        document.getElementById('qsInput').value = localStorage.getItem('q') ?? '[null]'
        document.getElementById("submitForm").click()
    }
    document.getElementById("buttonForm").addEventListener("click", stopDefAction, false);
</script>
</body>
</html>
