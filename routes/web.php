<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'home']);

Route::middleware([ 
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::any('{controller}/{method}/{params?}', function ($controller, $method, $params = null) {
    $controllerClass = 'App\\Http\\Controllers\\' . ucfirst($controller) . 'Controller';

    if (!class_exists($controllerClass)) {
        abort(404, "Controller [$controllerClass] not found.");
    }

    $controllerInstance = app($controllerClass);

    if (!method_exists($controllerInstance, $method)) {
        abort(404, "Method [$method] not found in [$controllerClass].");
    }

    // Better parameter handling
    $paramArray = [];
    if ($params) {
        $paramArray = explode('/', $params);
        // Remove empty values
        $paramArray = array_filter($paramArray);
        // Reindex array
        $paramArray = array_values($paramArray);
    }

    // Call the method with proper parameters
    return call_user_func_array([$controllerInstance, $method], $paramArray);
    
})->where('params', '.*');

