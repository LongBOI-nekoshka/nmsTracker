@extends('layouts.app')

@section('content')
    <br>
    <div class="jumbotron text-center" >
        <h1>{{$title}}</h1>
        <a class="btn btn-primary btn-lg" href="/project">See Projects</a>
        @if(!Auth::guest())
            <a href="/dashboard" class="btn btn-success btn-lg">Dashboard</a>
        @endif
    </div>
@endsection