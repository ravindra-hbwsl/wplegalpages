<?php
/**
Plugin Name: WP Legal Pages
Plugin URI: http://wplegalpages.com
Description: WP Legal Pages is a simple 1 click legal page management plugin. You can quickly add in legal pages to your wordpress sites. Furthermore the business information you fill in the general settings will be automatically filled into the appropriate places within the pages due to our custom integration system we have.
Author: WPEka Club
Version: 1.5.2
Author URI: http://wplegalpages.com/
License: GPL2
Text Domain: WP Legal Pages
Domain Path: /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * The code that runs during WP Legal Pages activation.
 * This action is documented in includes/class-wp-legal-pages-activator.php
 */
function activate_wp_legal_pages() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-legal-pages-activator.php';
	WP_Legal_Pages_Activator::activate();
}

/**
 * The code that runs during WP Legal Pages deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_wp_legal_pages() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-legal-pages-deactivator.php';
	WP_Legal_Pages_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_legal_pages' );
register_deactivation_hook( __FILE__, 'deactivate_wp_legal_pages' );

/**
 * The core WP Legal Pages class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-legal-pages.php';
/**
 * Begins execution of the WP Legal Pages.
 *
 * Since everything within the WP Legal Pages is registered via hooks,
 * then kicking off the WP Legal Pages from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_legal_pages() {

	$legal_pages = new WP_Legal_Pages();
	$legal_pages->run();

}
run_wp_legal_pages();