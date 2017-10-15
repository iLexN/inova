<?php

namespace App\Helper\ResponseResult;

use Psr\Http\Message\ResponseInterface;

interface ResponseResultInterface
{
    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getResponse(ResponseInterface $response) : ResponseInterface;
}
