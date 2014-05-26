<?php
/*
Plugin Name: Train To Proclaim Results
Plugin URI: https://github.com/traintoproclaim/ttp-wp-results
Description: Results section for Train To Proclaim
Author: Cambell Prince
Version: 0.1
Author URI: http://saygoweb.com/
*/

use TTP_Results\Controller;

require_once(__DIR__ . '/vendor/autoload.php');

function ttp_results_main() {
	$plugin = Controller::createContainer();
	$controller = $plugin['controller'];
	
	register_activation_hook(__FILE__, function() use ($plugin) {
		$plugin['installer']->install();
	});
	register_deactivation_hook(__FILE__, function() use ($plugin) {
		$plugin['installer']->uninstall();
	});
}
ttp_results_main();

?>