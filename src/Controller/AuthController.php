<?php

namespace App\Controller;

use App\Service\AuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController {

    private AuthService $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function register(Request $request, Response $response): Response {
        $user = $request->getParsedBody();
        $userId = $this->authService->register($user);
        $response->getBody()->write(json_encode($userId, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response;
    }

    public function login(Request $request, Response $response): Response {
        $user = $request->getParsedBody();
        $this->authService->login($user);
        //, 'token' => $request->getAttribute('token'));
        $sus = array('token' => $this->authService->login($user));
        $payload = json_encode($sus);

        $response->getBody()->write($payload);
        return $response;

    }

}