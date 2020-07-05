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
                {{Form::select('status', ['new' => 'New', 'close' => 'Close', 'assigned' => 'Assigned', 'in-Progress' => 'In-Progress', 'resolved' => 'Resolved'],$issue->status,['class'=>'form-control','id'=>'status','onchange'=>'change()'])}}
                @if($user_info->role == 'user')
                    <div id="assignee" class="form-group" style="display: none">
                        <br>
                        {{Form::label('assignee','Select an Assignee')}}
                        @foreach ($notAssigned as $noAssigned)
                            <br>
                            {{Form::radio('assignee',$noAssigned->id,false,['id'=>'asgn'])}}
                            {{Form::label('Assignee ID',$noAssigned->id)}}
                            {{Form::label('Assignee Name',$noAssigned->name)}}
                        @endforeach
                    </div>
                @else
                    <div id="assignee" class="form-group" style="display: none">
                        <br>
                        {{Form::label('assignee','Select an Assignee')}}
                        @foreach ($allUsers as $user)
                            <br>
                            {{Form::radio('assignee',$user->id,false,['id'=>'asgn'])}}
                            {{Form::label('Assignee Name',$user->id)}}
                            {{Form::label('Assignee ID',$user->name)}}
                        @endforeach
                    </div>
                @endif
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
<script>
    function change() {
        var x = document.getElementById("status").value;
        if(x == 'assigned') {
            document.getElementById("assignee").style.display = 'block';
        }else {
            document.getElementById("assignee").style.display = 'none';
            document.getElementById("asgn").checked = false;
        }
        
    }
</script>