<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    public function index(){
        try {
            $loans = Loan::with('client', 'book','payment')->get();
            return response()->json(['loans' => $loans]);
        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
    
    public function store(Request $request){
        
        try {

            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'book_id' => 'required',
                'desired' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'amount' => 'required',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $client_id = $request->input('client_id');
            $book_id = $request->input('book_id');
            $desired = $request->input('desired');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $return_date = $request->input('return_date');
            $amount = $request->input('amount');

            $loan = Loan::create([
                "client_id" => $client_id,
                "book_id" => $book_id,
                "desired" => $desired,
                "start_date" => $start_date,
                "end_date" => $end_date,
                "return_date" => !!$return_date ? $return_date : null,
            ]);

            Payment::create([
                "loan_id" => $loan->id,
                "amount" => $amount,
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
                'client_id' => 'required',
                'book_id' => 'required',
                'desired' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'amount' => 'required',
            ]);

            if($validator->fails()){
                throw new \Exception('Existen datos vacios');
            }

            $client_id = $request->input('client_id');
            $book_id = $request->input('book_id');
            $desired = $request->input('desired');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');
            $return_date = $request->input('return_date');
            $amount = $request->input('amount');

            $loan = Loan::findOrFail($id);
            $loan->client_id = $client_id;
            $loan->book_id = $book_id;
            $loan->desired = $desired;
            $loan->start_date = $start_date;
            $loan->end_date = $end_date;
            $loan->return_date = !!$return_date ? $return_date : null;
            $loan->save();

            $payment = Payment::where('loan_id', $loan->id)->first();
            if(!!$payment){
                $payment->amount = $amount;
                $payment->save();
            }

            return response()->json(["result" => "OK"], 200);

        } catch (\Exception $e) {
            return response()->json(["Error" => "Existio un problema, intentelo mas tarde"], 500);
        }
    }
}
