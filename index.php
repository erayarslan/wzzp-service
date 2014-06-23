<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

require dirname(__FILE__) . '/third-party/Slim/Slim.php';
require dirname(__FILE__) . '/libs/main.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'debug' => true
));
$main = new main();
$app->add(new \optionsFucker());

function security(\Slim\Route $route) {
    $app = \Slim\Slim::getInstance();
    $main = new main();
    if(!$main->checkToken($app->request->headers["wzzp_token"])) {
        $app->halt(401);
    }
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