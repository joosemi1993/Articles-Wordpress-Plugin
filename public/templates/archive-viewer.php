<?php 

/**
 * @package JosemiArticlesPlugin
**/

/*
 *
 * TEMPLATE FOR ALL VIEWERS
 *
 */

get_header(); 
global $wp_query, $wpdb, $paged;

$category_option_value = get_option('art_category_selected');

// If no category saved in admin panel we display all viewer post else only the viewers of the category selected
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
if (($category_option_value == '') || ($category_option_value == 'All')) {
    $args = [
        'post_type'         => 'viewer',
        'posts_per_page'    => 1,
        'order'             => 'DES',
        'orderby'           => 'date',
        'paged'             => $paged
    ];
} else {
    $args = [
        'post_type'       => 'viewer',
        'posts_per_page'  =>  1,
        'order'           => 'DES',
        'orderby'         => 'date',
        'paged'             => $paged,
        'tax_query'       => array(
            array (
                'taxonomy' => 'viewer_categories',
                'field' => 'slug',
                'terms' => $category_option_value,
            )
        )
    ];
}

$query = new WP_Query( $args );
// Creating the basic template
?>
<div class="art-container">
	<div class="art-row">
		<?php
        if( $query->have_posts() ) :
            while( $query->have_posts() ) : $query->the_post(); ?>
                <?php
                $post = get_post();
                $post_title = get_the_title();
                $post_content = get_the_content();
                $post_image_url = get_the_post_thumbnail_url();
                $post_date = get_the_date(); ?>
           		<div class="art-slides fade">
           			<div class="art-image" style="background-image: url(<?php echo $post_image_url; ?>)"></div>
                    <div class="art-content">
               			<div class="art-title"><h2><?php echo $post_title; ?></h2></div>
               			<div class="art-date"><span><?php echo $post_date; ?></span></div>
               			<div class="art-content-block"><p><?php echo $post_content; ?></p></div>
                    </div>
           		</div>
           	<?php	
                
            endwhile;?>
            <div class="art-navigation">
                <p class="art-nav-buttons art-nav-previous"><?php echo get_previous_posts_link( '< Previous' ); ?></p>
                <p class="art-nav-buttons art-nav-next"><?php echo get_next_posts_link( 'Next >', $query->max_num_pages ); ?></p>
            </div>
        <?php wp_reset_postdata();
        endif; ?>
	</div>
</div>

<?php 
get_footer();
