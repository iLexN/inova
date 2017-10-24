<?php

namespace App\Controller\Api\Product\Component;

use App\Controller\AbstractController;
use App\Module\Product\Services\ProductComponentServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Create
 *
 * @package App\Controller\Api\Product\Component
 */
class Create extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        $input = (array) $request->getParsedBody();

        /** @var ProductComponentServices $services */
        $services = $this->container['productComponentServices'];

        $one = $services->create($input);

        return new JsonResponse($one);
    }
}
