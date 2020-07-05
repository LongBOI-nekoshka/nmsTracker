@extends('layouts.app')

@section('content')
    <a href="/dashboard" class="btn btn-success">Dashboard</a>
    <br><br>
    <div class="container jumbotron">
            <h4><strong>Create Project</strong></h4>
            <br>
            {!! Form::open(['action' => 'ProjectController@store','method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('project_Name','Project Name')}}
                    {{Form::text('project_Name','',['class' => 'form-control','placeholder' =>'Project Name'])}}
                </div>
                <div class="form-group">
                    {{Form::label('description','Description')}}
                    {{Form::textarea('description','',['class' => 'form-control','rows' =>'4','cols' => '11','placeholder' =>'Description'])}}
                </div>
                <br>
                {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
@endsection