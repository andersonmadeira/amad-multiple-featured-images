<?php

class AMad_Multiple_Featured_Images_Public extends AMad_Multiple_Featured_Images_Loader {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/amad-multiple-featured-images.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/amad-multiple-featured-images.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * This will insert actions and filters
	 */
	public function define_hooks() {

		$this->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );

	}

}
?>