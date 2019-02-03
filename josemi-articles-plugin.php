<?php 

/**
 * @package JosemiArticlesPlugin
 */

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