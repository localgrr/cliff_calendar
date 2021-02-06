<?php
/**
 * @package Cliff Calendar
 * @version 1.0
 */
/*
Plugin Name: Cliff Calendar
Plugin URI: http://cliffweb.eu
Description: A calendar plugin that wont cost me a bunch of money
Author: Caroline Clifford
Version: 1.0
Author URI: http://cliffweb.eu
*/

include "includes/enqueue.php";
include "includes/functions.php";
include "includes/full_calendar.php";
include "includes/add_event.php";
include "includes/calendar_admin.php";

$cliff_full_calendar = new cliff_full_calendar();
$cliff_enqueue = new cliff_enqueue();
$cliff_add_event = new cliff_add_event();
$cliff_calendar_admin = new cliff_calendar_admin();
$cliff_functions = new cliff_functions();

add_action( 'init', array($cliff_calendar_admin, 'setup_post_type') );

function pre_r($code) {

	echo '<pre>';
	print_r($code);
 	echo '</pre>';

}  

?>
