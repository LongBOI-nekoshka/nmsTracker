@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="form-group col-md-3">
            <input type="text" class="form-control" onkeyup="myFunction()" placeholder="Search User Type Name or ID" id="myInput">
        </div>
        <table class="table text-center" id="myTable">
            <thead>
                <tr class="bg-warning">
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Set To</th>
                </tr>
                <tbody>
                    @foreach ($all_users as $user)
                        <tr>
                            @if ($user->role != 'admin')
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td> 
                                <div class="form-group mb-2">
                                    @if (auth()->user()->id !== $user->id)
                                        <td>
                                            {!! Form::open(['action' => ['AdminController@update',$user->id],'method' => 'POST']) !!}
                                            {{Form::select('role', ['user' => 'User', 'mod' => 'Moderator','disabled' => 'Disable'],$user->role,['class'=>'form-control form-control-sm'])}}
                                            {{Form::hidden('_method','PUT')}}
                                            {{Form::submit('Save',['class' => 'btn btn-outline-danger'])}}{!! Form::close() !!}
                                        </td>
                                        
                                    @else
                                        <td><select class='form-control form-control-sm' disabled><option>Admin</option></select><button class="btn btn-danger" disabled>Save</button></td>
                                    @endif
                                </div>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
    </div>
@endsection
<script>
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for(i = 0; i < tr.length; i++) {
            if(isNaN(input.value)) {
                td = tr[i].getElementsByTagName("td")[1];
                if(td) {
                    txtValue = td.textContent || td.innerText;
                    if(txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }else {
                        tr[i].style.display = "none";
                    }
                }
            }else {
                td = tr[i].getElementsByTagName("td")[0];
                if(td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    }
</script>