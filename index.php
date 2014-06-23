<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '/third-party/Slim/Slim.php';
require dirname(__FILE__) . '/libs/main.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$main = new main();

function security(\Slim\Route $route) {
    $app = \Slim\Slim::getInstance();
    $app->halt(401);
}

$app->get('/', 'security', function() use ($main) {
    echo json_encode($main->status());
});

$app->notFound(function () use ($main) {
    echo json_encode($main->errorNotFound());
});

$app->run();