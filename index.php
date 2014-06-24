<?php
require dirname(__FILE__) . '/third-party/Slim/Slim.php';
require dirname(__FILE__) . '/libs/main.php';
require_once dirname(__FILE__) . '/utils/constants.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, '.constants::token_name);
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, '.constants::bad_ass_method);

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->main = new main();

$app->hook(constants::slimBeforeRouter, function () use ($app) {
    if($app->request()->getMethod() == constants::bad_ass_method) { $app->halt(203, constants::ok); }
});

function security() {
    $app = \Slim\Slim::getInstance();
    $result = $app->main->checkToken($app->request->headers[constants::token_name]);
    if(!$result) { $app->halt(401); }
    else { $app->user_id = $result[constants::info]; }
}

$app->get('/', function() use ($app) {
    echo json_encode($app->main->status());
});

$app->get('/users/:user', function($user) use ($app) {
    echo json_encode($app->main->getUserByUsername($user));
});

function fuckingProtected() {
    $app = \Slim\Slim::getInstance();
    echo json_encode(array(
        "hi" => "welcome to protected path!"
    ));
}
$app->get('/fuckingProtected', 'security', 'fuckingProtected');

$app->get('/login', function() use ($app) {
    $username = $app->request()->params('username');
    $password = $app->request()->params('password');
    echo json_encode($app->main->auth($username,$password));
});

$app->notFound(function () use ($app) {
    $app->halt(404);
});

$app->run();