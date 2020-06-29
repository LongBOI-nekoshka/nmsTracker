@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        <h2><strong>Projects</strong></h2>
        <br>
        @if(count($projects) >= 1)
            <ul class='list-group'>
                @foreach ($projects as $project)
                <li class='list-group-item'>
                    <div class="well">
                        <h4><a href="/project/{{$project->Project_Id}}">{{$project->ProjectName}}</a></h4>
                        <small>Updated at: {{$project->updated_at}}</small>
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection