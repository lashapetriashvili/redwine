<?php

namespace Redwine\Creator;

use Redwine\Helper\PluginChecker;
use Redwine\Helper\PluginType;
use Redwine\Facades\Redwine;
use Illuminate\Support\Str;

class PluginCreator
{
    /**
     * Plugin Name
     *
     * @var string
     */
    protected $pluginName;

    /**
     * Plugin Type
     *
     * @var int
     */
    protected $pluginType;

    /**
     * The laravel console
     *
     * @var console
     */
    protected $console;

    /**
     * Create a Plain Plugin
     *
     * @var bool
     */
    protected $plain;

    /**
    * Force Status.
    *
    * @var boo
    */
    protected $force;

    /**
     * Set Plugin Name
     *
     * @param $pluginName
     * @return $this
     */
    public function setPluginName($pluginName)
    {
        $this->pluginName = $pluginName;

        return $this;
    }

    /**
     * Set Console
     *
     * @param $console
     * @return $this
     */
    public function setConsole($console)
    {
        $this->console = $console;

        return $this;
    }

    /**
     * set Force
     *
     * @param $force
     * @return $this
     */
    public function setForce($force)
    {
        $this->force = $force;

        return $this;
    }

    /**
     * set Plain
     *
     * @param $plain
     * @return $this
     */
    public function setPlain($plain)
    {
        $this->plain = $plain;

        return $this;
    }

    /**
     * Get Plugin Name
     *
     * @return string
     */
    public function getPluginName()
    {
        return Str::studly($this->pluginName);
    }

    /**
     * Get Plugin Type
     *
     * @return |null
     */
    public function getPluginType()
    {
        // Get Selected Type Index
        $getSelectedTypeIndex = array_search($this->pluginType, PluginType::getPluginType());
        // Return Plugin Type
        return $getSelectedTypeIndex
            ? Redwine::getConfigValue('plugin_type')[--$getSelectedTypeIndex]
            : Redwine::getAllFolderStructure();
    }

    /**
     * Choose Plugin Types For New Plugin
     */
    protected function chooseNewPluginType()
    {
        // Get Plugin Type
        $this->pluginType = $this->console->choice(
            'Choose Plugin Types',
            PluginType::getPluginType(),
            PluginType::getDefaultPluginTypeIndex()
        );
        // Output Info
        $this->console->info('Creating ' . $this->getPluginName() . ' Plugin');
    }

    /**
     * Check If Plugin Already Exist
     *
     * @return bool
     */
    public function checkPlugin()
    {
        // Check Plugin
        if ((new PluginChecker)->check($this->getPluginName())) {
            // Output Error Message
            $this->console->error($this->getPluginName() . ' Already Exist');

            return true;
        }
    }

    /**
     * Create Plugin
     */
    public function create()
    {
        // Check If Plugin Already Exist
        if ($this->checkPlugin()) return;
        // Choose Plugin Types For New Plugin
        $this->chooseNewPluginType();
        // Create Plugin Directories
        (new DirectoryCreator)->setPluginName($this->getPluginName())
            ->setPluginType($this->getPluginType())
            ->setConsole($this->console)
            ->setForce($this->force)
            ->createDirectory();

        // Create Plugin Files
        (new FileCreator)->setPluginName($this->getPluginName())
            ->setPluginType($this->getPluginType())
            ->setConsole($this->console)
            ->create();
    }
}
