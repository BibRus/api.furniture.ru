<?php

declare(strict_types=1);

use App\Exception\HttpNotFoundException;
use App\Middleware\CorsProvider;
use App\Middleware\JsonWrapper;
use App\Middleware\SuccessResponseWrapper;
use DI\Bridge\Slim\Bridge;
use DI\Container;

require __DIR__ . '/../../vendor/autoload.php';

$containerBuilder = new DI\ContainerBuilder();
$container = new Container();
$app = Bridge::create($container);

require_once __DIR__ . '/../Data/EnvironmentLoader.php';

require_once __DIR__ . '/Dependencies.php';
require_once __DIR__ . '/Services.php';
require_once __DIR__ . '/Repositories.php';
require_once __DIR__ . '/Routes.php';

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "path" => ['/api', '/images'],
    "secret" => $_ENV['SECRET_KEY'],
]));

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$app->add(CorsProvider::class);
$app->add(JsonWrapper::class);

require_once __DIR__ . '/../Middleware/ErrorHandler.php';

$app->options('/{routes:.+}', function ($request, $response) {
    return $response;
});

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});