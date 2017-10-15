<?php

namespace App\Helper\ResponseResult;

use Psr\Http\Message\ResponseInterface;

class TextResponse implements ResponseResultInterface
{
    /** @var mixed  */
    private $msg;

    /**
     * Response Result constructor.
     * @param mixed $msg
     */
    public function __construct($msg)
    {
        $this->msg = $msg;
    }

    public function getResponse(ResponseInterface $response): ResponseInterface
    {
        $response->getBody()->write($this->msg);
        return $response;
    }
}
