<?php

namespace App\Controller\Web\Product;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Product\Entity\Component;
use App\Module\Product\Services\ProductComponentServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class ComponentShow
 *
 * @package App\Controller\Web\Product
 */
class ComponentShow extends AbstractController
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

        $out = $this->twig->fetch('product/component.twig', [
            'new_info' => $this->getNew(),
            'list' => $list,
            'type_list' => Component::TYPE_LIST,
        ]);

        return new TextResponse($out);
    }

    /**
     * Get default field init
     *
     * @return string
     */
    private function getNew()
    {
        return \json_encode([
            'type' => Component::TYPE_LIST[0],
            'value' => '',
        ]);
    }
}
