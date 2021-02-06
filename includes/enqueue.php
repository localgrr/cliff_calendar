<?php
if ( ! class_exists( 'cliff_enqueue' ) ) {

	class cliff_enqueue {

		const CLIFF_JS_URL = '../js/cliff_custom.js';

		public function __construct() {

			add_action('wp_enqueue_scripts', array( $this, 'cliff_scripts' ));
			add_action('admin_head', array($this, 'cliff_admin_scripts'));

		}

		public function cliff_scripts() {

			wp_deregister_style('bootstrap');
			wp_enqueue_style('cliff_css', plugin_dir_url( __FILE__ ) . '../css/cliff_calendar_frontend.css');

			wp_deregister_script('jquery');
			wp_enqueue_script( 'jquery', static::JQUERY_URL, array(), null, true);

			wp_enqueue_script( 'cliff-script', plugin_dir_url( __FILE__ )  . static::CLIFF_JS_URL, array( 'jquery'), null, true);

		}

		public function cliff_admin_scripts() {

			wp_deregister_style('bootstrap');
			wp_enqueue_style('cliff_css', plugin_dir_url( __FILE__ ) . '../css/cliff_calendar_backend.css');

			wp_enqueue_script('bootstrap', plugin_dir_url( __FILE__ ) . '../src/bootstrap5/js/bootstrap.min.js', array(), null, true);

			wp_enqueue_script( 'cliff-scripts-cquery', plugin_dir_url( __FILE__ )  . '../js/includes/cliff_q.js', array(), null, true);
			wp_enqueue_script( 'cliff-scripts-datefn', plugin_dir_url( __FILE__ )  . '../js/includes/cliff_date_fn.js', array(), null, true);
			wp_enqueue_script( 'cliff-scripts-formfn', plugin_dir_url( __FILE__ )  . '../js/includes/cliff_form_fn.js', array(), null, true);
			wp_enqueue_script( 'cliff-scripts-repeating', plugin_dir_url( __FILE__ )  . '../js/includes/cliff_repeating.js', array(), null, true);
			wp_enqueue_script( 'cliff-scripts-event', plugin_dir_url( __FILE__ )  . '../js/includes/cliff_event.js', array(), null, true);
			wp_enqueue_script( 'cliff-scripts-module', plugin_dir_url( __FILE__ )  . '../js/cliff_custom_admin.js', array(), null, true);

		}

	}

}

?>