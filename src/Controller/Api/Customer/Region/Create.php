<?php

namespace App\Controller\Api\Customer\Region;

use App\Controller\AbstractController;
use App\Module\Customer\Services\RegionCountryServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Create
 *
 * @package App\Controller\Api\Customer\Region
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

        /** @var RegionCountryServices $services */
        $services = $this->container['regionServices'];
        $region = $services->createRegion($input);

        return new JsonResponse($region);
    }
}
