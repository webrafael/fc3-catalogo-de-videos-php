<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CastMemberController;

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

// Route::middleware(['auth:api', 'can:admin-catalog'])->group(function () {
    Route::apiResource('/videos', VideoController::class);
    Route::apiResource('/categories', CategoryController::class);
    Route::apiResource('/genres', GenreController::class);
    Route::apiResource('/cast_members', CastMemberController::class);
// });


Route::get('/', function() {
    return response()->json(['message' => 'success']);
});
