<?php

namespace App\Http\Controllers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function showAllAuthors()
    {
        $data = Author::all();
        if($data->isNotEmpty()){
            return response()->json([
                'success'=> true, 
                'data' => Author::all()
            ]);
        }
        else {
            return response()->json(array(
                'success'=>false, 
                'message' => 'Not Found!'
            ),500);
        }  
    }
    
    public function showOneAuthor($id)
    {
        $data = Author::find($id);
        if(!$data==null){
            return response()->json([  
                'success'=>true, 
                'data' => $data,
            ]);
        }
        else{
            return response()->json(array(
                'success'=>false, 
                'message' => 'Not Found!'
            ),500);
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'location' => 'required|alpha'
        ]);
        $author = Author::create($request->all());
        return response()->json([  
            'success'=>true, 
            'data' => $author,
        ],201);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
        'name' => 'required',
        'email' => 'required|email|unique:authors',
        'location' => 'required|alpha'
        ]);
        $author = Author::findOrFail($id);
        $author->update($request->all());
            return response()->json([
                'success'=>true, 
                'data' => $author
            ], 200);
    }

    public function delete($id)
    {
            $data = Author::destroy($id);
            if($data){
                return response()->json([
                    'success'=>true, 
                    'message' => 'Deleted Succesfully'
                ], 200);
        } else {
            return response()->json([
                'success'=>false, 
                'message'=>'User not found!',
            ], 500);
        }
    }
}