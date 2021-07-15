<?php

/**
 * Neko Framework View Engine Class
 * --------------------------------------
 * This class is only for Neko framework
 */

namespace Neko\Blade;

use Neko\Framework\App;
use Neko\Framework\View\ViewEngineInterface;

class ViewEngine implements ViewEngineInterface {

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
	public function render($file, array $data = [], $returnOnly=false)
	{
		return $this->app->blade->render($file, $data, $returnOnly);
	}

}
