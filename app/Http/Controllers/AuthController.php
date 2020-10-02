<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

use App\User;

use Auth;

class AuthController extends Controller
{
    public function index(){
        $data['page_title'] = 'Login Page';

        return view('pages.auth.login', $data);
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard.index')->with('success', 'Welcome to Centrin Inventory, have a nice day!!');
        }

        return redirect()->route('login')->with('danger', 'Invalid Account!');
    }

    public function register(){
        $data['page_title'] = 'Register Page';

        return view('pages.auth.register', $data);
    }

    public function registerStore(RegisterRequest $request){
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Register is successfull, do login first.');
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }
}
