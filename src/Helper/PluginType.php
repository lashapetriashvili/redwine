<?php

namespace Redwine\Helper;

use Redwine\Facades\Redwine;

class PluginType
{
    /**
     * Delete All Worng Type
     *
     * @param $types
     * @return mixed
     */
    static function deletaAllWorngType($types)
    {
        // Loop Each Plugin Type
        foreach ($types as $key => $type) {
            // CHeck IF This Type Exist In config
            if (is_null(Redwine::getConfigValue('folder_structure.' . $type . '.path'))) {
                // Remove This Element
                unset($types[$key]);
            }
        }
        // Return All Correct Types
        return $types;
    }

    /**
     * Get Plugin Type
     *
     * @return array
     */
    static function getPluginType()
    {
        // First Plugin Type
        $pluginType = ['Create Everything'];
        // Loop Each Plugin Type
        foreach (Redwine::getConfigValue('plugin_type') as $types) {
            // elete All Worng Type
            $types = self::deletaAllWorngType($types);
            // Push Array To string If There Is List One Correct Type
            if (count($types)) array_push($pluginType, '["' . implode('", "', $types) . '"]');
        }
        // Return All Plugin Types
        return $pluginType;
    }

    /**
     * Get Default Plugin Type Index
     *
     * @return int
     */
    static function getDefaultPluginTypeIndex()
    {
        return Redwine::getConfigValue('default_plugin_type_index');
    }
}