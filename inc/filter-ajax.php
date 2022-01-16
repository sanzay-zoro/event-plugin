<?php
/*==============================================================
	AJAX QUERIES
===============================================*/


add_action('wp_ajax_filter_events', 'filter_events');
add_action('wp_ajax_nopriv_filter_events', 'filter_events');
function filter_events() {
	$terms = $_POST['terms'];
	$tags = $_POST['tags'];
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	if($tags==''){
		$posts = new WP_Query(array( 
			'post_type' => 'event',
			'posts_per_page' => -1,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'event-type',
					'field' => 'slug',
					'terms' => $terms,
				)
			),
		),);		
	} 
	elseif($terms==''){
		$posts = new WP_Query(array( 
			'post_type' => 'event',
			'posts_per_page' => -1,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => $tags,
				)
			),
		),);		
	}
	else{
	$posts = new WP_Query(array( 
		'post_type' => 'event',
		'posts_per_page' => -1,
		'paged' => $paged,
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'event-type',
				'field' => 'slug',
				'terms' => $terms,
			),
			array(
				'taxonomy' => 'post_tag',
				'field' => 'slug',
				'terms' => $tags,
			),
		),
	),); 
	}
?>

<?php
	$result = '';
	if($posts->have_posts()){
		ob_start();
		while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<div class="filtered-content">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				 <h2><?php the_title(); ?> </h2>
				 <?php the_content(); ?>
				</div>
			</div>
		<?php endwhile;
		$result = ob_get_contents();
		ob_end_clean();
		echo $result;
	} 
	else{
		echo "No Events to display";
	}
	exit;
 }	
?>	
