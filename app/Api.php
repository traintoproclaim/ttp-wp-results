<?php
namespace TTP_Results;

class Api extends \Pimple
{
	/**
	 * @var Router
	 */
	private $_router;
	
	function __construct() {
		$this->_router = new \Router();
		$this['countries'] = function($c) {
			
		};
	}
	
	function response($baseUrl) {
		$router = $this->_router;
		$router->setBasePath($baseUrl);
		$response = array();
		$router->map('country/list', function($params) {
			$response = array("countries" => array());
			return $response;
		});
		$router->map('country/:id', function($params) {
			$response = array("country" => array("id" => $params['id']));
			return $response;
		});
		$route = $router->matchCurrentRequest();
		if ($route) {
			$callback = $route->getTarget();
			$params = $route->getParameters();
			$response = $callback($params);
		} else {
			throw new \Exception(sprintf("API Error: No route for '%s'", $_SERVER['REQUEST_URI']));
		}
		return $response;
	}
	
	function handle($baseUrl) {
		$response = $this->response($baseUrl);
		header("Content-Type: application/javascript");
		echo json_encode($response);
	}
	
}

?>