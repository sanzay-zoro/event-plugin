<?php
/**
* This page is to define the REST API end points for event CPT
*/

add_action('rest_api_init', 'event_api');
function event_api(){
	register_rest_route('api/v1', 'events', [
		'methods' => 'GET',
		'callback'=> 'api_events',
	]);
}

function api_events(){
	$args = array(
		//'numberposts' =>10,
		'post_type' => 'event',
		//'paged' => ($_REQUEST['paged'] ? $_REQUEST['paged'] : 1)
	);
 	$posts = get_posts($args);
 	$data = array();
 	$i = 0;

 	foreach($posts as $post){
 		$data[$i]['id'] = $post->ID; 
 		$data[$i]['title'] = $post->post_title; 
 		$data[$i]['slug'] = $post->post_name; 
 		$data[$i]['location'] = get_post_meta($post->ID, 'event_location',true);
 		$data[$i]['content'] = $post->post_content;
 		$data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail($post->ID, 'thumbnail');
 		$data[$i]['featured_image']['medium'] = get_the_post_thumbnail($post->ID, 'medium');
 		$data[$i]['featured_image']['large'] = get_the_post_thumbnail($post->ID, 'large');
 		$i++; 
 	}

 	return $data;
}