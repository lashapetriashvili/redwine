<?php

namespace Redwine\Helper;

use Illuminate\Support\Facades\File;
use Redwine\Facades\Redwine;

class PluginChecker
{
    /**
     * All Plugin Info
     *
     * @var array
     */
    protected $pluginInfo = [];

    /**
     * All Plugin Name
     *
     * @var array
     */
    protected $pluginName = [];

    /**
     * info File Name
     *
     * @var string
     */
    protected $infoFileName = 'info.json';

    /**
     * Get Directories
     *
     * @param $path
     * @return array
     */
    public function getDirectories($path)
    {
        return File::directories($path);
    }

    /**
     * Get Plugin Info
     *
     * @param $pluginPath
     * @return mixed
     */
    public function getPluginInfo($pluginPath)
    {
        // Plugin info.json Path
        $path = $pluginPath . '\\' . $this->infoFileName;
        // Check If info.json File Exist
        if (file_exists($path)) {
            return json_decode(file_get_contents($path, true));
        }
    }

    /**
     * Get ALL Plugin Info
     *
     * @param bool $getArray
     * @return array
     */
    public function getAllPluginInfo($getArray = false)
    {
        // Loob Each Plugin
        foreach ($this->getDirectories(Redwine::getPluginFolderPath()) as $directory) {
            // Get Plugin Info
            $pluginInfo = $this->getPluginInfo($directory);
            // Check Return Info
            if (count((array) $pluginInfo)) array_push($this->pluginInfo, $pluginInfo);
        }
        // Check & Return Plugin Info
        if ($getArray) return $this->pluginInfo;
    }

    /**
     * Get All Plugin Name
     *
     * @param bool $getArray
     * @return array
     */
    public function getAllPluginName($getArray = false)
    {
        // Loop Each Plugin Info
        foreach ($this->getAllPluginInfo(true) as $info) {
            array_push($this->pluginName, $info->name);
        }
        // Check & Return Plugin Name
        if ($getArray) return $this->pluginName;
    }

    /**
     * Check Plugin Info
     *
     * @param $pluginName
     * @return bool
     */
    public function checkPluginInfo($pluginName)
    {
        return file_exists(Redwine::getPluginFolderPath($pluginName)) ? true : false;
    }

    /**
     * Check Plugin Directory
     *
     * @param $pluginName
     * @return bool
     */
    public function checkPluginDirectory($pluginName)
    {
        return file_exists(Redwine::getPluginFolderPath($pluginName)) ? true : false;
    }

    /**
     * Check Plugin
     *
     * @param $pluginName
     * @return bool
     */
    public function check($pluginName)
    {
        return $this->checkPluginInfo($pluginName) || $this->checkPluginDirectory($pluginName) ? true : false;
    }
}
