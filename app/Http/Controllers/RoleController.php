<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index(){
        try {
            $roles = Role::all();
            return response()->json(['roles' => $roles]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
