<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Captcha;
use App\Project;
use App\Issue;
use App\User;
use DB;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $issues = Issue::where('Project_Id',$id)->get();
        $project = Project::where('Project_Id',$id)->get();
        // $columnList = DB::getSchemaBuilder()->getColumnListing('issues');
        return view('issues.index',compact(['project','issues']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $project_id = Project::find($id);
        // check user rank
        // $user_id = User::find(auth()->user()->id);
        return view('issues.create')->with('project_Id',$project_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'picture' => 'image|nullable|max:1999',
            'g-recaptcha-response' => new Captcha()
        ]);

        if($request->hasFile('picture')) {
            $fileNameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('picture')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'. $extention;
            $path = $request->file('picture')->storeAs('public/picture', $fileNameToStore);
        }else {
            $fileNameToStore = 'noimage.jpg';
        }
        $issue = new Issue;
        $issue->Name = $request->input('name');
        $issue->Description = $request->input('description');
        $issue->Picture = $fileNameToStore;
        $issue->Email = $request->input('email');
        $issue->Priority = $request->input('priority');
        $issue->tracker = $request->input('tracker');
        $issue->status = $request->input('status');
        $issue->Issuer_Id = auth()->user()->id;
        $issue->Project_Id = $request->input('secret');
        $issue->save();
        return redirect('/project/'.$request->input('secret').'/issue')->with('success', 'Issue have been submited');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$idd)
    {
        $issue = Issue::where('Issue_Id',$idd)->get();
        return view('issues.show',compact(['issue', 'id','idd']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$idd)
    {
        //
        $issue = Issue::find($idd);
        // $role = Role::find();
        if(auth()->user()->id !== $issue->Issuer_Id) {
            return redirect('/project/'.$id.'/issue/')->with('error' , 'Unauthorized Page');
        }

        return view('issues.edit',compact(['issue', 'id','idd']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,$idd)
    {
        //
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required',
            'picture' => 'image|nullable|max:1999'
        ]);

        if($request->hasFile('picture')) {
            $fileNameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('picture')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'. $extention;
            $path = $request->file('picture')->storeAs('public/picture', $fileNameToStore);
        }else {
            $fileNameToStore = 'noimage.jpg';
        }
        $issue = Issue::find($idd);
        $issue->Name = $request->input('name');
        $issue->Description = $request->input('description');
        $issue->Picture = $fileNameToStore;
        $issue->Email = $request->input('email');
        $issue->Priority = $request->input('priority');
        $issue->tracker = $request->input('tracker');
        $issue->status = $request->input('status');
        $issue->save();
        return redirect('/project')->with('success', 'Issue have been submited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$idd)
    {
        //
        $issue = Issue::find($idd);
        if(auth()->user()->id !== $issue->Issuer_Id) {
            return redirect('/project/'.$id.'/issue')->with('error', 'Unauthorize Page');
        }

        $issue->delete();
        return redirect('/project/'.$id.'/issue')->with('success','Issue is deleted');
    }
}
