<?php
namespace Redwine;

use illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

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
        if ($this->app->runningInConsole()) {
            $this->registerConsoleCommands();
        }

        $this->registerConfigFile();
    }

    /**
     * Register Config File
     */
    protected function registerConfigFile()
    {
        $configPath = __DIR__ . '/../config/config.php';

        $this->mergeConfigFrom($configPath, 'redwine');
        $this->publishes([
            $configPath => config_path('redwine.php'),
        ], 'config');
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\PluginMakeCommand::class);
    }
}
