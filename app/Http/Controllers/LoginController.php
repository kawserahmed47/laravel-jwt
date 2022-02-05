<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'loginCheck']]);
    }


    public function login(){
        return view('auth.login');
    }

    public function loginCheck(Request $request){

        if(Auth::attempt(array('email' => $request->email, 'password' => $request->password))){

            $user = User::find(Auth::id());

            $customClaims = [
                'foo' => 'bar', 
                'baz' => 'bob'
            ];

            $myTTL = 5; //minute
            
            $payload = JWTFactory::sub($user->id)
                        ->myCustomString('Foo Bar')
                        ->myCustomArray($customClaims)
                        ->myCustomObject($user)
                        ->setTTL($myTTL)
                        ->make();

            $token = JWTAuth::fromUser($user,$payload);

            Session::flash('message', "Email or password do not match!");

            return  redirect()->route('dashboard',$token);
        }else{
     

            Session::flash('message', "Email or password do not match!");
            return redirect()->back();
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }


}
