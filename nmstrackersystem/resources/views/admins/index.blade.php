@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <table class="table text-center">
            <thead>
                <tr class="bg-warning">
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Set To</th>
                </tr>
                <tbody>
                    @foreach ($all_users as $user)
                        <tr>
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
                        </tr>
                    @endforeach
                </tbody>
            </thead>
        </table>
    </div>
@endsection