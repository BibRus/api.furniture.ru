<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Throwable;

$app->addErrorMiddleware(true, true, true)
->setDefaultErrorHandler(function(ServerRequestInterface $request, Throwable $exception, bool $displayErrorDetails,
                                  bool $logErrors, bool $logErrorDetails, ?LoggerInterface $logger = null) use ($app) {

    $statusCode = 500;
    if (is_int($exception->getCode()) && $exception->getCode() >= 400 && $exception->getCode() <= 500) {
        $statusCode = $exception->getCode();
    }

    $state = [
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'type' => get_class($exception),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
    ];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(json_encode($state,JSON_PRETTY_PRINT));

    return $response
        ->withStatus($statusCode)
        ->withHeader('Content-type', 'application/problem+json');

});

function formatExceptionFragment(Throwable $exception): array {
    return [
        'code' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'type' => get_class($exception),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
    ];
}
