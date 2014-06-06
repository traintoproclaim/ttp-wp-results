<?php

use TTP_Results\Api;

require_once(__DIR__ . '/TestConfig.php');
require_once(TTP_RESULTS_SRCPATH . '/vendor/autoload.php');

require_once(TTP_RESULTS_TESTPATH . '/TestEnvironment.php');

class ApiTest extends PHPUnit_Framework_TestCase {

	function testConstructor() {
		$e = new TestEnvironment();
		$e->BaseUri = '/api/results/';
		
		// List N
		$e->setRequest('GET', '/api/results/country/list');
		$a = new Api();
		$result = $a->response($e->BaseUri);
		var_dump($result);
		
		// Post new
		$e->setRequest('POST', '/api/results/country');
		
		// List N+1
		$e->setRequest('GET', '/api/results/country/list');
		
		// Get new
		$e->setRequest('GET', '/api/results/country/'. $id);
		
		// Post update
		$e->setRequest('POST', '/api/results/country/'. $id);
		
		// Get update
		$e->setRequest('GET', '/api/results/country/'. $id);
		
		// Delete
		$e->setRequest('POST', '/api/results/country/'. $id . '/delete');
		
		// List N
		$e->setRequest('GET', '/api/results/country/list');
		
	}
	
}

?>
