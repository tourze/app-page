<?php

namespace page\Model;

/**
 * 跳转模型
 *
 * @package page\Model
 */
class Redirect extends Base
{

    /**
     * @var string
     */
    protected $_tableName = 'page_redirect';

    /**
     * @var array
     */
    protected $_createdColumn = ['column' => 'date_created', 'format' => true];

    /**
     * @var array
     */
    protected $_updatedColumn = ['column' => 'date_updated', 'format' => true];

    public static function status()
    {
        return [
            [
                'text'  => __('Permanent'),
                'value' => 301,
            ],
            [
                'text'  => __('Temporary'),
                'value' => 302,
            ],
        ];
    }

    public function status_json()
    {
        return json_encode(Model_Page_Redirect::status());
    }

    /**
     * 过滤规则
     */
    public function filters()
    {
        return [
            'url'    => [
                ['trim'],
                ['strip_tags'],
            ],
            'newurl' => [
                ['trim'],
                ['strip_tags'],
            ],
        ];
    }

    /**
     * 检验规则
     */
    public function rules()
    {
        return [
            'url'    => [
                ['not_empty'],
            ],
            'newurl' => [
                ['not_empty'],
            ],
            'type'   => [
                ['not_empty'],
            ],
        ];
    }

    /**
     * 如果查找到，那就直接跳转
     */
    public function go()
    {
        // 要加载到记录才继续
        if ($this->loaded())
        {
            if ($this->type == '301' || $this->type == '302')
            {
                Kohana::$log->add('INFO', __("Base - Redirected ':url' to ':newurl' (:type).", [
                    ':url'    => $this->url,
                    ':newurl' => $this->newurl,
                    ':type'   => $this->type,
                ]));
                HTTP::redirect($this->newurl, $this->type);
            }
            else
            {
                Kohana::$log->add('ERROR', __("Base - Could not redirect ':url' to ':newurl', type: :type.", [
                    ':url'    => $this->url,
                    ':newurl' => $this->newurl,
                    ':type'   => $this->type,
                ]));
                throw new Page_Exception('Unknown redirect type', [], 404);
            }
        }
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
        if ($this->loaded())
        {
        }
        return parent::delete();
    }
}
