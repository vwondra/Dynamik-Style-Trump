<?php
/**
 * Genesis Style Trump
 *
 * This is a fork of Carrie Dills awesome Genesis_Style_Trump plugin that has been modified to work with the Dynamik Website Builder for Genesis which has it's own custom CSS area 
 *
 * @package           Dynamik_Style_Trump
 * @author            Vincent Wondra
 * @license           GPL-2.0+
 * @link              http://www.bootstrapbusinesssolutions.com
 * @copyright         2014 Vincent Wondra
 *
 * Plugin Name:       Dynamik Style Trump
 * Plugin URI:        http://wordpress.org/plugins/dynamik-style-trump
 * Description:       Loads Dynamik & Genesis child theme style sheet after plugin styles.
 * Version:           1.0.0
 * Author:            Vincent Wondra
 * Author URI:        http://www.bootstrapbusinesssolutions.com
 * Text Domain:       dynamik-style-trump
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/vwondra/dynamik-style-trump
 * GitHub Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

// Unqueue WooCommerce styles one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
add_action( 'wp_enqueue_scripts', 'load_woocommerce_stylesheets', 5 );


/*Load WooCommerce style sheets early */
function load_woocommerce_stylesheets() {
	wp_enqueue_style('woocommerce_css', plugins_url() .'/woocommerce/assets/css/woocommerce.css');
	wp_enqueue_style('woocommerce_layout_css', plugins_url() .'/woocommerce/assets/css/woocommerce-layout.css');  
	wp_enqueue_style('woocommerce_smallscreen_css', plugins_url() .'/woocommerce/assets/css/woocommerce-smallscreen.css');  	
}


/* Load Genesis Style sheets later */
add_action( 'genesis_setup', 'genesisstyletrump_load_stylesheet' );

/*Load Dynamik Style Sheets later */
add_action( 'get_header', 'custom_dynamik_load_stylesheet' );
/**
 * Move Genesis child theme style sheet to a much later priority to give any plugins a chance to load first.
 *
 * @since 1.0.0
 */
function genesisstyletrump_load_stylesheet() {

	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
	add_action( 'wp_enqueue_scripts', 'genesis_enqueue_main_stylesheet', 20 );
	
function custom_dynamik_load_stylesheet() {
    remove_action( 'genesis_meta', 'genesis_load_stylesheet' );
    remove_action( 'genesis_meta', 'dynamik_add_stylesheets', 5 );
    add_action( 'wp_enqueue_scripts', 'dynamik_add_stylesheets', 30 );
}  
}
