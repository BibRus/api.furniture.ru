<?php

declare(strict_types=1);

namespace App\Controller;

use Exception;
use Psr\Container\ContainerInterface;
use Slim\Psr7\UploadedFile;

abstract class BaseController {

    protected ContainerInterface $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }


    protected function getSuccessResponseBody(string $message=""): array {
        if (empty($message)) {
            return [
                'code' => 200,
                'status' => 'success',
                'time' => date("Y-m-d H:i:s")
            ];
        } else {
            return [
                'code' => 200,
                'status' => 'success',
                'time' => date("Y-m-d H:i:s"),
                'message' => $message,
            ];
        }
    }

    protected function moveUploadedFile($directory, UploadedFile $uploadedFile): string
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $path = $directory . DIRECTORY_SEPARATOR . $filename;
        $uploadedFile->moveTo($path);
        if ($uploadedFile->getSize() > 9000) {
            throw new Exception('The photo size is large');
        }
        return $path;
    }

}