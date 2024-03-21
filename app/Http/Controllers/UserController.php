<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class UserController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Session::put('role', $user->role->name);
            $request->session()->regenerate();
            
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email')->setStatusCode(401);
    }

    public function index(){
        try {
            $users = User::select('id', 'name', 'last_name', 'second_last_name', 'email', 'role_id')->with('role')->get();
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function clients(){
        try {
            $clients = User::select('id', 'name', 'last_name', 'second_last_name')->whereHas('role', function($query) {
                $query->where('name', 'Cliente');
            })->get();
            return response()->json(['clients' => $clients]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
    
    public function store(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'last_name' => 'required',
                'second_last_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'rol_id' => 'required|exists:roles,id',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $second_last_name = $request->input('second_last_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $rol_id = $request->input('rol_id');

            User::create([
                'name' => $name,
                'last_name' => $last_name,
                'second_last_name' => $second_last_name,
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => $rol_id
            ]);

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'last_name' => 'required',
                'second_last_name' => 'required',
                'password' => 'required',
                'rol_id' => 'required|exists:roles,id',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $name = $request->input('name');
            $last_name = $request->input('last_name');
            $second_last_name = $request->input('second_last_name');
            $password = $request->input('password');
            $rol_id = $request->input('rol_id');

            $user = User::findOrFail($id);
            $user->name = $name;
            $user->last_name = $last_name;
            $user->second_last_name = $second_last_name;
            $user->password = bcrypt($password);
            $user->role_id = $rol_id;
            $user->save();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function destroy($id){
        try {

            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function getUser(){
        try{
            $user = Auth::user();
        
        $user = [
            'name' => $user->name,
            'email' => $user->email,
            'rol' => Session::get('role')
        ];
        return response()->json(["user" => $user], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
