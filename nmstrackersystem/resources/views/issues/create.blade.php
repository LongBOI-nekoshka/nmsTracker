@extends('layouts.app')
@extends('includes.recapcha3')

@section('content')
    <div class="container">
        <a href="/project/{{$project_Id->Project_Id}}" class="btn btn-secondary">Go Back</a>
        <br>
        <br>
        <h4>Create Issue</h4>
        {!! Form::open(['action' => ['IssueController@store',$project_Id->Project_Id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name','',['class' => 'form-control','placeholder' => 'Name of Issue'])}}
            </div>
            <div class="form-group">
                {{Form::label('email','Email')}}
                {{Form::text('email','',['class' => 'form-control','placeholder' => 'Email'])}}
            </div>
            <div class="form-group">
                {{Form::label('priority','Priority')}}
                {{Form::select('priority', ['high' => 'High', 'normal' => 'Normal','low' => 'Low'],null,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('tracker','Tracker')}}
                {{Form::select('tracker', ['bug' => 'Bug', 'feature' => 'Feature'],null,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('status','Status')}}
                {{Form::select('status', ['new' => 'New', 'close' => 'Close', 'assigned' => 'Assigned', 'in-Progress' => 'In-Progress', 'resolved' => 'Resolved'],null,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('description','Description')}}
                {{Form::textarea('description','',['class' => 'form-control','rows' =>'4','cols' => '11'])}}
                <br>
                {{Form::file('picture')}}
            </div>
            {{Form::hidden('secret',$project_Id->Project_Id)}}
            <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITEKEY')}}">
            </div>
            <br>
            {{Form::submit('Submit',['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
