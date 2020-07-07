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
                @if(Auth::guest())
                {{Form::label('email','Email')}}
                {{Form::text('email','',['class' => 'form-control','placeholder' => 'Email'])}}
                @endif
                @if(!Auth::guest())
                    {{Form::label('email','Email')}}
                    {{Form::text('email',$user_info->email,['class' => 'form-control','placeholder' => 'Email','disabled'])}}
                @endif
            </div>
            <div class="form-group">
                @if(Auth::guest())
                    {{Form::label('priority','Priority')}}
                    {{Form::select('priority', ['normal' => 'Normal'],'normal',['class'=>'form-control'])}}
                @endif
                @if(!Auth::guest())
                    {{Form::label('priority','Priority')}}
                    {{Form::select('priority', ['high' => 'High' , 'normal' => 'Normal' ,'low' => 'Low'],'normal',['class'=>'form-control'])}}
                @endif
            </div>
            <div class="form-group">
                {{Form::label('tracker','Tracker')}}
                {{Form::select('tracker', ['bug' => 'Bug', 'feature' => 'Feature'],null,['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                @if (!Auth::guest())
                    {{Form::label('status','Status')}}
                    {{Form::select('status', ['new' => 'New', 'close' => 'Close', 'assigned' => 'Assigned', 'in-Progress' => 'In-Progress', 'resolved' => 'Resolved'],'new',['class'=>'form-control','id'=>'status','onchange'=>'change()'])}}
                    @if($user_info->role == 'user')
                        <div id="assignee" class="form-group" style="display: none">
                            <br>
                            {{Form::label('assignees','Select an Assignee')}}
                            @foreach ($notAssigned as $noAssigned)
                                <br>
                                {{Form::radio('assignee',$noAssigned->id,false,['id'=>'asgn'])}}
                                {{Form::label('AssigneeID',$noAssigned->id)}}
                                {{Form::label('AssigneeName',$noAssigned->name)}}
                            @endforeach
                        </div>
                    @else
                        <div id="assignee" class="form-group" style="display: none">
                            <br>
                            {{Form::label('assignees','Select an Assignee')}}
                            @foreach ($allUsers as $user)
                                <br>
                                {{Form::radio('assignee',$user->id,false,['id'=>'asgn'])}}
                                {{Form::label('AssigneeName',$user->id)}}
                                {{Form::label('AssigneeID',$user->name)}}
                            @endforeach
                        </div>
                    @endif
                @endif
                @if (Auth::guest())
                {{Form::label('status','Status')}}
                {{Form::select('status', ['new' => 'New'],'new',['class'=>'form-control'])}}
                @endif
            </div>
            <div class="form-group">
                {{Form::label('description','Description')}}
                {{Form::textarea('description','',['class' => 'form-control','rows' =>'4','cols' => '11'])}}
                <br>
                {{Form::file('picture')}}
            </div>
            {{Form::hidden('secret',$project_Id->Project_Id)}}
            @if(Auth::guest())
                <div class="g-recaptcha" data-sitekey="{{env('RECAPTCHA_SITEKEY')}}"></div>             
            @endif
            <br>
            {{Form::submit('Submit',['class' => 'btn btn-primary', 'id' => 'submit'])}}
        {!! Form::close() !!}
    </div>
@endsection
<script>
    function change() {
        var x = document.getElementById("status").value;
        if(x == 'assigned' || x == 'in-Progress') {
            document.getElementById("assignee").style.display = 'block';
        }else {
            document.getElementById("assignee").style.display = 'none';
            document.getElementById("asgn").checked = false;
        }
    }
</script>