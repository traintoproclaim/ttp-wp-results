<?php

use TTP_Results\Environment;

require_once(__DIR__ . '/../vendor/autoload.php'); 
require_once(__DIR__ . '/TestConfig.php');

class EnvironmentTest extends PHPUnit_Framework_TestCase {

	function testConstructor() {
		$expectedPluginPath = realpath(__DIR__ . '/..');
		
		$m = new Environment();
		$this->assertEquals($expectedPluginPath, $m->pluginPath);
		$this->assertEquals($expectedPluginPath . '/theme', $m->themePath);
		$this->assertEquals($expectedPluginPath . '/views', $m->viewPath);
	}
	
	/**
	 * @expectedException Exception
	 */
	function testLocatePluginTemplate_Bogus_Throws() {
		$templateNames = array('bogus.php');
		
		$m = new Environment();
		$m->locate_plugin_template($templateNames);
	}
	
}

?>
