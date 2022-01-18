<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Island;

class IslandsController extends Controller
{
    public function showIslandTour(){
        return response()->json(Island::with('province')->with('city')->with('tour')->get(), 200);
    }

    public function show(Request $request){
        return response()->json([
            Island::all()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $island = Island::create([
            'name' => $request->name
        ]);

        return response()->json($island, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $island = Island::findOrFail($id);

        $island->name = $request->name;
        $island->save();

        return response()->json($island, 200);
    }

    public function delete($id){
        Island::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
