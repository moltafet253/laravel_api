<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends ApiController
{
    public function index()
    {
        //return customize
        // return [
        //     'name' => 'WEBLINE',
        // ];

        //return a custom value to json
        // return response()->json('webline');

        //return all posts
        // return response()->json(Post::all());

        //API controller
        //all functions to send response extends from ApiController

        //send all data to client to 200 status
        return $this->successResponse(Post::all(), 200);

        //send error to client to 500 status
        // return $this->errorResponse('error', 500);
    }

    //create post with api
    public function store(Request $request)
    {
        // dd($request->all());

        // validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'required|image',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        //save image
        // dd($request->image);
        $imageName = Carbon::now()->microsecond . '.' . $request->image->extension();
        $request->image->storeAs('images/posts', $imageName, 'public');
        // dd($imageName);

        //REMEMBER: php artisan storage:link

        //create request
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $imageName,
            'user_id' => $request->user_id,
        ]);

        return $this->successResponse(Post::all(), 201);
    }

    //show post with id
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $this->successResponse($post, 200);
    }

    //if you want to handle errors go to app/exceptions/handler.php -> function render

    //update post with api
    public function update(Request $request, Post $post)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'image',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        //check if image is not null save that
        if ($request->has('image')) {
            $imageName = Carbon::now()->microsecond . '.' . $request->image->extension();
            $request->image->storeAs('images/posts', $imageName, 'public');
        }

        //create request
        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $request->has('image') ? $imageName : $post->image,
            'user_id' => $request->user_id,
        ]);

        return $this->successResponse(Post::all(), 200);
    }

    //delete post
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return $this->successResponse($post, 200);
    }
}
