<?php

use App\Http\Controllers\Api\Coordinadores\CoordinadorController;
use App\Http\Controllers\Api\Alumnos\AlumnoController;
use App\Http\Controllers\Api\Coordinadores\MateriasController;
use App\Http\Controllers\Api\Coordinadores\DocentesController;
use App\Http\Controllers\Api\Coordinadores\GrupoController;
use App\Http\Controllers\Api\Coordinadores\ReporteEvaluacionController;
use App\Http\Controllers\Api\UserController;
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

Route::prefix('coordinador')->group(function () {

    Route::post('login', [CoordinadorController::class, 'login']);
    Route::middleware(['auth:sanctum', 'abilities:personal'])->group(function () {
        Route::get('perfil', [CoordinadorController::class, 'perfil']);
        Route::get('periodos', [CoordinadorController::class, 'periodos']);
        Route::get('estadisticas', [CoordinadorController::class, 'estadisticas']);
        Route::post('docentesByPeriodo', [DocentesController::class, 'docentesByPeriodo']);
        Route::post('materiasByPeriodoDocente', [MateriasController::class, 'materiasByPeriodoDocente']);
        Route::post('grupoByPeriodoDocenteMat', [GrupoController::class, 'grupoByPeriodoDocenteMat']);
        Route::post('reporteByPeriodoDocenteMateria', [ReporteEvaluacionController::class, 'reporteByPeriodoDocenteMateria']);
        Route::post('reporteGeneralDocentes', [ReporteEvaluacionController::class, 'reporteGeneralDocentes']);
        Route::post('reporteGeneralCarrerasDocentes', [ReporteEvaluacionController::class, 'reporteGeneralCarrerasDocentes']);
        Route::post('alumnosPeriodoActivo', [ReporteEvaluacionController::class, 'alumnosPeriodoActivo']);
    });
});

Route::prefix('alumnos')->group(function () {

    Route::post('login', [AlumnoController::class, 'login']);
    Route::middleware(['auth:sanctum', 'abilities:alumno'])->group(function () {
        Route::get('perfil', [AlumnoController::class, 'perfil']);
        Route::post('listaMaterias', [AlumnoController::class, 'listaMaterias']);
        Route::post('guardarEncuestaPorMateria', [AlumnoController::class, 'guardarEncuestaPorMateria']);
    });
});
// Route::get('registrar',[UserController::class, 'registrar']);
// Route::group(['middleware' => ['auth:sanctum']],function() {
//     Route::get('perfil',[UserController::class, 'perfil']);
//     Route::get('cerrar',[UserController::class, 'cerrar']);

// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
