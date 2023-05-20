<?php

declare(strict_types=1);

namespace App\Exception;

use Slim\Exception\HttpSpecializedException;

class HttpNotFoundException extends HttpSpecializedException {

    protected $code = 404;

    protected $message = 'Ресурс не найден';

    protected string $title = '404 Не найдено';
    protected string $description = 'Запрошенный ресурс не удалось найти. Пожалуйста, проверьте URI и повторите попытку';

}