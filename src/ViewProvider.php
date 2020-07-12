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
			//$theme="";
			//
			//if($app->request->route() !== NULL)
			//{
			//	foreach ($app->request->route()->getMiddlewares() as $key => $val) {
			//		if (strpos($val, 'theme') !== FALSE) {
			//			$theme=explode(":",$val)[1];
			//		}
			//	}
			//}
//
            //if($theme!="")
            //{
            //    $theme=$theme;
            //}else{
            //    $theme=$app->config->get('user_theme');
			//}
			

			$plugin_paths = array_map(function($val) use ($app) { return $app->config->get('app.path')."plugins/".str_replace(".","/",$val)."/assets";} , $app->plugin_active);
			$view_paths = [$app->config->get('app.path')."themes/".$app->config->get('user_theme'),$app->config->get('app.path')."themes/".$app->config->get('admin_theme')];
			$view_paths = array_merge($plugin_paths,$view_paths);
			$view_cache_path = $app->config['app.path']."themes/_cache";
			$blade = new Blade($view_paths, $view_cache_path);

			$blade->directive('uppercase', function($exp) {
				return "<?php echo strtoupper({$exp});?>";
			});

			$blade->directive('set', function($exp) {
				list($name, $val) = explode(',', $exp);
				return "<?php {$name} = {$val}; ?>";
			});

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

}
