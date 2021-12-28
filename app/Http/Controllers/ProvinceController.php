<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Province;

class ProvinceController extends Controller
{
    public function show(Request $request){
        return response()->json([
            Province::all()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'island_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $province = Province::create([
            'island_id' => $request->island_id,
            'name' => $request->name
        ]);

        return response()->json($province, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'island_id' => 'required',
            'name' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $province = Province::findOrFail($id);

        $province->island_id = $request->island_id;
        $province->name = $request->name;
        $province->save();

        return response()->json($province, 200);
    }

    public function delete($id){
        Province::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
