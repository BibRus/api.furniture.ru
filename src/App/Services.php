<?php

declare(strict_types=1);

use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\UserRolesRepository;
use App\Service\AuthService;

use App\Service\ProductService;
use function DI\autowire;
use function DI\get;

$container->set(AuthService::class, autowire()->constructor(get(UserRepository::class), get(UserRolesRepository::class)));
$container->set(ProductService::class, autowire()->constructor(get(ProductRepository::class)));

