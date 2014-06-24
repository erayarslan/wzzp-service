<?php
require dirname(__FILE__) . '/../third-party/Slim/Middleware.php';

class optionsFucker extends \Slim\Middleware
{
    public function call()
    {
        $this->app->hook('slim.before.dispatch', array($this, 'onBeforeDispatch'));
        $this->next->call();
    }

    public function onBeforeDispatch()
    {
        $route = $this->app->router()->getCurrentRoute();
        $methods = $route->getHttpMethods();
        if($methods[0]=="OPTIONS") {
            $this->app->halt(200);
            echo "HERE!";
        }
    }
}