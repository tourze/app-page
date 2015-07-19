<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Twig view
 */
class Twig extends View {

	/**
	 * Twig environment
	 */
	protected static $_environment = NULL;

	/**
	 * Initialize the Twig module
	 */
	public static function init()
	{
		require_once TWIG_PATH . 'Twig/Autoloader.php';
		Twig_Autoloader::register();
	}

	/**
	 * Create a Twig view instance
	 *
	 * @param   string  $file  Name of Twig template
	 * @param   array   $data  Data to be passed to template
	 * @return  Twig    Twig view instance
	 */
	public static function factory($file = NULL, array $data = NULL)
	{
		return new Twig($file, $data);
	}

	/**
	 * Create a new Twig environment
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	public static function generate_environment($loader = NULL)
	{
		$config = Kohana::$config->load('twig');

		if ($loader === NULL)
		{
			$loader = new Twig_Loader_CFS($config->get('loader'));
		}

		$env = new Twig_Environment($loader, $config->get('environment'));

		foreach ($config->get('functions') as $key => $value)
		{
			$function = new Twig_SimpleFunction($key, $value);
			$env->addFunction($function);
		}

		foreach ($config->get('filters') as $key => $value)
		{
			$filter = new Twig_SimpleFilter($key, $value);
			$env->addFilter($filter);
		}

		return $env;
	}

	/**
	 * Get the Twig environment (or create it on first call)
	 *
	 * @return  Twig_Environment  Twig environment
	 */
	protected static function environment()
	{
		if (static::$_environment === NULL)
		{
			static::$_environment = static::generate_environment();
		}
		return static::$_environment;
	}
	
	public function filename($file = NULL)
	{
		if ($file === NULL)
		{
			return $this->_file;
		}

		// 保存文件路径
		$this->_file = $file;
		return $this;
	}

	/**
	 * Render Twig template as string
	 *
	 * @param   string  $file  Base name of template
	 * @return  string  Rendered Twig template
	 */
	public function render($file = NULL, $clear = NULL)
	{
		if ($file !== NULL)
		{
			$this->filename($file);
		}
		return static::environment()->render($this->_file, $this->_data);
	}

} // End Twig
