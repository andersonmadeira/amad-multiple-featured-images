<?php

class AMad_Multiple_Featured_Images {

	protected $plugin_name;

	protected $version;

	public function __construct() {

		if ( defined( 'AMAD_MFI_VERSION' ) ) {
			$this->version = AMAD_MFI_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'amad-multiple-featured-images';

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

	public function run() {
		$this->i18n->execute_hooks();
		$this->admin->execute_hooks();
		$this->public->execute_hooks();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}

}
?>