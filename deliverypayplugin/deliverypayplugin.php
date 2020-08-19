<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              mariapantou.gr
 * @since             1.0.0
 * @package           Deliverypayplugin
 *
 * @wordpress-plugin
 * Plugin Name:       deliveryPayPlugin
 * Plugin URI:        mariapantou.gr
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pantou Maria
 * Author URI:        mariapantou.gr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       deliverypayplugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'DELIVERYPAYPLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-deliverypayplugin-activator.php
 */
function activate_deliverypayplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deliverypayplugin-activator.php';
	Deliverypayplugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deliverypayplugin-deactivator.php
 */
function deactivate_deliverypayplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deliverypayplugin-deactivator.php';
	Deliverypayplugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_deliverypayplugin' );
register_deactivation_hook( __FILE__, 'deactivate_deliverypayplugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-deliverypayplugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_deliverypayplugin() {

	$plugin = new Deliverypayplugin();
	$plugin->run();

}
run_deliverypayplugin();
