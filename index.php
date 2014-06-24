<?php
require dirname(__FILE__) . '/third-party/Slim/Slim.php';
require dirname(__FILE__) . '/libs/main.php';
require dirname(__FILE__) . '/utils/constants.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, '.constants::token_name);
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$main = new main();

$app->hook("slim.before.router", function () use ($app) {
    if($app->request()->getMethod() == constants::bad_ass_method) { $app->halt(203, constants::ok); }
});


function security() {
    $app = \Slim\Slim::getInstance();
    $main = new main();
    if(!$main->checkToken($app->request->headers[constants::token_name])) { $app->halt(401); }
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