<?php
/**
* This page is to define the filter
**/
?>
<?php 
	$eventTypes = get_terms(array( 'taxonomy' => 'event-type'));
 ?>
<!-- displying categories name -->
<ul class="event-filter">
	<h2>Event Types</h2>

  <?php foreach($eventTypes as $eventType) : ?>
    <li>
      <input type="checkbox" name="eventType" value = "<?php echo $eventType->slug; ?>">
      <label for="<?php echo $eventType->slug; ?>"><?php echo $eventType->name; ?></label>
    </li>
  <?php endforeach; ?>
  <h2>Tags</h2>
    <li>
      <input type="checkbox" name="eventTag" value = "wordpress">
      <label for="wordpress">WordPress</label>
    </li>
    <li>
      <input type="checkbox" name="eventTag" value = "react">
      <label for="react">React</label>
    </li>
    <li>
      <input type="checkbox" name="eventTag" value = "web">
      <label for="web">Web</label>
    </li>
    <li>
      <input type="checkbox" name="eventTag" value = "web-designer">
      <label for="web-designer">Web Designer</label>
    </li>
</ul>

<?php 
    $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
    $posts = new WP_Query(array( 
        'post_type' => 'event',
        'taxonomy' => 'event-type',
        'term' => $type,
        'posts_per_page' => $limit,
        'paged' => $paged
    )); 
?>
<h1>Events</h1>
<?php
	if($posts->have_posts()): ?>
		<div class="filtered-content">
			<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					    <h2><?php the_title(); ?></h2>
              <?php the_content(); ?>
				</div>
			<?php endwhile;?>
		</div>
		<?php		
	endif; 
wp_reset_postdata(); 
previous_posts_link( 'Newer Posts' );
next_posts_link( 'Older Posts', $posts->max_num_pages );



