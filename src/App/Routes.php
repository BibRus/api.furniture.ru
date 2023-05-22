<?php

declare(strict_types=1);

namespace App\App;

use App\Controller\ApiStatusController;
use App\Controller\AuthController;
use App\Controller\ProductController;
use Slim\Routing\RouteCollectorProxy;


$app->get('/', ApiStatusController::class);

$app->post('/registration',[AuthController::class, 'register']);
$app->post('/login', [AuthController::class, 'login']);

$app->group('/api', function (RouteCollectorProxy $api) {
    $api->post('/products', [ProductController::class, 'save']);
    $api->post('/products/{id:[0-9]+}', [ProductController::class, 'update']);
    $api->get('/products/{id:[0-9]+}', [ProductController::class, 'getById']);
    $api->get('/products', [ProductController::class, 'getAll']);
    $api->delete('/products/{id:[0-9]+}', [ProductController::class, 'delete']);
});



