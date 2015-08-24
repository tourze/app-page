<?php

namespace page\Model;

/**
 * CMS页面模型
 *
 * 在CMS中，页面主要由以下几个元素组成：
 *
 *   1. 布局
 *   2. 元素
 *     2.1 Content
 *     2.2 Snippet
 *     2.3 Request
 *
 * 关于几种不同元素模型的区别，可以参看具体的代码
 *
 * @package page\Model
 */
class Entry extends ORM_MPTT
{

    /**
     * @var string
     */
    protected $_tableName = 'page_entry';

    /**
     * @var array
     */
    protected $_createdColumn = ['column' => 'date_created', 'format' => true];

    /**
     * @var array
     */
    protected $_updatedColumn = ['column' => 'date_updated', 'format' => true];

    protected $_loadWith = ['layout'];

    protected $_belongsTo = [
        // 一个页面就属于一个布局啦
        'layout' => [
            'foreignKey' => 'layout_id',
            'model'      => 'Layout',
        ],
    ];

    /**
     * 过滤规则
     */
    public function filters()
    {
        return [
            'name'     => [
                ['trim'],
                ['strip_tags'],
            ],
            'title'    => [
                ['trim'],
                ['strip_tags'],
            ],
            'metakw'   => [
                ['trim'],
                ['strip_tags'],
            ],
            'metadesc' => [
                ['trim'],
                ['strip_tags'],
            ],
        ];
    }

    /**
     * 在指定节点创建页面
     *
     * @param  Page_Page    父节点
     * @param  string       /int   添加位置
     * @return void
     */
    public function create_at($parent, $location = 'last')
    {
        // 如果不是外链的话，那就必须要有布局
        if ( ! $this->islink AND empty($this->layout->id))
        {
            throw new Page_Exception("You must select a layout for a page that is not an external link.");
        }

        // 看代码啊
        if ($location == 'first')
        {
            $this->insert_as_first_child($parent);
        }
        else if ($location == 'last')
        {
            $this->insert_as_last_child($parent);
        }
        else
        {
            $target = ORM::factory('Page_Entry', intval($location));
            if ( ! $target->loaded())
            {
                throw new Page_Exception('Could not create page, could not find target for insert_as_next_sibling id: :location', [
                    ':location' => $location,
                ]);
            }
            $this->insert_as_next_sibling($target);
        }
    }

    /**
     * 移动页面
     */
    public function move_to($action, $target)
    {
        $target = ORM::factory('Page_Entry', $target);

        if ( ! $target->loaded())
        {
            throw new Page_Exception('Could not move page ( ID: :id ), target page did not exist.', [
                ':id' => (int) $target->id,
            ]);
        }

        if ($action == 'before')
        {
            $this->move_to_prev_sibling($target);
        }
        elseif ($action == 'after')
        {
            $this->move_to_next_sibling($target);
        }
        elseif ($action == 'first')
        {
            $this->move_to_first_child($target);
        }
        elseif ($action == 'last')
        {
            $this->move_to_last_child($target);
        }
        else
        {
            throw new Page_Exception("Could not move page, action should be 'before', 'after', 'first' or 'last'.");
        }
    }

    /**
     * 渲染页面
     *
     * @returns  View  渲染的视图页面
     */
    public function render()
    {
        if ( ! $this->loaded())
        {
            throw new Page_Exception('Base render failed because page was not loaded.', [], 404);
        }
        Page::$_page = $this;

        // 渲染布局
        return View::factory(Page::TEMPLATE_VIEW, [
            'layoutcode' => $this->layout->render(),
        ]);
    }

    public function nav_nodes($depth)
    {
        return ORM_MPTT::factory('Page_Entry')
            ->where($this->left_column, '>=', $this->{$this->left_column})
            ->where($this->right_column, '<=', $this->{$this->right_column})
            ->where($this->scope_column, '=', $this->{$this->scope_column})
            ->where($this->level_column, '<=', $this->{$this->level_column} + $depth)
            ->where('shownav', '=', 1)
            ->order_by($this->left_column, 'ASC')
            ->find_all();
    }


    /**
     * 重载values方法，进行额外的处理
     *
     * @param array values
     * @return $this
     */
    public function values(array $values, array $expected = null)
    {
        if (isset($values['islink']) AND is_string($values['islink']))
        {
            $values['islink'] = 1;
        }
        if (isset($values['generate_html']) AND is_string($values['generate_html']))
        {
            $values['generate_html'] = 1;
        }
        if (isset($values['showmap']) AND is_string($values['showmap']))
        {
            $values['showmap'] = 1;
        }
        if (isset($values['shownav']) AND is_string($values['shownav']))
        {
            $values['shownav'] = 1;
        }

        if ($this->loaded())
        {
            $new = [
                'islink'        => 0,
                'generate_html' => 0,
                'showmap'       => 0,
                'shownav'       => 0.
            ];
            $values = array_merge($new, $values);
        }
        if ($this->loaded() AND ! $values['generate_html'])
        {
            Model_Page_Entry::clear_html_cache($this->url);
        }

        return parent::values($values, $expected);
    }

    /**
     * 创建记录的同时，插入一份到Log中去
     */
    public function create(Validation $validation = null)
    {
        $result = parent::create($validation);
        if ($this->loaded())
        {
        }
        return $result;
    }

    /**
     * 修改记录的同时，把旧的数据保存到Log中去
     */
    public function update(Validation $validation = null)
    {
        if (empty($this->_changed))
        {
            // 没有东西需要更新
            return $this;
        }

        if ($this->loaded())
        {
        }
        return parent::update($validation);
    }

    /**
     * 删除前保存一份到Log中去
     */
    public function delete()
    {
        $entry_id = $this->id;
        $parent_result = parent::delete();

        // 查找所有残余的元素信息
        $elements = ORM::factory('Page_Element')
            ->where('entry_id', '=', $entry_id)
            ->find_all();
        foreach ($elements AS $element)
        {
            // 3为snippet，不可删除
            if ($element->type != 3)
            {
                $content = Model_Page_Element::factory(Model_Page_Element::$type_maps[$element->type])
                    ->where('id', '=', $element->element)
                    ->find();
                if ($content->loaded())
                {
                    $content->delete();
                }
            }
            $element->delete();
        }

        return $parent_result;
    }

    public static $_html_cache_ext = ['html', 'htm', 'txt'];

    /**
     * 生成HTML文件名
     */
    public static function generate_html_filename($url)
    {
        $filename = DOCROOT . $url;
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        //echo "ext:$ext ";
        // 如果扩展名为空，或者是不允许生成的扩展名，那就当做目录来生成
        if ( ! $ext OR ! in_array($ext, Model_Page_Entry::$_html_cache_ext))
        {
            $filename .= '/index.html';
        }
        return $filename;
    }

    /**
     * 清楚HTML缓存
     */
    public static function clear_html_cache($url)
    {
        $filename = Model_Page_Entry::generate_html_filename($url);
        return @unlink($filename);
    }

    /**
     * 生成HTML
     */
    public static function generate_html($url, $html)
    {
        $filename = Model_Page_Entry::generate_html_filename($url);
        $filepath = pathinfo($filename, PATHINFO_DIRNAME);
        $basename = pathinfo($filename, PATHINFO_BASENAME);

        // 先生成目录
        try
        {
            file_put_contents($filename, $html);
        }
        catch (Exception $e)
        {
            return false;
        }
        return true;
    }
}

