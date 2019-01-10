<?php

namespace Redwine\Helper;

class Directory
{
    /**
     * Make Directory
     *
     * @param $path
     * @param int $mode
     * @param bool $recursive
     * @param bool $force
     * @return bool
     */
    static function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        return $force
            ? @mkdir($path, $mode, $recursive)
            : mkdir($path, $mode, $recursive);
    }

    /**
     * Check Directory Path
     *
     * @param $path
     */
    protected static function checkDirectoryPath($path)
    {
        // Replace Path
        $path = str_replace('/', '\\', $path);
        // Get Last File Name (E.g. /redwine.php)
        $filePath = strrchr($path, '\\');
        // Get Fill Directory path
        $fullDirectoryPath = substr($path, 0, strlen($path) - strlen($filePath));
        // Create All Directories
        self::makeDirectory($fullDirectoryPath, 0755, true);
    }

    /**
     * Make File
     *
     * @param $path
     * @param $content
     * @return bool|int
     */
    static function makeFile($path,  $content)
    {
        // Check Path
        if (strpos($path, '/')) self::checkDirectoryPath($path);
        // Make File
        return file_put_contents($path, $content);
    }
}
