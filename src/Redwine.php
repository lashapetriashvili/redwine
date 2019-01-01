<?php

namespace Redwine;

class Redwine
{
    /**
     * Plguin Folder name
     *
     * @var string
     */
    public $folderName = 'Redwine';

    /**
     * Plugin Type
     *
     * @var array
     */
    public $pluginType = [
        'Test Type',
        'Test Type 2'
    ];

    /**
     * Default Plugin Type Index
     *
     * @var int
     */
    public $defaultPluginTypeIndex = 0;

    /**
     * Get Plugin Type
     *
     * @return array
     */
    public function getPluginType()
    {
        return $this->pluginType;
    }

    /**
     * Get Default Plugin Type Index
     *
     * @return int
     */
    public function getDefaultPluginTypeIndex()
    {
        return $this->defaultPluginTypeIndex;
    }

    /**
     * Get Plugin Folder Path
     *
     * @param null $url
     * @return string
     */
    public function getPluginFolderPath($url = null)
    {
        // Folder Path
        $folderPath = base_path($this->folderName);
        // Check If Exist Extra URl
        return is_null($url)
            ? $folderPath
            : $folderPath . '\\' . $url;
    }
}
