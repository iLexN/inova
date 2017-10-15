<?php

namespace App\Controller\Web\Customer\type;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerTypeServices;
use App\Module\Customer\Services\RegionCountryServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

class Index extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        /** @var CustomerTypeServices $customerTypeServices */
        $customerTypeServices = $this->container['customerTypeServices'];
        $typeList = $customerTypeServices->findAll();

        /** @var RegionCountryServices $regionServices */
        $regionServices = $this->container['regionServices'];
        $regionsList = $regionServices->findAllWithLoad();

        $out = $this->twig->fetch('customer/type/index.twig', [
            'type_list' => $typeList->toJson(),
            'regions_list' => $regionsList->toJson(),
        ]);

        return new TextResponse($out);
    }
}
