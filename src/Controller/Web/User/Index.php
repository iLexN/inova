<?php

namespace App\Controller\Web\User;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\User\Services\UserServices;
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
        /** @var UserServices $userServices */
        $userServices = $this->container['userServices'];
        $userList = $userServices->findAll();

        $out = $this->twig->fetch('user/index.twig', [
            'user_list' => $userList->toJson(),
        ]);

        return new TextResponse($out);
    }
}
