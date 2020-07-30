@extends('layouts.app')

@section('content')
    <br>
    <div class="jumbotron text-center" >
        <h1>{{$title}}</h1>
        <a href="/createfast" class="btn btn-success btn-lg" style="width: 21%;">Quick Create</a>
        <br>
        <br>
        <a class="btn btn-primary" href="/project">See Projects</a>
        <a class="btn btn-secondary" href="/showAllIssues">See all Issues</a>
        @if(!Auth::guest())
            <a href="/dashboard" class="btn btn-success btn-sm">Dashboard</a>
        @endif
    </div>
@endsection
