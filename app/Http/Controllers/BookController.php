<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookWriter;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(){
        try {
            $books = Book::with('editorial', 'category', 'writers')->get();
            return response()->json(['books' => $books]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
    
    public function store(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category_id' => 'required|exists:categories,id',
                'quantity' => 'required',
                'editorial_id' => 'required|exists:editorials,id',
                'writers' => 'required|array',
                'writers' => 'exists:writers,id',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $title = $request->input('title');
            $category_id = $request->input('category_id');
            $quantity = $request->input('quantity');
            $editorial_id = $request->input('editorial_id');
            $writers = $request->input('writers');

            $book = Book::create([
                "title" => $title,
                "category_id" => $category_id,
                "quantity" => $quantity,
                "editorial_id" => $editorial_id,
            ]);

            foreach ($writers as $key => $writer) {
                BookWriter::create([
                    "book_id" => $book->id,
                    "writer_id" => $writer
                ]);
            }

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'category_id' => 'required|exists:categories,id',
                'quantity' => 'required',
                'editorial_id' => 'required|exists:editorials,id',
                'writers' => 'required|array',
                'writers' => 'exists:writers,id',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }
            $title = $request->input('title');
            $category_id = $request->input('category_id');
            $quantity = $request->input('quantity');
            $editorial_id = $request->input('editorial_id');
            $writers = $request->input('writers');

            $book = Book::findOrFail($id);
            $book->title = $title;
            $book->category_id = $category_id;
            $book->quantity = $quantity;
            $book->editorial_id = $editorial_id;
            $book->save();

            $book->writers()->detach();

            foreach ($writers as $key => $writer) {
                BookWriter::create([
                    "book_id" => $book->id,
                    "writer_id" => $writer
                ]);
            }

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function destroy($id){
        try {
            $title = $request->input('title');

            $book = Book::findOrFail($id);
            $book->delete();

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }

    public function searchBooks(Request $request){
        try {

            $filterBook = $request->input('filterBook');
            $searchBookInput = $request->input('searchBookInput');

            switch ($filterBook) {
                case '0': //titulo
                    $books = Book::with('editorial', 'category', 'writers')
                    ->where('title', 'like', '%'. $searchBookInput .'%')
                    ->get();

                    break;
                case '1': //categoria
                    $books = Book::with('editorial', 'category', 'writers')
                    ->whereHas('category', function($query) use($searchBookInput) {
                        $query->where('name', 'like', '%'. $searchBookInput .'%');
                    })->get();
                    break;
                case '2': //editorial
                    $books = Book::with('editorial', 'category', 'writers')
                    ->whereHas('editorial', function($query) use($searchBookInput) {
                        $query->where('name', 'like', '%'. $searchBookInput .'%');
                    })->get();;
                    break;
                
                default:
                    $books = Book::with('editorial', 'category', 'writers')->get();
                    break;
            }
            return response()->json(['books' => $books]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
