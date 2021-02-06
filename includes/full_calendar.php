<?php
if ( ! class_exists( 'cliff_full_calendar' ) ) {

	class cliff_full_calendar {

		//FIXME: override needed
		const TIMEZONE = 'Europe/Berlin';

		const DATE_FORMAT = 'Y-m-d';

		const WRAPPER_ID = 'cliff-full-calendar';

		public function __construct() {

			date_default_timezone_set(static::TIMEZONE);

		}

		private function get_timestamp_from_qs() {

			$date = new DateTime();

			$ts = isset($_GET["timestamp"]) ? $_GET["timestamp"] : null;

			if($ts) if($this->is_valid_timestamp($ts)) $date->setTimestamp($ts);

			return $date;
			
		}

		private function is_valid_timestamp($timestamp) {

		    return ((string) (int) $timestamp === $timestamp) 
		        && ($timestamp <= PHP_INT_MAX)
		        && ($timestamp >= ~PHP_INT_MAX);

		}

		private function get_calendar_navigation_html($date) {

			$first_day_of_month = strtotime($date->format("01-m-Y"));

			$last_month_timestamp = strtotime("last month", $first_day_of_month);
			$next_month_timestamp = strtotime("next month", $first_day_of_month);

			return '
			<div class="full-calendar-navigation">
			<a class="last-month" href="?timestamp=' . $last_month_timestamp . '&select=false#' . static::WRAPPER_ID . '"> &lt;&lt; ' . date("F", $last_month_timestamp) . '</a>
			<input type="date" id="full_calendar_datepicker" placeholder="dd/mm/yyyy" onchange="datepicker_change(event)">
			<a href="?timestamp=' . strtotime("today") . '#' . static::WRAPPER_ID . '">Today</a>
			<a class="next-month" href="?timestamp=' . $next_month_timestamp . '&select=false#' . static::WRAPPER_ID . '">' . date("F", $next_month_timestamp) . ' &gt;&gt; </a>
			</div>';


		}

		private function get_calendar_title_html($date) {

			return '<h1 class="calendar-heading">' . $date->format('F') . ' ' . $date->format('Y') . '</h1>';

		}

		private function get_calendar_header_html($date) {

			$ht = $this->get_calendar_title_html($date);

			$ht .= $this->get_calendar_navigation_html($date);

			return $ht;
		}

		private function get_calendar_thead_html() {

			$ht = '<thead><tr>';

			$timestamp = strtotime('next Monday');

			for ($i = 0; $i < 7; $i++) {

				//FIXME: this automatically uses local language, might want to override some time
				$ht .= '<th>
				<span class="full">' . strftime('%A', $timestamp) . '</span>
				<span class="short">' . strftime('%a', $timestamp) . '</span></th>';

			    $timestamp = strtotime('+1 day', $timestamp);

			}

			$ht .= '</tr></thead>';

			return $ht;
		}

		private function can_highlight_selected_day() {

			$select = (isset($_GET["select"])) ? $_GET["select"] : null;
			return($select == "false") ? false : true;

		}

		private function get_calendar_days_in_month_html($date) {

			//Get number of days in this month
			$days_count = $date->format('t');

			$weeks_count = ceil($days_count / 7);

			$total_cells = $weeks_count * 7;

			$first_date_of_month = clone $date->modify('first day of this month');

			$first_day_of_month = $first_date_of_month->format("N"); //returns 1-7 EG Mon-Fri

			$first_date_of_grid = $first_date_of_month ->modify('-' . $first_day_of_month . ' days');

			$selected_date = $this->get_timestamp_from_qs();

			$selected_date_str = $selected_date->format(static::DATE_FORMAT);

			$todays_date = new DateTime();

			$todays_date_str = $todays_date->format(static::DATE_FORMAT);

			$day_of_week = 1; //FIXME: allow starting with Sunday

			$ht = '<tr>';

			for ($cell=1; $cell <= $total_cells ; $cell++) { 

				$classes = [];
				
				$current_date = $first_date_of_grid->modify("+1 day");

				$current_date_str = $current_date->format(static::DATE_FORMAT);

				if($current_date_str == $todays_date_str) $classes[] = "today";

				if(($current_date_str == $selected_date_str) && ($this->can_highlight_selected_day())) $classes[] = "selected-date";

				//ruh-oh date is not from this month
				if($date->format("m") !== $current_date->format("m")) $classes[] = "grid-filler";

				$ht .= '
				<td date="' . $current_date_str . '" class="' . implode(" ", $classes) . '">
				<a href="?timestamp=' . $current_date->getTimestamp(). '#' . static::WRAPPER_ID . '">' . $current_date->format("j") . '</a></td>';

				$day_of_week ++;

				if($day_of_week == 8) {

					$ht .= '</tr>';

					if($cell < $total_cells) $ht .= '<tr>';

					$day_of_week = 1;

				}

			}

			
			return $ht;
		}

		public function print_full_calendar() {

			$date = $this->get_timestamp_from_qs();

			$ht = '
			<div class="full-calendar" id="' . static::WRAPPER_ID . '">'

			. $this->get_calendar_header_html($date)

			. '<table class="full">'

			. $this->get_calendar_thead_html()

			. '<tbody>'

			. $this->get_calendar_days_in_month_html($date);

			$ht .= '</tbody></table></div>';

			return $ht;

		}

	}

}

?>