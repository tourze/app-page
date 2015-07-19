<?php defined('SYSPATH') OR die('No direct access.');
/**
 * Black captcha class.
 *
 * @package		Kohana/Captcha
 * @category	Driver
 */
class Kohana_Captcha_Driver_Black extends Captcha_Driver {

	/**
	 * Generates a new Captcha challenge.
	 *
	 * @return string The challenge answer
	 */
	public function generate_challenge()
	{
		// Complexity setting is used as character count
		$text = Text::random('distinct', max(1, ceil(Captcha_Driver::$config['complexity'] / 1.5)));
		return $text;
	}

	/**
	 * Outputs the Captcha image.
	 *
	 * @param boolean $html HTML output
	 * @return mixed
	 */
	public function render($html = TRUE)
	{
		// Creates a black image to start from
		$this->image_create(Captcha_Driver::$config['background']);

		// Add random white/gray arcs, amount depends on complexity setting
		$count = (Captcha_Driver::$config['width'] + Captcha_Driver::$config['height']) / 2;
		$count = $count / 5 * min(10, Captcha_Driver::$config['complexity']);
		for ($i = 0; $i < $count; $i++)
		{
			imagesetthickness($this->image, mt_rand(1, 2));
			$color = imagecolorallocatealpha($this->image, 255, 255, 255, mt_rand(0, 120));
			imagearc($this->image, mt_rand(-Captcha_Driver::$config['width'], Captcha_Driver::$config['width']), mt_rand(-Captcha_Driver::$config['height'], Captcha_Driver::$config['height']), mt_rand(-Captcha_Driver::$config['width'], Captcha_Driver::$config['width']), mt_rand(-Captcha_Driver::$config['height'], Captcha_Driver::$config['height']), mt_rand(0, 360), mt_rand(0, 360), $color);
		}

		// Use different fonts if available
		$font = Captcha_Driver::$config['fontpath'].Captcha_Driver::$config['fonts'][array_rand(Captcha_Driver::$config['fonts'])];

		// Draw the character's white shadows
		$size = (int) min(Captcha_Driver::$config['height'] / 2, Captcha_Driver::$config['width'] * 0.8 / strlen($this->response));
		$angle = mt_rand(-15 + strlen($this->response), 15 - strlen($this->response));
		$x = mt_rand(1, Captcha_Driver::$config['width'] * 0.9 - $size * strlen($this->response));
		$y = ((Captcha_Driver::$config['height'] - $size) / 2) + $size;
		$color = imagecolorallocate($this->image, 255, 255, 255);
		imagefttext($this->image, $size, $angle, $x + 1, $y + 1, $color, $font, $this->response);

		// Add more shadows for lower complexities
		(Captcha_Driver::$config['complexity'] < 10) and imagefttext($this->image, $size, $angle, $x - 1, $y - 1, $color, $font , $this->response);
		(Captcha_Driver::$config['complexity'] < 8)  and imagefttext($this->image, $size, $angle, $x - 2, $y + 2, $color, $font , $this->response);
		(Captcha_Driver::$config['complexity'] < 6)  and imagefttext($this->image, $size, $angle, $x + 2, $y - 2, $color, $font , $this->response);
		(Captcha_Driver::$config['complexity'] < 4)  and imagefttext($this->image, $size, $angle, $x + 3, $y + 3, $color, $font , $this->response);
		(Captcha_Driver::$config['complexity'] < 2)  and imagefttext($this->image, $size, $angle, $x - 3, $y - 3, $color, $font , $this->response);

		// Finally draw the foreground characters
		$color = imagecolorallocate($this->image, 0, 0, 0);
		imagefttext($this->image, $size, $angle, $x, $y, $color, $font, $this->response);

		// Output
		return $this->image_render($html);
	}

} // End Captcha Black Driver Class

