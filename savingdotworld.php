<?php

/*
Plugin Name: Saving.World
Plugin URI:  http://saving.world
Description: Customizations for the saving.world website
Version:     0.5
Author:      Wayne Moses Burke
Author URI:  http://waynemosesburke.com/
License:     ALv2
License URI: https://www.apache.org/licenses/LICENSE-2.0
Domain Path: /savingdotworld
*/

/*defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
*/

// The register_post_type() function is not to be used before the 'init'.
add_action( 'init', 'sdw_activity_init' );

/* Here's how to create your customized labels */
function sdw_activity_init() {
 $labels = array(
   'name' => _x( 'Activities', 'custom post type generic name' ), // Tip: _x('') is used for localization
   'singular_name' => _x( 'Activity', 'individual custom post type name' ),
   'add_new' => _x( 'Add New', 'add' ),
   'add_new_item' => __( 'Add New Activity' ),
   'edit_item' => __( 'Edit Activity' ),
   'new_item' => __( 'New Activity' ),
   'view_item' => __( 'View Activity' ),
   'search_items' => __( 'Search Activities' ),
   'not_found' =>  __( 'No Activity Found' ),
   'not_found_in_trash' => __( 'No Activity Found in trash' ),
   'parent_item_colon' => ''
 );

 // Create an array for the $args
 $args = array( 'labels' => $labels, /* NOTICE: the $labels variable is used here... */
   'public' => true,
   'publicly_queryable' => true,
   'menu_position' => 20,
   'menu_icon' => 'dashicons-yes',
   'supports' => array(
     'title',
     'editor',
     'thumbnail',
     'custom-fields',
     'comments',
     'revisions',
   ),
   'has_archive' => true
 );

 register_post_type( 'sdw_activity', $args ); /* Register it and move on */
}

add_action( 'init', 'sdw_activity_issues_init' );
function sdw_activity_issues_init() {
	register_taxonomy(
		'sdw_activity_issues',
		'sdw_activity',
		array(
			'label' => __( 'Issues' ),
			'rewrite' => array( 'slug' => 'issues' ),
      'update_count_callback' => '_update_post_term_count'
		)
	);
}

add_action( 'init', 'sdw_activity_type_init' );
function sdw_activity_type_init() {
	register_taxonomy(
		'sdw_activity_type',
		'sdw_activity',
		array(
			'label' => __( 'Activity Type' ),
			'rewrite' => array( 'slug' => 'activityType' ),
		)
	);
}

add_action( 'init', 'sdw_venue_type_init' );
function sdw_venue_type_init() {
	register_taxonomy(
		'sdw_venue_type',
		'sdw_activity',
		array(
			'label' => __( 'Venue Type' ),
			'rewrite' => array( 'slug' => 'venueType' ),
		)
	);
}

add_action( 'init', 'sdw_venue_city_init' );
function sdw_venue_city_init() {
	register_taxonomy(
		'sdw_venue_city',
		'sdw_activity',
		array(
			'label' => __( 'Venue City' ),
			'rewrite' => array( 'slug' => 'venueCity' ),
		)
	);
}

function sdw_install() {

    // Trigger our function that registers the custom post type
    sdw_activity_init();

    // Trigger our function that registers the custom taxonomies
    sdw_activity_issues_init();
    sdw_activity_type_init();

    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();

}
register_activation_hook( __FILE__, 'sdw_install' );

function sdw_deactivation() {

    // Our post type will be automatically removed, so no need to unregister it

    // Clear the permalinks to remove our post type's rules
    flush_rewrite_rules();

}
register_deactivation_hook( __FILE__, 'sdw_deactivation' );

?>
