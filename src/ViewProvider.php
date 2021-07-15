<?php

/**
 * Provider Class for Neko Framework
 * --------------------------------------
 * This class is only for Neko framework
 */

namespace Neko\Blade;

use Neko\Framework\App;
use Neko\Framework\Provider;

class ViewProvider extends Provider {

	/**
	 * Register blade instance on application booting
	 */
	public function register()
	{
		$app = $this->app;
		$app['blade'] = $app->container->singleton(function($container) use ($app) {
			
			$blade = new Blade();
			
			$blade->directive('capitalize', function ($text) {
				return "<?php echo strtoupper($text) ?>";
			});


			/*
			$blade->directive('set', function($exp) {
				list($name, $val) = explode(',', $exp);
				return "<?php {$name} = {$val}; ?>";
			});
			*/

			return $blade;
		});
	}

	/**
	 * Register view macro on application booting
	 */
	public function boot()
	{
		$app = $this->app;

		$app->macro('blade', function($file, array $data = []) use ($app) {
			return $app->blade->render($file, $data);
		});
	}

	public function shutdown()
	{
		
	}

}
