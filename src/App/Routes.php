<?php

declare(strict_types=1);

namespace App\App;

use App\Controller\ApiStatusController;
use App\Controller\AuthController;
use App\Controller\GroupController;
use Slim\Routing\RouteCollectorProxy;


$app->get('/', ApiStatusController::class);

$app->post('/registration',[AuthController::class, 'register']);
$app->post('/login', [AuthController::class, 'login']);

$app->group('/api', function (RouteCollectorProxy $api) {
    $api->get('/groups', [GroupController::class, 'getAll']);
    $api->get('/groups/{id:[0-9]+}', [GroupController::class, 'getById']);
    $api->post('/groups', [GroupController::class, 'save']);

});



