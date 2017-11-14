<?php

namespace App\Controller\Api\Customer\Product;

use App\Controller\AbstractController;
use App\Module\Customer\Services\CustomerServices;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Update
 *
 * @package App\Controller\Api\Customer\Product
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
        $pid = $args['pid'];

        /** @var CustomerServices $customerService */
        $customerService = $this->container['customerService'];
        $customer = $customerService->findOne($args['id']);
        $customerService->updateProducts($customer, $pid, $input);

        $customerService->withProducts($customer);
        $key = $customer->products->search(function ($item) use ($pid) {
            return $item->id === (int)$pid;
        });


        return new JsonResponse($customer->products->get($key));
    }
}