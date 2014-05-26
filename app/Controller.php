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
		if (is_page('results-page')) {
			wp_dequeue_script('default');
			// TODO Enqueu the scripts here.
			add_filter('the_content', array($this, 'onContent'));
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