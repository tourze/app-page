<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * 输出验证码图片
 *
 *     <img src="<?php echo URL::site('captcha') ?>" />
 *
 * @package		Kohana/Captcha
 * @cateogry	Controller
 * @author		YwiSax
 */
class Kohana_Controller_Captcha extends Controller {

	/**
	 * 当前执行的配置组
	 */
	public $group = NULL;

	public function before()
	{
		$this->group = $this->request->param('group', 'default');
	}

	/**
	 * 处理和渲染验证码
	 */
	public function action_index()
	{
		//$group = $this->request->param('group', 'default');
		Captcha::instance($this->group)->render(FALSE);
	}

	public function after()
	{
		Captcha::instance($this->group)->update_response_session();
	}

} // End Captcha_Controller

