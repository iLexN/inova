<?php

namespace App\Controller\Api\Customer;

use App\Controller\AbstractController;
use App\Module\Customer\Entity\Customers;
use App\Module\Customer\Services\CustomerServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Update
 *
 * @package App\Controller\Api\Customer
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
        //todo add checking

        /** @var CustomerServices $services */
        $services = $this->container['customerService'];

        /** @var Customers $customer */
        $customer = $services->findOne((int) $args['id']);

        $code = $input['customer']['code'];
        if ($customer->code !== $code && $services->isCodeExist($code)) {
            return new JsonResponse(['error'=>'code already exist']);
        }

        $services->updateCustomer($customer, $input);

        return new JsonResponse($customer);
    }
}
