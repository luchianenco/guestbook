<?php

namespace App\Container;

use App\Controller\DefaultController;
use App\Controller\SecurityController;
use App\Http\Message\Request;
use App\Http\Router\Router;
use App\Http\Router\RouterInterface;
use App\Http\Session\SessionManager;
use App\Http\Session\SessionManagerInterface;
use App\Storage\AdapterInterface;
use App\Storage\MysqlAdapter;

/**
 * Class Configuration
 * @package App\Container
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Build Container Configuration State
     */
    public function getInstances(): array
    {
        return [
            // Direct Instantiation
            RouterInterface::class => (new Router())
                ->add('/', Request::GET, DefaultController::class, 'index')
                ->add('/post/edit', Request::GET, DefaultController::class, 'editPost')
                ->add('/post/update', Request::POST, DefaultController::class, 'updatePost')
                ->add('/post', Request::POST, DefaultController::class, 'newPost')
                ->add('/post/status', Request::POST, DefaultController::class, 'changeStatus')
                ->add('/login', Request::POST, SecurityController::class, 'login')
                ->add('/logout', Request::GET, SecurityController::class, 'logout')
            ,

            // Lazy loading
            \PDO::class => function () {
                return new \PDO(
                    getenv('MYSQL_DSN'),
                    getenv('MYSQL_USER'),
                    getenv('MYSQL_PASSWORD'),
                    [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
                );
            }
        ];
    }

    /**
     * @return array
     */
    public function getDefinitions(): array
    {
        return [
            AdapterInterface::class => MysqlAdapter::class,
            SessionManagerInterface::class => SessionManager::class,
            DefaultController::class,
            SecurityController::class
        ];
    }
}
