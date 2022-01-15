<?php
/*==============================================================
	AJAX QUERIES
===============================================*/


add_action('wp_ajax_filter_events', 'filter_events');
add_action('wp_ajax_nopriv_filter_events', 'filter_events');
function filter_events() {
	$terms = $_POST['terms'];
	$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
	$posts = new WP_Query(array( 
		'post_type' => 'event',
		'posts_per_page' => -1,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'event-type',
				'field' => 'slug',
				'terms' => $terms,
			),
		),
	),
); 
?>

<?php
	$result = '';
	if($posts->have_posts()):
		while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<div class="filtered-content">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				 <?php $result .= the_title(); ?>
				</div>
			</div>
		<?php endwhile;
	endif; 
	echo $result;
	exit;
 }	
?>	
