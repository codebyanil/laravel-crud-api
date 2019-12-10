<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//user routes
Route::resource('members', 'MemberController');


//contact routes
Route::resource('contacts', 'ContactController');


//book routes
Route::resource('stories', 'StoryController');


//project routes
Route::resource('projects', 'ProjectController');

Route::prefix('count')->group(function () {
    Route::get('', 'AggregateController@count');
});


