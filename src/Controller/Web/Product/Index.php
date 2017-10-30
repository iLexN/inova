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

class Index extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {

        /** @var ProductServices $productServices */
        $productServices = $this->container['productServices'];
        /** @var Product $one */
        $p_list = $productServices->findAll();
        $p_list->load('component');



        $out = $this->twig->fetch('product/index.twig', [
            'product_list' => $p_list
        ]);

        return new TextResponse($out);
    }
}
