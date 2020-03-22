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
			$theme="";
            foreach ($app->request->route()->getMiddlewares() as $key => $val) {
                if (strpos($val, 'theme') !== FALSE) {
                    $theme=explode(":",$val)[1];
                }
            }
            if($theme!="")
            {
                $theme=$theme;
            }else{
                $theme=$app->config->get('user_theme');
			}
			
            $view_paths = [$app->config->get('app.path')."themes/".$theme];
			//$view_paths = [ $app->config['app.path']."themes/".$app->config['user_theme'] ];
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

		$app->macro('theme', function($file, array $data = []) use ($app) {
			return $app->blade->render($file, $data);
		});
	}

}
