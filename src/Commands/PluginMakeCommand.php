<?php

namespace Redwine\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
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
    protected $name = 'redwine:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new redwine plugin.';

    /**
     * Get The Console Command Arguments.
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
     * Get The Console Command Options
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Create a plain plugin.'],
            ['force', 'f', InputOption::VALUE_NONE, 'Rewrite already exist plugin.'],
        ];
    }

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
     * Execute the console command.
     */
    public function handle()
    {
        // Get Plugin name(s)
        $names = $this->argument('name');
        // Check If Plugin Name Is Empty
        if ($this->checkPluginName($names)) return;
        // Get Plugin Type
        $type = $this->choice('Choose Plugin Types', Redwine::getPluginType(), Redwine::getDefaultPluginTypeIndex());
        // Loop Each Plugin Name
        foreach ($names as $name) {
            // Create Plugin
            (new PluginCreator)->setFileHandler(new FileHandler)
                ->setConfig(config('redwine'))
                ->setForce($this->option('force'))
                ->setPlain($this->option('plain'))
                ->setPluginName($name)
                ->setPluginType($type)
                ->setConsole($this)
                ->create();
        }
    }
}
