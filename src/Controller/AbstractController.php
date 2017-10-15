<?php

namespace App\Controller;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Helper\ResponseResult\ResponseResultInterface;
use Slim\Views\Twig;

abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /** @var  Twig */
    protected $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container['twig'];
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args)
    {
        $result = $this->action($request, $args);

        return $result->getResponse($response);
    }

    /**
     * the action process the Request
     * @param ServerRequestInterface $request
     * @param array $args
     * @return ResponseResultInterface
     */
    abstract protected function action(ServerRequestInterface $request, array $args): ResponseResultInterface;
}
