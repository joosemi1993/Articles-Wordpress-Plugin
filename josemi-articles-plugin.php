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