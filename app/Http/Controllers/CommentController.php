<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function show(){
        return response()->json([
            Comment::with('tours')->with('users')->get()
        ], 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 401);
        }

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'message' => $request->message
        ]);

        return response()->json($comment, 200);
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 200);
        }

        $comment = Comment::findOrFail($id);

        $comment->message = $request->message;
        $comment->save();

        return response()->json($comment, 200);
    }

    public function delete($id){
        Comment::findOrFail($id)->delete();
        return response()->json([
            'message' => 'delete success'
        ], 200);
    }
}
