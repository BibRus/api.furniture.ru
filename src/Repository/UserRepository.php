<?php

namespace App\Repository;

use Exception;
use PDO;

class UserRepository extends BaseRepository {

    public function register(array $user): int {
        $password_hash = password_hash($user['password'], PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, login, password) VALUE (:name, :login, :password)";
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('name', $user['name']);
        $statement->bindParam('login', $user['login']);
        $statement->bindParam('password', $password_hash);
        $statement->execute();
        return (int) $this->dataBase->lastInsertId();
    }

    public function login(array $candidate): array {
        $query = 'SELECT * FROM users WHERE login = :login';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('login', $candidate['login']);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new Exception('User ' . $candidate['login'] . ' not found');
        } else {
            if (password_verify($candidate['password'], $user['password'])) {
                return $user;
            } else {
                throw new Exception('Password not validate');
            }
        }
    }

    public function getByLogin(string $login): mixed {
        $query = 'SELECT * FROM users WHERE login = :login';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('login', $login);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

}