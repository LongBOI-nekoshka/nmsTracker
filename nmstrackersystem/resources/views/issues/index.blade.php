@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($project as $pInfo)
            <a href="/project/{{$pInfo->Project_Id}}" class="btn btn-secondary">Go Back</a>
            <br><br>
            <div class="jumbotron">
                <div class="text-center">
                    <h4>Issues for Project <strong>{{$pInfo->ProjectName}}</strong></h4>
                </div>
                <br><br>
                <table class="table">
                    <thead class="table-info">
                        <tr>
                            <th scope="col">Issue Number</th>
                            <th scope="col">Name</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Status</th>
                            <th scope="col">Tracker</th>
                            <th scope="col">Updated</th>
                        </tr>
                    </thead>
                    @foreach ($issues as $issue)
                    <tr>
                        <td class="table-warning">{{$issue->Issue_Id}}</td>
                        <td class="table-warning"><a href="/project/{{$pInfo->Project_Id}}/issue/{{$issue->Issue_Id}}">{{$issue->Name}}</a></td>
                        <td class="table-warning">{{$issue->Priority}}</td>
                        <td class="table-warning">{{$issue->status}}</td>
                        <td class="table-warning">{{$issue->tracker}}</td>
                        <td class="table-warning">{{$issue->updated_at}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
@endsection