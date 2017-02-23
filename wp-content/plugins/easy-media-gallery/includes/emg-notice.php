<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_admin() ) {
	add_action('admin_notices', 'emg_aff_admin_notice');
}

function emg_aff_admin_notice() {
    global $current_user, $post;
		if ( !empty( $post ) && 'easymediagallery' === $post->post_type ) {
        	$user_id = $current_user->ID;
        	/* Check that the user hasn't already clicked to ignore the message */
   	 		if ( ! get_user_meta($user_id, 'emg_ignore_notice') ) {
       	 		echo '<div class="updated"><p>'; 
        		printf(__('Earn <span style="color: red;">EXTRA MONEY</span> and get 30&#37; affiliate share from every sale you make!&nbsp;&nbsp;<a href="http://goo.gl/AZMFid" target="_blank">JOIN AFFILIATE NOW!</a><span style="float: right;"><a href="%1$s">Hide Notice</a><span>'), '?emg_nag_ignore=0');
        		echo "</p></div>";
    			}
			}
}

if ( is_admin() ) {
	add_action('admin_init', 'emg_nag_ignore');
}

function emg_nag_ignore() {

    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['emg_nag_ignore']) && '0' == $_GET['emg_nag_ignore'] ) {
             add_user_meta($user_id, 'emg_ignore_notice', 'true', true);
    }
}



?>