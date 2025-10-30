<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatsApiController;
use App\Http\Controllers\ExamController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Obtener estadísticas de un alumno vía API
Route::middleware('auth:sanctum')->get('/stats', [StatsApiController::class, 'index']);

use App\Http\Controllers\CourseController;

Route::middleware(['auth:sanctum', 'role:admin'])->post('/admin/courses', [CourseController::class, 'store']);
