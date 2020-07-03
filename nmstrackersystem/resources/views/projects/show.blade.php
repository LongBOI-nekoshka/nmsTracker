@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project" class="btn btn-secondary">Go Back</a>
        <br><br>
        <h4><strong>{{$project->ProjectName}}</strong></h4>
        <br>
        <p>{{$project->Description}}</p>
        <small>Owned by: @foreach ($owner as $own)
            {{$own->name}}
        @endforeach</small>
        <br><br>
        <a href="{{$project->Project_Id}}/issue/create" class="btn btn-primary">Create Issue</a>
        <a href="{{$project->Project_Id}}/issue/" class="btn btn-primary">Show all Issues</a>
        @if(!Auth::guest())
            @if (Auth::user()->id == $project->user_id)
                <br><br>
                <a href="/project/{{$project->Project_Id}}/edit" class="btn btn-warning">Edit</a>
                <br><br>
                    {!!Form::open(['action'=>['ProjectController@destroy',$project->Project_Id],'method'=>'POST','id'=>'form'])!!}
                        <div class="custom-control custom-checkbox">
                            {{Form::checkbox('validate','yes',false,['id'=>'validate','class'=>'control-input','onclick'=>'valid()'])}}
                            {{Form::label('project_Name','check to delete')}}
                        </div>
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete',['class'=>'btn btn-danger mr-auto','id'=>'bnt_danger','disabled'])}}      
                    {!!Form::close()!!}
            @endif
        @endif
    </div>
@endsection
<script>
function valid() {
    var vali = document.getElementById('validate');
    
    if(vali.checked == true) {
        var sub = document.getElementById('bnt_danger').disabled = false;
    }else {
        var sub = document.getElementById('bnt_danger').disabled = true;
    }
}
</script>