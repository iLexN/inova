<?php

namespace App\Controller\Web\Customer\Product;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerServices;
use App\Module\Product\Services\ProductServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;


/**
 * Class Attach
 *
 * @package App\Controller\Web\Customer\Product
 */
class Attach extends AbstractController
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

        /** @var ProductServices $productServices */
        $productServices = $this->container['productServices'];
        $product_list = $productServices->findCustomerNotHaveProduct((int) $args['id']);

        $out = $this->twig->fetch('customer/product/attach.twig', [
            'customer_info' => $customer,
            'product_list' => $product_list
        ]);

        return new TextResponse($out);
    }
}