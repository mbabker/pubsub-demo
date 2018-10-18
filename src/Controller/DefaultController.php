<?php

namespace App\Controller;

use Gos\Bundle\PubSubRouterBundle\Request\PubSubRequest;
use Gos\Bundle\PubSubRouterBundle\Router\Route;
use Gos\Bundle\PubSubRouterBundle\Router\RouterRegistry;

class DefaultController
{
    /**
     * @var RouterRegistry
     */
    private $registry;

    public function __construct(RouterRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function index()
    {
        $router = $this->registry->getRouter('notification');

        $generatedRoute = $router->generate('user_notification', ['role' => 'admin', 'application' => 'pubsub-demo', 'user_ref' => 42]);
        dump($generatedRoute);

        /**
         * @var string $routeName
         * @var Route  $route
         * @var array  $attributes
         */
        list($routeName, $route, $attributes) = $router->match($generatedRoute);

        dump($routeName, $route, $attributes);

        $request = new PubSubRequest($routeName, $route, $attributes);

        call_user_func($route->getCallback(), $request);

        die;
    }
}
