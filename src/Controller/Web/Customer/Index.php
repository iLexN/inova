<?php

namespace App\Controller\Web\Customer;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Index
 *
 * @package App\Controller\Web\Customer
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
        /** @var CustomerServices $customerServices */
        $customerServices = $this->container['customerService'];
        $customerList = $customerServices->findAll();
        $customerList->load(['type', 'region', 'country', 'extra', 'staff']);

        $out = $this->twig->fetch('customer/index.twig', [
            'customer_list' => $customerList->toJson(),
        ]);

        return new TextResponse($out);
    }
}
