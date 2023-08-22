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
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2028'
        ]);

        $equipments = new gymEquipments;

        $file_name = time() . '.'. request()->image->getClientOriginalExtension();
        request()->image->move(public_path('imagesEquipments'), $file_name);

        $equipments->name = $request->name;
        $equipments->description = $request->description;
        $equipments-> category = $request->category;
        $equipments->image = $file_name;
        

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

        $file_name = $request-> hidden_equipments_image;

        if($request->image !='')
        {
            $file_name = time() . '.'. request()->image->getClientOriginalExtension();
            request()->image->move(public_path('imagesEquipments'), $file_name);
        }

        $equipmentsEdit = gymEquipments::find($request->hidden_id);

        $equipmentsEdit->name = $request->name;
        $equipmentsEdit->description = $request->description;
        $equipmentsEdit-> category = $request->category;
        $equipmentsEdit->image = $file_name;

        $equipmentsEdit-> save();
        return redirect()->route('dashboard')->with('success', 'Equipments has been Updated');

    }

    public function delete($id)
    {
        $equipments = gymEquipments::findOrFail($id);
        $image_path = public_path()."/images/";
        $image =  $image_path. $equipments->image;
        if (file_exists($image))
        {
           @unlink($image); 
        }
        $equipments->delete();
        return redirect()->route('dashboard')->with('success', 'Equipments has been Deleted');

    }
}
