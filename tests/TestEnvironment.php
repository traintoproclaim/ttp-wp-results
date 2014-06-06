<?php

class TestEnvironment
{
	public $BaseUri;
	
	function __construct() {
	}
	
	function setRequest($method, $uri) {
		$_SERVER['REQUEST_METHOD'] = strtoupper($method);
		$_SERVER['REQUEST_URI'] = $uri;
	}
	
}

?>