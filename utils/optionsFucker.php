<?php
require dirname(__FILE__) . '/../third-party/Slim/Middleware.php';

class optionsFucker extends \Slim\Middleware
{
    public function call()
    {
        $route = $this->app->router()->getCurrentRoute();
        var_dump($route->getHttpMethods());
        /*
        if($route->getHttpMethods()[0]=="OPTIONS") {
            $this->app->halt(200);
        }
        */
        $this->next->call();
    }
}