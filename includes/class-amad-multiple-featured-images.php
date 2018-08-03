<?php

class AMad_Multiple_Featured_Images {

	protected $plugin_name;

	protected $version;

	protected $images_data;

	public function __construct() {

		if ( defined( 'AMAD_MFI_VERSION' ) ) {
			$this->version = AMAD_MFI_VERSION;
		} else {
			$this->version = '1.0.5';
		}

		$this->plugin_name = 'amad-multiple-featured-images';

		$this->images_data = array();

		$this->load_dependencies();

	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amad-multiple-featured-images-loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-amad-multiple-featured-images-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-amad-multiple-featured-images-admin.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-amad-multiple-featured-images-public.php';

		$this->i18n = new AMad_Multiple_Featured_Images_i18n();
		$this->admin = new AMad_Multiple_Featured_Images_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->public = new AMad_Multiple_Featured_Images_Public( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Registers a new featured image
	 * @param string Image data array ( slug, display name )
	 */
	public function register_image($data) {
		array_push( $this->images_data, $data );
	}

	public function run() {
		$this->admin->set_images_data( $this->get_images_data() );

		$this->i18n->execute_hooks();
		$this->admin->execute_hooks();
		$this->public->execute_hooks();
	}

	public function get_images_data() {
		return $this->images_data;
	}

	public function get_image_url($post_id, $slug) {
		return $this->admin->get_image_url($post_id, $slug);
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}

}
?>