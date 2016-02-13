<?php
/**
 * Advanced Term Fields: Colors
 *
 * @package Advanced_Term_Fields_Colors
 *
 * @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 * @version     0.1.2
 *
 * Plugin Name: Advanced Term Fields: Colors
 * Plugin URI:  http://darrinb.com/plugins/advanced-term-fields-colors
 * Description: Easily assign colors for categories, tags, and custom taxonomy terms.
 * Version:     0.1.2
 * Author:      Darrin Boutote
 * Author URI:  http://darrinb.com
 * Text Domain: atf-colors
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * @internal Nobody should be able to overrule the real version number
 * as this can cause serious issues, so no if ( ! defined() )
 *
 * @since 0.1.2
 */
define( 'ATF_COLORS_VERSION', '0.1.2' );


if ( ! defined( 'ATF_COLORS_FILE' ) ) {
	define( 'ATF_COLORS_FILE', __FILE__ );
}


/**
 * Load Utilities
 *
 * @since 0.1.2
 */
include dirname( __FILE__ ) . '/inc/functions.php';


/**
 * Checks compatibility
 *
 * @since 0.1.0
 */
add_action( 'plugins_loaded', '_atf_colors_compatibility_check', 99 );


/**
 * Instantiates the main Advanced Term Fields: Colors class
 *
 * @since 0.1.0
 */
function _atf_colors_init() {

	if ( ! _atf_colors_compatibility_check() ){ return; }

	include dirname( __FILE__ ) . '/inc/class-adv-term-fields-colors.php';

	$Adv_Term_Fields_Colors = new Adv_Term_Fields_Colors( __FILE__ );
	$Adv_Term_Fields_Colors->init();

}
add_action( 'init', '_atf_colors_init', 99 );


/**
 * Run actions on plugin upgrade
 *
 * @since 0.1.2
 */
add_action( "atf__term_color_version_upgraded", '_atf_colors_version_upgraded_notice', 10, 5 );
add_action( "atf__term_color_version_upgraded", '_atf_colors_maybe_update_meta_key', 10, 5 );
