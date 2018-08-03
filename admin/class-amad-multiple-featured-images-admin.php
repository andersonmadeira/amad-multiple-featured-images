<?php

class AMad_Multiple_Featured_Images_Admin extends AMad_Multiple_Featured_Images_Loader {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->define_hooks();

	}

	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/amad-multiple-featured-images.css', array(), $this->version, 'all' );

	}

	public function enqueue_scripts() {

		global $post;

		if ( ! empty($post) ) {
			wp_register_script( 'amad-multiple-featured-images', plugin_dir_url( __FILE__ ) . 'js/amad-multiple-featured-images.js', array( 'jquery' ), '1.0.3', true );

			$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

			$array_data = array(
				'upload_link' => $upload_link,
				'get_thumbnail_nonce' => wp_create_nonce( 'mfi-get-thumbnail' ),
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'select_message' => __('Selecione a imagem'),
				'use_message' => __('Usar essa imagem'),
			);

			wp_localize_script( 'amad-multiple-featured-images', 'amad_mfi', $array_data );
			wp_enqueue_script( 'amad-multiple-featured-images' );
		}

	}

	// Print the html of the metabox
	public function noticia_destaque_html() {
		global $post;

		$mfi_id = get_post_meta( $post->ID, 'mfi_id', true );

		$mfi_thumb_image = wp_get_attachment_image($mfi_id, 'medium');

		$mfi_has_thumb_image = ! empty( $mfi_thumb_image );

		include plugin_dir_path( __FILE__ ) . 'partials/view-metabox-basic.php';
	}

	public function add_custom_meta_boxes() {
		add_meta_box( 
			'amad_mfi_noticia_destaque',
			'Imagem miniatura',
			array($this, 'noticia_destaque_html'),
			'post',
			'side'
		);
	}

	public function get_thumbnail() {

		check_ajax_referer( 'mfi-get-thumbnail', 'security' );
	
		$id = $_POST['id'];
		
		$response = wp_get_attachment_image($id, 'medium');
	
		echo $response;
		
		wp_die();
	}

	// Save post data
	public function save_noticia_destaque( $id ) {
		if ( ! empty( $_POST['mfi_id'] ) ) {
			add_post_meta( $id, 'mfi_id', $_POST['mfi_id'] );
			update_post_meta( $id, 'mfi_id', $_POST['mfi_id'] );
		}
	}

	/**
	 * This will insert actions and filters
	 */
	public function define_hooks() {

		$this->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
		$this->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
		$this->add_action( 'add_meta_boxes', $this, 'add_custom_meta_boxes' );
		$this->add_action( 'wp_ajax_mfi_get_thumbnail', $this, 'get_thumbnail' );
		$this->add_action( 'save_post', $this, 'save_noticia_destaque' );

	}

}
?>