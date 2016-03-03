<?php
define('ROOT_PATH', dirname(__FILE__));


// Find the path to the secure config file
// Uncomment after go live
/*
$foundPublic = false;
$parts = explode('/', str_replace('\\', '/', dirname(__FILE__)));
$config_path = '';
foreach ($parts as $part) {
	if ($part === 'public_html' || $part === 'www'
                || $part === 'NorthRegionScripts') {
		$foundPublic = true;
	}
	if ( ! $foundPublic) {
		$config_path .= $part . '/';
	}
}
$config_path .= 'config_info/scripts_info.php';

// Load database info
require_once($config_path);
*/
require_once('scripts_info.php');

/*****************************************************************************
 *              Include Files / Autoloaders
 ****************************************************************************/
require_once(ROOT_PATH . '/MySQLModule/' . 'class.database.php');

spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/models/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/mappers/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/classes/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/controllers/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/views/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/RegistryModule/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/MySQLModule/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
spl_autoload_register(function ($className) {
    $file = ROOT_PATH . '/interfaces/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
?>
