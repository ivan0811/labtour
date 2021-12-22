<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Search;

class SearchController extends Controller
{
    public function show(Request $request){
        $validator = Validator::make($request->all(), [
            'search' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        return response()->json([
            Search::with('user')->where('search', 'LIKE', '%'.$request->search.'%')->get()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'search' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $search = Search::create([
            'user_id' => $request->user()->id,
            'search' => $request->search
        ]);

        return response()->json($search, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'search' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $search = Search::findOrFail($id);

        $search->search = $request->search;
        $search->save();

        return response()->json($comment, 200);
    }

    public function delete($id){
        Search::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
