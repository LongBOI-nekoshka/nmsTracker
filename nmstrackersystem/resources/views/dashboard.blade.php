@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/project/create" class="btn btn-primary"> Create Project</a>
                    <a href="/project" class="btn btn-secondary"> See other's project</a>
                    <br><br>
                    @if(count($projects) >= 1)
                        <table class="table">
                            <tr>
                                <th>Project Name</th>
                                <th>Date Created</th>
                            </tr>
                            @foreach ($projects as $project)
                                <tr>
                                    <td><a href="/project/{{$project->Project_Id}}">{{$project->ProjectName}}</a></td>
                                    <td>{{$project->created_at}}</td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>you have no project</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
