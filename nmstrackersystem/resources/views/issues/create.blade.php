@extends('layouts.app')
@extends('includes.recapcha3')
<script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous">
</script>
<style>
    .editable {
        width: 100%;
        border-bottom: 1px solid  #CED4DA;
        padding: 5px;
    }

    .editable[placeholder]:empty:before {
        content: attr(placeholder);
        color: #6C757D; 
    }

    .editable[placeholder]:empty:focus:before {
        content: "";
    }
    img {
        width: 20%;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <div class="container">
        <a href="/project/{{$project_Id->Project_Id}}" class="btn btn-secondary">Go Back</a>
        <br>
        <br>
        <h4>Create Issue</h4>
        <!--   -->
        {!! Form::open(['id'=>'sendIssue','files' => true,'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('name','Name')}}
                {{Form::text('name','',['class' => 'form-control', 'id' => 'name','placeholder' => 'Name of Issue'])}}
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
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" onkeyup="myFunction()" placeholder="Search User Type Name or ID" id="myInput">
                            </div>
                            <div id="tableLike">
                                {{Form::label('assignees','Select an Assignee')}}
                                @foreach ($notAssigned as $noAssigned)
                                    <div class="trLike form-group">
                                        {{Form::radio('assignee',$noAssigned->id,false,['id'=>'asgn'])}}
                                        {{Form::label('AssigneeID',$noAssigned->id)}}
                                        {{Form::label('AssigneeName',$noAssigned->name)}}
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
                                {{Form::label('assignees','Select an Assignee')}}
                                @foreach ($allUsers as $user)
                                    <div class="trLike form-group">
                                        {{Form::radio('assignee',$user->id,false,['id'=>'asgn'])}}
                                        {{Form::label('AssigneeName',$user->id)}}
                                        {{Form::label('AssigneeID',$user->name)}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
                @if (Auth::guest())
                {{Form::label('status','Status')}}
                {{Form::select('status', ['new' => 'New'],'new',['class'=>'form-control'])}}
                @endif
            </div>
            <div class="form-group">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-dark active">
                        <input type="radio" id="write" checked> write
                      </label>
                      <label class="btn btn-outline-dark">
                        <input type="radio" id="preview"> preview
                      </label>
                </div>
                <div id='previewThis' class="editable" placeholder="Nothing to Preview" contenteditable="false"></div>
                {{Form::textarea('description','',['class' => 'form-control', 'id' => 'ta','rows' =>'4','cols' => '11', 'placeholder' => 'Description'])}}
                <br>
                {{Form::file('[]',['id' => 'manualUpload','class' => 'form-control-file','multiple' => 'multiple'])}}
            </div>
            {{Form::hidden('secret',$project_Id->Project_Id)}}
            @if(Auth::guest())
                <div class="g-recaptcha" data-sitekey="6Le7_rcZAAAAAOH2h05uKtpWOyl_-zsgaQ0r1PDh"></div>             
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
<script>
$( document ).ready(function() {
    var img = [];
    var arrayFiles = [];
    var dropzone = document.getElementById('ta');
    var manualUpload = document.getElementById('manualUpload');
    const pictureOnly = ["image/gif", "image/jpeg", "image/png"];
    var check;


    dropzone.ondrop = function(e) {
        e.preventDefault();
        readfiles(e.dataTransfer.files);
    };

    manualUpload.onchange = function(e) {
        readfiles(manualUpload.files);
    }

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
            for(var i = 0; i < arrayFiles.length; i++) {
                var read = new FileReader();
                read.readAsDataURL(arrayFiles[i]);
            }
            read.onload = function() {
                img.push(read.result);
            }
        }
        console.log(arrayFiles[0]['name']);
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
    $('#sendIssue').on('submit', function(event) {
        event.preventDefault();
        if($("#ta").val() == '') {
            alert('Description is needed');
        }
        if($("#name").val() == '') {
            alert('Issue name is needed');
        }
        var data = $(this).serialize();
        var formData = new FormData(this);
        if(arrayFiles.length == 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/project/{$project_Id->Project_Id}/issue',
                type: 'POST',
                data:  formData,
                async: true,
                success: function (res) {
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
                url: '/project/{$project_Id->Project_Id}/issue',
                type: 'POST',
                data: formData,
                async: true,
                success: function (res) {
                    window.location = res.url;
                },
                cache: false,
                contentType: false,
                processData: false
            }).fail( function($xhr) {
                alert('file is large');
                window.location = '/project/{{$project_Id->Project_Id}}/issue/create'
            });;
        }
    });
    $('#previewThis').hide();
    $('#write').change(function() {
        $('#previewThis').hide();
        $('#ta').show();
    });
    $('#preview').change(function() {
        $('#ta').hide();
        $('#previewThis').show();
        $('#previewThis').html($('#ta').val().replace(/(?:\r\n|\r|\n)/g, '<br>'));
        if(arrayFiles.length > 0) {
            for(var i = 0; i < img.length; i++) {
                var rep = $('#previewThis').html().replace('{--'+arrayFiles[i].name.split('.').slice(0, -1).join('.')+'--}','<img src='+img[i]+'>');
                $('#previewThis').html(rep);
            }
        }
    });
    // function createElems(tagName) {
    //     var child = document.createElement(tagName);
    //     var parent = document.getElementById('#previewThis')[0];
    //     parent.appendChild(child);
    // }
    // function attrImg(tagName, tagIndex, attrName, attrVal) {
    //     var child = document.getElementsByTagName(tagName)[tagIndex];
    //     child.setAttribute(attrName,attrVal);
    // }
});
</script>