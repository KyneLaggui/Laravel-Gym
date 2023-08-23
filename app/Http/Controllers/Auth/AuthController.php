<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use App\Models\gymEquipments;


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

    public function dashboard(Request $request)
    {
        if(Auth::check())
        {
            $keyword = $request->get('search');
            $perPage = 5;

            if (!empty($keyword)) {
                $equipments = gymEquipments::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('category', 'LIKE', "%$keyword%")
                    ->latest()
                    ->paginate($perPage);
            } else {
                $equipments = gymEquipments::latest()->paginate($perPage);
            }

            return view('dashboard', ['equipments' => $equipments])->with('i', (request()->input('page', 1) - 1) * $perPage);
        }
        return redirect('login')->withSuccess("Login to Access");
    }
    
    public function createProduct()
    {
        return view('createProduct');
    }   

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            
        ]);

        $equipments = new gymEquipments;

        $equipments->name = $request->name;
        $equipments->description = $request->description;
        $equipments-> category = $request->category;
        
        

        $equipments-> save();
        return redirect()->route('dashboard')->with('success', 'Equipment Added Successfully');

    }

    public function edit($id) 
    {
        $equipmentsEdit = gymEquipments::findOrFail($id);
        return view('editEquipments', ["equipmentsEdit" => $equipmentsEdit]);
    }

    public function update(Request $request, gymEquipments $equipmentsEdit)
    {

        $request->validate([
            'name' => 'required'
        ]);

    


        $equipmentsEdit = gymEquipments::find($request->hidden_id);

        $equipmentsEdit->name = $request->name;
        $equipmentsEdit->description = $request->description;
        $equipmentsEdit-> category = $request->category;
       

        $equipmentsEdit-> save();
        return redirect()->route('dashboard')->with('success', 'Equipments has been Updated');

    }

    public function delete($id)
    {
        $equipments = gymEquipments::findOrFail($id);
        $equipments->delete();
        return redirect()->route('dashboard')->with('success', 'Equipments has been Deleted');

    }

    public function listUser()
    {
        if (Auth::check() && Auth::user()->level === 10) {

            $users = User::all(); 
            return view('admin.users', ['users' => $users]);
        } else {

            return redirect('login')->withErrors("Not an Admin");
        }
    }

    public function updateUserLevel(Request $request, $id)
    {
        
        $request->validate([
            'level' => 'required|in:1,2,3', 
        ]);

        
        $user = User::findOrFail($id);

        
        $user->level = $request->level;
        $user->save();

        return redirect()->route('usersList')->with('success', 'User level updated successfully.');
    }
}
