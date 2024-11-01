<?php

add_action('admin_menu', 'wpms_menu');
function wpms_menu() {
        $wpmsopts = add_menu_page( 
			__('WP Matterport Shortcode','wp-matterport'),  // Page Title
			__('WP Matterport Shortcode','wp-matterport'),  // Menu Title
			'manage_options', // Capability
			'wpms-options',  // Menu Slug
			'wpms_options',  // Callable
			plugins_url('wpms-icon.png', __FILE__) // Icon URL
		);
        add_action( "admin_print_styles-wpms-options", 'wp_matterport_scripts' );
        add_action( "load-" . $wpmsopts, 'wpms_screen_options');
}
function wpms_options() {

	global $wpdb;

	if ( !current_user_can( 'manage_options' ) || !is_user_logged_in() )  {
                wp_die( esc_html(__( 'You do not have sufficient permissions to access this page.' )) );
	}
	if (isset($_GET["refresh"])) {
		$nonce_check = check_admin_referer( 'MP_refresh_'.$_GET["refresh"]);
		
		// Get Space's data
		$results = $wpdb->get_results(
			$wpdb->prepare("
					SELECT data 
					FROM {$wpdb->prefix}wpms 
					WHERE name=%s 
					ORDER BY `time` LIMIT 9999
				", [ $_GET["refresh"] ]
			)
		);
	//	echo "<pre>".json_encode($results, JSON_PRETTY_PRINT)."</pre>";
		
		if (!is_null($results)){
		$thisTour = json_decode($results[0]->data, TRUE);
			if (count($thisTour) > 0) {
				echo '<div class="notice notice-success is-dismissible"><p>Updated cached data for: ' . esc_html($thisTour['name']) . '</p></div>';
				$wpdb->delete( $wpdb->prefix . "wpms", array( 'name' => $_GET["refresh"])); // Custom Table wp_wpms
			}
		}
	}
	if (isset($_GET["clear"])) {
		$nonce_check = check_admin_referer('MP_clear_db');
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(__('Cleared all cached tours.')) . '</p></div>';
		$wpdb->query('DELETE FROM ' . $wpdb->prefix . 'wpms'); // Custom Table wp_wpms
	}

    echo '<div class="wrap">';
    echo '<h1>' . esc_html(__('WP Matterport Shortcode','wp-matterport')) . '</h1>';
	
	// Get Space's data
	$results = $wpdb->get_results(
		$wpdb->prepare("
				SELECT * 
				FROM {$wpdb->prefix}wpms 
				WHERE name<>%s
				ORDER BY `time` LIMIT 9999
			", [ "" ]
		)
	);
//	echo "<pre>".json_encode($results, JSON_PRETTY_PRINT)."</pre>";
	
	if (count($results) > 0) {
		foreach($results as $key => $values)
			$keys[] = $values->name;
			/* translators: %s: number of showcases */
		echo '<p><b>' . sprintf( esc_html(__('Showing: %s 3D Showcases','wp-matterport')), count($keys)) . '</b>.</p>';
	}
	echo '<p>' . esc_html(__('To instantly update your information, click "reload".  Need to edit?  Click "MyMatterport".','wp-matterport')) . '</p>';
	$nonce = wp_create_nonce( 'MP_clear_db', 'clean_nonce');
	echo '<p><a href="' . esc_url($_SERVER["PHP_SELF"]) . '?page=wpms-options&amp;clear=all&amp;_wpnonce='.esc_html($nonce).'">' . esc_html(__('Clear all Matterport Tours from Cache')) . '</a></p>';
	
	$user = get_current_user_id();
	$screen = get_current_screen();
	$option = $screen->get_option('per_page', 'option');
 	$per_page = get_user_meta($user, $option, true);
 	if ( empty ( $per_page) || $per_page < 1) {
 		$per_page = 2;
 	}
 	elseif ($per_page > 4) {
 		$per_page = 4;
 	}
 	
	if (isset($_GET["refresh"]))
		echo do_shortcode('[matterport admin="true" cols="1" showdate="true" address="true" src="' . urldecode($_GET["refresh"]) . '" showstats="1"]');
	if (isset($keys) && count($keys) > 0) {
		echo do_shortcode('[matterport admin="true" cols="' . $per_page . '" showdate="true" address="true" src="' . implode(',',$keys) . '" showstats="1"]');
	}
    echo '</div>';
}

function wpms_screen_options() {
	$args = array(
		'label' => __('# of Columns (Max 4)', 'wpms'),
		'default' => 2,
		'max' => 4,
		'option' => 'wpms_admin_cols'
	);
	add_screen_option( 'per_page', $args );
}
function wpms_set_screen_option($status, $option, $value) {
	if ( 'wpms_admin_cols' == $option ) return $value;
	return $status;
}
add_filter('set-screen-option', 'wpms_set_screen_option', 10, 3);
