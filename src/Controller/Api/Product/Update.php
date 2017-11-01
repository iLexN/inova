<?php

namespace App\Controller\Api\Product;

use App\Controller\AbstractController;
use App\Module\Product\Services\ProductServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Update
 *
 * @package App\Controller\Api\Product
 */
class Update extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        $input = (array) $request->getParsedBody();

        /** @var ProductServices $services */
        $services = $this->container['productServices'];
        $one = $services->findOne($args['id']);

        $model = $input['product_info']['model_no'];
        if (empty($model)) {
            return new JsonResponse(['error'=>'enter model_no']);
        }

        if (!empty($model) && $one->model_no !== $model &&  $services->isModelExist($model)) {
            return new JsonResponse(['error'=>'this model no is exist']);
        }


        $services->updateProduct($one, $input);

        return new JsonResponse($one);
    }
}
