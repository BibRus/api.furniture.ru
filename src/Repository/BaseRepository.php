<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

abstract class BaseRepository {

    protected PDO $dataBase;

    public function __construct(PDO $dataBase) {
        $this->dataBase = $dataBase;
    }

    protected function fetchQueryBuild(string $query, array $params=[], int $fetchMode=PDO::FETCH_ASSOC): array|false {
        $statement = $this->dataBase->prepare($query);
        if ($params) {
            foreach ($params as $param => &$value) {
                $statement->bindParam($param, $value);
            }
        }
        $statement->execute();
        return $statement->fetchAll($fetchMode);
    }

}




