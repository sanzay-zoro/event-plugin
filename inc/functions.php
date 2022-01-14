<?php

/*====================================
Adding Plugin Menu in Admin Dashboard
======================================*/

if(!function_exists('event_plugin_top_menu')):
	add_action('admin_menu', 'event_plugin_top_menu');
	function event_plugin_top_menu(){
		add_menu_page(
			'Event Plugin',
			'Event Plugin',
			'manage_options',
			'event-plugin',
			'event_plugin_page',
			'dashicons-tickets-alt'
		);
	}
	function event_plugin_page(){
		?>
		<h1>Event Plugin</h1>
		<?php
	}
endif;

/*================================================
Adding "event" post type if not registered already
==================================================*/

if(!post_type_exists( 'event' )):
	if(!function_exists('event_plugin_event_cpt')):
		function event_plugin_event_cpt(){
			 $labels = array(
	        'name'                  => _x( 'Events', 'Post type general name', 'event-plugin' ),
	        'singular_name'         => _x( 'Event', 'Post type singular name', 'event-plugin' ),
	        'menu_name'             => _x( 'Events', 'Admin Menu text', 'event-plugin' ),
	        'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'event-plugin' ),
	        'add_new'               => __( 'Add New', 'event-plugin' ),
	        'add_new_item'          => __( 'Add New Event', 'event-plugin' ),
	        'new_item'              => __( 'New Event', 'event-plugin' ),
	        'edit_item'             => __( 'Edit Event', 'event-plugin' ),
	        'view_item'             => __( 'View Event', 'event-plugin' ),
	        'all_items'             => __( 'All Events', 'event-plugin' ),
	        'search_items'          => __( 'Search Events', 'event-plugin' ),
	        'parent_item_colon'     => __( 'Parent Events:', 'event-plugin' ),
	        'not_found'             => __( 'No Events found.', 'event-plugin' ),
	        'not_found_in_trash'    => __( 'No Events found in Trash.', 'event-plugin' ),
	        'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'event-plugin' ),
	        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'event-plugin' ),
	        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'event-plugin' ),
	    );
	 
	    $args = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'event' ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => null,
	        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	        'taxonomies'		=> array('post_tag'),
	    );
	 
	    register_post_type( 'event', $args );
	}
	 
	add_action( 'init', 'event_plugin_event_cpt' );
	endif;
endif;			

/*=======================================
 Add New Metabox or Custom Fields
========================================*/

if(!function_exists('event_register_metabox')):
	add_action('add_meta_boxes', 'event_register_metabox');
	function event_register_metabox(){
		add_meta_box(
			'event-metabox-1',
			__('Event Information', 'event-plugin'),
			'event_metabox_items',
			'event',
			'side',
			'low',

		);
	}
	function event_metabox_items($post){
		wp_nonce_field( basename(__FILE__), 'event_nonce');
		$event_location_value = get_post_meta($post->ID, 'event_location', true);
		?>
		<div>
			<label for="event_location">Event Location</label>
			<input type="text" name="event_location" id="event_location" value="<?php echo $event_location_value; ?>">
		</div>
		<?php
	}

	/*---------save metabox data in db---------------*/
	add_action("save_post", "save_event_metabox", 10, 2);
	function save_event_metabox($post_id, $post){
		if( !isset($_POST['event_nonce']) || !wp_verify_nonce($_POST['event_nonce'], basename(__FILE__))){
			return $post_id;
		}

		$post_slug = "event";
		if($post_slug != $post->post_type){
			return;
		}

		$event_location = '';
		if( isset($_POST['event_location']) ){
			$event_location = sanitize_text_field($_POST['event_location']);
		}else{
			$event_location = '';
		}

		update_post_meta($post_id, 'event_location', $event_location);

	}
endif; 

/*==================================
 Registering Event Type Taxonomy
 ==================================*/
if(! function_exists('register_event_type_taxonomy')):
	add_action('init', 'register_event_type_taxonomy');
	function register_event_type_taxonomy() {
 
    $labels = array(
        'name'              => _x( 'Event Types', 'taxonomy general name', 'event-plugin' ),
        'singular_name'     => _x( 'Event Types', 'taxonomy singular name', 'event-plugin' ),
        'search_items'      => __( 'Search Event Types', 'event-plugin' ),
        'all_items'         => __( 'All Event Types', 'event-plugin' ),
        'view_item'         => __( 'View Event Types', 'event-plugin' ),
        'parent_item'       => __( 'Parent Event Types', 'event-plugin' ),
        'parent_item_colon' => __( 'Parent Event Types:', 'event-plugin' ),
        'edit_item'         => __( 'Edit Event Types', 'event-plugin' ),
        'update_item'       => __( 'Update Event Types', 'event-plugin' ),
        'add_new_item'      => __( 'Add New Event Types', 'event-plugin' ),
        'new_item_name'     => __( 'New Event Types Name', 'event-plugin' ),
        'not_found'         => __( 'No Event Types Found', 'event-plugin' ),
        'back_to_items'     => __( 'Back to Event Types', 'event-plugin' ),
        'menu_name'         => __( 'Event Types', 'event-plugin' ),
    );
 
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'event-types' ),
        'show_in_rest'      => true,
    );
 
 
    register_taxonomy( 'event-type', 'event', $args );
 
}
endif;