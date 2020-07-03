@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project/{{$id}}/issue/" class="btn btn-secondary">Go Back</a>
        <br><br>
        @foreach ($issue as $isInfo)
            <img style="width:30%" src="/storage/picture/{{$isInfo->Picture}}">
            <br><br>
            <h4>{{$isInfo->Name}}</h4>
            <br>
            <p>{{$isInfo->Description}}</p>
            @if(!Auth::guest())
                @if (Auth::user()->id == $isInfo->Issuer_Id || $user_Info->role == 'admin' || $user_Info->role == 'mod')
                    <a href="/project/{{$id}}/issue/{{$idd}}/edit" class="btn btn-warning">Edit</a>
                    <br><br>
                    {!!Form::open(['action'=>['IssueController@destroy',$id,$idd],'method'=>'POST','id'=>'form'])!!}
                        <div class="custom-control custom-checkbox">
                            {{Form::checkbox('validate','yes',false,['id'=>'validate','class'=>'control-input','onclick'=>'valid()'])}}
                            {{Form::label('project_Name','check to delete')}}
                        </div>
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete',['class'=>'btn btn-danger mr-auto','id'=>'bnt_danger','disabled'])}}      
                    {!!Form::close()!!}
                @endif
            @endif
        @endforeach
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