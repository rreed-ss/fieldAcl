<?php namespace Neposoft\FieldAcl;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class FieldAclServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //  $this->app->bind('Neposoft\FieldAcl', '');
    }

    public function boot(Router $router)
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'fieldAcl');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/fieldAcl'),
            __DIR__ . '/fieldAclConfig.php' => base_path('config/fieldAcl.php'),
            __DIR__ . '/create_acl_fields_permissions_table.php' => base_path('database/migrations/create_acl_fields_permissions_table.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/fieldAclConfig.php', 'fieldAcl');

        $route = $this->app['config']->get('fieldAcl.route', []);
        $route['namespace'] = 'Neposoft\FieldAcl';
        if (!isset($route['middleware']) || is_array($route['middleware'])) {
            $route['middleware'][] = 'web';
        }

        $router->group($route, function ($router) {
            $router->resource('/', 'FieldAclController', ['only' => ['index', 'store']]);
        });

    }
}