<?php

namespace App\Controller;

use Gos\Bundle\PubSubRouterBundle\Request\PubSubRequest;
use Gos\Bundle\PubSubRouterBundle\Router\Route;
use Gos\Bundle\PubSubRouterBundle\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;

class DefaultController implements ServiceSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index()
    {
        /** @var RouterInterface $router */
        $router = $this->container->get('gos_pubsub_router.notification');

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

    public static function getSubscribedServices()
    {
        return [
            'gos_pubsub_router.notification' => RouterInterface::class,
        ];
    }
}
