
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
    if($posts->have_posts()):
        while ( $posts->have_posts() ) : $posts->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><?php the_title(); ?></h2>
                <p> location: <?php echo get_post_meta(get_the_ID(), 'event_location', true); ?></p>
            </div>
        <?php endwhile;
    endif; 
wp_reset_postdata(); 
previous_posts_link( 'Newer Posts' );
next_posts_link( 'Older Posts', $posts->max_num_pages );
?>