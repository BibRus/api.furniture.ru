<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Repository\UserRolesRepository;
use Exception;
use Firebase\JWT\JWT;

use Respect\Validation\Validator;

class AuthService {

    private UserRepository $users;
    private UserRolesRepository $roles;

    public function __construct(UserRepository $users, UserRolesRepository $roles) {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function register(array $user): int {
        $this->validate($user);
        $this->verify($user);
        $userId = $this->users->register($user);
        $this->roles->bind($user['roles'], $userId);
        return $userId;
    }

    public function login(array $user): string {
        $authorizedUser = $this->users->login($user);
        $authorizedUser['roles'] = $this->roles->getRolesById($authorizedUser['id']);
        $token = array(
            'iss' => 'http://furniture.ru',
            'aud' => 'http://furniture.ru',
            'iat' => 1356999524,
            'nbf' => 1357000000,
            'user' => array(
                'name' => $authorizedUser['name'],
                'login' => $authorizedUser['login'],
                'roles' => $authorizedUser['roles']
            )
        );
        return JWT::encode($token, $_SERVER['SECRET_KEY']);
    }

    private function validate(array $user): void {
        if (!Validator::notBlank()->length(4, 40)->validate($user['name'])) {
            throw new Exception('Недопустимое имя');
        }
        if (!Validator::noWhitespace()->alnum()->notBlank()->lowercase()->length(4, 40)->validate($user['login'])) {
            throw new Exception('Недопустимый логин');
        }
        if (!Validator::noWhitespace()->notBlank()->length(6, 40)->validate($user['password'])) {
            throw new Exception('Небезопасный пароль');
        }
    }

    private function verify(array $user): void {
        if ($this->users->getByLogin($user['login'])) {
            throw new Exception('Пользователь с логином ' . $user['login'] . ' уже существует');
        }
    }

}