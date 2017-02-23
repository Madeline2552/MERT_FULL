<?php
/*-----------------------------------------------------------------------------------*/
/* Start WooThemes Functions - Please refrain from editing this section */
/*-----------------------------------------------------------------------------------*/

// Set path to WooFramework and theme specific functions
$functions_path = TEMPLATEPATH . '/functions/';
$includes_path = TEMPLATEPATH . '/includes/';

// Don't load alt stylesheet from WooFramework
if (!function_exists( 'woo_output_alt_stylesheet')) {
	function woo_output_alt_stylesheet() {}
}

// Define the theme-specific key to be sent to PressTrends.
define( 'WOO_PRESSTRENDS_THEMEKEY', 'tnla49pj66y028vef95h2oqhkir0tf3jr' );

// WooFramework
require_once ( $functions_path . 'admin-init.php' );			// Framework Init

if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {
	//Enable Tumblog Functionality and theme is upgraded
	update_option( 'woo_needs_tumblog_upgrade', 'false' );
	update_option( 'tumblog_woo_tumblog_upgraded', 'true' );
	update_option( 'tumblog_woo_tumblog_upgraded_posts_done', 'true' );
	require_once ( $functions_path . 'admin-tumblog-quickpress.php' );	// Tumblog Dashboard Functionality
}

/*-----------------------------------------------------------------------------------*/
/* Load the theme-specific files, with support for overriding via a child theme.
/*-----------------------------------------------------------------------------------*/

$includes = array(
				'includes/theme-options.php', 			// Options panel settings and custom settings
				'includes/theme-functions.php', 		// Custom theme functions
				'includes/theme-actions.php', 			// Theme actions & user defined hooks
				'includes/theme-comments.php', 			// Custom comments/pingback loop
				'includes/theme-js.php', 				// Load JavaScript via wp_enqueue_script
				'includes/sidebar-init.php', 			// Initialize widgetized areas
				'includes/theme-widgets.php'			// Theme widgets
				);

// Theme-Specific
$includes[] = 'includes/theme-advanced.php';			// Advanced Theme Functions
$includes[] = 'includes/theme-shortcodes.php';	 		// Custom theme shortcodes
// Modules
$includes[] = 'includes/woo-layout/woo-layout.php';
$includes[] = 'includes/woo-meta/woo-meta.php';
$includes[] = 'includes/woo-hooks/woo-hooks.php';

// Allow child themes/plugins to add widgets to be loaded.
$includes = apply_filters( 'woo_includes', $includes );
			
foreach ( $includes as $i ) {
	locate_template( $i, true );
}

// Load WooCommerce functions, if applicable.
if ( is_woocommerce_activated() ) {
	locate_template( 'includes/theme-woocommerce.php', true );
}

if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' ) {

	define( 'WOOTUMBLOG_ACTIVE', true ); // Define a constant for use in our theme's templating engine.

	require_once ( $includes_path . 'tumblog/theme-tumblog.php' );		// Tumblog Output Functions
	// Test for Post Formats
	if ( get_option( 'woo_tumblog_content_method' ) == 'post_format' ) {
		// Tumblog Post Format Class
		require_once( $includes_path . 'tumblog/wootumblog_postformat.class.php' );
	} else {
		// Tumblog Custom Taxonomy Class
		require_once ($includes_path . 'tumblog/theme-custom-post-types.php' );	// Custom Post Types and Taxonomies
	}
	
	// Test for Post Formats
	if ( get_option( 'woo_tumblog_content_method' ) == 'post_format' ) {
	    //Tumblog Post Formats
	    global $woo_tumblog_post_format; 
	    $woo_tumblog_post_format = new WooTumblogPostFormat(); 
	    if ( $woo_tumblog_post_format->woo_tumblog_upgrade_existing_taxonomy_posts_to_post_formats()) {
	    	update_option( 'woo_tumblog_post_formats_upgraded', 'true' );
	    }
	    
	}
}

// Output stylesheet and custom.css after Canvas custom styling
remove_action( 'wp_head', 'woothemes_wp_head' );
add_action( 'woo_head', 'woothemes_wp_head' );
if ( get_option( 'woo_woo_tumblog_switch' ) == 'true' && get_option( 'woo_custom_rss' ) == 'true' ) {
	add_filter( 'the_excerpt_rss', 'woo_custom_tumblog_rss_output' );
	add_filter( 'the_content_rss', 'woo_custom_tumblog_rss_output' );
}

/*-----------------------------------------------------------------------------------*/
/* You can add custom functions below */
/*-----------------------------------------------------------------------------------*/

function removeUnusedMenus() {
	remove_menu_page('link-manager.php');
	remove_menu_page('edit-comments.php'); 
	remove_menu_page('edit.php?post_type=portfolio');
	remove_menu_page('edit.php?post_type=feedback');
	remove_menu_page('edit.php?post_type=woothemes'); /* Has some useful options and could be reenabled */
}
add_action( 'admin_menu', 'removeUnusedMenus' );

function removeUnusedProfileFields($profile_fields) {
	$profile_fields['mobile'] = 'Mobile Phone Number';
	unset($profile_fields['aim']);
	unset($profile_fields['yim']);
	unset($profile_fields['jabber']);
	unset($profile_fields['description']);
	

	return $profile_fields;
}
add_filter('user_contactmethods', 'removeUnusedProfileFields');

add_action( 'mailusers_group_custom_meta_filter', 'sendMailByRank', 5 );
function sendMailByRank() {
    mailusers_register_group_custom_meta_filter('FTOs', 'rank', 'FTO');
    mailusers_register_group_custom_meta_filter('801s', 'rank', '801');
    mailusers_register_group_custom_meta_filter('802s', 'rank', '802');
    mailusers_register_group_custom_meta_filter('803s', 'rank', '803');
    mailusers_register_group_custom_meta_filter('804s', 'rank', '804');
    mailusers_register_group_custom_meta_filter('Alumni', 'rank', 'alumni');
    mailusers_register_group_custom_meta_filter('New Members', 'rank', 'new');
    mailusers_register_group_custom_meta_filter('Inactive Members', 'rank', '0');
}

add_action( 'admin_init', 'redirect_non_admin_users' );
function redirect_non_admin_users() {
	if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
		wp_redirect( home_url() );
		exit;
	}
}

function habfna_hide_admin_bar_settings() { ?>
	<style type="text/css">
		.show-admin-bar {
			display: none;
		}
	</style>
<?php }
function habfna_disable_admin_bar() {
	if(!current_user_can('administrator')) {
		add_filter( 'show_admin_bar', '__return_false' );
		add_action( 'admin_print_scripts-profile.php', 'habfna_hide_admin_bar_settings' );
	}
}
add_action('init', 'habfna_disable_admin_bar', 9);


/*-----------------------------------------------------------------------------------*/
/* Don't add any code below here or the sky will fall down */
/*-----------------------------------------------------------------------------------*/
?>