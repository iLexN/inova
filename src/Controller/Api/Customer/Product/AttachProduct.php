<?php

namespace App\Controller\Api\Customer\Product;

use App\Controller\AbstractController;
use App\Module\Customer\Services\CustomerServices;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class AttachProduct
 *
 * @package App\Controller\Api\Customer\Product
 */
class AttachProduct extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        $input = (array) $request->getParsedBody();

        /** @var CustomerServices $customerService */
        $customerService = $this->container['customerService'];
        $customer = $customerService->findOne($args['id']);
        $customerService->attachProduct($customer, $input);

        return new JsonResponse($input);
    }
}