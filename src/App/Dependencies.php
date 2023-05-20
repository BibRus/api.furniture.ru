<?php

declare(strict_types=1);

use App\Data\DataBaseConnector;

$container->set(DataBaseConnector::class, fn() => DataBaseConnector::getConnect());
