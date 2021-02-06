<?php
if ( ! class_exists( 'cliff_calendar_admin' ) ) {

	class cliff_calendar_admin extends cliff_functions {

		public function __construct() {

			register_deactivation_hook( __FILE__, array( $this, 'remove_post_type') );
			add_action( 'add_meta_boxes', array( $this, 'meta_box'));
			add_action( 'save_post', array( $this, 'event_meta_fields_callback') );
			add_action( 'admin_menu', array( $this, 'add_menus') );

		}

		public function add_menus() {

			add_menu_page( "Cliff Events" , "Cliff Events" , "edit_posts", "cliff-events" , array($this, "admin_page"), "dashicons-calendar-alt");
			add_submenu_page( "cliff-events", "Add Event", "Add Event", "edit_posts", "cliff-events-add", array($this, "add_event") );
			add_submenu_page( "cliff-events", "List Events", "List Events", "read", "cliff-events-list", array($this, "list_events") );

		}

		public function setup_post_type() {

			$args =         array(
	            'labels'      => array(
	                'name'          => __('Cliff Events', 'cliff_event'),
	                'singular_name' => __('Cliff Event', 'cliff_event'),
	                'add_new_item'  => __('Add New Event', 'cliff_event' ),
	            ),
                'public'      => true,
                'has_archive' => true,
		        'menu_icon' => 'dashicons-calendar-alt',
		        'show_ui' => true,
		        'show_in_menu' => false,
		        'map_meta_cap' => true,
		        'capability_type' => 'post',
		        'supports' => array( 'title', 'thumbnail', 'editor' ),
		        'register_meta_box_cb' => array($this, "meta_box")

	        );
		    register_post_type( 'cliff_event', $args );
		}

		public function meta_box() {

			add_meta_box( 'cliff-add-event-meta', esc_html__( 'Event Meta', 'text-domain' ), array($this, 'event_meta_fields'), 'cliff_event', 'advanced', 'high', array($this, 'event_meta_fields_callback') );

		}

		public function event_meta_fields_callback($id) {

			$post = get_post($id);

			if(!$post->post_type == "cliff_event") return false;

		}

		private function get_tz_datalist($name = "cliff_timezone") {

			$default_tz = date_default_timezone_get();

			$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
			$ht = '<datalist id="' . $name . '">';

			foreach ($tzlist as $tz) {
				$ht .= '<option>' . $tz . '</option>';
			}

			$ht .= '</datalist>';
					
			$ht .= '<input class="form-control" name="' . $name . '" autoComplete="on" list="' . $name . '" value="' . $default_tz . '"/>';

			return $ht;
		}

		public function create_admin_panels() {

			$sections = [
				[
					'slug' => 'date',
					'title' => 'Date &amp; Time'
				],
				[
					'slug' => 'repeating',
					'title' => 'Repeating Event'
				],
				[
					'slug' => 'venue',
					'title' => 'Venue'
				],
				[
					'slug' => 'special',
					'title' => 'Special Dates'
				],
				[
					'slug' => 'ticketing',
					'title' => 'Ticketing'
				]
			];

			echo '

			<div class="cliff-calendar-admin-wrapper">

			<div class="d-flex align-items-start">

				<div class="nav flex-column nav-pills me-3 col-md-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">';

				foreach ($sections as $i => $section) {
					$active = ($i == 1) ? " active" : "";
					$selected = ($i ==0) ? "true" : "false";
					echo 	
					'<a class="nav-link' . $active . ' mb-2" id="v-pills-' . $section["slug"] . '-tab" data-bs-toggle="pill" href="#v-pills-' . $section["slug"] . '" role="tab" aria-controls="v-pills-' . $section["slug"] . '" aria-selected="' . $selected . '">' . $section["title"] . '</a>';
				}
				echo '
				</div><!-- /nav-pills -->
				<div class="tab-content col-lg-9 col-xl-6" id="v-pills-tabContent">';
				foreach ($sections as $i => $section) {
					$active = ($i == 1) ? " show active" : "";
					echo '<div class="tab-pane fade' . $active . '" id="v-pills-' . $section["slug"] . '" role="tabpanel" aria-labelledby="v-pills-' . $section["slug"] . '-tab">';
					echo '<h3 class="h4 pills-title">' . $section["title"] . '</h3>';
					include 'panels/admin_' . $section["slug"] . '_panel.php';
					echo '</div><!-- /tab-pane -->';
				}
				echo '
				</div><!-- /tab-content -->

			</div><!-- /d-flex -->

			</div><!-- /cliff-calendar-admin-wrapper -->';

		}

		public function event_meta_fields() {

			$this->create_admin_panels();

		}

	    public function plugin_prefix_unregister_post_type() {

	        unregister_post_type( 'cliff_event' );

	    }

		public function admin_page() {

?>
		<div class="cliff-calendar-admin-wrapper">

			<h1>Cliff Calendar</h1>
			<button type="button" class="btn btn-danger" id="nuke_cliff_calendar">Nuke Cliff Calendar</button>

		</div>
<?php

		}

		public function list_events() {

			$this->go('edit.php?post_type=cliff_event');

		}

		public function add_event() {

			$this->go('post-new.php?post_type=cliff_event');

		}

	}
}

?>