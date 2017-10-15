<?php

namespace App\Helper\ResponseResult;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Response Result
 */
class JsonResponse implements ResponseResultInterface
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

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getResponse(ResponseInterface $response) : ResponseInterface
    {
        $response->getBody()->write(\json_encode($this->msg, JSON_PRETTY_PRINT));
        $response = $response->withHeader('Content-type', 'application/json');

        return $response;
    }
}
