<?php

declare(strict_types=1);

use App\Repository\UserRepository;
use App\Repository\UserRolesRepository;
use App\Service\AuthService;

use function DI\autowire;
use function DI\get;

$container->set(AuthService::class, autowire()->constructor(get(UserRepository::class), get(UserRolesRepository::class)));

