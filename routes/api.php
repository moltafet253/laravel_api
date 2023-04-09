<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\V1\PostController as V1PostController;
use App\Http\Controllers\Api\V2\PostController as V2PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//view posts
Route::get('posts', [PostController::class, 'index']);

//show post with id
Route::get('posts/{id}', [PostController::class, 'show']);

//create post
Route::post('posts', [PostController::class, 'store']);

//update post
Route::put('posts/{id}', [PostController::class, 'update']);

//delete post
Route::delete('posts/{id}', [PostController::class, 'delete']);

//Create API Controller -> php artisan make:controller UserController --api => UserController is name of controller
Route::apiResource('users', UserController::class);

//Version management -> you can
//first create your controller like this -> php artisan make:controller Api\V1\PostController --api
//then create resources split -> php artisan make:resource V1\PostResource
Route::prefix('v1')->group(function (){
    Route::get('/posts',[V1PostController::class,'index']);
});

Route::prefix('v2')->group(function (){
    Route::get('/posts',[V2PostController::class,'index']);
});
