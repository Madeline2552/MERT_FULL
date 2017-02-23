<?php
/*
Plugin Name: Easy Media Gallery
Plugin URI: http://www.ghozylab.com/plugins/
Description: Easy Media Gallery (Lite) - Displaying your gallery, video (MP4, Youtube, Vimeo) and audio mp3 in elegant and fancy lightbox with very easy. Allows you to customize all media to get it looking exactly what you want. <a href="https://ghozy.link/q65dp" target="_blank"><strong> Upgrade to Pro Version Now</strong></a> and get a tons of awesome features.
Author: GhozyLab, Inc.
Text Domain: easy-media-gallery
Domain Path: /languages
Version: 1.3.131
Author URI: http://www.ghozylab.com/plugins/
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}


/*
|--------------------------------------------------------------------------
| I18N - LOCALIZATION
|--------------------------------------------------------------------------
*/
function emg_lang_init() {
	load_plugin_textdomain( 'easy-media-gallery', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
add_action( 'init', 'emg_lang_init' );


/*
|--------------------------------------------------------------------------
| Defines
|--------------------------------------------------------------------------
*/
if ( !defined( 'EASYMEDG_PLUGIN_BASENAME' ) )
    define( 'EASYMEDG_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( !defined( 'EASYMEDG_PLUGIN_NAME' ) )
    define( 'EASYMEDG_PLUGIN_NAME', trim( dirname( EASYMEDG_PLUGIN_BASENAME ), '/') );

if ( !defined( 'EASYMEDG_PLUGIN_DIR' ) )
    define( 'EASYMEDG_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . EASYMEDG_PLUGIN_NAME . '/' );

if ( !defined( 'EASYMEDG_PLUGIN_URL' ) ) {
	if ( is_ssl() ) {
		if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
			define( 'EASYMEDG_PLUGIN_URL', WP_PLUGIN_URL . '/' . EASYMEDG_PLUGIN_NAME . '/' );
			} else {
				define( 'EASYMEDG_PLUGIN_URL', str_replace('http', 'https', WP_PLUGIN_URL) . '/' . EASYMEDG_PLUGIN_NAME . '/' );
				}
		} else {
			define( 'EASYMEDG_PLUGIN_URL', WP_PLUGIN_URL . '/' . EASYMEDG_PLUGIN_NAME . '/' );
			}
	}
	
	
$wp_plugin_dir = substr( plugin_dir_path(__FILE__), 0, -1 );
define( 'EMG_DIR', $wp_plugin_dir );

// plugin pathCL
if ( ! defined( 'EMG_DIR_CL' ) ) {
	define( 'EMG_DIR_CL', plugin_dir_path( __FILE__ ) );
	}

// WP Version
if( ( float )substr( get_bloginfo( 'version' ), 0, 3 ) >= 3.5 ) {
	define( 'EMG_WP_VER', "g35" );
	}
	else {
		define( 'EMG_WP_VER', "l35" );
	}

// Plugin Name
if ( !defined( 'EASYMEDIA_NAME' ) ) {
	define( 'EASYMEDIA_NAME', 'Easy Media Gallery Lite' );
}

// Plugin Version
if ( !defined( 'EASYMEDIA_VERSION' ) ) {
	define( 'EASYMEDIA_VERSION', '1.3.131' );
}

// Pro Price
if ( !defined( 'EASYMEDIA_PRO_PRICE' ) ) {
	define( 'EASYMEDIA_PRO_PRICE', '24' );
}

// Pro+
if ( !defined( 'EASYMEDIA_PRICE' ) ) {
	define( 'EASYMEDIA_PRICE', '29' );
}

// Pro++ Price
if ( !defined( 'EASYMEDIA_PLUS_PRICE' ) ) {
	define( 'EASYMEDIA_PLUS_PRICE', '35' );
}

// Dev Price
if ( !defined( 'EASYMEDIA_DEV_PRICE' ) ) {
	define( 'EASYMEDIA_DEV_PRICE', '99' );
}

// WP Version
if ( !defined( 'EMG_WPVER' ) ) {
	define( 'EMG_WPVER', get_bloginfo( 'version' ) );
}

define( 'EASYMEDIA_PLUGIN_SLUG', 'easy-media-gallery/easy-media-gallery.php' );
define( 'EMG_API_URLCURL', 'https://secure.ghozylab.com/' );
define( 'EMG_API_URL', 'http://secure.ghozylab.com/' );


/*
|--------------------------------------------------------------------------
| Requires Wordpress Version
|--------------------------------------------------------------------------
*/
function req_wordpress_version() {
	
	$plugin = plugin_basename( __FILE__ );

	if ( version_compare( EMG_WPVER, "3.3", "<" ) ) {
		if ( is_plugin_active( $plugin ) ) {
			deactivate_plugins( $plugin );
			wp_die( "".EASYMEDIA_NAME." requires WordPress 3.3 or higher, this plugin has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
		}
	}
}
add_action( 'admin_init', 'req_wordpress_version' );


/*
|--------------------------------------------------------------------------
| Requires PHP Version (min version PHP 5.2)
|--------------------------------------------------------------------------
*/
if ( version_compare(PHP_VERSION, '5.2', '<') ) {
	if ( is_admin() && ( !defined('DOING_AJAX') || !DOING_AJAX ) ) {
		require_once ABSPATH.'/wp-admin/includes/plugin.php';
		deactivate_plugins( __FILE__ );
	    wp_die( "".EASYMEDIA_NAME." requires PHP 5.2 or higher. The plugin has now disabled itself. Please ask your hosting provider for this issue.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
	} else {
		return;
	}
}


/*
|--------------------------------------------------------------------------
| Requires GD Library
|--------------------------------------------------------------------------
*/
if ( is_admin() ) {
	if ( !extension_loaded('gd') && !function_exists('gd_info') ) {
		require_once ABSPATH.'/wp-admin/includes/plugin.php';
		deactivate_plugins( __FILE__ );
	    wp_die( "<strong>GD Library</strong> for PHP is not installed on your server. ".EASYMEDIA_NAME." requires it to function properly. The plugin has now disabled itself. Please ask your hosting provider for this issue.<br /><br />Back to <a href='".admin_url()."'>WordPress admin</a>" );
		}
}
// Learn more here http://www.webassist.com/tutorials/Enabling-the-GD-library-setting


/*-------------------------------------------------------------------------------*/
/*  JetPack ( Photon Module ) Detect
/*-------------------------------------------------------------------------------*/
add_action( 'admin_notices', 'emg_jetpack_modules_photon' );

function emg_jetpack_modules_photon() {
	
	if( class_exists( 'Jetpack' ) && in_array( 'photon', Jetpack::get_active_modules() ) ) {
		
		echo '<div class="error"><span class="emgwarning"><p class="emgwarningp">You need to deactivate JetPack <strong>Photon Module</strong> to make <strong>'.EASYMEDIA_NAME.'</strong> work!</p><p><a href="'.admin_url().'admin.php?page=jetpack&action=deactivate&module=photon&_wpnonce='.wp_create_nonce( 'jetpack_deactivate-photon' ).'" >Deactivate Now!</a>'.'</p></div>';
		
		}
		
}


 /*
|--------------------------------------------------------------------------
| Easymedia (Lite) Get Control Panel Options
|--------------------------------------------------------------------------
*/
function easy_get_option( $name ){
	
    $easymedia_values = get_option( 'easy_media_opt' );
    if ( is_array( $easymedia_values ) && array_key_exists( $name, $easymedia_values ) ) return $easymedia_values[$name];
	
    return false;
	
}


/*
|--------------------------------------------------------------------------
| Load WP jQuery library.
|--------------------------------------------------------------------------
*/
function easmedia_enqueue_scripts() {
	
	if( !is_admin() ){
		wp_enqueue_script( 'jquery' );
		}
		
}

if ( !is_admin() ){
	
	add_action( 'init', 'easmedia_enqueue_scripts' );
	
	}

/*
|--------------------------------------------------------------------------
| SETTINGS LINK 01
|--------------------------------------------------------------------------
*/
function easmedia_settings_link( $link, $file ) {
	
	static $this_plugin;
	
	if ( !$this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$settings_link = '<a href="' . admin_url( 'edit.php?post_type=easymediagallery&page=emg_settings' ) . '"><span class="dashicons dashicons-admin-generic"></span>&nbsp;' . __( 'Settings', 'easy-media-gallery' ) . '</a>';
		array_unshift( $link, $settings_link );
	}
	
	return $link;
}
add_filter( 'plugin_action_links', 'easmedia_settings_link', 10, 2 );


/*
|--------------------------------------------------------------------------
| SETTINGS LINK 02
|--------------------------------------------------------------------------
*/
function easmedia_settings_link_rowmeta( $link, $file ) {
	static $this_plugin;
	
	if ( !$this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$link[] = '<a href="https://ghozy.link/rs3bq" target="_blank"><span class="dashicons dashicons-heart"></span>&nbsp;' . __( 'Donate', 'easy-media-gallery' ) . '</a>';
		$link[] = '<a href="https://www.youtube.com/GhozyLab" target="_blank"><span class="dashicons dashicons-editor-help"></span>&nbsp;' . __( 'Tutorials', 'easy-media-gallery' ) . '</a>';
		$link[] = '<a href="https://wordpress.org/support/plugin/easy-media-gallery/reviews/?filter=5" target="_blank"><span class="dashicons dashicons-star-filled"></span>&nbsp;' . __( 'Rate Us', 'easy-media-gallery' ) . '</a>';
	}
	
	return $link;
}
add_filter( 'plugin_row_meta', 'easmedia_settings_link_rowmeta', 10, 2 );


/*
|--------------------------------------------------------------------------
| Registers custom post type
|--------------------------------------------------------------------------
*/
function easmedia_post_type() {
	$labels = array(
		'name' 				=> _x( 'Easy Media Gallery Lite', 'post type general name' ),
		'singular_name'		=> _x( 'Easy Media Gallery Lite', 'post type singular name' ),
		'add_new' 			=> __( 'Add New Media', 'easy-media-gallery' ),
		'add_new_item' 		=> __( 'Easy Media Item', 'easy-media-gallery' ),
		'edit_item' 		=> __( 'Edit Media', 'easy-media-gallery' ),
		'new_item' 			=> __( 'New Media', 'easy-media-gallery' ),
		'view_item' 		=> __( 'View Media', 'easy-media-gallery' ),
		'search_items' 		=> __( 'Search Media', 'easy-media-gallery' ),
		'not_found' 		=> __( 'No Media Found', 'easy-media-gallery' ),
		'not_found_in_trash'=> __( 'No Media Found In Trash', 'easy-media-gallery' ),
		'parent_item_colon' => __( 'Parent Media', 'easy-media-gallery' ),
		'menu_name'			=> __( 'Easy Media', 'easy-media-gallery' )
	);

	$taxonomies = array();
	$supports = array( 'title', 'thumbnail' );
	
	$post_type_args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __( 'Easy Media', 'easy-media-gallery' ),
		'public' 			=> false,
		'show_ui' 			=> true,
		'publicly_queryable'=> true,
		'query_var'			=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> false,
		'hierarchical' 		=> false,
		'rewrite' 			=> array( 'slug' => 'easymedia', 'with_front' => false ),
		'supports' 			=> $supports,
		'menu_position' 	=> 20,
		'menu_icon' =>  plugins_url( 'includes/images/emg-dash-icon.png' , __FILE__ ),		
		'taxonomies'		=> $taxonomies
	);

	 register_post_type( 'easymediagallery', $post_type_args );
}

require_once( ABSPATH . 'wp-includes/pluggable.php' );
if ( current_user_can( 'install_plugins' ) ) {
	add_action( 'init', 'easmedia_post_type' );
}


/*-------------------------------------------------------------------------------*/
/* Put css file and add Custom Icon for Easy Media Gallery
/*-------------------------------------------------------------------------------*/
function add_my_admin_stylesheet() {
	wp_enqueue_style( 'easmedia_admin_styles', plugins_url('includes/css/admin.css' , __FILE__ ) );
	}
	
add_action( 'admin_print_styles', 'add_my_admin_stylesheet' );


function easmedia_easymediagallery_icons() { ?>
    <style type="text/css" media="screen">

		#icon-edit.icon32-posts-easymediagallery {
		    background: url(<?php echo plugins_url( 'includes/images/easymedia-32x32.png' , __FILE__ )?>) no-repeat top left transparent !important;
		}
		
		#icon-edit.icon32-posts-easymedia {
		    background: url(<?php echo plugins_url( 'includes/images/easymedia-32x32.png' , __FILE__ )?>) no-repeat top left transparent !important;
		}		
		
    </style>
<?php }

add_action( 'admin_head', 'easmedia_easymediagallery_icons' );


/*--------------------------------------------------------------------------------*/
/*  Add Custom Columns for Portfolios 
/*--------------------------------------------------------------------------------*/
add_filter( 'manage_edit-easymediagallery_columns', 'easmedia_edit_columns_easymedia' );

function easmedia_edit_columns_easymedia( $easymedia_columns ){  
	$easymedia_columns = array(  
		'cb' => '<input type="checkbox" />',  
		'title' => _x( 'Title', 'column name', 'easy-media-gallery' ),
		'psg_thumbnail' => __( 'Thumbnails', 'easy-media-gallery' ),
		'psg_type' => __( 'Type', 'easy-media-gallery' ),		
		'psg_cat' => __( 'Categories', 'easy-media-gallery' ),
		'psg_id' => __( 'ID', 'easy-media-gallery' )		
			
	);  
	unset( $easymedia_columns['Date'] );
	return $easymedia_columns;  
}  

function easmedia_custom_columns_easymedia( $easymedia_columns, $post_id ){
	
if ( is_array( get_post_meta( $post_id, 'easmedia_metabox_media_gallery', true ) ) ) {
	$ittl = array_filter( get_post_meta( $post_id, 'easmedia_metabox_media_gallery', true ) );
	$ittl = count( $ittl );
	}
	else {
		$ittl = '0';
		}

	switch ( $easymedia_columns ) {
	    case 'psg_thumbnail':
	        	$mediatype = get_post_meta( $post_id, 'easmedia_metabox_media_type', true );
						switch	( $mediatype ) {
								case 'Single Image':
										$thumbmedia = get_post_meta( $post_id, 'easmedia_metabox_img', true );
	       								
										 if ( isset( $thumbmedia ) && $thumbmedia != '' ) {
											 $globalimgsize = wp_get_attachment_image_src( emg_get_attachment_id_from_src( $thumbmedia ), 'full' );
											 $timthumbimg = easymedia_resizer( $thumbmedia, $globalimgsize[1], $globalimgsize[2], 70, 70, true );
											 echo '<img class="imgthumblist" width="70" height="70" alt="Thumbnail" src="' . $timthumbimg . '"></img>';
											 } 
											 else {
												 echo '<img class="imgthumblist" width="70" height="70" alt="Thumbnail" src="' . plugins_url( 'includes/images/no_images.png' , __FILE__ ) . '"></img>';
												 }
												 break;												 
											

								case 'Video':
											 echo '<img class="imgthumblist" width="70" height="70" alt="Thumbnail" src="' . plugins_url( 'images/video.png' , __FILE__ ) . '"></img>';
												 break;			
			
								case 'Audio':
											 echo '<img class="imgthumblist" width="70" height="70" alt="Thumbnail" src="' . plugins_url( 'images/audio.png' , __FILE__ ) . '"></img>';
												 break;	
												 
								case 'Multiple Images (Slider)':
											 echo '<img class="imgthumblist" width="70" height="70" alt="Thumbnail" src="' . plugins_url( 'images/gallery.png' , __FILE__ ) . '"></img>';
												 break;										 
												 	
		
			}
			
	        break;
	    case 'psg_id':
		echo $post_id;

	        break;
			
						
	    case 'psg_type':

 $mediatype = get_post_meta( $post_id, 'easmedia_metabox_media_type', true );

	        if ( isset( $mediatype ) && $mediatype !='Select' ) {
				if ( trim( $mediatype ) =='Multiple Images (Slider)' ) {
					echo $mediatype.'<br><span class="emgttlimage">Total image(s): '.$ittl.'</span>';
				} else {
					echo $mediatype;
						}
	        } else {
	            echo __( 'None', 'easy-media-gallery' );
	        }

			break;
								
	    case 'psg_cat':
			$cats = get_the_terms( $post_id, 'emediagallery' );
            if ( is_array( $cats ) ) {
				$item_cats = array();
				foreach ( $cats as $cat ) {
					$item_cats[] = $cat->name;
					}
				echo implode( ', ', $item_cats );
			}
			else {echo 'Uncategorized';}
			break;		
	        
		default:
			break;
	}  
}  

add_filter( 'manage_posts_custom_column',  'easmedia_custom_columns_easymedia', 10, 2 );  

// jQuery Auto Save Media Order
function easmedia_save_easymedia_sorted_order() {
    global $wpdb;
    
    $order = explode( ',', $_POST['order'] );
    $counter = 0;
    
    foreach ( $order as $easymedia_id ) {
        $wpdb->update( $wpdb->posts, array( 'menu_order' => $counter ), array( 'ID' => $easymedia_id ) );
        $counter++;
    }
    die(1);
}


add_action( 'wp_ajax_easymedia_sort', 'easmedia_save_easymedia_sorted_order' );

function easmedia_print_sort_scripts() {
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_script( 'easmedia_easymedia_sort', plugins_url('includes/js/func/easymedia_sort.js' , __FILE__ ) );
}

function easmedia_print_sort_styles() {
    wp_enqueue_style( 'nav-menu' );
}


/*-------------------------------------------------------------------------------*/
/*  Add The Custom Columns ( Thanks & Credit to Captain Slider Plugin ) 
/*-------------------------------------------------------------------------------*/
function easmedia_add_new_easymediagallery_column( $easmedia_col ) {
	$easmedia_col['emg_menu_order'] = "Order";
	return $easmedia_col;
}
add_action( 'manage_edit-easymediagallery_columns', 'easmedia_add_new_easymediagallery_column' );


// Show Custom Order Values
function easmedia_show_order_column( $name ) {
	global $post;

	switch ( $name ) {
		case 'emg_menu_order':
			$order = $post->menu_order;
			echo $order;
		break;
	 default:
		break;
	 }
}
add_action( 'manage_easymediagallery_posts_custom_column','easmedia_show_order_column' );


// Make It Sortable
function easmedia_order_column_register_sortable( $columns ) {
	$columns['emg_menu_order'] = 'menu_order';
	return $columns;
}
add_filter( 'manage_edit-easymediagallery_sortable_columns','easmedia_order_column_register_sortable' );


// Presets Media Order to be menu_order
function easmedia_set_custom_post_types_admin_order( $wp_query ) {
	if ( is_admin() ) {
		// Get the post type from the query
		$post_type = $wp_query->query['post_type'];
		// if it's one of our custom ones
		if ( $post_type == 'easymediagallery' ) {
			$wp_query->set( 'orderby', 'menu_order' );
			$wp_query->set( 'order', 'ASC' );
		}
	}
}
add_filter( 'pre_get_posts', 'easmedia_set_custom_post_types_admin_order' );


/*-------------------------------------------------------------------------------*/
/*   Hide View, Quick Edit and Preview Button
/*-------------------------------------------------------------------------------*/
function emg_remove_row_actions( $actions ) {
	global $post;
    if( $post->post_type == 'easymediagallery' ) {
		unset( $actions['view'] );
		unset( $actions['inline hide-if-no-js'] );
	}
    return $actions;
}

if ( is_admin() ) {
	add_filter( 'post_row_actions','emg_remove_row_actions', 10, 2 );
}


/*-------------------------------------------------------------------------------*/
/*   Executing shortcode inside the_excerpt() and sidebar/widget
/*-------------------------------------------------------------------------------*/
add_filter( 'widget_text', 'do_shortcode', 11 ); // <--- comment this to disable media in widget.
add_filter( 'the_excerpt', 'shortcode_unautop' );
add_filter( 'the_excerpt', 'do_shortcode' );  


/*
|--------------------------------------------------------------------------
| RENAME SUBMENU
|--------------------------------------------------------------------------
*/
function emg_rename_submenu() {  
    global $submenu;     
	$submenu['edit.php?post_type=easymediagallery'][5][0] = __( 'Overview', 'easy-media-gallery' );  
}  
add_action( 'admin_menu', 'emg_rename_submenu' );  


/*-------------------------------------------------------------------------------*/
/*   Load Front End Script
/*-------------------------------------------------------------------------------*/
include_once( dirname( __FILE__ ) . '/includes/functions/functions.php' );
include_once( dirname( __FILE__ ) . '/includes/class/easymedia_resizer.php' );
include_once( dirname( __FILE__ ) . '/includes/taxonomy.php' );
include_once( dirname( __FILE__ ) . '/includes/shortcode.php' );
include_once( dirname( __FILE__ ) . '/includes/easywidget.php' );

if ( easy_get_option( 'easymedia_disen_plug' ) == '1' ) {	
	include_once( dirname( __FILE__ ) . '/includes/frontend.php' );
	include_once( dirname( __FILE__ ) . '/includes/dynamic-style.php' ); //@since 1.2.9.5
}

/*-------------------------------------------------------------------------------*/
/*   Includes Files
/*-------------------------------------------------------------------------------*/
/* These files build out the plugin specific options and associated functions. */

if ( is_admin() ) {
	include_once( dirname( __FILE__ ) . '/includes/options.php' );
	include_once( dirname( __FILE__ ) . '/includes/emg-settings.php' );
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-pricing.php' ); 	
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-welcome.php' );
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-featured.php' );
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-freeplugins.php' );
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-addons.php' );
	include_once( dirname( __FILE__ ) . '/includes/pages/emg-demo.php' );
	include_once( dirname( __FILE__ ) . '/includes/metaboxes.php' ); 
	include_once( dirname( __FILE__ ) . '/includes/tinymce-dlg.php' );

}


/*
|--------------------------------------------------------------------------
| CHECK PLUGIN DEFAULT SETTINGS
|--------------------------------------------------------------------------
*/

function emg_plugin_activate() {

  add_option( 'Activated_Emg_Plugin', 'emg-activate' );

}
register_activation_hook( __FILE__, 'emg_plugin_activate' );


/*
|--------------------------------------------------------------------------
| PLUGIN AUTO UPDATE
|--------------------------------------------------------------------------
*/
$emg_is_auto_update = easy_get_option( 'easymedia_disen_autoupdt' );

switch ( $emg_is_auto_update ) {
	
	case '1':
		if ( !wp_next_scheduled( "emg_auto_update" ) ) {
			wp_schedule_event( time(), "daily", "emg_auto_update" );
			}
		add_action( "emg_auto_update", "plugin_emg_auto_update" );
	break;
	
	case '':
		wp_clear_scheduled_hook( "emg_auto_update" );
	break;
					
}	
		
function plugin_emg_auto_update() {
	try
	{
		require_once( ABSPATH . "wp-admin/includes/class-wp-upgrader.php" );
		require_once( ABSPATH . "wp-admin/includes/misc.php" );
		define( "FS_METHOD", "direct" );
		require_once( ABSPATH . "wp-includes/update.php" );
		require_once( ABSPATH . "wp-admin/includes/file.php" );
		wp_update_plugins();
		ob_start();
		$plugin_upg = new Plugin_Upgrader();
		$plugin_upg->upgrade( "easy-media-gallery/easy-media-gallery.php" );
		$output = @ob_get_contents();
		@ob_end_clean();
	}
	catch(Exception $e)
	{
	}
}


?>