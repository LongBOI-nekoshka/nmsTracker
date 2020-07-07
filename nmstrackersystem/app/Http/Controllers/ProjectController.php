<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Issue;
use App\User;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('ProjectName','desc')->get();
        return view('projects.project')->with('projects',$projects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'project_Name' => 'required',
            'description' => 'required'
        ]);

        $project = new Project;
        $project->ProjectName = $request->input('project_Name');
        $project->Description = $request->input('description');
        $project->user_id = auth()->user()->id;
        $project->save();
        return redirect('/dashboard')->with('success','Project Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $project = Project::find($id);
        $owner = User::where('id',$project->user_id)->get();
        return view('projects.show',compact('project','owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $project = Project::find($id);
        //Check for correct User
        if(auth()->user()->id !== $project->user_id) {
            return redirect('/project')->with('error' , 'Unauthorized Page');
        }
        
        return view('projects.edit')->with('project' , $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'project_Name' => 'required',
            'description' => 'required'
        ]);

        $project = project::find($id);
        if(auth()->user()->id !== $project->user_id) {
            return redirect('/project')->with('error', 'Unauthorize Page');
        }
        $project->ProjectName = $request->input('project_Name');
        $project->Description = $request->input('description');
        $project->save();
        return redirect('/dashboard')->with('success','Project Created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $project = project::find($id);
        if(auth()->user()->id !== $project->user_id) {
            return redirect('/project')->with('error', 'Unauthorize Page');
        }
        $project->delete();
        return redirect('/dashboard')->with('success','Project Got Rekt');
    }
}
