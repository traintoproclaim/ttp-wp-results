<?php
namespace TTP_Results;

class Environment {
	
	/**
	 * @var string
	 */
	public $themePath;
	
	/**
	 * @var string
	 */
	public $pluginPath;

	/**
	 * @var string
	 */
	public $viewPath;
	
	/**
	 * @var string
	 */
	public $clientPath;
	
	function __construct() {
		$this->pluginPath = self::toURL(realpath(__DIR__ . '/../'));
		$this->themePath  = $this->pluginPath . '/theme';
		$this->viewPath   = $this->pluginPath . '/views';
		$this->clientPath = $this->pluginPath . '/client';
	}
	
	static function toURL($path) {
		return str_replace('\\', '/', $path);
	}

	/**
	 * Returns all the scripts for the give app.
	 * The scripts are all under clients/$app
	 * @param string $app
	 * @return multitype:string
	 */
	function scriptPaths($app) {
		$it = new \RecursiveDirectoryIterator($this->clientPath . '/' . $app);
		$it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::SELF_FIRST);
	
		$baseLength = strlen(ABSPATH);
		$scripts = array();
		foreach ($it as $file) {
			if ($file->isFile()) {
				$ext = $file->getExtension();
				$isMin = (strpos($file->getPathname(), '-min') !== false);
				if (!$isMin && $ext == 'js') {
					$scripts[] = '/' . self::toURL(substr($file->getPathname(), $baseLength));
				}
			}
		}
		return $scripts;
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