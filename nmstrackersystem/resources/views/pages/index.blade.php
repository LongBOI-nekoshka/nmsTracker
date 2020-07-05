@extends('layouts.app')

@section('content')
    <br>
    <div class="jumbotron text-center" >
        <h1>{{$title}}</h1>
        <a class="btn btn-primary btn-lg" href="/project">See Projects</a>
        <a class="btn btn-secondary btn-lg" href="/showAllIssues">See all Issues</a>
        @if(!Auth::guest())
            <a href="/dashboard" class="btn btn-success btn-lg">Dashboard</a>
        @endif
    </div>
@endsection