<?php

namespace page\Model;
use tourze\Model\Model;

/**
 * CMS布局模型
 * 在CMS中，模型是跟页面直接相关的部分，因为布局决定页面的总体
 * 你也可以把这里的布局理解为Template（模板）
 *
 * @property int id
 * @package page\Model
 */
class Layout extends Model
{

    /**
     * @var string
     */
    protected $_tableName = 'page_layout';

    /**
     * @var array
     */
    protected $_createdColumn = ['column' => 'date_created', 'format' => true];

    /**
     * @var array
     */
    protected $_updatedColumn = ['column' => 'date_updated', 'format' => true];

    /**
     * @var array
     */
    protected $_hasMany = [
        // 每个布局都可能有多个页面
        'pages' => [
            'model'      => 'Entry',
            'foreignKey' => 'layout_id',
        ],
    ];

    /**
     * 渲染布局内容
     */
    public function render($content = null)
    {
        // 确保布局已经加载完成
        if ( ! $this->loaded())
        {
            return __('Layout Failed to render because it wasn\'t loaded.');
        }

        $out = Base::twig_render($this->code);
        return $out;
    }

    /**
     * 检验当前Twig模板的有效性
     */
    public function test_twig()
    {
        // 确保布局代码没有语法错误
        try
        {
            $test = Base::twig_render($this->code);
        }
        catch (Twig_SyntaxError $e)
        {
            $e->setFilename('code');
            throw new Page_Exception('There was a Twig Syntax error: :message', [
                ':message' => $e->getMessage(),
            ]);
        }
        catch (Exception $e)
        {
            throw new Page_Exception('There was an error: :message on line :line', [
                ':message' => $e->getMessage(),
                ':line'    => $e->getLine(),
            ]);
        }
    }

    /**
     * 重载原来的[create]方法，判断Twig模板有效性等。
     */
    public function create(Validation $validation = null)
    {
        $this->test_twig();

        $result = parent::create($validation);

        if ($this->loaded())
        {
        }
        return $result;
    }

    /**
     * 重载原来的[update]方法，判断Twig模板有效性等。
     */
    public function update(Validation $validation = null)
    {
        $this->test_twig();

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
        if ($this->loaded())
        {
        }
        return parent::delete();
    }
}
