<?php

//Last In First Executed
if (getenv('DB_LOG')) {
    $app->add(new \App\Middleware\DBLog($container, $capsule));
}

