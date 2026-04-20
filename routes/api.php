<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Import natin ang AI Controller na ginawa natin kanina
use App\Http\Controllers\AIQuizController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Default route para sa authenticated users
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// DITO NATIN IDADAGDAG ANG ROUTE PARA SA AI GENERATION
// Ito ang tatawagin ng React mo para mag-scan ng PDF
Route::post('/generate-quiz', [AIQuizController::class, 'generateModuleContent']);