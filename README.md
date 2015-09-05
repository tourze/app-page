# PAGE系统

PAGE系统是一个基于twig和markdown来实现的静态网站系统。

适用场景：

1. 只需要简单页面的网站系统，如APP着陆页、企业展示站
2. 没复杂后端逻辑
3. 开发人员熟悉twig

## 开发指南

模板默认统一放置到项目根目录下的`storage`目录。
如果需要更改加载路径，可以新建文件`config/main-local.php`：

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

