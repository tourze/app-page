<?php

namespace page;

use page\Exception\PageException;
use page\Model\Entry;
use tourze\Base\Helper\Arr;
use tourze\Base\Helper\Text;
use tourze\View\View;

/**
 * Page基础类
 *
 * @package    Base
 * @author     YwiSax
 */
class Page
{

    /**
     * @const 默认使用的页面模板
     */
    const TEMPLATE_VIEW = 'page/xhtml';

    /**
     * @var string 当前渲染的页面
     */
    public static $_page = null;

    /**
     * @var bool 是否在管理模式中
     */
    public static $adminMode = false;

    /**
     * @var string 保存内容
     */
    protected static $_content = null;

    /**
     * @var string 自定义内容
     */
    protected static $_custom_content = null;

    /**
     * @var bool 处于override模式
     */
    protected static $_override = false;

    // 一些资源文件，乱七八糟的
    protected static $_javascripts = [];
    protected static $_stylesheets = [];
    protected static $_metas       = [];

    /**
     * 返回当前页面。PS：这样写的助手方法是不是不好呢？
     *
     * @param string $key   页面参数键
     * @param mixed  $value 页面参数值
     * @return mixed
     */
    public static function entry($key = null, $value = null)
    {
        // 如果key没有的话，不管那么多，直接返回就是了
        if ($key === null)
        {
            return Page::$_page;
        }

        // 页面都没加载，玩毛
        if (Page::$_page === null)
        {
            return null;
        }

        $key = (string) $key;
        if ($value === null)
        {
            return isset(Page::$_page->{$key})
                ? Page::$_page->{$key}
                : null;
        }
        else
        {
            Page::$_page->{$key} = $value;
        }
    }

    /**
     * 主系统导航
     *
     * @param  string $params 参数
     * @return string  渲染后的导航条
     */
    public static function mainNav($params = '')
    {
        if ( ! Page::$_override && ( ! Page::entry('id')))
        {
            return __('{mainNav} load failed because page is not loaded');
        }

        $defaults = [
            'header' => false,
            'depth'  => 1
        ];
        $options = Arr::merge($defaults, Text::params($params));

        if (Page::$_override)
        {
            // 没办法，只能是查找第一个页面然后写咯。
            /** @var Entry $descendants */
            $descendants = (new Entry)
                ->where('lvl', '=', 0)
                ->find();
            $descendants = $descendants->root();
            $descendants = $descendants->navNodes($options['depth']);
        }
        else
        {
            $descendants = Page::entry()
                ->root()
                ->navNodes($options['depth']);
        }

        $out = View::factory('page/navigation', [
            'nodes'        => $descendants,
            'level_column' => 'lvl',
            'options'      => $options
        ])->render();

        return $out;
    }

    /**
     * 二级菜单（侧边栏）菜单
     *
     * @param string $params 参数字符串
     * @param bool   $render 是否直接渲染
     * @return string
     * @throws \tourze\View\Exception\ViewException
     */
    public static function nav($params = '', $render = true)
    {
        // 确保页面已经加载了。。。
        if ( ! Page::entry('id'))
        {
            return __('Base::secondary_nav failed because page is not loaded');
        }

        $options = Text::params($params);
        // Set the defaults
        $defaults = [
            // Options for the header before the nav
            'header'        => false,
            'header_elem'   => 'h3',
            'header_class'  => '',
            'header_id'     => '',

            // Options for the list itself
            'class'         => '',
            'id'            => '',
            'depth'         => 2,

            // Options for items
            'current_class' => 'current',
            'first_class'   => 'first',
            'last_class'    => 'last',
        ];
        // Merge to create the options
        $options = Arr::merge($options, $defaults);

        if (Page::entry()->has_children())
        {
            $page = Page::entry();
        }
        else
        {
            $page = Page::entry()->parent();
        }

        /** @var Entry $descendants */
        /** @var Entry $page */
        $descendants = $page->navNodes($options['depth']);

        if ($render)
        {
            $out = View::factory('page/navigation', [
                'nodes'        => $descendants,
                'level_column' => 'lvl',
                'options'      => $options
            ])->render();
        }
        else
        {
            $out = $descendants->asArray();
        }

        return $out;
    }


    /**
     * 渲染面包屑导航
     *
     * @return string
     */
    public static function breadCrumbs()
    {
        if ( ! Page::entry('id'))
        {
            return __('{breadCrumbs} load failed because page is not loaded');
        }

        $parents = Page::entry()
            ->parents()//->render_descendants('mainnav', TRUE, 'ASC', $maxdepth)
        ;

        $out = View::factory('page/breadcrumb')
            ->set('nodes', $parents)
            ->set('page', Page::entry('name'))
            ->render();
        return $out;
    }

    /**
     * 渲染站点地图
     *
     * @return string
     */
    public static function site_map()
    {
        if ( ! Page::entry('id'))
        {
            return __('Base::site_map failed because page is not loaded.');
        }

        $out = Page::entry()
            ->root()
            ->render_descendants('Base.Sitemap', false, 'ASC')
            ->render();

        return $out;
    }

    /**
     * 渲染和输出元素内容
     *
     * @param   int     元素ID
     * @param   string  元素名称（admin时才有用）
     * @return  boolean
     */
    public static function element_area($id, $name)
    {
        if ( ! Page::entry('id'))
        {
            return __('Base Error: element_area(:id) failed. (Base::entry was not set)', [
                ':id' => $id,
            ]);
        }

        if (Kohana::$profiling === true)
        {
            $benchmark = Profiler::start('Base', __FUNCTION__);
        }

        // 自定义页面内容
        if (Page::$_content !== null)
        {
            return View::factory('page/element/area', [
                'id'      => $id,
                'name'    => $name,
                'content' => Arr::get(Page::$_content, $id - 1, '')
            ]);
        }
        $elements = ORM::factory('Page_Element')
            ->where('entry_id', '=', Page::entry('id'))
            ->where('area', '=', $id)
            ->order_by('order', 'ASC')
            ->find_all();
        $content = '';

        foreach ($elements AS $item)
        {
            try
            {
                $element = Model_Page_Element::factory($item->type_name());
                $element->id = $item->element;
                $element->block = $item;
                $content .= $element->render();
            }
            catch (Exception $e)
            {
                if (Kohana::$environment == Kohana::DEVELOPMENT)
                {
                    throw $e;
                }
                else
                {
                    $content .= __('Error: Could not load element, notice: :message.', [
                        ':message' => $e->getMessage(),
                    ]);
                }
            }
        }

        $out = View::factory('page/element/area', [
            'id'      => $id,
            'name'    => $name,
            'content' => $content
        ])->render();

        if (isset($benchmark))
        {
            Profiler::stop($benchmark);
        }
        return $out;
    }

    const ELEMENT_CACHE_PREFIX = 'element_cache~';

    /**
     * 根据指定类型和名称生成元素缓存名
     */
    public static function generate_element_cache_name($type, $name)
    {
        return Page::ELEMENT_CACHE_PREFIX . $type . '~' . $name;
    }

    /**
     * 返回指定类型和名称的元素实例
     *
     * 如：
     *  echo element('snippet', 'footer');
     *
     * @param  string   元素类型
     * @param  name     元素名称
     * @param  lifetime 是否缓存和缓存周期
     * @return string
     */
    public static function element($type, $name, $lifetime = null)
    {
        // 先尝试从缓存中读取
        $lifetime = (int) $lifetime;
        $key = Page::generate_element_cache_name($type, $name);
        if ($lifetime AND ($cache = Kohana::cache($key, null, $lifetime)))
        {
            return $cache;
        }

        $out = '';

        // 读取和解析
        if (Kohana::$profiling === true)
        {
            $benchmark = Profiler::start('Base', __FUNCTION__);
        }

        try
        {
            $element = Model_Page_Element::factory($type)
                ->where('name', '=', $name)
                ->find();
        }
        catch (Exception $e)
        {
            $out .= '<!--';
            $out .= __("Could not render :type ':name' (:message)", [
                ':type'    => $type,
                ':name'    => $name,
                ':message' => $e->getMessage(),
            ]);
            $out .= '-->';
            return $out;
        }

        if ($element->loaded())
        {
            $out = $element->render();
        }
        else
        {
            $out .= '<!--';
            $out .= __("Could not render :type with the name ':name'.", [
                ':type' => $type,
                ':name' => $name,
            ]);
            $out .= '-->';
        }
        if (isset($benchmark))
        {
            Profiler::stop($benchmark);
        }

        // 保存到缓存
        if ($lifetime)
        {
            Kohana::cache($key, $out, $lifetime);
        }
        return $out;
    }

    /*
     * CSS控制方法，这个方法可能需要继续优化下
     */
    public static function style($stylesheet, $media = null)
    {
        Page::$_stylesheets[$stylesheet] = $media;
    }

    /**
     * CSS渲染方法
     */
    public static function style_render()
    {
        $out = '';
        foreach (Page::$_stylesheets AS $stylesheet => $media)
        {
            if ($media != null)
            {
                $out .= "\t" . HTML::style(Media::url($stylesheet), ['media' => $media]) . "\n";
            }
            else
            {
                $out .= "\t" . HTML::style(Media::url($stylesheet)) . "\n";
            }
        }
        return $out;
    }

    /*
     * Javascript控制方法，具体用法请参考Layout相关代码
     *
     * @param	array	要加载的脚本地址
     * @return	void
     */
    public static function script($javascript = null)
    {
        // 没参数时直接返回所有地址
        if ($javascript === null)
        {
            return Page::$_javascripts;
        }
        // 循环赋值
        if (is_array($javascript))
        {
            foreach ($javascript AS $js)
            {
                Page::script($js);
            }
        }
        else
        {
            // 防止重复引用
            if ( ! in_array($javascript, Page::$_javascripts))
            {
                Page::$_javascripts[] = $javascript;
            }
        }
    }

    /**
     * 移除指定的脚本链接
     */
    public static function script_remove($javascript = null)
    {
        // 清空全部
        if ($javascript === null)
        {
            Page::$_javascripts = [];
        }
        // 如果不是数组，那就转换为数组
        if ( ! is_array($javascript))
        {
            $javascript = [$javascript];
        }
        // 循环删除
        foreach (Page::$_javascripts AS $key => $value)
        {
            if (in_array($value, $javascript))
            {
                unset(Page::$_javascripts[$key]);
            }
        }
    }

    /**
     * JS渲染器
     */
    public static function script_render()
    {
        $out = '';
        foreach (Page::$_javascripts AS $key => $javascript)
        {
            $out .= "\t" . HTML::script(Media::url($javascript)) . "\n";
        }
        return $out;
    }

    /*
     * META控制方法
     */
    public static function meta($metas = [])
    {
        if ( ! is_array($metas))
        {
            $metas = [$metas];
        }
        foreach ($metas AS $key => $meta)
        {
            Page::$_metas[] = $meta;
        }
    }

    /**
     * META渲染方法
     */
    public static function meta_render()
    {
        $out = '';
        foreach (Page::$_metas AS $key => $meta)
        {
            $out .= "\t{$meta}\n";
        }
        return $out;
    }

    /**
     * 返回当前渲染Profile信息
     *
     * @return string
     */
    public static function render_stats()
    {
        $run = Profiler::application();
        $run = $run['current'];
        return __('Base rendered in :time seconds using :memory MB', [
            ':time'   => Number::format($run['time'], 3),
            ':memory' => Number::format($run['memory'] / 1024 / 1024, 2),
        ]);
    }

    /**
     * 使用指定的布局和内容来渲染
     *
     * 使用示例：
     *
     *     echo Base::override('error', $content);
     *
     * @param  string   要使用的布局名
     * @param  page     页面内容
     * @return string
     * @throws Page_Exception
     */
    public static function override($layoutname, $content = null)
    {
        // 查找对应布局
        $layout = ORM::factory('Page_Layout')
            ->where('name', '=', $layoutname)
            ->find();
        if ( ! $layout->loaded())
        {
            throw new PageException("Failed to load the layout with name ':layout'.", [
                ':layout' => $layoutname,
            ]);
        }
        if ($content)
        {
            Page::content($content);
        }
        Page::$_override = true;
        // 设置一些需要的变量，同时渲染页面啦
        return View::factory(Page::TEMPLATE_VIEW, [
            'layoutcode' => $layout->render($content)
        ]);
    }

    /**
     * 指定页面内容
     *
     * @param  string  内容，HTML代码等
     * @return void
     */
    public static function content($content = null)
    {
        if ($content === null)
        {
            return Page::$_custom_content;
        }
        Page::$_custom_content = $content;
    }

    /**
     * Twig渲染的助手方法
     *
     * @param  string  要用Twig解析的代码
     * @return string  Twig解析后的代码
     */
    public static function twig_render($code)
    {
        static $instance = null;

        if ($instance === null)
        {
            $loader = new Twig_Loader_String();
            $instance = Twig::generate_environment($loader);
        }

        $template = $instance->loadTemplate($code);
        $content = $template->render(['Base' => new Page]);

        return $content;
    }
}

