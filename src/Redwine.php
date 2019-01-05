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
     * Config Name
     *
     * @var string
     */
    public $configName = 'redwine';

    /**
     * Get All Folder Structure
     *
     * @return array
     */
    public function getAllFolderStructure()
    {
        // Folder Structure Empty Array
        $folderStructureArray = [];
        // Get Each Folder Structure From Config
        foreach (config($this->configName . '.folder_structure') as $key => $folder) {
            array_push($folderStructureArray, $key);
        }
        // Return Folder Structure In Array
        return $folderStructureArray;
    }

    /**
     * Get Plugin Folder Path
     *
     * @param null $path
     * @return string
     */
    public function getPluginFolderPath($path = null)
    {
        // Folder Path
        $folderPath = base_path($this->folderName);
        // Check If Exist Extra Path
        return is_null($path)
            ? $folderPath
            : $folderPath . '\\' . $path;
    }

    /**
     * get Config Value
     *
     * @param $path
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getConfigValue($path)
    {
        return config($this->configName . '.' . $path);
    }
}
