<?php

namespace App\Controller\Web\Product;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Product\Entity\Component;
use App\Module\Product\Entity\Product;
use App\Module\Product\Services\ProductComponentServices;
use App\Module\Product\Services\ProductServices;
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
        /** @var ProductComponentServices $services */
        $services = $this->container['productComponentServices'];
        $list = $services->findAll();

        $out = $this->twig->fetch('product/edit.twig', [
            'mode' => 'new',
            'product_info' => $this->getNewInfo(),
            'pc_list' => '[]',
            'list' => $list->toJson(),
            'type_list' => Component::TYPE_LIST,
        ]);

        return new TextResponse($out);
    }

    public function getNewInfo()
    {
        return \json_encode([
            'model_no'=> '',
            'material_code'=> '',
            'product_description'=> '',
            'product_voltage'=> '',
            'product_input_current'=> '',
            'product_framesize'=> '',
            'tp_withvat_rmb'=> '',
            'tp_novat_rmb'=> '',
            'tp_update_date'=> '',
            'tp_update_by'=> '',
            'list_price_fobsh_usd'=> '',
            'remark'=> '',
        ]);
    }
}
