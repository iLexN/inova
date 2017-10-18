<?php
use Dotenv\Dotenv;
use ParagonIE\Cookie\Session as SessionHandler;

date_default_timezone_set('Asia/Hong_Kong');

$autoloader = require '../vendor/autoload.php';

SessionHandler::start();

$evn = new Dotenv(__DIR__.'/../');
$evn->load();

//$settings = \json_decode(file_get_contents(__DIR__.'/../config/app-config.json'), true);
$conf = new Noodlehaus\Config(__DIR__.'/../config');
$settings = $conf->all() ?: [];

// app init
$app = new \Slim\App($settings);
$container = $app->getContainer();
// service setup
require __DIR__.'/../app/dependencies.php';

//db setup
require __DIR__.'/../app/db-setup.php';

//Middleware
require __DIR__.'/../app/middleware.php';

require __DIR__.'/../app/route.php';

// Run!
$app->run();
