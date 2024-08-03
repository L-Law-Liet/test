
<ul class="list-group list-group-flush">
    @foreach($tops as $user)
        <div class="list-group-item">
            <div class="d-flex justify-content-between mb-2">
                <div class="p-1 d-flex align-items-center">
                    <img width="60px" src="{{asset((!$user->country->flag) ? 'flags/img.png' : 'flags/'.$user->country->flag.'.svg')}}"></div>
                <div class="p-1">
                    {{$user->name}}
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="btn btn-outline-dark">
                    IQ {{$user->score}}
                </div>
                <div style="font-size: .8rem" class="text-secondary d-flex align-items-end">
                    <span>{{$user->created}}</span>
                </div>
            </div>
        </div>
    @endforeach
</ul>
