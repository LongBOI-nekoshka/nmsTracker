<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $projects = $user->projects;
        if(empty($user->role)) {
            $user->role = 'user';
            $user->save();
        }
        $user_role = $user->role;
        if($user_role == 'disabled') {
            Auth::logout();
            return redirect('/')->with('error','Sorry but, you have been banned. ;(');
        }
        return view('dashboard',compact('projects','user_role'));
    }
}
