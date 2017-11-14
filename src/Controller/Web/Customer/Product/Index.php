<?php

namespace App\Controller\Web\Customer\Product;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerServices;
use App\Module\Product\Services\ProductServices;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;


/**
 * Class Index
 *
 * @package App\Controller\Web\Customer\Product
 */
class Index extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        /** @var CustomerServices $customerService */
        $customerService = $this->container['customerService'];
        $customer = $customerService->findOne((int) $args['id']);
        $customer_info = $customer->toArray();
        $customerService->withProducts($customer);
        $product_list = $customer->products->toArray();

        $out = $this->twig->fetch('customer/product/index.twig', [
            'customer_info' => $customer_info,
            'product_list' => $product_list,
        ]);

        return new TextResponse($out);
    }
}
