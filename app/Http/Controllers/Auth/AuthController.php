<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\gymEquipment;
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
        if(Auth::check())
        {
            return view('dashboard', ['test' => "hahahha"]);
        }
        return redirect('login')->withSuccess("Login to Access");
    }
    
    public function createProduct()
    {
        return view('createProduct');
    }   

    public function storeProduct(Request $request)
    {
        // $file_name = time(). '.'. request()->image->getClientOriginalExtension();
        // request()->image->move(public_path('images'). $file_name);

        $equipments = new gymEquipments;
        $equipments->name = $request->name;
        $equipments->description = $request->description;
        $equipments-> category = $request->category;
        $equipments->image = $file_name;
        

        $equipments->save();
        return redirect()->route('dashboard')->with('success', 'Product Added Successfully');

    }
}
