<?php

use App\Http\Controllers\Infraction\InfractionController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'multas',
], function () {
    Route::get('/', [InfractionController::class, 'index']);
    Route::get('/valid', [InfractionController::class, 'indexValid']);
    Route::get('/invalid', [InfractionController::class, 'indexInvalid']);
    Route::get('/{id}', [InfractionController::class, 'show']);
    Route::post('/levantarMulta', [InfractionController::class, 'store']);
    Route::delete('/{id}', [InfractionController::class, 'destroy']);
});
