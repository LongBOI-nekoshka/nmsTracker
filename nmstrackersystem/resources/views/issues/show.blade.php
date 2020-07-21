@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="/project/{{$id}}/issue/" class="btn btn-secondary">Go Back</a>
        <br><br>
        @foreach ($issue as $isInfo)
            {{-- <img style="width:30%" src="/storage/picture/{{$isInfo->Picture}}"> --}}
            <br><br>
            <h4>Title: {{$isInfo->Name}}</h4>
            <br>
            <p>Description: {!!$isInfo->Description!!}</p>
            @if(!Auth::guest())
                @if (Auth::user()->id === $isInfo->Issuer_Id || $user_Info->role === 'admin' || $user_Info->role === 'mod')
                    <hr>
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
        <hr>
        @if(!Auth::guest())
            @if($isInfo->status != 'closed')
            <h6>Comment</h6>
                <div class="sticky-top">
                    <br>
                    {!!Form::open(['action'=>['CommentController@store',$id,$idd],'method'=>'POST','id'=>'form'])!!}
                        {{Form::textarea('comment','',['class' => 'form-control','rows' =>'4','cols' => '11'])}}
                        {{Form::hidden('issue_id',$idd)}}
                        {{Form::hidden('project_id',$id)}}
                        <br>
                        {{Form::submit('Comment',['class' => 'btn btn-primary'])}}
                    {!!Form::close()!!}
                </div>
            @else
                <h4>Issue have been Closed</h4>
            @endif
        @endif
        <div class="jumbotron">
        @foreach ($comments as $comment)
            <hr>
            <small>commented by: {{$comment->name}}</small>
            <h5>{{$comment->comment}}</h5>
            @if(!Auth::guest())
                @if(Auth::user()->id == $comment->id || $user_Info->role == 'admin' || $user_Info->role == 'mod')
                {!!Form::open(['action' => ['CommentController@destroy',$id,$idd,$comment->comment_Id],'method'=>'POST'])!!}
                    {{Form::hidden('_method', 'DELETE')}}
                    {{Form::submit('Delete',['class'=>'btn btn-danger btn-sm'])}}
                {!!Form::close()!!}
                @endif
            @endif
            <hr>
        @endforeach
        </div>
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