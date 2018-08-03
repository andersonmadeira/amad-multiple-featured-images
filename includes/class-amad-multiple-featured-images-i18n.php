<?php

class AMad_Multiple_Featured_Images_i18n extends AMad_Multiple_Featured_Images_Loader {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'amad-multiple-featured-images',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	// Override
	public function define_hooks() {

	}

}
?>