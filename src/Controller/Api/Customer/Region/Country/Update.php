<?php

namespace App\Controller\Api\Customer\Region\Country;

use App\Controller\AbstractController;
use App\Module\Customer\Services\RegionCountryServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Update
 *
 * @package App\Controller\Api\Customer\Region\Country
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

        /** @var RegionCountryServices $services */
        $services = $this->container['regionServices'];
        $country = $services->findOneCountry((int) $args['id']);

        $services->updateCountry($country, $input);

        return new JsonResponse($country);
    }
}
