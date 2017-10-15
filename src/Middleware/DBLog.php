<?php

namespace App\Middleware;

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * logs sql.
 */
class DBLog
{
    /** @var ContainerInterface  */
    protected $c;

    /**
     * @var Capsule
     */
    protected $capsule;

    public function __construct(ContainerInterface $container, Capsule $capsule)
    {
        $this->c = $container;
        $this->capsule = $capsule;
    }

    /**
     * logRoute app setting determineRouteBeforeAppMiddleware = true.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next) : ResponseInterface
    {
        $response = $next($request, $response);
        $query = $this->capsule->getConnection()->getQueryLog();

        /** @var LoggerInterface $logger */
        $logger = $this->c['logger'];
        $logger->info('query', $query);
        /*
                $route = $request->getAttribute('route');
                $this->c->logger->info('route method', $route->getMethods());
                $this->c->logger->info('route name', [$route->getName()]);
        */
        return $response;
    }
}
