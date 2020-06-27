@extends('layouts.appNAuth')

@section('content')
    <div class="container">
        <br>
        <a href="/project" class="btn btn-secondary">Go Back</a>
        <br><br>
        <h4>{{$project->ProjectName}}</h4>
        <br>
        <a href="{{$project->Project_Id}}/issue/create" class="btn btn-primary">Create Issue</a>
        <a href="{{$project->Project_Id}}/issue/" class="btn btn-primary">Show all Issues</a>
    </div>
@endsection