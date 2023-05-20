<?php

declare(strict_types=1);

use App\Repository\UserRepository;
use App\Repository\UserRolesRepository;
use App\Service\AuthService;

use function DI\autowire;
use function DI\get;

$container->set(App\Service\ScheduleService::class, autowire()->constructor(get(\App\Repository\ScheduleRepository::class)));
$container->set(App\Service\UserAuthService::class, autowire()->constructor(get(UserRepository::class)));
$container->set(App\Service\UserLoginService::class, autowire()->constructor(get(UserRepository::class)));
$container->set(App\Service\UserSignInService::class, autowire()->constructor(get(UserRepository::class)));
$container->set(App\Service\TeacherService::class, autowire()->constructor(get(\App\Repository\TeacherRepository::class)));
$container->set(App\Service\StudentService::class, autowire()->constructor(get(\App\Repository\StudentRepository::class)));
$container->set(App\Service\GroupService::class, autowire()->constructor(get(\App\Repository\GroupRepository::class)));
$container->set(App\Service\TypeService::class, autowire()->constructor(get(\App\Repository\TypeRepository::class)));
$container->set(App\Service\AuditoriumService::class, autowire()->constructor(get(\App\Repository\AuditoriumRepository::class)));
$container->set(App\Service\SubjectService::class, autowire()->constructor(get(\App\Repository\SubjectRepository::class)));
$container->set(App\Service\ClassNumberService::class, autowire()->constructor(get(\App\Repository\ClassNumberRepository::class)));
$container->set(App\Service\PhotoService::class, autowire()->constructor(get(\App\Repository\PhotoRepository::class)));


$container->set(AuthService::class, autowire()->constructor(get(UserRepository::class), get(UserRolesRepository::class)));

