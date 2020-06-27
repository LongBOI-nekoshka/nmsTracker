@extends('layouts.appNAuth')

@section('content')
    <div class="container">
        
        <br><br>
        @foreach ($issue as $isInfo)
            <h4>{{$isInfo->Name}}</h4>
            <br>
            <img style="width:50%" src="/storage/picture/{{$isInfo->Picture}}">
            <p>{{$isInfo->Description}}</p>
        @endforeach
    </div>
@endsection