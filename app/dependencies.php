<?php

use App\Event\CustomerListenerProvider;
use App\Event\UserListenerProvider;
use App\Helper\ResponseResult\JsonResponse;
use App\Helper\ResponseResult\TextResponse;
use App\Module\Cache\CacheHandler;
use App\Module\Customer\Repository\CustomerExtraInfoRepository;
use App\Module\Customer\Repository\CustomerRepository;
use App\Module\Customer\Repository\CustomerTypeRepository;
use App\Module\Customer\Repository\RegionCountryRepository;
use App\Module\Customer\Services\CustomerExtraInfoServices;
use App\Module\Customer\Services\CustomerServices;
use App\Module\Customer\Services\CustomerTypeServices;
use App\Module\Customer\Services\RegionCountryServices;
use App\Module\Login\Repository\LoginRepository;
use App\Module\Login\Services\LoginServices;
use App\Module\User\Repository\UserRepository;
use App\Module\User\Services\UserServices;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

$container['logger'] = function(ContainerInterface $container) {
    $settings = $container->get('logConfig');
    $logger = new \Monolog\Logger($settings['name']);
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], \Monolog\Logger::DEBUG));

    return $logger;
};

// Twig
$container['twig'] = function(ContainerInterface $container) {
    $settings = $container->get('twigConfig');
    $view = new \Slim\Views\Twig($settings['template_path'], $settings['twig']);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['cache'] = function(ContainerInterface $container) {
    $settings = $container->get('cacheConfig');
    $cache = new FilesystemCache($settings['name'], $settings['ttl'], $settings['dir']);
    return new CacheHandler($cache);
};




$container['notFoundHandler'] = function(ContainerInterface $container) {
    return function(ServerRequestInterface $request, ResponseInterface $response) use ($container) {
        /** @var Psr\Log\LoggerInterface $logger */
        $logger = $container['logger'];
        $logger->error('404');
        $json = new JsonResponse(['404']);
        return $json->getResponse($response)->withStatus(404);
    };
};

$container['errorHandler'] = function(ContainerInterface $container) {
    return function(ServerRequestInterface $request, ResponseInterface $response, \Exception $exception) use ($container) {
        /** @var Psr\Log\LoggerInterface $logger */
        $logger = $container['logger'];
        $logger->error('error handler', (array) $exception);
        $res = new TextResponse($exception);
        return $res->getResponse($response)->withStatus(500);
    };
};

$container['phpErrorHandler'] = function(ContainerInterface $container) {
    return function(ServerRequestInterface $request, ResponseInterface $response, $error) use ($container) {
        /** @var Psr\Log\LoggerInterface $logger */
        $logger = $container['logger'];
        $logger->error('php error handler', (array) $error);
        $res = new TextResponse($error);
        return $res->getResponse($response);
    };
};

$container['userServices'] = function(ContainerInterface $container) {
    return new UserServices($container, new UserRepository());
};
$container['loginServices'] = function(ContainerInterface $container) {
    return new LoginServices($container, new LoginRepository());
};
//customer services
$container['regionServices'] = function(ContainerInterface $container) {
    return new RegionCountryServices($container, new RegionCountryRepository());
};
$container['customerTypeServices'] = function(ContainerInterface $container) {
    return new CustomerTypeServices($container, new CustomerTypeRepository());
};
$container['customerExtraServices'] = function(ContainerInterface $container) {
    return new CustomerExtraInfoServices($container, new CustomerExtraInfoRepository());
};
$container['customerService'] = function(ContainerInterface $container) {
    return new CustomerServices($container, new CustomerRepository());
};


$container['eventEmitter'] = function(ContainerInterface $container) {
    $emitter = new Emitter;
    $emitter->useListenerProvider(new UserListenerProvider($container));
    $emitter->useListenerProvider(new CustomerListenerProvider($container));
    return $emitter;
};
