@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project" class="btn btn-secondary">Go Back</a>
        <br><br>
        <h4><strong>{{$project->ProjectName}}</strong></h4>
        <br>
        <p>{{$project->Description}}</p>
        <small>Owned by: @foreach ($owner as $own)
            {{$own->name}}
        @endforeach</small>
        <br><br>
        <a href="{{$project->Project_Id}}/issue/create" class="btn btn-primary">Create Issue</a>
        <a href="{{$project->Project_Id}}/issue/" class="btn btn-primary">Show all Issues</a>
    </div>
@endsection