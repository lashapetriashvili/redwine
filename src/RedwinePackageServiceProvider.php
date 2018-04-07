<?php
namespace Redwine;
use illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Redwine\Http\Middleware\RedwineMiddleware;

class RedwinePackageServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Redwine', function () {
            return new Redwine;
        });
    }
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
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migration');
        $this->loadViewsFrom(__DIR__ . '/Resources/Views', 'redwine');
        $this->publishes([
            __DIR__ . '/Assets' => public_path('vendor/redwine')
        ], "public");
        
        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('redwine', RedwineMiddleware::class);
        } else {
            $router->middleware('redwine', RedwineMiddleware::class);
        }
        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }
    }
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\UpdateCommand::class);
    }
}
