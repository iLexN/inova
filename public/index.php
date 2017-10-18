<?php
use Dotenv\Dotenv;
use ParagonIE\Cookie\Session as SessionManager;


date_default_timezone_set('Asia/Hong_Kong');

$autoloader = require '../vendor/autoload.php';

SessionManager::start();

$evn = new Dotenv(__DIR__.'/../');
$evn->load();

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
