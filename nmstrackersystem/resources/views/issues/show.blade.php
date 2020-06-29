@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project/{{$id}}/issue/" class="btn btn-secondary">Go back</a>
        <br><br>
        @foreach ($issue as $isInfo)
            <img style="width:30%" src="/storage/picture/{{$isInfo->Picture}}">
            <br><br>
            <h4>{{$isInfo->Name}}</h4>
            <br>
            <p>{{$isInfo->Description}}</p>
        @endforeach
    </div>
@endsection