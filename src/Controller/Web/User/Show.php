<?php

namespace App\Controller\Web\User;

use App\Controller\AbstractController;
use App\Helper\ResponseResult\TextResponse;
use App\Module\User\Entity\User;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;

class Show extends AbstractController
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
        $userList = $userServices->getAll();
        $user = $userServices->findOne($args['id']);

        $out = $this->twig->fetch('user/create.twig', [
            'mode' => 'edit',
            'user_info' => $user,
            'userList' => $userList->filter(function (User $u) use ($user) {
                return $u->id !== $user->id;
            }),
        ]);

        return new TextResponse($out);
    }
}
