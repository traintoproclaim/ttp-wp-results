<?php
namespace TTP_Results;

class Environment {
	
	public $themePath;
	
	public $pluginPath;

	public $viewPath;
	
	function __construct() {
		$this->pluginPath = realpath(__DIR__ . '/../');
		$this->themePath = $this->pluginPath . '/theme';
		$this->viewPath = $this->pluginPath . '/views';
	}

	function locate_plugin_template($templateNames) {
		foreach ($templateNames as $templateName) {
			$templateFilePath = $this->themePath . '/' . $templateName;
			if (file_exists($templateFilePath)) {
				return $templateFilePath;
			}
		}
		throw new \Exception('TTP_Results: Could not find template. Looked in: ' . implode(', ', $templateNames));
	}
	
	function locate_template($templateNames) {
		// Check the theme first
		$templateFilePath = \locate_template($templateNames);
		if ('' == $templateFilePath) {
			return $this->locate_plugin_template($templateNames);
		}
	}
	
	function load_template($templateNames) {
	
	}
	
	
}

?>