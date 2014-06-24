<?php
require dirname(__FILE__) . '/third-party/Slim/Slim.php';
require dirname(__FILE__) . '/libs/main.php';
require dirname(__FILE__) . '/utils/constants.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, wzzp_token');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$main = new main();

$app->hook("slim.before.router", function () use ($app) {
    if($app->request()->getMethod() == "OPTIONS") { $app->halt(203, "OK"); }
});


function security() {
    $app = \Slim\Slim::getInstance();
    $main = new main();
    if(!$main->checkToken($app->request->headers["wzzp_token"])) { $app->halt(401); }
}

$app->get('/', 'security', function() use ($main,$app) {
    echo json_encode($main->status());
});

$app->get('/login', function() use ($main,$app) {
    $username = $app->request()->params('username');
    $password = $app->request()->params('password');
    echo json_encode($main->auth($username,$password));
});

$app->notFound(function () use ($main,$app) {
    $app->halt(404);
});

$app->run();