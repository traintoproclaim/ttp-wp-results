<?php
namespace TTP_Results;

class Controller {
	private $_environment;
	
	function __construct(Environment $environment) {
		$this->_environment = $environment;
		// Add routes
		
	}
	
	static function createContainer() {
		$container = new Pimple\Pimple();
		$container['environment'] = function($c) {
			return new Environment();
		};
		$container['controller'] = function ($c) {
			return new Controller($c['environment']);
		};
	}
	
}

?>