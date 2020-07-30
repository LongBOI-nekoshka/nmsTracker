<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue;
use App\User;
use App\Project;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['about','index','showAllIssues','createfast']]);
    }
    //
    public function index() {
        $title = 'NMS Tracking Application';
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $aboutApp = 'This app is for tracking issue';
        return view('pages.about')->with('aboutApp', $aboutApp);
    }

    public function showAllIssues() {
        $allIssues = Issue::join('projects','Projects.Project_Id','=','issues.Project_Id')->leftJoin('users','users.id','=','issues.assignee_id')->get();
        return view('pages.allIssues')->with('allIssues',$allIssues);
    }

    public function assignedIssues() {
        $assigneIssues = Issue::where('assignee_id',auth()->user()->id)->whereRaw('(status = "assigned" OR status = "in-Progress")')->get();
        return view('pages.assigned')->with('assigneIssues',$assigneIssues);
    }

    public function createfast() {
        $getProjectId = Project::select('Project_Id','ProjectName')->get();
        return view('pages.quick',compact(['getProjectId']));
    }
}
