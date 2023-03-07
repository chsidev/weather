<?php

use App\Apis\WeatherApi;
use App\Jobs\WeatherToday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redis;
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

Route::get('/', function () {
    $users = User::all();
    if (!request()->has('reload')) {
        // dd(request()->all());
        $users->map(function ($user) {
            WeatherToday::dispatchAfterResponse($user);
        });
    }

    foreach ($users as $user) {
        $weather = Redis::get('user:'.$user->id);
        if ($weather) $user->weather = json_decode($weather);
    }

    return response()->json($users);
});

Route::get('/user/{id}', function ($id) {
    $user = User::findOrFail($id);
    $weather = Redis::get('user:'.$user->id);
    if ($weather) $user->weather = json_decode($weather);

    return response()->json($user);
});

Route::get('/clean', function () {
    Redis::flushDB();
    $weather = Redis::get('user:1');

    return response()->json($weather);
});
