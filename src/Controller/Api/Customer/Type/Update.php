<?php

namespace App\Controller\Api\Customer\Type;

use App\Controller\AbstractController;
use App\Module\Customer\Services\CustomerTypeServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

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

        /** @var CustomerTypeServices $services */
        $services = $this->container['customerTypeServices'];

        $type = $services->findOne((int) $args['id']);
        $services->update($type, $input);

        return new JsonResponse($type);
    }
}
