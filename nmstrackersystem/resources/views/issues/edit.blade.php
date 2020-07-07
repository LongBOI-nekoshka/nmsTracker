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
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control" onkeyup="myFunction()" placeholder="Search User Type Name or ID" id="myInput">
                        </div>
                        <div id="tableLike">
                            {{Form::label('assignee','Select an Assignee')}}
                            @foreach ($notAssigned as $noAssigned)
                                <div class="trLike form-group">
                                    {{Form::radio('assignee',$noAssigned->id,false,['id'=>'asgn'])}}
                                    {{Form::label('Assignee ID',$noAssigned->id)}}
                                    {{Form::label('Assignee Name',$noAssigned->name)}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div id="assignee" class="form-group" style="display: none">
                        <br>
                        <div class="form-group col-md-3">
                            <input type="text" class="form-control" onkeyup="myFunction()" placeholder="Search User Type Name or ID" id="myInput">
                        </div>
                        <div id="tableLike">
                            {{Form::label('assignee','Select an Assignee')}}
                            @foreach ($allUsers as $user)
                                <div class="trLike form-group">
                                    {{Form::radio('assignee',$user->id,false,['id'=>'asgn'])}}
                                    {{Form::label('Assignee Name',$user->id)}}
                                    {{Form::label('Assignee ID',$user->name)}}
                                </div>
                            @endforeach
                        </div>
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
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tableLike");
        tr = table.getElementsByClassName("trLike");
        for(i = 0; i < tr.length; i++) {
            if(input.value.match(/^[0-9]+$/)) {
                td = tr[i].getElementsByTagName("label")[0];
                if(td) {
                    txtValue = td.textContent || td.innerText;
                    if(txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }else {
                        tr[i].style.display = "none";
                    }
                }
            }else {
                td = tr[i].getElementsByTagName("label")[1];
                if(td) {
                    txtValue = td.textContent || td.innerText;
                    if(txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }
</script>