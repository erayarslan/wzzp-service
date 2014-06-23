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

        var_dump($route);
    }
}