<?php

namespace App\Repository;

use PDO;

class ProductRepository extends BaseRepository {

    public function getById(int $id): array|false {
        $query = 'SELECT * FROM  products WHERE id = :id';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('id', $id);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    public function getAll(): array|false {
        $query = 'SELECT * FROM  products';
        $statement = $this->dataBase->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(array $product): int {
        $query = 'INSERT INTO products (title, description, image, price, category_id) VALUE (:title, :description, :image, :price, :category_id)';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('title', $product['title']);
        $statement->bindParam('description', $product['description']);
        $statement->bindParam('image', $product['image']);
        $statement->bindParam('price', $product['price']);
        $statement->bindParam('category_id', $product['category_id']);
        $statement->execute();
        return (int) $this->dataBase->lastInsertId();
    }

    public function update(array $product): bool {
        $query = 'UPDATE products SET title = :title, description = :description, image = :image, price = :price, category_id = :category_id WHERE id = :id';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('id', $product['id']);
        $statement->bindParam('title', $product['title']);
        $statement->bindParam('description', $product['description']);
        $statement->bindParam('image', $product['image']);
        $statement->bindParam('price', $product['price']);
        $statement->bindParam('category_id', $product['category_id']);
        return $statement->execute();
    }

    public function deleteById(int $id): bool {
        $query = 'DELETE FROM products WHERE id = :id';
        $statement = $this->dataBase->prepare($query);
        $statement->bindParam('id', $id);
        return $statement->execute();
    }

    public function count(): int {
        $query = 'SELECT COUNT(id) FROM products';
        $statement = $this->dataBase->prepare($query);
        $statement->execute();
        return (int) $statement->fetch(PDO::FETCH_ASSOC);
    }

}