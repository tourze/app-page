<?php

use tourze\Twig\Twig;

return [

    'component' => [
        'http' => [
            'class' => PHP_SAPI == 'cli' ? 'tourze\Server\Component\Http' : 'tourze\Http\Component\Http',
            'params' => [
            ],
            'call' => [
            ],
        ],
        'session' => [
            'class' => PHP_SAPI == 'cli' ? 'tourze\Server\Component\Session' : 'tourze\Http\Component\Session',
            'params' => [
            ],
            'call' => [
            ],
        ],
        'log' => [
            'class' => PHP_SAPI == 'cli' ? 'tourze\Server\Component\Log' : 'tourze\Http\Component\Log',
            'params' => [
            ],
            'call' => [
            ],
        ],
        'twig' => [
            'class'  => 'tourze\Twig\Component\Twig',
            'params' => [
                'loaderOptions' => [
                    'type' => Twig::FILE_LOADER,
                    'args' => [
                        STORAGE_PATH . 'layout',
                        STORAGE_PATH . 'page',
                    ],
                ],
            ],
            'call'   => [
            ],
        ],
    ],

    'server' => [
        // 默认的web配置
        'web' => [
            'count'          => 4, // 打开进程数
            'user'           => '', // 使用什么用户打开
            'reloadable'     => true, // 是否支持平滑重启
            'socketName'     => 'http://0.0.0.0:8080', // 默认监听8080端口
            'contextOptions' => [], // 上下文选项
            'siteList'       => [
                'www.example.com' => WEB_PATH,
            ],
        ],
    ],
];
