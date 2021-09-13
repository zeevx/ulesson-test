<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'topic'],function () {
    Route::get('/', ['App\Http\Controllers\Api\TopicController', 'index']);
    Route::post('/create', ['App\Http\Controllers\Api\TopicController', 'store']);
    Route::delete('/delete/{id}', ['App\Http\Controllers\Api\TopicController', 'delete']);
});

Route::get('/subscribers/{topic}', ['App\Http\Controllers\Api\SubscriptionController', 'subscribers']);
Route::post('/subscribe/{topic}', ['App\Http\Controllers\Api\SubscriptionController', 'subscribe']);
Route::delete('/unsubscribe/{topic}', ['App\Http\Controllers\Api\SubscriptionController', 'unsubscribe']);


Route::post('/publish/{topic}', ['App\Http\Controllers\Api\PublishController', 'publish']);
