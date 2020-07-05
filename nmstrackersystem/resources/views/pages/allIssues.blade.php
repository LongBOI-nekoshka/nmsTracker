@extends('layouts.app')

@section('content')
    @if(Auth::guest())
        <a href="/" class="btn btn-secondary">Go Back</a>
    @endif
    @if(!Auth::guest())
        <a href="/dashboard" class="btn btn-success">Dashboard</a>
    @endif
    <br><br>
    <table class="table">
        <tr>
            <th>Issue Id</th>
            <th>Project Name</th>
            <th>Tracker</th>
            <th>Status</th>
            <th>Priority</th>
            <th>Description</th>
            <th>Assignee</th>
            <th>Updated at</th>
        </tr>
        @foreach ($allIssues as $issue)
            <tr>
                <td><a href="/project/{{$issue->Project_Id}}/issue/{{$issue->Issue_Id}}">{{$issue->Issue_Id}}</a></td>
                <td><a href="/project/{{$issue->Project_Id}}">{{$issue->ProjectName}}</a></td>
                <td>{{$issue->tracker}}</td>
                <td>{{$issue->status}}</td>
                <td>{{$issue->Priority}}</td>
                <td>{{$issue->Name}}</td>
                <td>{{$issue->name}}</td>
                <td>{{$issue->updated_at}}</td>
                
            </tr>
        @endforeach
    </table>
    
@endsection