<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use App\Models\gymEquipments;
use App\Models\Event;
use App\Models\Tracker;


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

            if (!empty($keyword)) {
                $equipments = gymEquipments::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('category', 'LIKE', "%$keyword%")
                    ->latest()
                    ->get();
            } else {
                $equipments = gymEquipments::latest()->get();
            }

            return view('dashboard', ['equipments' => $equipments]);
        }
        return redirect('login')->withErrors("Login to Access");
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

    public function listUser(Request $request)
    {
        if (Auth::check() && Auth::user()->level === 10) {

            // $users = User::all(); 
            $users = User::where('level', '!=', 10)->get();
            $keyword = $request->get('searchUser');
            
            if (!empty($keyword)) {
                $users = User::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('email', 'LIKE', "%$keyword%")
                    ->orWhere('level', 'LIKE', "%$keyword%")
                    ->latest()
                    ->get(); 
            } else {
                
            }
            return view('admin.users', ['users' => $users]);
        } else {

            return redirect('login')->withErrors("Admin only allowed");
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
    
    public function deleteUser($id)
    {
        $equipments = User::findOrFail($id);
        $equipments->delete();
        return redirect()->route('dashboard')->with('success', 'Equipments has been Deleted');

    }

    public function taskSchedule(Request $request)
    {
        if ($request->ajax()) {
            $user_id = auth()->user()->id;
            $data = Event::where('user_id', $user_id)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'title', 'start', 'end']);
            return response()->json($data);
        }
        return view('taskSchedule');
    }

    public function receiveSchedule(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
    
            if ($request->type === 'add') {
                $calendar = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                    'user_id' => $user->id, 
                ]);
                return response()->json($calendar);
            } elseif ($request->type === 'update') {
                $event = Event::find($request->id);
    
                
                if ($event->user_id === $user->id) {
                    $event->update([
                        'title' => $request->title,
                        'start' => $request->start,
                        'end' => $request->end,
                    ]);
                    return response()->json($event);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            } elseif ($request->type === 'delete') {
                $event = Event::find($request->id);
                
    
                
                if ($event->user_id === $user->id) {

                    $eventDate = date('Y-m-d', strtotime($event->start));

                    $event->delete();

                    Tracker::where('date', $eventDate)->delete();
                    return response()->json($event);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 403);
                }
            }
        }
    }
    
}
