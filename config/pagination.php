<?php defined('SYSPATH') OR die('No direct script access.');

return [

    // 分页配置
    'cms'                        => [
        'current_page'      => ['source' => 'query_string', 'key' => 'page'], // source: "query_string" or "route"
        'total_items'       => 0,
        'items_per_page'    => 10,
        'view'              => 'Pagination.Digg',
        'auto_hide'         => true,
        'first_page_in_url' => false,
    ],

    'page_admin_element_content' => [
        'current_page'      => ['source' => 'query_string', 'key' => 'page'], // source: "query_string"或"route"
        'total_items'       => 0,
        'items_per_page'    => 10,
        'view'              => 'pagination/digg',
        'auto_hide'         => true,
        'first_page_in_url' => false,
    ],
];
