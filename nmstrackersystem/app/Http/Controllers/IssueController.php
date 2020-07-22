<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Issue;
use App\User;
use App\Comment;
use DB;

class IssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index','show','create','store']]);
    }
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
        $project_Id = Project::find($id);
        if(empty(auth()->user())) {
            return view('issues.create')->with('project_Id',$project_Id);
        }
        $user_info = User::find(auth()->user()->id);
        $notAssigned = User::whereNull('issues.assignee_Idd')->leftJoin('issues','issues.assignee_Idd','=','users.id')->get();
        $allUsers = User::where('role','!=','disabled')->get();
        return view('issues.create',compact('project_Id','user_info','notAssigned','allUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty(auth()->user())) {
            $this->validate($request, [
                'name'=>'required',
                'description'=>'required',
                'g-recaptcha-response' => 'required',
            ]);
        }
        if($request->input('status') == 'assigned' || $request->input('status') == 'In-Progress') {
            $this->validate($request, [
                'name'=>'required',
                'description'=>'required',
                'assignee' => 'required',
            ]);
        }
        $this->validate($request, [
            'name'=>'required',
            'description'=>'required'
        ]);

        $issue = new Issue;
        $search = strtr($request->input('description'), array('{--' => '<p><img style="width:40%" src="/storage/picture/', '--}' => '"></p>'));
        preg_match_all('/{--(.*?)--}/', $request->input('description'), $match);
        
        if(!empty(auth()->user())) {
            $user_email = User::find(auth()->user()->id);
            $issue->Issuer_Id = auth()->user()->id;
            $issue->Email = $user_email->email;
        }else {
            $issue->Email = $request->input('email');
        }
        if(!empty($request->input('assignee'))) {
            $user = User::find($request->input('assignee'));
            $issue->assignee_id = $request->input('assignee');
            $issue->assignee_idd = $request->input('assignee');
            $issue->assignee = $user->name;
        }
        if(empty($match[1])) {
            $_FILES = [];
        }
        if(!empty($_FILES)) {
            $temp = array();
            $temphtml = array();
            $word = array();
            for($i = 0; $i < sizeof($_FILES); $i++) {
                $fileNameWithExt = $request->file('file'.$i)->getClientOriginalName();
                $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extention = $request->file('file'.$i)->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'. $extention;
                
                foreach ($match[1] as $key) {
                    $keys = str_replace($key,$fileNameToStore,$key);
                    $replace = str_replace($key,$fileNameToStore,$search);
                    array_push($word,$key);
                }
                array_push($temp,$keys);
                array_push($temphtml,$replace);
            }
            $arrEnique = array_unique($word);

            if(sizeof($arrEnique) == sizeof($temp)) {
                for($j = 0; $j < sizeof($temphtml); $j++) {
                    $temphtml[sizeof($temphtml)-1] = strtr($temphtml[sizeof($temphtml)-1],array(array_unique($word)[$j] => $temp[$j]));
                    $issue->Description = $temphtml[sizeof($temphtml)-1];
                    $path = $request->file('file'.$j)->storeAs('public/picture', $temp[$j]);
                }
            }else {
                $_FILES = [];
            }
        }
        if(empty($_FILES)) {
            $issue->Description = $request->input('description');
        }
        $issue->Name = $request->input('name');
        $issue->Priority = $request->input('priority');
        $issue->tracker = $request->input('tracker');
        $issue->status = $request->input('status');
        $issue->Project_Id = $request->input('secret');
        $issue->save();
        return redirect('/project/'.$request->input('secret').'/issue');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$idd) {
        $comments = Comment::where('comments.issue_Id',$idd)->rightjoin('users','users.id','=','comments.user_id')->get();
        $issue = Issue::where('Issue_Id',$idd)->get();
        if(!empty(auth()->user())) {
            $user_Info = User::find(auth()->user()->id);
            return view('issues.show',compact(['issue', 'id','idd','user_Info','comments']));
        }
        return view('issues.show',compact(['issue', 'id','idd','comments']));
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
        $user_info = User::find(auth()->user()->id);
        $notAssigned = User::whereNull('issues.assignee_id')->orWhere('issues.status','!=','assigned')->where('issues.status','!=','in-progress')->leftJoin('issues','issues.assignee_id','=','users.id')->get();
        $allUsers = User::all();
        if(auth()->user()->id === $issue->Issuer_Id || $user_info->role === 'admin' || $user_info->role === 'mod') {
            return view('issues.edit',compact(['issue', 'id','idd','user_info','notAssigned','allUsers']));
        }
        return redirect('/project/'.$id.'/issue/')->with('error' , 'Unauthorized Page');
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
        if($request->input('status') == 'assigned') {
            $this->validate($request, [
                'name'=>'required',
                'description'=>'required',
                'picture' => 'image|nullable|max:1999',
                'assignee' => 'required',
            ]);
        }
        if($request->hasFile('picture')) {
            $fileNameWithExt = $request->file('picture')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extention = $request->file('picture')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'. $extention;
            $path = $request->file('picture')->storeAs('public/picture', $fileNameToStore);
        }

        $issue = Issue::find($idd);
        if(!empty($request->input('assignee'))) {
            $user = User::find($request->input('assignee'));
            $issue->assignee_id = $request->input('assignee');
            $issue->assignee = $user->name;
        }

        if($request->input('assignee') !== 'assigned' || $request->input('assignee') !== 'in-progress') {
            $issue->assignee_idd = NULL;
        }

        $issue->Name = $request->input('name');
        $issue->Description = $request->input('description');
        if ($request->hasFile('picture')) {
            $issue->Picture = $fileNameToStore;
        }
        
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
        $user_Info = User::find(auth()->user()->id);
        if(auth()->user()->id === $issue->Issuer_Id || $user_Info->role === 'admin' || $user_Info->role === 'mod') {
            $comment = Comment::where('issue_Id',$idd);
            $comment->delete();
            $issue->delete();
            return redirect('/project/'.$id.'/issue')->with('success','Issue is deleted');
        }        
        return redirect('/project/'.$id.'/issue')->with('error', 'Unauthorize Page');
    }
}
