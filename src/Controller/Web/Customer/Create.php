<?php

namespace App\Controller\Web\Customer;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerTypeServices;
use App\Module\Customer\Services\RegionCountryServices;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
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

        /** @var RegionCountryServices $regionServices */
        $regionServices = $this->container['regionServices'];
        $regions = $regionServices->findAllWithLoad();

        /** @var CustomerTypeServices $typeServices */
        $typeServices = $this->container['customerTypeServices'];

        /** @var UserServices $userServices */
        $userServices = $this->container['userServices'];
        $staff_list = $userServices->getAll();

        $out = $this->twig->fetch('customer/create.twig', [
            'mode' => 'new',
            'customer_info' => $this->getNew(),
            'customer_type' => '[]',
            'customer_extra' => '[]',
            'customer_staff' => '[]',
            'regions' => $regions,
            'customer_type_list' => $typeServices->findAll(),
            'staff_list' => $staff_list->toJson(),
        ]);

        return new TextResponse($out);
    }

    private function getNew()
    {
        return \json_encode([
            'code' => '',
            'name' => '',
            'comment' => '',
            'country_id' => '',
            'region_id' => '',
        ]);
    }
}
