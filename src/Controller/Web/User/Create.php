<?php

namespace App\Controller\Web\User;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Create
 *
 * @package App\Controller\Web\User
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
        /** @var UserServices $userServices */
        $userServices = $this->container['userServices'];
        $userList = $userServices->findAll();

        $out = $this->twig->fetch('user/create.twig', [
            'mode' => 'new',
            'user_info' => $this->getNew(),
            'userList' => $userList,
        ]);

        return new TextResponse($out);
    }

    /**
     * default field init
     *
     * @return string
     */
    private function getNew()
    {
        return \json_encode([
            'name' => '',
            'email' => '',
            'department' => '',
            'title' => '',
            'head_id' => '',
        ]);
    }
}
