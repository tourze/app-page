<?php

namespace page\Model;

use page\Exception\PageException;
use tourze\Base\Log;
use tourze\Http\Http;
use tourze\Model\Model;

/**
 * 跳转模型
 *
 * @property string new_url
 * @property string url
 * @property mixed  type
 * @package page\Model
 */
class Redirect extends Model
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

    /**
     * 状态信息
     *
     * @return array
     */
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

    /**
     * 返回状态数据的json格式
     *
     * @return string
     */
    public function statusJson()
    {
        return json_encode(self::status());
    }

    /**
     * 过滤规则
     */
    public function filters()
    {
        return [
            'url'     => [
                ['trim'],
                ['strip_tags'],
            ],
            'new_url' => [
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
            'url'     => [
                ['notEmpty'],
            ],
            'new_url' => [
                ['notEmpty'],
            ],
            'type'    => [
                ['notEmpty'],
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
                Log::info('Redirected trigger.', [
                    'url'     => $this->url,
                    'new_url' => $this->new_url,
                    'type'    => $this->type,
                ]);
                Http::redirect($this->new_url, $this->type);
            }
            else
            {
                Log::error('Could not redirect', [
                    'url'     => $this->url,
                    'new_url' => $this->new_url,
                    'type'    => $this->type,
                ]);
                throw new PageException('Unknown redirect type', [], 404);
            }
        }
    }
}
