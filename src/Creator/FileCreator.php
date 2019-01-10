<?php

namespace Redwine\Creator;

use Redwine\Helper\Directory;
use Redwine\Facades\Redwine;
use Redwine\Helper\Stub;

class FileCreator
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
     * Create Files
     *
     * @param $files
     * @param $type
     */
    protected function createFiles($files, $type) {
        // Loop Each File
        foreach ($files as $file) {
            // Get Directory path
            $getDirectoryPath = Redwine::getConfigValue('folder_structure.' . $type . '.path');
            // Check If File Is Array
            if (is_array($file)) {
                if (isset($file['name']) && isset($file['stub']) && isset($file['stub']['path'])) {
                    $fileName = $file['name'];
                    $content = (new Stub)->setPath($file['stub']['path'])
                        ->setReplace($file['stub']['replace'])
                        ->getContent();
                } else {
                    continue;
                }
            } else {
                $fileName = $file;
                $content  = '';
            }
            // Get Clean File Path
            $fileName = $fileName[0] == '/'
                ? substr($fileName, 1, strlen($fileName))
                : $fileName;
            // Make Directory
            Directory::makeFile(Redwine::getPluginFolderPath($this->pluginName . '\\' . $getDirectoryPath . '\\' . $fileName), $content);
        }
    }

    /**
     * Create
     */
    public function create()
    {
        foreach ($this->pluginType as $type) {
            // Check IF This Type Exist In config
            if (Redwine::getConfigValue('folder_structure.' . $type . '.files')) {
                // Create Files
                $this->createFiles(Redwine::getConfigValue('folder_structure.' . $type . '.files'), $type);
            }
        }
    }
}
