<?php

return [
    /**
     * -------------------------------------------
     * Module path
     * - app
     * - modules
     * - - your_module
     * -------------------------------------------
     */
    'module_path' => base_path('modules'),



    'spl_autoload' => true,

    // work if spl_autoload true
    'namespaces' => [
        // "module_directory" => YourNameSpace
    ],

    /**
     *
     */
    'observers' => [
        'autoboot' => true,
        'except' => []
    ],

    //laramoud.json
    //isinya
    //observer_autoboot
];