<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Project;
use App\Issue;
use App\User;
use App\Comment;
use DB;
/**
 * update get description find file name if not in string then delete file
 * try convert tag to {--filename--} this format and send it to description
 */
/**
 * on update check if img is deleted
 */

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
        $issues = Issue::where('Project_Id',$id)->orderBy('Issue_Id','DESC')->get();
        $project = Project::where('Project_Id',$id)->get();
        try {
            $project[0];
        }catch(\Exception $e) {
            $error = 404;
            return response()->view('errors.custom',compact('error'));
        }
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
        $notag = htmlentities($request->input('description'));
        $search = strtr($notag, array('{--' => '<p><img style="width:30%" src="/storage/picture/', '--}' => '"></p>'));
        preg_match_all('/{--(.*?)--}/', $notag, $match);
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
            $pictureNames = '';
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
                for($j = 1; $j < sizeof($temphtml); $j++) {
                    $temphtml[sizeof($temphtml)-1] = strtr($temphtml[sizeof($temphtml)-1],array(array_unique($word)[$j-1] => $temp[$j-1]));
                }
                for($k = 0; $k < sizeof($temp); $k++) {
                    $request->file('file'.$k)->storeAs('public/picture', $temp[$k]);
                    $pictureNames = $pictureNames.'{'.$temp[$k].'}';
                }
                $issue->Picture =  $pictureNames;
                $issue->Description = $temphtml[sizeof($temphtml)-1];
            }else {
                $_FILES = [];
            }
        }
        if(empty($_FILES)) {
            $issue->Description = htmlentities($request->input('description'));
        }
        $issue->Name = $request->input('name');
        $issue->Priority = $request->input('priority');
        $issue->tracker = $request->input('tracker');
        $issue->status = $request->input('status');
        $issue->Project_Id = $request->input('secret');
        $issue->save();
        return response()->json(['url'=>url('/project/'.$request->input('secret').'/issue')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$idd) {

        $comments = Comment::where('comments.issue_Id',$idd)->rightjoin('users','users.id','=','comments.user_id')->orderBy('comment_id','DESC')->get();
        $issue = Issue::where('Issue_Id',$idd)->get();
        if(!empty(auth()->user())) {
            $user_Info = User::find(auth()->user()->id);
            try {
                $issue[0]['Issue_Id'];
            }catch(\Exception $e) {
                $error = 404;
                return response()->view('errors.custom',compact('error'));
            }
            
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
        $notag = htmlentities($request->input('description'));
        $issue = Issue::find($idd);
        preg_match_all('/{(.*?)}/', $issue->Picture, $match);
        if(!empty($match[1])) {
            for($i = 0; $i < sizeof($match[1]); $i++) {
                strpos($notag,$match[1][$i]) !== false ? 'yes' : Storage::delete('public/picture/'.$match[1][$i]);
            }
        }
        
            
        if(!empty($request->input('assignee'))) {
            $user = User::find($request->input('assignee'));
            $issue->assignee_id = $request->input('assignee');
            $issue->assignee = $user->name;
        }
        
        if($request->input('assignee') !== 'assigned' || $request->input('assignee') !== 'in-progress') {
            $issue->assignee_idd = NULL;
        }

        $issue->Name = $request->input('name');
        $issue->Description = strtr($notag, array('{--' => '<p><img style="width:30%" src="/storage/picture/', '--}' => '"></p>'));
        
        $issue->Priority = $request->input('priority');
        $issue->tracker = $request->input('tracker');
        $issue->status = $request->input('status');
        $issue->save();
        return redirect('/project/'.$id.'/issue/'.$idd)->with('success', 'Issue have been submited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$idd)
    {
        $issue = Issue::find($idd);
        $user_Info = User::find(auth()->user()->id);
        if(auth()->user()->id === $issue->Issuer_Id || $user_Info->role === 'admin' || $user_Info->role === 'mod') {
            $comment = Comment::where('issue_Id',$idd)->get();
            $comments = Comment::where('issue_Id',$idd);
            if(!empty($issue->Picture)) {
                preg_match_all('/{(.*?)}/', $issue->Picture, $match);
                foreach ($match[1] as $key) {
                    Storage::delete('public/picture/'.$key);
                }
                
            }
            if(!empty($comment[0]['Picture'])) {
                preg_match_all('/{(.*?)}/', $comment[0]['Picture'], $match);
                foreach ($match[1] as $key) {
                    Storage::delete('public/picture/'.$key);
                }
            }
            $comments->delete();
            $issue->delete();
            return redirect('/project/'.$id.'/issue')->with('success','Issue is deleted');
        }        
        return redirect('/project/'.$id.'/issue')->with('error', 'Unauthorize Page');
    }
}
