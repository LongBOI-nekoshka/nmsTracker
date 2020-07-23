@extends('layouts.app')
{{-- 
    -Add picture column in comments table
    -Learn websocket for realtime comments
    -store all picture name in column picture
    -when delete get image name and delete it from local file
    -use blackets to get for regex to get it
 --}}
<script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div class="container">
        <a href="/project/{{$id}}/issue/" class="btn btn-secondary">Go Back</a>
        <br><br>
        @foreach ($issue as $isInfo)
            <br><br>
            <h4>Title: {{$isInfo->Name}}</h4>
            <br>
            <p>Description: {!!$isInfo->Description!!}</p>
            @if(!Auth::guest())
                @if (Auth::user()->id === $isInfo->Issuer_Id || $user_Info->role === 'admin' || $user_Info->role === 'mod')
                    <hr>
                    <a href="/project/{{$id}}/issue/{{$idd}}/edit" class="btn btn-warning">Edit</a>
                    <br><br>
                    {!!Form::open(['action'=>['IssueController@destroy',$id,$idd],'method'=>'POST'])!!}
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
                    {!!Form::open(['id'=>'form','files' => true,'enctype' => 'multipart/form-data'])!!}
                        {{Form::textarea('comment','',['class' => 'form-control','id'=>'ta','rows' =>'4','cols' => '11'])}}
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
            <h5>{!!$comment->comment!!}</h5>
            @if(!Auth::guest())
                @if(Auth::user()->id == $comment->id || $user_Info->role == 'admin' || $user_Info->role == 'mod')
                {!!Form::open(['action' => ['CommentController@destroy',$id,$idd,$comment->comment_Id],'id'=>'notForm','method'=>'POST'])!!}
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
<script>
$(document).ready(function() {
    var arrayFiles = [];
    var dropzone = document.getElementById('ta');
    const pictureOnly = ["image/gif", "image/jpeg", "image/png"];
    var check;
    dropzone.ondrop = function(e) {
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    };

    window.onload = function() {
     document.getElementById("ta").addEventListener("paste", handlePaste);
    };

    function handlePaste(e) {
        if(e.clipboardData.files.length != 0) {
            const dT = e.clipboardData || window.clipboardData;
            const file = dT.files;
            readfiles(file);
        }
    }
    
    function readfiles(files) {
        var formData = new FormData();
        if(typeof files.length !== 'undefined') {
            for (var i = 0; i < files.length; i++) {
                if(!pictureOnly.includes(files[i]['type'])) {
                    check = true;
                    alert(files[i]['name']+' is not a picture is a '+files[i]['type']);
                } else {
                    arrayFiles.push(files[i]);
                    formData.append('file'+i, files[i],files[i]['name'].split('.').slice(0, -1).join('.')+arrayFiles.length);
                }
            }
            if(check != true) {
                Object.defineProperty(arrayFiles[arrayFiles.length-1], 'name', {
                    writable: true,
                    value: arrayFiles[arrayFiles.length-1]['name'].split('.').slice(0, -1).join('.')+arrayFiles.length+'.'+arrayFiles[arrayFiles.length-1]['name'].split('.').pop(),
                });
            }
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/upload',
            type: 'POST',
            data: formData,
            async: true,
            success: function (data) {
                var message = $("#ta").val();
                $("#ta").val(message+''+data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    $('#form').on('submit', function(event) {
        event.preventDefault();
        var data = $(this).serialize();
        var formData = new FormData(this);
        if(arrayFiles.length == 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/project/{$id}/issue/{$idd}/comment',
                type: 'POST',
                data:  formData,
                async: true,
                success: function (res) {
                    // console.log(res);
                    window.location = res.url;
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }else {
            for (var i = 0; i < arrayFiles.length; i++) {
                formData.append('file'+i, arrayFiles[i],arrayFiles[i]['name'].split('.').slice(0, -1).join('.')+'.'+arrayFiles[i]['name'].split('.').pop());
            }
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/project/{$id}/issue/{$idd}/comment',
                type: 'POST',
                data: formData,
                async: true,
                success: function (res) {
                    // console.log(res);
                    window.location = res.url;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});
</script>