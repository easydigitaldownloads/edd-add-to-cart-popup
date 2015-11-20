<?php

/**
 * @wordpress-plugin
 * Plugin Name: Easy Digital Downloads - Add to Cart Popup
 * Description: An Easy Digital Downloads extension for showing a lightbox popup when customers click the "Add to Cart" button. <strong>Requires PHP 5.3 or later.</strong>
 * Version: 0.0
 * Author: Jean Galea
 * Contributors: Miguel Muscat
 */

// If the file is called directly, or has already been called, abort
if ( ! defined('WPINC') || defined('EDD_ACP') ) die;

// Define short-hand directory separator if not already defined
if ( ! defined('DS') ) define( 'DS', DIRECTORY_SEPARATOR );

// Directory and path constant definitions
define( 'EDD_ACP', 					__FILE__ );
define( 'EDD_ACP_DIR',				plugin_dir_path(EDD_ACP) );
define( 'EDD_ACP_BASE',				plugin_basename(EDD_ACP) );
define( 'EDD_ACP_URL',				plugin_dir_url(EDD_ACP) );
define( 'EDD_ACP_ASSETS_URL',		EDD_ACP_URL . 'assets/' );
define( 'EDD_ACP_CSS_URL',			EDD_ACP_ASSETS_URL . 'css/' );
define( 'EDD_ACP_JS_URL',			EDD_ACP_ASSETS_URL . 'js/' );
define( 'EDD_ACP_INCLUDES_DIR',		EDD_ACP_DIR . 'includes' . DS );

// Load the autoloader - lol
require EDD_ACP_INCLUDES_DIR . 'autoload.php';
// Add autoloading paths
edd_acp_autoloader()->add( 'Aventura\\Edd\\AddToCartPopup', EDD_ACP_INCLUDES_DIR );

/**
 * Gets the singleton instance of the plugin.
 *
 * @staticvar Aventura\Edd\AddToCartPopup\Plugin The singleton instance
 * @return Aventura\Edd\AddToCartPopup\Plugin The singleton instance of the plugin.
 */
function edd_acp() {
	static $instance = null;
	return is_null($instance)
		? $instance = new Aventura\Edd\AddToCartPopup\Plugin(EDD_ACP)
		: $instance;
}

// "Execute" the plugin functionality
edd_acp()->run();
