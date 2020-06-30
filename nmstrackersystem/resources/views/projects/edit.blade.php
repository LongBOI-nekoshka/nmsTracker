@extends('layouts.app')

@section('content')
    <a href="/project/{{$project->Project_Id}}" class="btn btn-secondary">Go back</a>
    <br><br>
    <div class="container jumbotron">
            <h4><strong>Edit Project</strong></h4>
            <br>
            {!! Form::open(['action' => ['ProjectController@update',$project->Project_Id],'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('project_Name','Project Name')}}
                    {{Form::text('project_Name',$project->ProjectName,['class' => 'form-control','placeholder' =>'Project Name'])}}
                </div>
                <div class="form-group">
                    {{Form::label('description','Description')}}
                    {{Form::textarea('description',$project->Description,['class' => 'form-control','rows' =>'4','cols' => '11','placeholder' =>'Description'])}}
                </div>
                <br>
                {{Form::hidden('_method','PUT')}}
                {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
@endsection