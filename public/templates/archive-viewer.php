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
global $wp_query, $wpdb;

$category_option_value = get_option('art_category_selected');

if (($category_option_value == '') || ($category_option_value == 'All')) {
    $args = [
        'post_type'         => 'viewer',
        'posts_per_page'    => -1,
        'order'             => 'DES',
        'orderby'           => 'date'
    ];
} else {
    $args = [
        'post_type'       => 'viewer',
        'posts_per_page'  =>  -1,
        'order'           => 'DES',
        'orderby'         => 'date',
        'tax_query'       => array(
            array (
                'taxonomy' => 'viewer_categories',
                'field' => 'slug',
                'terms' => $category_option_value,
            )
        )
    ];
}

?>
<div class="art-container">
    <div class="art-container-inside">
        <div class="gallery js-flickity">
        <?php
        $query = new WP_Query( $args );
        if( $query->have_posts() ) :
            while( $query->have_posts() ) : $query->the_post() ?>
                <?php
                $post = get_post();
                $post_title = get_the_title();
                $post_content = get_the_content();
                $post_image_url = get_the_post_thumbnail_url();
                $post_date = get_the_date(); 
                ?>
                <div class="gallery-cell">
                    <!--<div class="image-back" style="background-image: url(<?php echo $post_image_url; ?>); width: 100%; height: 600px; background-size: cover; background-position: 50%;"></div>-->
                    <div class="art-image" style="background-image: url(<?php echo $post_image_url; ?>)"></div>
                    <div class="art-content">
                        <div class="art-title"><h2><?php echo $post_title; ?></h2></div>
                        <div class="art-date"><span><?php echo $post_date; ?></span></div>
                        <div class="art-content-block"><p><?php echo $post_content; ?></p></div>
                    </div>
                </div>
            <?php   
            endwhile;
        endif; ?>
        </div>
    </div>
</div>
<?php 
get_footer();
