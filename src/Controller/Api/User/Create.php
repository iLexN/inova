<?php

namespace App\Controller\Api\User;

use App\Controller\AbstractController;
use App\Module\User\Services\UserServices;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

/**
 * Class Create
 *
 * @package App\Controller\Api\User
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
        $input = (array) $request->getParsedBody();

        //todo: add validation check input
        $input['head_id'] = !empty($input['head_id']??null) ? $input['head_id'] : null;


        /** @var UserServices $userServices */
        $userServices = $this->container['userServices'];

        if ($userServices->isEmailExist($input['email'])) {
            return new JsonResponse(['error'=>'email already exist']);
        }
        
        if (!empty($input['head_id']) && (!\is_numeric($input['head_id']) || !$userServices->isUserExist($input['head_id']))) {
            return new JsonResponse(['error'=>'belong to not exist']);
        }

        $user = $userServices->create($input);

        return new JsonResponse($user);
    }
}
