<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $comment->comment = $request->input('comment');
        $comment->user_id = auth()->user()->id;
        $comment->issue_id = $request->input('issue_id');
        $comment->save();
        return redirect('/project/'.$request->input('project_id').'/issue/'.$request->input('issue_id'));
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
            $comdel = DB::table('comments')->where('comment_Id',$iddd)->delete();
            return redirect('/project/'.$id.'/issue/'.$idd)->with('success','Comment is deleted');
        }
        return redirect('/project/'.$id.'/issue/'.$idd)->with('error', 'Unauthorize Page');
    }
}
