
<style>
.full-calendar {
	table-layout: fixed;
}

.full-calendar .today {
	background-color: cyan;
}

.full-calendar .grid-filler {
	opacity: 0.5;
}
</style>
<?php

$date = new DateTime(); //Todays date but can be anything
echo print_calendar_month_html($date);

function print_calendar_month_html($date) {

	
	return '
	<h1>' . $date->format("F") . ' ' . $date->format("Y") . '</h1>
	<table class="full-calendar">'
	. get_calendar_thead_html() .
	'<tbody>'
	. get_calendar_days_in_month_html($date) .
	'</tbody></table>';

}

function get_calendar_thead_html() {

    $ht = '<thead><tr>';

    $timestamp = strtotime('next Monday');

    for ($i = 0; $i < 7; $i++) {

        //FIXME: this automatically uses local language, might want to override some time
        $ht .= '<th>' . strftime('%a', $timestamp) . '</th>';

        $timestamp = strtotime('+1 day', $timestamp);

    }

    $ht .= '</tr></thead>';

    return $ht;
}

/**
 * Return part of an HTML table containing all the days 
 * in the current month, plus padd it with next and 
 * previous months days if needed to fill out the grid
 *
 *
 * @param date $date date object containing month to display
 * 
 * @return string
 */
function get_calendar_days_in_month_html($date) {

    $date_format = "Y-m-d"; 
    
    $days_count = $date->format('t'); //Get number of days in this month
    
    $weeks_count = ceil($days_count / 7); //How many weeks in this month?

    $total_cells = $weeks_count * 7; 
    
    //clone is used or we literally are modifying the $date variable
    $first_date_of_month = clone $date->modify('first day of this month');

    $first_day_of_month = $first_date_of_month->format("N"); //returns 1-7 EG Mon-Fri

    $first_date_of_grid = $first_date_of_month ->modify('-' . $first_day_of_month . ' days');

    $todays_date = new DateTime();

    $todays_date_str = $todays_date->format($date_format);

    $selected_date_str = $date->format($date_format);

    $day_of_week = 1; //FIXME: allow starting with Sunday or whatever

    $ht = '<tr>';

    for ($cell=1; $cell <= $total_cells ; $cell++) { 

        $classes = []; //CSS classes

        $current_date = $first_date_of_grid->modify("+1 day");

        $current_date_str = $current_date->format($date_format);

        if($current_date_str == $todays_date_str) $classes[] = "today";

        if($selected_date_str == $todays_date_str) $classes[] = "selected-date";

        /* if current date is not from this month (EG previous or next month) then give 
        it a special class, you might want to grey it out or whatever */
        if($date->format("m") !== $current_date->format("m")) $classes[] = "grid-filler";

        $ht .= '
        <td date="' . $current_date_str . '" class="' . implode(" ", $classes) . '">' . $current_date->format("j") . '</td>';

        $day_of_week ++;

        if($day_of_week == 8) {

            $ht .= '</tr>';
            if($cell < $total_cells) $ht .= '<tr>';
            $day_of_week = 1;

        }

    }

    return $ht;
}

?>