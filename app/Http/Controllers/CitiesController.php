<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\City;

class CitiesController extends Controller
{
    
    public function show(Request $request){
        return response()->json([
            City::all()
        ], 200);
    }

    public function showCitiesTour(){
        return response()->json(City::with('tour')->get(), 200);
    }

    public function showCitiesTourById($id){
        return response()->json(City::findOrFail($id)->with('tour')->get(), 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'province_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $city = City::create([
            'province_id' => $request->province_id,
            'name' => $request->name
        ]);

        return response()->json($city, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'province_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $city = City::findOrFail($id);

        $city->province_id = $request->province_id;
        $city->name = $city->name;
        $city->save();

        return response()->json($city, 200);
    }

    public function delete($id){
        City::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
