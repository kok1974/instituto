<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Models\User;

use Psr\Http\Message\ServerRequestInterface;
use Tqdev\PhpCrudApi\Api;
use Tqdev\PhpCrudApi\Config;

use App\Http\Controllers\API\PeriodoclaseController;
use App\Models\Peridoclase;
use App\Http\Controllers\API\CentroController;

use App\Http\Controllers\API\PeriodolectivoController;
use App\Http\Controllers\API\AnyoescolarController;
use App\Http\Controllers\API\MateriamatriculadaController;
use App\Http\Controllers\API\NivelController;
use App\Http\Controllers\API\MateriaController;
use App\Http\Controllers\API\GrupoController;
use App\Http\Controllers\API\MatriculaController;

use App\Http\Resources\CentroResource;

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

Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json([
        'token_type' => 'Bearer',
        'access_token' => $user->createToken('token_name')->plainTextToken // token name you can choose for your self or leave blank if you like to
    ]);
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/user', function (Request $request) {
        return new UserResource($request->user());
    });

    Route::post('/avatar', [\App\Http\Controllers\API\AvatarController::class, 'store']);
    Route::get('/avatar', [\App\Http\Controllers\API\AvatarController::class, 'getAvatar']);

    Route::apiResource('centros', CentroController::class);

    Route::get('miCentro', function (Request $request) {
        return new CentroResource($request->user()->centroCoordinado);
    });

    Route::apiResource('periodoslectivos', PeriodolectivoController::class)->parameters(['periodoslectivos' => 'periodolectivo']);
    Route::apiResource('anyosescolares', AnyoescolarController::class)->parameters(['anyosescolares' => 'anyoescolar']);
    Route::apiResource('periodosclases', PeriodoclaseController::class)->parameters(['periodosclases' => 'periodoclase']);
    Route::apiResource('materiasmatriculadas', MateriamatriculadaController::class)->parameters(['materiasmatriculadas' => 'materiamatriculada']);
    Route::apiResource('materias', MateriaController::class);
    Route::apiResource('grupos',GrupoController::class);
    Route::apiResource('matriculas', MatriculaController::class);
    Route::apiResource('niveles', NivelController::class)->parameters(['niveles' => 'nivel']); /* Debido a como trabaja laravel, el parámetro que usamos cuando por ejemplo queremos sacar un nivel
    en concreto (Ej: http://instituto.test/api/niveles/1), nos lo coge como "nivele" (laravel interpreta que el singular de niveles es nivele). Si no le indicamos a laravel que el singular de
    niveles es nivel, nos hará la consulta pero nos devolverá todo a null */
});

Route::get('centrosAPIRM', [CentroController::class, 'indexAPIRM']);


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
