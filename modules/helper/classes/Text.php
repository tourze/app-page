<?php defined('SYSPATH') OR die('No direct access allowed.');

class Text extends Kohana_Text {

	/**
	 * parses a string of params into an array, and changes numbers to ints
	 *
	 *    params('depth=2,something=test')
	 *
	 *    becomes
	 *
	 *    array(2) (
	 *       "depth" => integer 2
	 *       "something" => string(4) "test"
	 *    )
	 *
	 * @param  string  the params to parse
	 * @return array   the resulting array
	 */
	public static function params($var)
	{
		$var = explode(',', $var);
		$new = array();
		foreach ($var AS $i)
		{
			$i = explode('=', trim($i));
			$new[$i[0]] = Arr::get($i,1,null);
			
			if (is_numeric($new[$i[0]]))
				$new[$i[0]] = (int) $new[$i[0]];
		}

		return $new;
	}

}

