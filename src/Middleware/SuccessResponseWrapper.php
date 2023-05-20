<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

final class SuccessResponseWrapper {

    public function  __invoke(Request $request, RequestHandler $handler): Response {
        $response = $handler->handle($request);
        $success = $this->getSuccessResponseBody(code: $response->getStatusCode());
        $next = (array) $response->getBody()->getContents();
        array_push($next, $success);
        $response->getBody()->write(json_encode($next, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response->withHeader('Content-Type', 'application/json');
    }

    private function getSuccessResponseBody($code, $message = ''): array {
        if ($message) {
            return [
                'code' => $code,
                'status' => 'success',
                'time' => date("Y-m-d H:i:s")
            ];
        } else {
            return [
                'code' => $code,
                'status' => 'success',
                'time' => date("Y-m-d H:i:s"),
                'message' => $message,
            ];
        }
    }

}