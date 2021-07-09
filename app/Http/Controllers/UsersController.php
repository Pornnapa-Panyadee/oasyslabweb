<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(Auth::user()->role_id != 1){
            $request->session()->flash('error',"Permission Denied.");
            return redirect(route('home'));
        }
        $users = User::get();
        return view('users.list')->with(['users' => $users]);
    }

    public function deleteUser(Request $request,$id)
    {
        if(Auth::user()->role_id != 1){
            $request->session()->flash('error',"Permission Denied.");
            return redirect(route('home'));
        }
        $user = User::find($id);
        if(!$user){
            $request->session()->flash('error',"User not found.");
            return redirect(route('users'));    
        }
        $user->delete();
        if(!$user){
            $request->session()->flash('error',"Delete User fail.");
            return redirect(route('users'));   
        }
        $request->session()->flash('status','success');
        return redirect(route('users'));
    }

    public function showDeletedUsers(Request $request)
    {
        if(Auth::user()->role_id != 1){
            $request->session()->flash('error',"Permission Denied.");
            return redirect(route('home'));
        }
        $users = User::onlyTrashed()->get();
        if(!$users){
            $request->session()->flash('error',"User not found.");
            return redirect(route('users'));    
        }
        return view('users.deleted')->with(['users' => $users]);
    }

    public function RestoreUser(Request $request,$id)
    {
        if(Auth::user()->role_id != 1){
            $request->session()->flash('error',"Permission Denied.");
            return redirect(route('home'));
        }
        $user = User::withTrashed()->where('id', $id)->restore();
        if(!$user){
            $request->session()->flash('error',"Restore User fail.");
            return redirect(route('users'));   
        }
        $request->session()->flash('status','success');
        return redirect(route('users'));
    }
}
