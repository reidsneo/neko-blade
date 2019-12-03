<?php

/**
 * Neko Framework View Engine Class
 * --------------------------------------
 * This class is only for Neko framework
 */

namespace Neko\Blade;

use Neko\Framework\App;
use Neko\Framework\View\ViewEngineInterface;

class NekoViewEngine implements ViewEngineInterface {

	protected $app;

	public function __construct(App $app)
	{
		$this->app = $app;
	}

	/**
	 * Render view file with blade factory
	 *
	 * @param string $file
	 * @param array $data
	 * @return string rendered view
	 */
	public function render($file, array $data = [])
	{
		return $this->app->blade->render($file, $data);
	}

}
