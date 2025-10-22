<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});



// Rota para servir o arquivo JSON do Swagger (aceita query parameter)
Route::get('/docs', function () {
    $filePath = storage_path('api-docs/api-docs.json');

    if (!file_exists($filePath)) {
        abort(404, 'API documentation not found');
    }

    return response()->file($filePath, [
        'Content-Type' => 'application/json',
        'Access-Control-Allow-Origin' => '*',
    ]);
});

// Rota alternativa para path parameter
Route::get('/docs/api-docs.json', function () {
    $filePath = storage_path('api-docs/api-docs.json');

    if (!file_exists($filePath)) {
        abort(404, 'API documentation not found');
    }

    return response()->file($filePath, [
        'Content-Type' => 'application/json',
        'Access-Control-Allow-Origin' => '*',
    ]);
});
