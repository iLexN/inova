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

/**
 * Class Show
 *
 * @package App\Controller\Web\Product
 */
class Show extends AbstractController
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

        /** @var ProductServices $productServices */
        $productServices = $this->container['productServices'];
        /** @var Product $one */
        $one = $productServices->findOne($args['id']);
        $p_info = $one->toJson();
        $pcList = $one->component->toJson();

        $out = $this->twig->fetch('product/edit.twig', [
            'mode' => 'edit',
            'product_info' => $p_info,
            'pc_list' => $pcList,
            'list' => $list->toJson(),
            'type_list' => Component::TYPE_LIST,
        ]);

        return new TextResponse($out);
    }
}
