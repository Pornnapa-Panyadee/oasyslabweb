<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$data["id"],
            'password' => 'required|confirmed|min:6',
        ]);
    }

    public function reset(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->setRememberToken(Str::random(60));
        $user->save();

        if($user){
            $request->session()->flash('status','success');
            return redirect('/home');
        }

        // $this->guard()->login($user);
    }

    public function showResetForm(Request $request, $id = null)
    {   
        if(Auth::user()->role_id != 1){
            $request->session()->flash('error',"Permission Denied.");
            return redirect('/home');
        }
        $user = User::find($id);
        if(!empty($user)){
            return view('auth.passwords.reset')->with(
                ['id' => $id, 'email' => $request->email,'user' => $user]
            );
        }else{
            $request->session()->flash('error',"User not found.");
            return redirect('/users');    
        } 
    }
}
