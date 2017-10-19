<?php

$settings = [
    'settings' => [
        'displayErrorDetails' => (bool)getenv('DISPLAY_ERROR_DETAILS'),
        'determineRouteBeforeAppMiddleware' => true,
    ],
];

if ( (bool)getenv('ROUTER_CACHE_ENABLE') ){
    $settings['settings']['routerCacheFile'] = __DIR__ . '/../cache/route.cache';
}

return $settings;
