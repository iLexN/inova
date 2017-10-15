<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERROR_DETAILS'),
        //'routerCacheDisabled' => false,
        //'routerCacheFile' => __DIR__ . '/../cache/route.cache',
        'determineRouteBeforeAppMiddleware' => true,
    ],
];
