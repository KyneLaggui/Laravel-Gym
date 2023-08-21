<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required | email | unique:users' ,
            'password' => 'required|min:8',
        ]);
        $data = $request-> all();
        $createUser = $this->create($data);
        return redirect('login')->withSuccess("Sign Up Successful");
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required | email' ,
            'password' => 'required',
        ]);
        $checkLoginCredentials = $request->only('email', 'password');
        if(Auth::attempt($checkLoginCredentials))
        {
            return redirect('dashboard')->withSuccess("Login Successfully");
        }
        return redirect('login')->withErrors("Incorrect Credentials");
    }

    public function logout()
    {
        
        Session::flush(); //Clear all Sessions
        Auth::logout();
        return redirect('login');
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
        return redirect('login')->withSuccess("Login to Access");
    }
}
