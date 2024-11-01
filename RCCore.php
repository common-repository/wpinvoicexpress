<?php

class RCCore {

	protected $extensions = array();

	public function __contruct() {

		$this->loadExtensions();

	}

	public function loadExtensions() {

		require_once 'interface-extension.php';

		foreach (new DirectoryIterator(__DIR__ . '/extensions') as $fileInfo) {

    		if($fileInfo->isDot()) continue;

    		try {

	    		include 'extensions/' .  $fileInfo->getFilename();

	    		$class = $fileInfo->getBasename('.php');
	    		$class::enable();
	    		$this->extensions[] = $class;

    		} catch (Exception $e) {

    			die(sprintf('Unable to load extension: %s', $class));

    		}

		}

	}

	public static function includeLib($name) {

		include_once __DIR__ . '/libs/' . $name . '.php';

	}

	public static function includeVendor($name) {

		include_once __DIR__ . '/vendors/' . $name . '.php';

	}

	public static function render($template_file, $params = array()) {

		extract($params);

		include __DIR__ . '/views/' . $template_file . '.php';

	}

	public static function renderWPTemplate($template_file, $params = array()) {

		extract($params);

		include get_stylesheet_directory() . '/plugin/' . $template_file . '.php';

	}

	public static function getPluginUrl($file) {

		return plugins_url($file, __FILE__);

	}

	public static function includeScript($name, $path, $version = '1.0.0') {

		wp_enqueue_script( $name, plugins_url($path, __FILE__), array(), $version, true );

	}

	public static function includeCSS($name, $path, $version = '1.0.0') {

		wp_enqueue_style( $name, plugins_url($path, __FILE__), array(), $version );

	}

}

if (!isset($RCCore)) {

	$RCCore = new RCCore();

}

add_action( 'init', array ( $RCCore, 'loadExtensions' ), 0 );

/**
 * Generic debug helper method
 */
function RCDebug() {

	foreach (func_get_args() as $arg) {
		echo '<pre>';
		var_dump($arg);
		echo '</pre>';
	}

}