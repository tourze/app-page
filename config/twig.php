<?php

return [

    /**
     * Twig Loader options
     */
    'loader'    => [
        'extension' => 'html',  // Extension for Twig files
        'path'      => 'views', // Path within cascading filesystem for Twig files
    ],

    /**
     * Custom functions and filters
     *
     *     'functions' => array(
     *         'my_method' => array('MyClass', 'my_method'),
     *     ),
     */
    'functions' => [
        'url_site'  => ['URL', 'site'],
        'media_url' => ['Media', 'url'],
    ],
    'filters'   => [
        // 翻译
        'translate' => '__',
        'trans'     => '__',
        'tr'        => '__',
        '__'        => '__',
    ],
];
