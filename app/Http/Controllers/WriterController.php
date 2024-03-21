<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Writer;
use Illuminate\Support\Facades\Validator;

class WriterController extends Controller
{
    public function index(){
        try {
            $writers = Writer::all();
            return response()->json(['writers' => $writers]);
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

            Writer::create(["name" => $name]);

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

            $writer = Writer::findOrFail($id);
            $writer->name = $name;
            $writer->save();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function destroy($id){
        try {

            $writer = Writer::findOrFail($id);
            $writer->delete();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
