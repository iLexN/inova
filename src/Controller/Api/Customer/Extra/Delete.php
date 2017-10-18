<?php

namespace App\Controller\Api\Customer\Extra;

use App\Controller\AbstractController;
use App\Module\Customer\Services\CustomerExtraInfoServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

class Delete extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        /** @var CustomerExtraInfoServices $services */
        $services = $this->container['customerExtraServices'];
        $services->delete((int) $args['id']);

        return new JsonResponse(['success']);
    }
}
