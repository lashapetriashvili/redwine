<?php

namespace Redwine\Creator;

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
     * Redwine Config (config/redwine.php)
     *
     * @var array
     */
    protected $config;

    /**
     *  Plugin File Handler
     *
     * @var class
     */
    protected $fileHandler;

    /**
     * The laravel console
     *
     * @var console
     */
    protected $console;

    /**
     * Plugin Type
     *
     * @var int
     */
    protected $pluginType;

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
     * Get Plugin Name
     *
     * @return string
     */
    public function getPluginName()
    {
        return Str::studly($this->pluginName);
    }

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
     * get Config
     *
     * @param $getValue
     * @return mixed
     */
    public function getConfig($getValue)
    {
        return $this->config[$getValue];
    }

    /**
     * Set Config
     *
     * @param $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set File Management
     *
     * @param $fileManagement
     * @return $this
     */
    public function setFileHandler($fileHandler)
    {
        $this->fileHandler = $fileHandler;

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
     * Get Plugin Type
     *
     * @return false|int|string
     */
    public function getPluginType()
    {
        return array_search($this->pluginType, Redwine::getPluginType());
    }

    /**
     * Set Plugin Type
     *
     * @param $type
     * @return $this
     */
    public function setPluginType($type)
    {
        $this->pluginType = $type;

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
     * Check If Plugin Already Exist
     *
     * @return bool
     */
    public function checkPlugin()
    {
        if ($this->fileHandler->checkPlugin($this->getPluginName())
            || $this->fileHandler->checkPluginDirectory($this->getPluginName())
        ) {
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
        // Output Info
        $this->console->info('Creating ' . $this->getPluginName() . ' Plugin');
    }
}
