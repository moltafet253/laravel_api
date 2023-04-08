<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends ApiController
{
    public function index()
    {
        $posts = Post::all();
        //return customize
        // return [
        //     'name' => 'WEBLINE',
        // ];

        //return a custom value to json
        // return response()->json('webline');

        //return all posts
        // return response()->json($posts);

        //API controller
        //all functions to send response extends from ApiController

        //send all data to client to 200 status
//        return $this->successResponse($posts, 200);

        //send error to client to 500 status
        // return $this->errorResponse('error', 500);

        //with apiResource - method 1
        return PostResource::collection($posts);

        //with apiResource - method 2
        //make collection of table -> php artisan make:resource User --collection =>User is our table - that file class extends from Resource Collection
//        return new PostCollection($posts);

    }

    //show post with id
    public function show($id)
    {
        $post = Post::findOrFail($id);
        //without apiResource
//        return $this->successResponse($post, 200);

        //with apiResource -> if want to make privileges to user and create permission you must use apiResource
        //to make apiResource enter this -> php artisan make:resource PostResource => PostResource is name of resource
//        return new PostResource($post);

        //bind array method 2 -> if want to bind an array to main export data - if you want to bind a variable
        return (new PostResource($post))->additional([
            'foo'=>[
                'key'=>$post->id
            ]
        ]);

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
