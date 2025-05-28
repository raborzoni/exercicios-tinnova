<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VotosController;
use App\Http\Controllers\BubbleSortController;
use App\Http\Controllers\FatorialController;
use App\Http\Controllers\SomaMultiplosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/votos', [VotosController::class, 'calcularPercentuais']);

Route::get('/bubble-sort', [BubbleSortController::class, 'ordenarVetorExercicio']);
Route::get('/bubble-sort/rapido', [BubbleSortController::class, 'ordenarRapido']);

Route::get('/fatorial/testes', [FatorialController::class, 'executarTestes']);
Route::get('/fatorial/{numero}', [FatorialController::class, 'calcular']);

Route::get('/multiplos/teste', [SomaMultiplosController::class, 'executarTesteExercicio']);
Route::get('/multiplos/{numero}', [SomaMultiplosController::class, 'calcular']);