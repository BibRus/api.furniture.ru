<?php

namespace App\Service;

use Exception;
use Respect\Validation\Validator;
use App\Repository\ProductRepository;

class ProductService {

    private ProductRepository $products;

    public function __construct(ProductRepository $products) {
        $this->products = $products;
    }

    public function save(array $product): int {
        $this->validate($product);
        return $this->products->save($product);
    }

    public function update(array $product): bool {
        $this->validate($product);
        return $this->products->update($product);
    }

    public function getAll(): array|false {
        return $this->products->getAll();
    }

    public function getById(int $id): array|false {
        return $this->products->getById($id);
    }

    public function delete(int $id): bool {
        return $this->products->deleteById($id);
    }

    private function validate(array $product): void {
        if (!Validator::notBlank()->length(4, 240)->validate($product['title'])) {
            throw new Exception('Недопустимая длина названия');
        }
        if (!Validator::notBlank()->length(0, 1200)->validate($product['description'])) {
            throw new Exception('Недопустимая длина описания');
        }
        if (!Validator::notBlank()->length(0, 480)->validate($product['image'])) {
            throw new Exception('Недопустимая длина пути изображения');
        }
        if (!Validator::notBlank()->length(1, 20)->validate($product['price'])) {
            throw new Exception('Недопустимая цена');
        }
    }

}