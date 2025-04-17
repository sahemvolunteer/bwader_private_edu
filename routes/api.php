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
use App\Http\Controllers\MyParent\MyController;
use App\Http\Controllers\SupportTeam\MarkController;

Route::Post('/my_children', [MyController::class, 'apiChildren']);

Route::Post('/student_result', [MarkController::class, 'apiShow']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
