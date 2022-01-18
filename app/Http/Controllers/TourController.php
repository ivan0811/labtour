<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tour;

class TourController extends Controller
{        
    public function show(Request $request){
        return response()->json([
            Tour::all()
        ], 200);
    }        

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $tour = Tour::create([
            'city_id' => $request->city_id,
            'name' => $request->name
        ]);

        return response()->json($tour, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $tour = Tour::findOrFail($id);

        $tour->city_id = $request->city_id;
        $tour->name = $request->name;
        $tour->save();

        return response()->json($tour, 200);
    }

    public function delete($id){
        Tour::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
