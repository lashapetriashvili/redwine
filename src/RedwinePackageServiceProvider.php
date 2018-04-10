<?php
namespace Redwine;
use illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Redwine\Http\Middleware\RedwineMiddleware;

class RedwinePackageServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('Redwine', function () {
            return new Redwine;
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $this->publishes([
            __DIR__.'/Assets' => public_path('assets'),
        ], 'public_assets');
        $this->publishes([
            __DIR__.'/Uploads' => public_path('uploads'),
        ], 'public_uploads');
        $this->publishes([
            __DIR__.'/RedwineLang' => resource_path('redwineLang'),
        ], 'public_uploads');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'redwine');
        $this->loadViewsFrom(app_path('RedwinePlugins'), 'redwinePlugin');
        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/redwine')
        ], 'public');
        
        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('redwine', RedwineMiddleware::class);
        } else {
            $router->middleware('redwine', RedwineMiddleware::class);
        }
        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\UpdateCommand::class);
    }
}
