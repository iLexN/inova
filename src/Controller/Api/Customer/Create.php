<?php

namespace App\Controller\Api\Customer;

use App\Controller\AbstractController;
use App\Module\Customer\Services\CustomerServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

class Create extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        $input = (array)$request->getParsedBody();

        //todo add checking

        /** @var CustomerServices $services */
        $services = $this->container['customerService'];

        if ($services->isCodeExist($input['customer']['code'])) {
            return new JsonResponse(['error'=>'code already exist']);
        }

        $customer = $services->createCustomer($input);

        return new JsonResponse($customer);
    }
}
