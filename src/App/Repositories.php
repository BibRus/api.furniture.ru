<?php

declare(strict_types=1);

use App\Data\DataBaseConnector;
use App\Repository\UserRepository;
use App\Repository\UserRolesRepository;

use function DI\autowire;
use function DI\get;

$container->set(UserRepository::class, autowire()->constructor(get(DataBaseConnector::class)));
$container->set(UserRolesRepository::class, autowire()->constructor(get(DataBaseConnector::class)));

