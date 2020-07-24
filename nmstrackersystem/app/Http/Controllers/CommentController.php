<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Comment;
use App\User;
use DB;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'comment'=>'required',
        ]);

        $comment = new Comment;
        $comment->user_id = auth()->user()->id;
        $comment->issue_id = $request->input('issue_id');
        $search = strtr($request->input('comment'), array('{--' => '<p><img style="width:25%" src="/storage/picture/', '--}' => '"></p>'));
        preg_match_all('/{--(.*?)--}/', $request->input('comment'), $match);
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
                    $path = $request->file('file'.$k)->storeAs('public/picture', $temp[$k]);
                    $pictureNames = $pictureNames.'{'.$temp[$k].'}';
                }
                $comment->Picture =  $pictureNames;
                $comment->comment = $temphtml[sizeof($temphtml)-1];
            }else {
                $_FILES = [];
            }
        }
        if(empty($_FILES)) {
            $comment->comment = $request->input('comment');
        }
        $comment->save();
        return response()->json(['url'=>'/project/'.$request->input('project_id').'/issue/'.$request->input('issue_id')]);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$idd,$iddd)
    {
        //
        $comment = Comment::find($iddd);
        $user_Info = User::find(auth()->user()->id);
        if(auth()->user()->id === $comment->user_Id || $user_Info->role === 'admin' || $user_Info->role === 'mod') {
            if(!empty($comment->Picture)) {
                preg_match_all('/{(.*?)}/', $comment->Picture, $match);
                foreach ($match[1] as $key) {
                    Storage::delete('public/picture/'.$key);
                }
            }
            DB::table('comments')->where('comment_Id',$iddd)->delete();
            return redirect('/project/'.$id.'/issue/'.$idd)->with('success','Comment is deleted');
        }
        return redirect('/project/'.$id.'/issue/'.$idd)->with('error', 'Unauthorize Page');
    }
}
