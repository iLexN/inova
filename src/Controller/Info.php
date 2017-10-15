<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\ResponseResultInterface;

class Info extends AbstractController
{
    /**
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    public function action(ServerRequestInterface $request, array $args): ResponseResultInterface
    {
        $uri = $request->getUri()->getPath();

        /** @var LoggerInterface $logger */
        $logger = $this->container['logger'];
        $logger->info('uri', [$uri]);

        $out = ['this is home page'];

        return new JsonResponse($out);
    }
}
