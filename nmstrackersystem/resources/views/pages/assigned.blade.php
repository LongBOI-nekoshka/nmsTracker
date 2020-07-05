@extends('layouts.app')

@section('content')
    <a href="/dashboard" class="btn btn-success">Dashboard</a>
    <br><br>
    <table class="table">
        <tr>
            <th>Issue_Id</th>
            <th>Name</th>
            <th>Status</th>
            <th>Priority</th>
        </tr>
        @foreach ($assigneIssues as $assigned)
            <tr>
                <td>{{$assigned->Issue_Id}}</td>
                <td><a href="/project/{{$assigned->Project_Id}}/issue/{{$assigned->Issue_Id}}">{{$assigned->Name}}</a></td>
                <td>{{$assigned->status}}</td>
                <td>{{$assigned->Priority}}</td>
            </tr>
        @endforeach
    </table>
@endsection