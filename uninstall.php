<?php

/**
 * Trigger this file on Plugin uninstall
 *
 * @package  AlecadddPlugin
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// Clear Database stored data
$viewers = get_posts( array( 'post_type' => 'viewer', 'numberposts' => -1 ) );

foreach( $viewers as $viewer ) {
	wp_delete_post( $viewer->ID, true );
}
