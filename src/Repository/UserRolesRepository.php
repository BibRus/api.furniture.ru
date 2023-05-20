<?php

namespace App\Repository;

use PDO;

class UserRolesRepository extends BaseRepository {

    public function bind(array $roles, int $userId): string|bool {
        foreach ($roles as &$role) {
            $queryStudents = "INSERT INTO user_roles (user_id, role_id) VALUE (:user_id, :role_id)";
            $roleId = $this->getIdByTitle($role);
            $statement = $this->dataBase->prepare($queryStudents);
            $statement->bindParam('user_id', $userId);
            $statement->bindParam('role_id', $roleId);
            $statement->execute();
            $statement->fetchAll();
        }
        return $this->dataBase->lastInsertId();
    }

    public function getIdByTitle(string $title): int {
        $query = 'SELECT id FROM roles WHERE title = :title';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('title', $title);
        $statement->execute();
        $role = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();
        return (int) $role['id'];
    }

    public function getTitleById(int $id): string {
        $query = 'SELECT title FROM roles WHERE id = :id';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('id', $id);
        $statement->execute();
        $role = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();
        return (string) $role['title'];
    }

    public function getRolesById(int $id): array {
        $query = 'SELECT role_id FROM user_roles WHERE user_id = :id';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('id', $id);
        $statement->execute();
        $roleIds = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->execute();
        $roles = [];
        foreach ($roleIds as &$roleId) {
            $roles[] = $this->getTitleById($roleId);
        }
        return $roles;
    }

}