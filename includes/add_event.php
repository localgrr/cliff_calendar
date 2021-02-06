<?php
if ( ! class_exists( 'cliff_add_event' ) ) {

	class cliff_add_event {

		const REPEAT_TYPE = ["None", "Daily", "Weekly", "Certain Days", "Monthly", "Custom Days", "Yearly"];

		public function __construct() {

			
		}

		static function get_repeat_select() {

			$ht = '<select class="form-control" id="cliff_repeat_type" name="cliff_repeat_type">';

			foreach (static::REPEAT_TYPE as $repeat) {
				
				$ht .= '<option value="' . strtolower(str_replace(" ", "", $repeat)) . '">' . $repeat . '</option>';
			}


			$ht .= '</select>';

			return $ht;
		}

	}
}

?>