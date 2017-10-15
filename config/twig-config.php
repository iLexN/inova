<?php

return [
    'twigConfig' => [
        // View settings
        'template_path' => __DIR__.'/../templates',
        'twig'          => [
            'cache'       => __DIR__.'/../cache/twig',
            'debug'       => true,
            'auto_reload' => true,
        ],
    ],
];