<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->successResponse(User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        //create request
        $post = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->successResponse(User::all(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = User::findOrFail($id);
        return $this->successResponse($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        //create request
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return $this->successResponse(User::all(), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = User::findOrFail($id);
        $post->delete();
        return $this->successResponse($post, 200);
    }
}
