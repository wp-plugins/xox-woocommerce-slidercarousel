<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://demo.xolluteon.com/
 * @since             1.0.0
 * @package           Xox_Woo_Carousel
 *
 * @wordpress-plugin
 * Plugin Name:       X-tra Ordinary WooCommerce Product Carousel and Slider
 * Plugin URI:        http://demo.xolluteon.com/
 * Description:       This plugin will create an X-tra ordinary Slider and Carousels where you can then add it to any page with shortcode or through widget.
 * Version:           1.0.0
 * Author:            Arung Isyadi
 * Author URI:        http://demo.xolluteon.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       xox-woo-carousel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-xox-woo-carousel-activator.php
 */
function activate_xox_woo_carousel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xox-woo-carousel-activator.php';
	Xox_Woo_Carousel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-xox-woo-carousel-deactivator.php
 */
function deactivate_xox_woo_carousel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-xox-woo-carousel-deactivator.php';
	Xox_Woo_Carousel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_xox_woo_carousel' );
register_deactivation_hook( __FILE__, 'deactivate_xox_woo_carousel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-xox-woo-carousel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_xox_woo_carousel() {

	$plugin = new Xox_Woo_Carousel();
	$plugin->run();

}
run_xox_woo_carousel();

function xox_create_new_post_type(){
    register_post_type('xox-carousel-slider', // Register Custom Post Type
    array(
        'labels' => array(
            'name' => __('XoX Slider & Carousel', $plugin_name), // Rename these to suit
            'singular_name' => __('XoX Slider & Carousel', $plugin_name),
            'add_new' => __('Add New Slider/Carousel', $plugin_name),
            'add_new_item' => __('Add New Slider/Carousel', $plugin_name),
            'edit' => __('Edit Slider/Carousel', $plugin_name),
            'edit_item' => __('Edit Slider/Carousel', $plugin_name),
            'new_item' => __('New Slider/Carousel', $plugin_name),
            'view' => __('View Slider/Carousel', $plugin_name),
            'view_item' => __('View Slider/Carousel', $plugin_name),
            'search_items' => __('Search Slider/Carousel', $plugin_name),
            'not_found' => __('No Slider/Carousel found', $plugin_name),
            'not_found_in_trash' => __('No Slider/Carousel found in Trash', $plugin_name)
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'show_in_nav_menus' => true,
        'show_in_menu' => true,
        'show_in_admin_bar' => true,
        'menu_icon' => 'dashicons-images-alt',
        'menu_position' => 100,
        'supports' => array(
            'title',
            'revisions'
            //'editor',
            //'excerpt',
            //'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            //'post_tag',
            //'category'
        ) // Add Category and Post Tags support
    ));
}
add_action('init', 'xox_create_new_post_type');

//enable shortcode in text widget
add_filter('widget_text', 'do_shortcode');

function adding_new_publish( $post_type, $post ) {
    add_meta_box( 
        'my-publish-box',
        __( 'Publish Slider/Carousel' ),
        'publish_box',
        'xox-carousel-slider',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'adding_new_publish', 10, 2 );

function publish_box(){
    $val = isset($_GET['action']) && $_GET['action'] == 'edit' ? 'Update' : 'Publish';
    $name = isset($_GET['action']) && $_GET['action'] == 'edit' ? 'save' : 'publish';
    submit_button( __( $val ), 'primary', $name, false, array( 'tabindex' => '5', 'accesskey' => 'p' ) );
}
