<?php

namespace App\Controller\Api\Product\Component;

use App\Controller\AbstractController;
use App\Module\Product\Services\ProductComponentServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Delete
 *
 * @package App\Controller\Api\Product\Component
 */
class Delete extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        /** @var ProductComponentServices $services */
        $services = $this->container['productComponentServices'];
        $services->delete($args['id']);

        return new JsonResponse(['success']);
    }
}
