<?php 

/**
 * @package JosemiArticlesPlugin
 */

/**
 *
 * TEMPLATE FOR ADMIN PAGE
 *
 */

?>

<h1>Viewer Admin Panel</h1>

<div class="category-selector">
	<p>Please select a category to display in 'Viewer' page (ONLY ONE!):</p>
<?php
$taxonomy = 'viewer_categories';
$terms = get_terms( $taxonomy ); // Get all terms of a taxonomy
if ( $terms && !is_wp_error( $terms ) ) : ?>
	<?php
    // If form submit store the option category selected
	if( isset( $_REQUEST['art_submit'] ) ) {
       	$category_name = $_POST["category_value"];
       	if ( $category_name == "" ) {
       		update_option( 'art_category_selected', '' );
       	} else {
       		update_option( 'art_category_selected', $category_name );
       	}
    }
    ?>
    <form action="" method="POST">
    	<label><input type="checkbox" name="category_value" value="All">All categories</label>
        <?php foreach ( $terms as $term ) { ?>
        	<?php 
        	$term_name = $term->name;
        	$term_slug = $term->slug;
        	?>
        	<label><input type="checkbox" name="category_value" value="<?php echo $term_slug; ?>"><?php echo $term_name; ?></label>
        <?php } ?>
        <input type="submit" value="Save" name="art_submit">
    </form>
<?php endif;?>
	<?php $category_option_value = get_option( 'art_category_selected' ); ?>
	<p class="category-selected">Now the category selected is: <span><?php echo $category_option_value; ?></span></p>
</div>
