<?php defined('SYSPATH') OR die('No direct script access.');
/**
 * 继承原来的异常类，方便接下来操作啊
 *
 * @package    Page
 * @author     YwiSax
 */
class Page_Exception extends Kohana_Exception {

	/**
	 * 重载这个方法
	 */
	public function __construct($message = '', array $variables = NULL, $code = 0, Exception $previous = NULL)
	{
		return parent::__construct($message, $variables, $code, $previous);
	}
}
