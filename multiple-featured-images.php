<?php

/*
Plugin Name: Multiple Featured Images
Description: Add multiple featured images for your wordpress site
Version: 1.0.0
Author: Anderson Madeira <andersonmadeiracs@gmail.com>
Author URI: https://www.github.io/andersonmadeira
License: MIT License
License URI: http://opensource.org/licenses/MIT
Text Domain: multiple-featured-images
Domain Path: /languages
*/

define('PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// register scripts and styles
function amad_mfi_register_resources() {
	wp_register_style( 'amad-multiple-featured-images', plugin_dir_url( __FILE__ ) . 'assets/css/multiple-featured-images.css', array(), '1.0.0', 'all' );
	wp_register_script( 'amad-multiple-featured-images', plugin_dir_url( __FILE__ ) . 'assets/js/multiple-featured-images.js', array( 'jquery' ), '1.0.2', true );
}

add_action( 'wp_loaded', 'amad_mfi_register_resources' );

function amad_mfi_enqueue_admin_resources() {
    global $post;

    wp_enqueue_style( 'amad-multiple-featured-images' );

    // get data to localize

    // Get WordPress' media upload URL
    $upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

    $array_data = array(
        'featured_image_url' => 'https://picsum.photos/800/300/?image=426',
        'upload_link' => $upload_link,
        'get_thumbnail_nonce' => wp_create_nonce( 'mfi-get-thumbnail' ),
        'ajax_url'   => admin_url( 'admin-ajax.php' ),
        'select_message' => _e('Select your image'),
        'use_message' => _e('Usar essa imagem'),
    );

    wp_localize_script( 'amad-multiple-featured-images', 'amad_mfi', $array_data );
    wp_enqueue_script( 'amad-multiple-featured-images' );
}

add_action( 'admin_enqueue_scripts', 'amad_mfi_enqueue_admin_resources' );

// Add new featured image metabox
function amad_mfi_add_custom_meta_boxes() {
	add_meta_box( 
		'amad_mfi_noticia_destaque',
		'Imagem Destaque',
		'amad_mfi_noticia_destaque_html',
		'post',
		'side'
	);
}

add_action( 'add_meta_boxes', 'amad_mfi_add_custom_meta_boxes' );

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

// Print the html of the metabox
function amad_mfi_noticia_destaque_html() {
    global $post;

    $mfi_id = get_post_meta( $post->ID, 'mfi_id', true );

    $mfi_thumb_image = wp_get_attachment_image($mfi_id, 'medium');

    $mfi_has_thumb_image = ! empty( $mfi_thumb_image );

    include PLUGIN_PATH . 'partials/view-metabox-basic.php';
}

add_action( 'wp_ajax_mfi_get_thumbnail', 'amad_mfi_get_thumbnail' );

function amad_mfi_get_thumbnail() {

	check_ajax_referer( 'mfi-get-thumbnail', 'security' );

    $id = $_POST['id'];
    
    $response = wp_get_attachment_image($id, 'medium');

    echo $response;
    
	wp_die();
}

// Save post data
function amad_mfi_save_noticia_destaque( $id ) {
    if ( ! empty( $_POST['mfi_id'] ) ) {
        add_post_meta( $id, 'mfi_id', $_POST['mfi_id'] );
        update_post_meta( $id, 'mfi_id', $_POST['mfi_id'] );
    }
}

add_action( 'save_post', 'amad_mfi_save_noticia_destaque' );