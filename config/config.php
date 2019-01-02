<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Plugin Type
    |--------------------------------------------------------------------------
    |
    | You Can Create Your Own Plugin Type, Just Create Another Array And
    | Insert Inside Values From "folder_structure" Array.
    |
    */

    'plugin_type' => [
        ['config', 'command'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Plugin Type Index
    |--------------------------------------------------------------------------
    |
    | You Can Choose What Plugin Type Was By Default.
    | 0 => "Create Everything".
    |
    */

    'default_plugin_type_index' => 0,

    /*
    |--------------------------------------------------------------------------
    | Folder Structurre
    |--------------------------------------------------------------------------
    |
    | Compose Folders Structure Where The Files Will Be Created.
    |
    */

    'folder_structure' => [
        'config'        => ['path' => 'Config'],
        'command'       => ['path' => 'Console'],
        'migration'     => ['path' => 'Database/Migrations'],
        'seeder'        => ['path' => 'Database/Seeders'],
        'factory'       => ['path' => 'Database/factories'],
        'model'         => ['path' => 'Models'],
        'controller'    => ['path' => 'Http/Controllers'],
        'filter'        => ['path' => 'Http/Middleware'],
        'request'       => ['path' => 'Http/Requests'],
        'assets'        => ['path' => 'Resources/assets'],
        'lang'          => ['path' => 'Resources/lang'],
        'views'         => ['path' => 'Resources/views'],
        'test'          => ['path' => 'Tests'],
        'event'         => ['path' => 'Events'],
        'listener'      => ['path' => 'Listeners'],
        'policies'      => ['path' => 'Policies'],
        'rules'         => ['path' => 'Rules'],
        'jobs'          => ['path' => 'Jobs'],
        'emails'        => ['path' => 'Emails'],
        'notifications' => ['path' => 'Notifications']
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin Templates
    |--------------------------------------------------------------------------
    |
    | Default Plugin Templates.
    |
    */

    'template' => [
        'stubs_files' => [
            'routes/web'      => 'Routes/web.php',
            'routes/api'      => 'Routes/api.php',
            'views/index'     => 'Resources/views/index.blade.php',
            'views/master'    => 'Resources/views/layouts/master.blade.php',
            'scaffold/config' => 'Config/config.php',
            'composer'        => 'composer.json',
            'assets/js/app'   => 'Resources/assets/js/app.js',
            'assets/sass/app' => 'Resources/assets/sass/app.scss',
            'webpack'         => 'webpack.mix.js',
            'package'         => 'package.json',
        ]
    ],
];
