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
     * Get Plugin Type
     *
     * @return array
     */
    public function getPluginType()
    {
        // First Plugin Type
        $pluginType = ['Create Everything'];
        // Loop Each Plugin Type
        foreach (config('redwine.plugin_type') as $type) {
            // Push Array To string
            array_push($pluginType, '["' . implode('", "', $type) . '"]');
        }
        // Return All Plugin Types
        return $pluginType;
    }

    /**
     * Get Default Plugin Type Index
     *
     * @return int
     */
    public function getDefaultPluginTypeIndex()
    {
        return config('redwine.default_plugin_type_index');
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
