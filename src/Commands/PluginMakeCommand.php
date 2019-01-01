<?php

namespace Redwine\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Redwine\Creator\PluginCreator;
use Redwine\Handler\FileHandler;
use Illuminate\Console\Command;
use Redwine\Facades\Redwine;

class PluginMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'redwine:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new redwine plugin.';

    /**
     * Check If Plugin Name Is Empty
     *
     * @param $pluginName
     */
    protected function checkPluginName($pluginName)
    {
        if (empty($pluginName)) {
            // Output Error Message
            $this->error('Plugin Name(s) is Empty!');

            return true;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The names of plugins will be created.'],
        ];
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get Plugin name(s)
        $names = $this->argument('name');
        // Check If Plugin Name Is Empty
        if ($this->checkPluginName($names)) return;
        // Get Plugin Type
        $type = $this->choice('Choose Plugin Type', Redwine::getPluginType(), Redwine::getDefaultPluginTypeIndex());
        // Loop Each Plugin Name
        foreach ($names as $name) {
            // Create Plugin
            (new PluginCreator)->setFileHandler(new FileHandler)
                ->setConfig(config('redwine'))
                ->setPluginName($name)
                ->setPluginType($type)
                ->setConsole($this)
                ->create();
        }
    }
}
