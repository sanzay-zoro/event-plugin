<?php
/**
* This file contains shortcode to display Event CPT
**/

if( ! function_exists('register_event_shortcode')):
	add_shortcode("event", "register_event_shortcode");
	function register_event_shortcode($attr){
		$attr = shortcode_atts(array(
			"type" => "",
			"limit"	=> 5
		), $attr, 'event');
		$type = $attr['type'];
		$limit = $attr['limit'];
		ob_start();
		include EVENT_PLUGIN_DIR_PATH . 'views/event-shortcode-view.php';
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
endif;
