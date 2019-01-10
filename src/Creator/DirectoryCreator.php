<?php

namespace Redwine\Creator;

use Redwine\Helper\Directory;
use Redwine\Facades\Redwine;

class DirectoryCreator
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
     * Get Plugin Directory Path
     *
     * @param $directoryName
     * @return mixed
     */
    protected function getPluginDirectoryPath($directoryName)
    {
        return Redwine::getPluginFolderPath($this->pluginName . '\\' . $directoryName);
    }

    /**
     * Make Directory
     *
     * @param $path
     * @param int $mode
     * @param bool $recursive
     * @return bool
     */
    protected function makeDirectory($path, $mode = 0755, $recursive = false)
    {
        return Directory::makeDirectory($path, $mode, $recursive, $this->force);
    }

    /**
     * Create Plugin Directories
     */
    public function createDirectory()
    {
        foreach ($this->pluginType as $type) {
            // Check IF This Type Exist In config
            if (Redwine::getConfigValue('folder_structure.' . $type . '.path')) {
                // Get Plugin Directory Path
                $path = $this->getPluginDirectoryPath(Redwine::getConfigValue('folder_structure.' . $type . '.path'));
                // Make Directory
                $this->makeDirectory($path, 0755, true);
            } else {
                // Output Error Message
                $this->console->error('Can Not Find ' . $type . ' Type!');
            }
        }
    }
}
