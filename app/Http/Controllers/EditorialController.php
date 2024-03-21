<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;
use Illuminate\Support\Facades\Validator;

class EditorialController extends Controller
{
    public function index(){
        try {
            $editorials = Editorial::all();
            return response()->json(['editorials' => $editorials]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
    
    public function store(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $name = $request->input('name');

            Editorial::create(["name" => $name]);

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
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }
            $name = $request->input('name');

            $editorial = Editorial::findOrFail($id);
            $editorial->name = $name;
            $editorial->save();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function destroy($id){
        try {

            $editorial = Editorial::findOrFail($id);
            $editorial->delete();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
