@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project/{{$id}}" class="btn btn-secondary">Go Back</a>
        <br>
        <br>
        <h4>Edit Issue</h4>
        {!! Form::open(['action' => ['IssueController@update',$id,$idd], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name',$issue->Name,['class' => 'form-control','placeholder' => 'Name of Issue'])}}
            </div>
            <div class="form-group">
                {{Form::label('email','Email')}}
                {{Form::text('email',$issue->Email,['class' => 'form-control','placeholder' => 'Email','disabled'])}}
            </div>
            <div class="form-group">
                {{Form::label('priority','Priority')}}
                {{Form::select('priority', ['high' => 'High' , 'normal' => 'Normal' ,'low' => 'Low'],$issue->Priority,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('tracker','Tracker')}}
                {{Form::select('tracker', ['bug' => 'Bug', 'feature' => 'Feature'],$issue->tracker,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('status','Status')}}
                {{Form::select('status', ['new' => 'New', 'close' => 'Close', 'assigned' => 'Assigned', 'in-Progress' => 'In-Progress', 'resolved' => 'Resolved'],$issue->status,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('description','Description')}}
                {{Form::textarea('description',$issue->Description,['class' => 'form-control','rows' =>'4','cols' => '11'])}}
                <br>
                {{Form::file('picture')}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection