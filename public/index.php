<?php

require __DIR__ . "/../vendor/autoload.php";
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$pdo = new PDO("sqlite:" . __DIR__ . "/../db/chat.sqlite");

$userRoutes = require __DIR__ . "/../src/routes/userRoutes.php";
$userRoutes($app, $pdo);

$messageRoutes = require __DIR__ . "/../src/routes/messageRoutes.php";
$messageRoutes($app, $pdo);

$groupRoutes = require __DIR__ . "/../src/routes/groupRoutes.php";
$groupRoutes($app, $pdo);

$groupUserRoutes =  require __DIR__ . "/../src/routes/groupUserRoutes.php";
$groupUserRoutes($app, $pdo);

$app->run();