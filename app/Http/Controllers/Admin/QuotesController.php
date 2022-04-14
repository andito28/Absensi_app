<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quotes;

class QuotesController extends Controller
{
    public function index(){
        $quotes = Quotes::first();
        return view('quotes.index',compact('quotes'));
    }

    public function update(Request $request){

        $id = $request->id;
        $quotes = Quotes::findOrFail($id);
        $quotes->text = $request->quotes;
        $quotes->save();
        return response()->json($quotes);

    }
}
