<?php

use App\Http\Controllers\Api\V1\passportAuthController;
use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication
$router->group(['namespace' => 'Api\V1', 'prefix' => 'v1/auth'], function () use ($router) {
    /** Register */
    $router->post('/register', [passportAuthController::class, 'registerUser']);
    /** Login **/
    $router->post('/login', [passportAuthController::class, 'loginUser']);
});

// Products
$router->group(['namespace' => 'Api\V1', 'prefix' => 'v1/products', 'middleware' => ['auth:api']], function () use ($router) {
    $router->get('/', [ProductController::class, 'getAll']);
    $router->post('/', [ProductController::class, 'store']);
    $router->get('/{id}', [ProductController::class, 'show']);
    $router->put('/{id}', [ProductController::class, 'update']);
    $router->delete('/{id}', [ProductController::class, 'destroy']);
});
