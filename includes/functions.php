<?php
if ( ! class_exists( 'cliff_functions' ) ) {

	class cliff_functions {

		public function __construct() {

			global $cliff_full_calendar;

			add_shortcode( 'cliff_calendar', array( $cliff_full_calendar, 'print_full_calendar' ) ); 

		}

		public function go($url) {

			echo '
			<script type="text/javascript">
			window.location.href="'.$url.'"
			</script>';

		}

	}

}
?>