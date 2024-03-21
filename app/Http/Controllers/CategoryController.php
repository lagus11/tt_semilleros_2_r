<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(){
        try {
            $categories = Category::all();
            return response()->json(['categories' => $categories]);
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

            Category::create(["name" => $name]);

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

            $category = Category::findOrFail($id);
            $category->name = $name;
            $category->save();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function destroy($id){
        try {

            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
