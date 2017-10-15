<?php

namespace App\Helper\ResponseResult;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\NotFoundException;

/**
 * Class Response Result
 */
class NotFountResponse implements ResponseResultInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * Response Result constructor.
     * @param ServerRequestInterface $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * NotFound
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \Slim\Exception\NotFoundException
     */
    public function getResponse(ResponseInterface $response) : ResponseInterface
    {
        throw new NotFoundException($this->request, $response);
    }
}
