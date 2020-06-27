@extends('layouts.appNAuth')

@section('content')
    <div class="container">
        <a href="/project/{{$project_Id}}" class="btn btn-secondary_">Go Back</a>
        <br>
        <br>
        <h4>Create Issue</h4>
        {!! Form::open(['action' => ['IssueController@store',$project_Id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name','',['class' => 'form-control','placeholder' => 'Name of Issue'])}}
            </div>
            <div class="form-group">
                {{Form::label('description','Description')}}
                {{Form::textarea('description','',['class' => 'form-control','rows' =>'4','cols' => '11'])}}
                <br>
                {{Form::file('picture')}}
            </div>
            <div class="form-group">
                {{Form::label('email','Email')}}
                {{Form::text('email','',['class' => 'form-control','placeholder' => 'Email'])}}
                {{Form::hidden('secret',$project_Id)}}
            </div>
            {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection