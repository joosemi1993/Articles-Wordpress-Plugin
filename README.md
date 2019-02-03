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
