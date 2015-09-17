# PAGE系统

PAGE系统是一个基于twig和markdown来实现的静态网站系统。

适用场景：

1. 只需要简单页面的网站系统，如APP着陆页、企业展示站
2. 没复杂后端逻辑
3. 开发人员熟悉twig

## 开发指南

模板默认统一放置到项目根目录下的`storage`目录。

每个请求页面一一对应`storage/page`中的twig模板：

1. `/` 对应 `index.html.twig`
2. `/index.html` 对应 `index.html.twig`
3. `/sub1/test.html` 对应 `sub1/test.html.twig`

如果需要更改twig模板的加载路径，可以新建文件`config/main-local.php`：

    <?php
    
    use tourze\Twig\Twig;
    
    return [
    
        'component' => [
            'twig' => [
                'class'  => 'tourze\Twig\Component\Twig',
                'params' => [
                    'loaderOptions' => [
                        'type' => Twig::FILE_LOADER,
                        'args' => [
                            STORAGE_PATH . 'layout',
                            STORAGE_PATH . 'page',
                            "这里放置你需要的路径",
                        ],
                    ],
                ],
                'call'   => [
                ],
            ],
        ],
    ];

本系统支持twig原生语法，同时在此基础上进行了扩展，支持更多的第三方语法。
具体可以看[tourze/twig](https://github.com/tourze/twig)中的语法说明。

如果你之前未接触过twig，或者还是不太熟悉如何入手，我建议你尝试下阅读`storage`目录下的文件，同时在web中打开本项目，一一对照着。
我相信如果有亲自去了解其原理，应该可以很快上手。
