<?php

namespace App\Controller\Web\Customer;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Customer\Services\CustomerServices;
use App\Module\Customer\Services\CustomerTypeServices;
use App\Module\Customer\Services\RegionCountryServices;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

class Show extends AbstractController
{

    /**
     * @param ServerRequestInterface $request
     * @param array $args
     *
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        /** @var CustomerServices $customerServices */
        $customerServices = $this->container['customerService'];
        $customer = $customerServices->findOne((int)$args['id']);
        // Get related info
        $customerInfo = $customer->toJson();
        $customerType = $customer->type->pluck('id')->toJson();
        $customerExtra = $customer->extra->toJson();
        $customerStaff = $customer->staff->pluck('id')->toJson();

        /** @var RegionCountryServices $regionServices */
        $regionServices = $this->container['regionServices'];
        $regions = $regionServices->findAllWithLoad();

        /** @var CustomerTypeServices $typeServices */
        $typeServices = $this->container['customerTypeServices'];


        /** @var UserServices $userServices */
        $userServices = $this->container['userServices'];
        $staff_list = $userServices->findAll();

        $out = $this->twig->fetch('customer/create.twig', [
            'mode' => 'edit',
            'customer_info' => $customerInfo,
            'customer_type' => $customerType,
            'customer_extra' => $customerExtra,
            'customer_staff' => $customerStaff,
            'regions' => $regions,
            'customer_type_list' => $typeServices->findAll(),
            'staff_list' => $staff_list->toJson(),
        ]);
        return new TextResponse($out);
    }
}
