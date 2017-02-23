<?php
/**
 * Plugin Name: MERT Scheduler
 * Plugin URI: http://www.bradleyhalpern.com
 * Description: A custom jQuery scheduler for University of Rochester R/C MERT.
 * Version: 1.0
 * Author: Bradley Halpern
 * Author URI: http://www.bradleyhalpern.com
 * License: GPL2
 */
 
 /*  Copyright 2013  Bradley Halpern  (email : bradley@bradleyhalpern.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to bradley@bradleyhalpern.com.
*/

/* Based on http://arshaw.com/fullcalendar/ */


?>
<?php
class MySettingsPage {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Shifts Scheduler', 
            'manage_options', 
            'schedule-settings-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'schedule_option' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Shift Scheduler</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'schedule-settings' );   
                do_settings_sections( 'schedule-settings-admin' );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {        
        register_setting(
            'schedule-settings', // Option group
            'schedule_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'schedule_settings_section', // ID
            'Schedule Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'schedule-settings-admin' // Page
        );  

        add_settings_field(
            'enable_night', // ID
            'Enable Night Shifts', // Title 
            array( $this, 'enable_night_callback' ), // Callback
            'schedule-settings-admin', // Page
            'schedule_settings_section' // Section           
        );      

        add_settings_field(
            'enable_day', 
            'Enable Day Shifts', 
            array( $this, 'enable_day_callback' ), 
            'schedule-settings-admin', 
            'schedule_settings_section'
        );    
        
        
        add_settings_section(
            'schedule_instructions_section', // ID
            'Shift Scheduler Instructions', // Title
            array( $this, 'print_instructions_info' ), // Callback
            'schedule-settings-admin' // Page
        );   
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input ) {
        /*if( !is_numeric( $input['id_number'] ) )
            $input['id_number'] = '';  

        if( !empty( $input['title'] ) )
            $input['title'] = sanitize_text_field( $input['title'] );*/

        return $input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info() {
        print 'Settings for the schedule are pretty simple. If you need more customization, the plugin will have to be modified by somebody who knows what they&rsquo;re doing.';
    }
    public function print_instructions_info() {
        print '<p><b>To place the scheduler:</b> Create or edit the page(s) on which you want the scheduler to appear, and use the shortcode <code>[schedule]</code>. Be sure the page is set to Private, or the schedule will be viewable and editable by anybody!</p>
        <p><b>To add a shift:</b> Under Shifts on the left sidebar of the admin panel, select Add New. Assign a title, date, and shift type. Excerpt may be used as a description (optional).</p><p><b>Questions?</b> Email <a href="mailto:bradley@bradleyhalpern.com">bradley@bradleyhalpern.com</a>.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function enable_night_callback() {
        echo '<input type="checkbox" id="enable_night" name="schedule_option[enable_night]"';
        if($this->options['enable_night'] == 'on') echo ' checked="checked"';
        echo ' />';
    }
    public function enable_day_callback() {
        echo '<input type="checkbox" id="enable_day" name="schedule_option[enable_day]"';
        if($this->options['enable_day'] == 'on') echo ' checked="checked"';
        echo ' />';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    /*public function enable_day_callback() {
        printf(
            '<input type="checkbox" id="enable_day" name="schedule_option[enable_day]" value="%s" />',
            esc_attr( $this->options['enable_day'])
        );
    }*/
}


/* Define Custom Post Type */
add_action( 'init', 'register_cpt_shifts' );

function register_cpt_shifts() {

    $labels = array( 
        'name' => _x( 'Shifts', 'shifts' ),
        'singular_name' => _x( 'Shift', 'shifts' ),
        'add_new' => _x( 'Add New', 'shifts' ),
        'add_new_item' => _x( 'Add New Shift', 'shifts' ),
        'edit_item' => _x( 'Edit Shift', 'shifts' ),
        'new_item' => _x( 'New Shift', 'shifts' ),
        'view_item' => _x( 'View Shift', 'shifts' ),
        'search_items' => _x( 'Search Shifts', 'shifts' ),
        'not_found' => _x( 'No shifts found', 'shifts' ),
        'not_found_in_trash' => _x( 'No shifts found in Trash', 'shifts' ),
        'parent_item_colon' => _x( 'Parent Shift:', 'shifts' ),
        'menu_name' => _x( 'Shifts', 'shifts' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'All crew shifts for MERT, including night shifts, day shifts, and standby shifts.',
        'supports' => array( 'title', 'excerpt', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'Shift Type' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => true,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'shifts', $args );
}
add_action( 'init', 'register_taxonomy_shift_types' );

function register_taxonomy_shift_types() {

    $labels = array( 
        'name' => _x( 'Shift Types', 'shift_types' ),
        'singular_name' => _x( 'Shift Type', 'shift_types' ),
        'search_items' => _x( 'Search Shift Types', 'shift_types' ),
        'popular_items' => _x( 'Popular Shift Types', 'shift_types' ),
        'all_items' => _x( 'All Shift Types', 'shift_types' ),
        'parent_item' => _x( 'Parent Shift Type', 'shift_types' ),
        'parent_item_colon' => _x( 'Parent Shift Type:', 'shift_types' ),
        'edit_item' => _x( 'Edit Shift Type', 'shift_types' ),
        'update_item' => _x( 'Update Shift Type', 'shift_types' ),
        'add_new_item' => _x( 'Add New Shift Type', 'shift_types' ),
        'new_item_name' => _x( 'New Shift Type', 'shift_types' ),
        'separate_items_with_commas' => _x( 'Separate shift types with commas', 'shift_types' ),
        'add_or_remove_items' => _x( 'Add or remove Shift Types', 'shift_types' ),
        'choose_from_most_used' => _x( 'Choose from most used Shift Types', 'shift_types' ),
        'menu_name' => _x( 'Shift Types', 'shift_types' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => false,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'show_admin_column' => false,
        'hierarchical' => true,

        'rewrite' => false,
        'query_var' => true
    );

    register_taxonomy( 'shift_types', array('shifts'), $args );
}

/* Method to lookup upcoming shifts for a given user */
function listShiftsForUser( $netid, $time = 'upcoming' ) {
	$args=array(
		'post_type' => 'shifts',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'caller_get_posts'=> 1,
		'meta_query' => array(
			'relation' => 'OR',
			array('key' => '801', 'value' => $netid),
			array('key' => '802', 'value' => $netid),
			array('key' => '803', 'value' => $netid)
		)
	);
	$shifts = null;
	$shifts = new WP_Query($args);
	ob_start();
	if( $shifts->have_posts() ) {
		if($time == 'upcoming') {echo '<h3>Your Upcoming Shifts</h3><ul class="my-shifts">';} else {echo '<h3>Your Shifts</h3><ul class="my-shifts">';}
		while ($shifts->have_posts()) : $shifts->the_post();
			$date = new DateTime(get_field('date'));
			if(date_format($date, 'Ymd') >= date('Ymd') && $time != 'all') {
			 ?><li><?php echo get_the_title(); ?><i style="color:#666;"> on <?php echo date_format($date, 'l, M. jS'); ?></i></li><?php 
			} else if($time == 'all') {
			 ?><li style="<?php if(date_format($date, 'Ymd') >= date('Ymd')) echo 'color:#999;'; else echo 'color:#666;';?>"><?php echo get_the_title(); ?><i> on <?php echo date_format($date, 'l, M. jS'); ?></i></li><?php 
			}
		endwhile;
		echo '</ul>';
	} else {
		if($time == 'upcoming') {echo '<h3>Your Upcoming Shifts</h3><p>You have no upcoming shifts.</p>';} else {echo '<h3>Your Shifts</h3><p>You have not taken any shifts yet, and you<br>are not signed up for any upcoming shifts.</p>';}
	}
	$return = ob_get_clean();
	wp_reset_query();
	return $return;
}

/* Define shortcode */
function calendar_shortcode( $atts ){
	wp_enqueue_script( 'fullcalendar-js', plugins_url( '/js/fullcalendar.js', __FILE__ ), array('jquery'), '1.0.0', false );
	wp_enqueue_style( 'fullcalendar-css', plugins_url( '/css/fullcalendar.css', __FILE__ ), array(), '1.0.0', 'all' );
	wp_enqueue_script( 'fancybox-js', plugins_url( '/js/fancybox.min.js', __FILE__ ), array('jquery'), '1.0.0', false );
	wp_enqueue_style( 'fancybox-css', plugins_url( '/css/fancybox.css', __FILE__ ), array(), '1.0.0', 'all' );
?>
<script>
	jQuery(document).ready(function($) {
		var signedUpThisLoad = false;
		
		/* If a schedule element exists, replace its content with the schedule. If not, create one at the end of the .entry */
		if($('#schedule').length == 0) {
			$('.entry').append('<div id="schedule"></div>');
		} else {
			$('#schedule').html('');
		}
		
		$('#schedule').fullCalendar({
			editable: false,
			eventBorderColor: '#ddd',
			eventBackgroundColor: '#fafafa',
			events: "<?php echo plugins_url( '/json-feed.php', __FILE__ ); ?>",
			eventDrop: function(s, delta) {
				//alert(s.title + ' was moved ' + delta + ' days\n' +
				//	'(should probably update your database)');
			},
			eventRender: function(s, elem) {
				//alert(elem);
			},
			eventClick: function(s, jsEvent, view) {
				jsEvent.preventDefault();
				
				/* Init display variable with basic meta */
				var display = '<h3>'+s.title+'</h3><p><b>'+$.fullCalendar.formatDate(s.start, 'MMM d, yyyy')+' '+s.time+'</b></p>';
				if(s.description) {display += '<p><i>'+s.description+'</i></p>';}
				
				/* Display appropriate fields for user rank */
				display += '<p><label for="801" class="c801">801</label>: <input id="801-name" class="c801" type="text" value="'+s.s801+'" disabled="disabled">';
				if(s.s801 == '' && s.userRank == '801') {display += ' <button class="shift-sign-up" id="801" data-shiftID="'+s.id+'" data-name="'+s.userName+'">Sign Up</button>';}
				display += '<br><label for="802" class="c802">802</label>: <input id="802-name" class="c802" type="text" value="'+s.s802+'" disabled="disabled">';
				if(s.s802 == '' && (s.userRank == '801' || s.userRank == '802')) {display += ' <button class="shift-sign-up" id="802" data-shiftID="'+s.id+'" data-name="'+s.userName+'">Sign Up</button>';}
				display += '<br><label for="803" class="c803">803</label>: <input id="803-name" class="c803" type="text" value="'+s.s803+'" disabled="disabled">';
				if(s.s803 == '' && (s.userRank == '801' || s.userRank == '802' || s.userRank == '803')) {display += ' <button class="shift-sign-up" id="803" data-shiftID="'+s.id+'" data-name="'+s.userName+'">Sign Up</button>';}
				display += '</p>';
				
				/* Display it */
				if(s.editlink) {display += '<p><a href="'+s.editlink+'" title="Edit this shift">Edit</a></p>';}
				$.fancybox( display, {helpers : { overlay : { locked : false } } } );
				
				
				$('.shift-sign-up').on('click', function() {
					var trigger = $(this);
					trigger.attr("disabled", "disabled");
					$.post( "<?php echo plugins_url('ajax-submit.php', __FILE__); ?>", { rank: $(this).attr('id'), id: $(this).attr('data-shiftID'), name: $(this).attr('data-name') })
					.done(function( data ) {
						$('#schedule-message').fadeOut('fast', function() {
							data = jQuery.parseJSON(data);
							if(data.code > 0) {
								$('#schedule-message').addClass('woo-sc-box tick success');
								signedUpThisLoad = true;
							} else {
								$('#schedule-message').addClass('woo-sc-box alert error');
							}
							$('#schedule-message').html('<p>'+data.message+'</p>');
							$('#schedule-message').slideDown().delay(5000).slideUp();
							$.fancybox.close();
							$('#schedule').fullCalendar( 'refetchEvents' );
						});
					})
					.fail(function( data ) {
						data = jQuery.parseJSON(data);
						$('#schedule-message').fadeOut('fast', function() {
							$('#schedule-message').addClass('woo-sc-box alert error');
							$('#schedule-message').html('<p>Fail: '+data.message+'</p>');
							$('#schedule-message').slideDown();
							$.fancybox.close();
							$('#schedule').fullCalendar( 'refetchEvents' );
						});
					});
				});
				
		        /*alert('Event: ' + s.title);
		        alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		        alert('View: ' + view.name);
		
		        // change the border color just for fun
		        $(this).css('border-color', 'red');*/
		
		    },
			eventRender: function(s, element) {
				/*element.qtip({
					content: s.description
				});*/
				
			},
			loading: function(bool) {
				if (bool) {
					$('#loading').fadeIn(600);
				} else {
					$('.fc-event-inner').append('<span class="dots"></span>');
					$('.needs-803 .dots').append('<span style="color:#6e86d6;">&middot;</span>');
					$('.needs-802 .dots').append('<span style="color:#3C14FF;">&middot;</span>');
					$('.needs-801 .dots').append('<span style="color:#061f70;">&middot;</span>');
					/* Bind detector on tabs to selectively reload calendar when user clicks the calendar tab */
					$('#tabs-dashboard .nav-tab').on('click', function(e) {
						if(e.target.innerHTML == "Schedule") {
							$('#schedule').fullCalendar( 'refetchEvents' );
						}
					});
					$('#loading').fadeOut(900);
				}
			}
		});
		$('.fc-header-right').prepend('<span><a href="#" id="my-schedule" title="View all of your upcoming shifts">Your Upcoming Shifts</a></span>');
		$('#my-schedule').on('click', function(e) {
			e.preventDefault();
			<?php global $current_user; get_currentuserinfo(); $netid = $current_user->user_login; ?>
			if(signedUpThisLoad) {
				$.fancybox( <?php echo "'".listShiftsForUser($netid)."<p style=\"border-top:1px solid #ddd;margin-top:0.5em;padding-top:0.5em;color: #999999;\">The shifts you just signed up for are not reflected yet.<br>You must <a href=\"#\" onclick=\"location.reload(true);\">reload the page</a> to see them here.</p>'";?>, {helpers : { overlay : { locked : false } } }  );
			} else {
				$.fancybox( <?php echo "'".listShiftsForUser($netid)."'";?>, {helpers : { overlay : { locked : false } } }  );
			}
			
		});
		$('#schedule').append('<div class="schedule-bottom"><span><a href="#" id="my-history" title="View all of your past and upcoming shifts">View all of your past and upcoming shifts</a></span></div>');
		$('#my-history').on('click', function(e) {
			e.preventDefault();
			<?php global $current_user; get_currentuserinfo(); $netid = $current_user->user_login; ?>
			if(signedUpThisLoad) {
				$.fancybox( <?php echo "'".listShiftsForUser($netid, 'all')."<p style=\"border-top:1px solid #ddd;margin-top:0.5em;padding-top:0.5em;color: #999999;\">The shifts you just signed up for are not reflected yet.<br>You must <a href=\"#\" onclick=\"location.reload(true);\">reload the page</a> to see them here.</p>'";?>, {helpers : { overlay : { locked : false } } } );
			} else {
				$.fancybox( <?php echo "'".listShiftsForUser($netid, 'all')."'";?>, {helpers : { overlay : { locked : false } } } );
			}
			
		});
		
		setInterval(function() {$('#schedule').fullCalendar( 'refetchEvents' );}, 600000); /* Refresh every 10 min. */
	});
</script>
<div id="schedule-message"></div>
<div id="loading">&nbsp;</div>
<?php
}
add_shortcode( 'scheduler', 'calendar_shortcode' );



if( is_admin() )
    $my_settings_page = new MySettingsPage();
?>