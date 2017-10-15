<?php

namespace App\Helper\ResponseResult;

use Psr\Http\Message\ResponseInterface;

/**
 * Class RedirectResponse
 * @package Tink\Controller\ResponseResult
 */
class RedirectResponse implements ResponseResultInterface
{
    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $location;

    /**
     * RedirectResponse constructor.
     * @param int $code
     * @param string $location
     */
    public function __construct($code, $location)
    {
        $this->code = $code;
        $this->location = $location;
    }

    /**
     * 301 Redirect with path
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function getResponse(ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus($this->code)->withHeader('Location', $this->location);
    }
}
