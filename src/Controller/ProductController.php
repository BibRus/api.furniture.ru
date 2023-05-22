<?php

namespace App\Controller;

use App\Service\ProductService;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

class ProductController extends BaseController {

    const PATH_PRODUCT_IMAGES = __DIR__ . '/../../public/images/products';

    private ProductService $productService;

    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    public function save(Request $request, Response $response): Response {
        $product = $request->getParsedBody();

        $this->moveProductImageFile($request->getUploadedFiles(), $product);

        $productId = $this->productService->save($product);
        $response->getBody()->write(json_encode($productId, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response;
    }

    public function update(Request $request, Response $response): Response {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $productId= $route->getArgument('id');

        $product = $request->getParsedBody();
        $product['id'] = $productId;

        $this->moveProductImageFile($request->getUploadedFiles(), $product);

        $productId = $this->productService->update($product);
        $response->getBody()->write(json_encode($productId, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $response;
    }

    public function getAll(Request $request, Response $response): Response {
        $products = $this->productService->getAll();
        if ($products) {
            $response->getBody()->write(json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } else {
            $response->getBody()->write(json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
        return $response;
    }

    public function getById(Request $request, Response $response): Response {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $productId= $route->getArgument('id');
        $product = $this->productService->getById($productId);
        if ($product) {
            $response->getBody()->write(json_encode($product, JSON_PRETTY_PRINT |JSON_UNESCAPED_UNICODE));
        } else {
            $response->getBody()->write(json_encode([], JSON_PRETTY_PRINT |JSON_UNESCAPED_UNICODE));
        }

        return $response;
    }

    public function delete(Request $request, Response $response): Response {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        $productId= $route->getArgument('id');
        $isDeleted = $this->productService->delete($productId);
        if ($isDeleted) {
            $response->getBody()->write(json_encode('Продукт удалён', JSON_PRETTY_PRINT |JSON_UNESCAPED_UNICODE));
        } else {
            $response->getBody()->write(json_encode('Ошибка при удалении продукта', JSON_PRETTY_PRINT |JSON_UNESCAPED_UNICODE));
        }

        return $response;
    }

    private function moveProductImageFile(array $files, array &$product) {
        if (empty($files['image'])) {
            throw new Exception('Изображение не было загружено');
        }

        $image = $files['image'];
        $path = $this->moveUploadedFile(self::PATH_PRODUCT_IMAGES, $image);
        $image = explode('public', $path);
        $product['image'] = end($image);
    }

}