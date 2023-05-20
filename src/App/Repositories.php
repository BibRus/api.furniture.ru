<?php

declare(strict_types=1);

use App\Data\DataBaseConnector;
use App\Repository\ScheduleRepository;

use App\Repository\UserRepository;

use App\Repository\UserRolesRepository;
use function DI\autowire;

$container->set(ScheduleRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\TeacherRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\StudentRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\GroupRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\TypeRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\AuditoriumRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\SubjectRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\ClassNumberRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(\App\Repository\PhotoRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));


$container->set(UserRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));
$container->set(UserRolesRepository::class, autowire()->constructor(\DI\get(DataBaseConnector::class)));

