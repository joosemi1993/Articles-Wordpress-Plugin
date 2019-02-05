<?php 

/**
 * @package JosemiArticlesPlugin
**/

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

defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file, you silly human!');

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

// Enqueue Style and Scripts
function art_viewer_scripts() {
	wp_enqueue_style( 'art_style', plugins_url( 'public/assets/art_style.css', __FILE__ ) );
    wp_enqueue_style( 'flick_style', plugins_url( 'public/assets/flickity.css', __FILE__ ) );
	wp_enqueue_script('art_script', plugins_url( 'public/assets/art_script.js', __FILE__),'','',true);
    wp_enqueue_script('flick_script', plugins_url( 'public/assets/flickity.pkgd.min.js', __FILE__),'','',true);
}
add_action( 'wp_enqueue_scripts', 'art_viewer_scripts' );

function art_viewer_admin_scripts() {
	wp_enqueue_style( 'art_admin_style', plugins_url( 'admin/assets/art_admin_style.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'art_viewer_admin_scripts' );

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

// Filter to force only 1 viewer per page
function viewer_posts_per_page( $query ) {
    if ( $query->query_vars['post_type'] == 'viewer' ) $query->query_vars['posts_per_page'] = 1;
    return $query;
}
if ( !is_admin() ) add_filter( 'pre_get_posts', 'viewer_posts_per_page' );













