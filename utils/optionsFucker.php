<?php
require dirname(__FILE__) . '/../third-party/Slim/Middleware.php';

class optionsFucker extends \Slim\Middleware
{
    public function call()
    {
        if($this->app->router()->getCurrentRoute()->getHttpMethods()[0]=="OPTIONS") {
            $this->app->halt(200);
        }
        $this->next->call();
    }
}