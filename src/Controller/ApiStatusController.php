<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ApiStatusController extends BaseController {

    public function __invoke(Request $request, Response $response): Response {
        $success = $this->getSuccessResponseBody();
        $success['status'] = $this->getApiStatus();
        $response->getBody()->write(json_encode($success, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response;
    }

    private function getApiStatus(): array {
        return [
            'phpVersion' => PHP_VERSION,
        ];
    }

}