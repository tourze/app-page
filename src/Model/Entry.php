<?php

namespace page\Model;

use page\Exception\PageException;
use tourze\Model\MPTT;

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
 * @property int    id
 * @property int    is_link
 * @property int    layout_id
 * @property Layout layout
 * @package page\Model
 */
class Entry extends MPTT
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
     * @param  Entry      $parent   父节点
     * @param  string|int $location 添加位置
     * @throws PageException
     */
    public function create_at($parent, $location = 'last')
    {
        // 如果不是外链的话，那就必须要有布局
        if ( ! $this->is_link AND empty($this->layout->id))
        {
            throw new PageException("You must select a layout for a page that is not an external link.");
        }

        // 看代码啊
        if ($location == 'first')
        {
            $this->insertAsFirstChild($parent);
        }
        else if ($location == 'last')
        {
            $this->insertAsLastChild($parent);
        }
        else
        {
            $target = new self(intval($location));
            if ( ! $target->loaded())
            {
                throw new PageException('Could not create page, could not find target for insert_as_next_sibling id: :location', [
                    ':location' => $location,
                ]);
            }
            $this->insertAsNextSibling($target);
        }
    }

    /**
     * 移动页面
     */
    public function move_to($action, $target)
    {
        if ( ! $target instanceof $this)
        {
            $target = new self($target);
        }

        if ( ! $target->loaded())
        {
            throw new Page_Exception('Could not move page ( ID: :id ), target page did not exist.', [
                ':id' => (int) $target->id,
            ]);
        }

        if ($action == 'before')
        {
            $this->moveToPrevSibling($target);
        }
        elseif ($action == 'after')
        {
            $this->moveToNextSibling($target);
        }
        elseif ($action == 'first')
        {
            $this->moveToFirstChild($target);
        }
        elseif ($action == 'last')
        {
            $this->moveToLastChild($target);
        }
        else
        {
            throw new PageException("Could not move page, action should be 'before', 'after', 'first' or 'last'.");
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

    /**
     * 返回指定深度的导航信息
     *
     * @param int $depth
     * @return Entry[]
     */
    public function navNodes($depth)
    {
        return (new self)
            ->where($this->_leftColumn, '>=', $this->{$this->_leftColumn})
            ->where($this->_rightColumn, '<=', $this->{$this->_rightColumn})
            ->where($this->_scopeColumn, '=', $this->{$this->_scopeColumn})
            ->where($this->_levelColumn, '<=', $this->{$this->_levelColumn} + $depth)
            ->where('show_nav', '=', 1)
            ->orderBy($this->_leftColumn, 'ASC')
            ->findAll();
    }

    /**
     * @inheritdoc
     */
    public function values(array $values, array $expected = null)
    {
        if (isset($values['is_link']) AND is_string($values['is_link']))
        {
            $values['is_link'] = 1;
        }
        if (isset($values['show_map']) AND is_string($values['show_map']))
        {
            $values['show_map'] = 1;
        }
        if (isset($values['show_nav']) AND is_string($values['show_nav']))
        {
            $values['show_nav'] = 1;
        }

        if ($this->loaded())
        {
            $new = [
                'is_link'  => 0,
                'show_map' => 0,
                'show_nav' => 0.
            ];
            $values = array_merge($new, $values);
        }

        return parent::values($values, $expected);
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
}

