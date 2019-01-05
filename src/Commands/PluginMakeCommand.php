<?php

namespace Redwine\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Redwine\Creator\PluginCreator;
use Illuminate\Console\Command;

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
            ['name', InputArgument::OPTIONAL, 'The name of plugin .'],
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
     * @return bool
     */
    protected function checkPluginName()
    {
        if (empty($this->argument('name'))) {
            // Output Error Message
            $this->error('Plugin Name is Empty!');

            return true;
        }
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check If Plugin Name Is Empty
        if ($this->checkPluginName()) return;
        // Create Plugin
        (new PluginCreator)->setPluginName($this->argument('name'))
            ->setForce($this->option('force'))
            ->setPlain($this->option('plain'))
            ->setConsole($this)
            ->create();
    }
}
