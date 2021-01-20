<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;

use App\Http\Controllers\API\CentroController;

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

Route::apiResource('centros', CentroController::class);
Route::get('centrosAPIRM', [App\Http\Controllers\HomeController::class, 'indexAPIRM']);

Route::any('/{any}', function (ServerRequestInterface $request) {
    $config = new Config([
        'address' => env('DB_HOST'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'database' => env('DB_DATABASE'),
        'basePath' => '/api',
    ]);
    $api = new Api($config);
    $response = $api->handle($request);
    return $response;
})->where('any', '.*');
