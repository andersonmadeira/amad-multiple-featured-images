<?php

/*
Plugin Name: AMad Multiple Featured Images
Plugin URI: https://github.com/andersonmadeira/amad-multiple-featured-images
Description: Add multiple featured post images for your wordpress site
Version: 1.0.0
Author: Anderson Madeira <andersonmadeiracs@gmail.com>
Author URI: https://github.com/andersonmadeira
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: amad-multiple-featured-images
Domain Path: /languages
*/

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'AMAD_MFI_VERSION', '1.0.5' );

function amad_activate_multiple_featured_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amad-multiple-featured-images-activator.php';
	AMad_Multiple_Featured_Images_Activator::activate();
}

function amad_deactivate_multiple_featured_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-amad-multiple-featured-images-deactivator.php';
	AMad_Multiple_Featured_Images_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_multiple_featured_images' );
register_deactivation_hook( __FILE__, 'deactivate_multiple_featured_images' );

require plugin_dir_path( __FILE__ ) . 'includes/class-amad-multiple-featured-images.php';

?>