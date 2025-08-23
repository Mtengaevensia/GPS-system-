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

    // Handle different methods that need Request object
    if (in_array($method, ['store', 'update'])) {
        // For store and update methods, pass the Request object
        return app()->call([$controllerInstance, $method], [request()]);
    } else {
        // For other methods, handle parameters normally
        $paramArray = $params ? explode('/', $params) : [];
        return call_user_func_array([$controllerInstance, $method], $paramArray);
    }
    
})->where('params', '.*');

