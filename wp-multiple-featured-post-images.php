<?php

/*
Plugin Name: WP Multiple Featured Post Images
Plugin URI: https://github.com/andersonmadeira/wp-multiple-featured-post-images
Description: Add multiple featured post images for your wordpress site
Version: 1.0.0
Author: Anderson Madeira <andersonmadeiracs@gmail.com>
Author URI: https://github.com/andersonmadeira
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: wp-multiple-featured-post-images
Domain Path: /languages
*/

define('PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// register scripts and styles
function amad_mfpi_register_resources() {
	wp_register_style( 'amad-wp-multiple-featured-post-images', plugin_dir_url( __FILE__ ) . 'assets/css/wp-multiple-featured-post-images.css', array(), '1.0.0', 'all' );
	wp_register_script( 'amad-wp-multiple-featured-post-images', plugin_dir_url( __FILE__ ) . 'assets/js/wp-multiple-featured-post-images.js', array( 'jquery' ), '1.0.2', true );
}

add_action( 'wp_loaded', 'amad_mfpi_register_resources' );

function amad_mfpi_enqueue_admin_resources() {
    global $post;

    wp_enqueue_style( 'amad-wp-multiple-featured-post-images' );

    // get data to localize

    // Get WordPress' media upload URL
    $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

    $array_data = array(
        'upload_link' => $upload_link,
        'get_thumbnail_nonce' => wp_create_nonce( 'mfpi-get-thumbnail' ),
        'ajax_url'   => admin_url( 'admin-ajax.php' ),
        'select_message' => __('Select your image'),
        'use_message' => __('Use this image'),
    );

    wp_localize_script( 'amad-wp-multiple-featured-post-images', 'amad_mfpi', $array_data );
    wp_enqueue_script( 'amad-wp-multiple-featured-post-images' );
}

add_action( 'admin_enqueue_scripts', 'amad_mfpi_enqueue_admin_resources' );

// Add new featured image metabox
function amad_mfpi_add_custom_meta_boxes() {
	add_meta_box( 
		'amad_mfpi_noticia_destaque',
		'Imagem Destaque',
		'amad_mfpi_noticia_destaque_html',
		'post',
		'side'
	);
}

add_action( 'add_meta_boxes', 'amad_mfpi_add_custom_meta_boxes' );

// Print the html of the metabox
function amad_mfpi_noticia_destaque_html() {
    global $post;

    $mfpi_id = get_post_meta( $post->ID, 'mfpi_id', true );

    $mfpi_thumb_image = wp_get_attachment_image($mfpi_id, 'medium');

    $mfpi_has_thumb_image = ! empty( $mfpi_thumb_image );

    include PLUGIN_PATH . 'partials/view-metabox-basic.php';
}

function get_images_from_media_library($id) {
    $args = array(
        'post_type' => 'attachment',
        'post_mime_type' =>'image',
        'post_status' => 'inherit',
        'posts_per_page' => 5,
        'orderby' => 'rand'
    );
    $query_images = new WP_Query( $args );
    $images = array();
    foreach ( $query_images->posts as $image) {
        $images[]= $image->guid;
    }
    return $query_images;
}

add_action( 'wp_ajax_mfpi_get_thumbnail', 'amad_mfpi_get_thumbnail' );

function amad_mfpi_get_thumbnail() {

	check_ajax_referer( 'mfpi-get-thumbnail', 'security' );

    $id = $_POST['id'];
    
    $response = wp_get_attachment_image($id, 'medium');

    echo $response;
    
	wp_die();
}

// Save post data
function amad_mfpi_save_noticia_destaque( $id ) {
    if ( ! empty( $_POST['mfpi_id'] ) ) {
        add_post_meta( $id, 'mfpi_id', $_POST['mfpi_id'] );
        update_post_meta( $id, 'mfpi_id', $_POST['mfpi_id'] );
    }
}

add_action( 'save_post', 'amad_mfpi_save_noticia_destaque' );