# Articles-Wordpress-Plugin


This is a Wordpress Plugin that allow us to create new Viewers articles 
in the Wordpress panel page and display them in the /viewer page.

Each article allows, as if it were a blog post, to insert a title, 
a text and an image. It will also allow us to assign the categories 
we want.

How to install the Plugin
--------------

1. Download the folder in this link: (https://github.com/joosemi1993/Articles-Wordpress-Plugin/archive/master.zip).
2. Unzip the file you have already downloaded.
3. Copy the folder to the Plugin folder of our Wordpress project (wordpress/wp-content/plugins).
4. Go to your wordpress admin page and go to Plugins section. Now you can see the plugin in the plugins list.
5. Finally you only have to click in the activate link.

How to use the Plugin
--------------

When you activate the plugin you can see that the left Wordpress panel 
shows two new items. These are 'Viewer' and 'Viewer_Admin'. 

In the first one you can see a list of articles we create. To create 
new articles we only have to click in the 'Add new viewer' button we 
have above. Then, as if it were a blog post, we can insert a title, 
text, image and its differents categories.

In the second one, the admin page, we can see a list of viewer categories, 
if we have created before. This list of categories allow us to see in the 
/viewer page only the articles of the category we choose.

The only thing we have to do is to select one category and click the 
button bellow to save our choice.

Structure of the Code
--------------

The main file of the plugin is: josemi-articles-plugin.php It has the same name
as the plugin folder. In this file we create all the functionality of our plugin.

The first thing we have to do create a Plugin is to write this in the main file:

```php
/*
Plugin Name: Josemi Articles Plugin
Plugin URI: https://github.com/joosemi1993/Articles-Wordpress-Plugin
Description: This is a plugin that show us a list of articles with different categories.
Version: 1.0.0
Author: José Miguel Calvo Vílchez
Author URI: https://josemicalvo.com/
License: GPLv2 or later
Text Domain: josemi-articles-plugin
*/

/*
Josemi Articles Plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Josemi Articles Plugin is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Josemi Articles Plugin. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/
```

It code define our Plugin. 

Then we define the activation and deactivation hooks:

```php
function activate() {	
	// flush rewrite rules
	flush_rewrite_rules();
}

function deactivate() {
	// flush rewrite rules
	flush_rewrite_rules();
}

// Activation
register_activation_hook( __FILE__, 'activate' );

// Deactivation
register_deactivation_hook( __FILE__, 'deactivate' );
```

After that we have to create a new Custom Post Type and a new category taxonomy for the viewers articles:

```php
// Creating the Custom Post Type Viewer
function art_plug_custom_post_type()  {
	$labels = [
		'name'                  => 'Viewer',
        'singular_name'         => 'Viewer',
        'add_new'               => 'Add new viewer',
        'add_new_item'          => 'Add new viewer',
        'edit_item'             => 'Edit viewer',
        'view_item'             => 'View viewer',
        'view_items'            => 'View viewers',
        'search_items'          => 'Search viewer',
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in the trush',
        'all_items'             => 'Viewers',
        'insert_into_item'      => 'Insert',
        'uploaded_to_this_post' => 'Uploaded',
        'featured_image'        => 'Viewer Image',
        'set_featured_image'    => 'set viewer image',
        'use_featured_image'    => 'Use as viewer image',
        'remove_featured_image' => 'Remove viewer image',	
	];

	$args = [
        'labels'                => $labels,
        'description'           => 'Articles with different categories',
        'public'                => true,
        'hierarchical'          => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'menu_position'         => 15,
        'menu_icon'             => 'dashicons-feedback',
        'capability_type'       => 'post',
        'supports'              => [
                                        'title',
                                        'editor',
                                        'revisions',
                                        'thumbnail'
                                    ],
        'has_archive'           => true,
        'rewrite' 				=> array( 
								    'slug'          => 'viewer',
								    'with_front'    => true,
								    'hierarchical'	=> true
								),
        ];

	register_post_type( 'viewer', $args );
	flush_rewrite_rules();
}
add_action('init', 'art_plug_custom_post_type');

// Creating Viewer Post Type Categories Taxonomy
function create_viewer_taxonomies() {
    $labels = array(
        'name'              => _x( 'Viewer Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Viewer Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Viewer Categories' ),
        'all_items'         => __( 'All Viewer Categories' ),
        'parent_item'       => __( 'Parent Viewer Category' ),
        'parent_item_colon' => __( 'Parent Viewer Category:' ),
        'edit_item'         => __( 'Edit Viewer Category' ),
        'update_item'       => __( 'Update Viewer Category' ),
        'add_new_item'      => __( 'Add New Viewer Category' ),
        'new_item_name'     => __( 'New Viewer Category Name' ),
        'menu_name'         => __( 'Viewer Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'viewer_categories' ),
    );

    register_taxonomy( 'viewer_categories', array( 'viewer' ), $args );
}
add_action( 'init', 'create_viewer_taxonomies', 0 );
```

Then we enqueue the style and script files with the next code:
```php
// Enqueue Style and Scripts
function art_viewer_scripts() {
	wp_enqueue_style( 'art_style', plugins_url( 'public/assets/art_style.css', __FILE__ ) );
	wp_enqueue_script('art_script', plugins_url( 'public/assets/art_script.js', __FILE__),'','',true);
}
add_action( 'wp_enqueue_scripts', 'art_viewer_scripts' );

function art_viewer_admin_scripts() {
	wp_enqueue_style( 'art_admin_style', plugins_url( 'admin/assets/art_admin_style.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'art_viewer_admin_scripts' );
```
Before that we have created the basic structure of the Plugin folder:
josemi-articles-plugin \n
	+ admin
		+ assets
		+ templates
	+ public
		+ assets
		+ templates
	josemi-articles-plugin.php
	uninstall.php

Then we can create our admin page template and archive viewer page template. 

```php
// Creating admin page
function viewer_admin_page() {
    add_menu_page(
       'Viewer Admin',
       'Viewer_Admin',
       'manage_options',
        plugin_dir_path(__FILE__) . 'admin/templates/admin_page.php',
        null,
    	'dashicons-star-filled'
    );
}
add_action( 'admin_menu', 'viewer_admin_page' );

// Creating archive template for viewer post type
function viewer_archive($template){
    if(is_post_type_archive('viewer')){
        $theme_files = array('archive-viewer.php');
        $exists_in_theme = locate_template($theme_files, false);
        if($exists_in_theme == ''){
            return plugin_dir_path(__FILE__) . 'public/templates/archive-viewer.php';
        }
    }
    return $template;
}
add_filter('archive_template','viewer_archive');
```

First one, in the admin page template we have to create the basic structure of the page, 
with the categories form and the button to save our choice.

```php
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
```
Then the archive viewer page show us all the articles we have been created.
But it only shows us one by one with next and previous button in the bottom 
side to navigate between articles.

```php
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
        'posts_per_page'  =>  -1,
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
```

Finally to use the kewboard functionality to our articles navigation we have insert
that in our public script file:

```java
jQuery(document).keypress(function(e){
    var charCode = e.which;
    if (charCode) {
        var lowerCharStr = String.fromCharCode(charCode).toLowerCase();
        // Detect the keywork
        if (lowerCharStr == "j") {
            // If j redirect to previous viewer
            if( jQuery('.art-nav-previous a').length ) {
			    var a_href = jQuery('.art-navigation').find('.art-nav-previous a').attr('href');
			    window.location.href = a_href;
			}
        } else if (lowerCharStr == "k") {
            // If k redirect to next viewer
            if( jQuery('.art-nav-next a').length ) {
			    var a_href = jQuery('.art-navigation').find('.art-nav-next a').attr('href');
			    window.location.href = a_href;
			}
        }
    }
});
```
