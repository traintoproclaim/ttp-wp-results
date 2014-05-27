<?php
namespace TTP_Results;

class Controller {
	/**
	 * @var Environment
	 */
	private $_environment;

	/**
	 * @var array
	 */
	private $_params;
	
	/**
	 * @var Pimple
	 */
	public static $Plugin;
	
	
	function __construct(Environment $environment) {
		$this->_environment = $environment;

		add_action('wp', array($this, 'onWP'));
		
		// Add routes
		\Timber::add_route('api/results/.*', function($params) {
			$api = self::$Plugin['api'];
			$api->handle('/api/results/');
			exit;
		});
// 		\Timber::add_route('results/:appPage', function($params) {
// 			$this->_params = $params;
// 			add_filter('the_content', array($this, 'onContent'));
// 			\Timber::load_template('page.php');
// 		});
		
	}

	/**
	 * 
	 * @param WP_Query $wp
	 */
	function onWP($wp) {
		if (is_page('results')) {
			add_filter('the_content', array($this, 'onContent'));
			
			// Remove the default angular app
			wp_dequeue_script('default');
			// Add scripts for this page
			$scripts = $this->_environment->scriptPaths('results');
			$i = 0;
			foreach($scripts as $script) {
				wp_enqueue_script(sprintf("ttp-results-%d", $i++), $script, array('angular'), '', true);
			}
		}
	}
	
	function onContent($content) {
		return '<div data-ng-view></div>';
	}
	
	static function createContainer() {
		$container = new \Pimple();
		$container['db'] = function($c) {
			global $wpdb;
			return $wpdb;
		};
		$container['api'] = function($c) {
			return new Api();
		};
		$container['environment'] = function($c) {
			return new Environment();
		};
		$container['controller'] = function ($c) {
			return new Controller($c['environment']);
		};
		$container['installer'] = function($c) {
			return new Installer($c['db']);
		};
		self::$Plugin = $container;
		return self::$Plugin;
	}
	
}

?>