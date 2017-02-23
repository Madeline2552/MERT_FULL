<?php
/*
Plugin Name: Maddy Tally
Description: Site specific code changes for rochester.edu/mert
*/
/* Start Adding Functions Below this Line */

add_action( 'admin_menu', 'shift_tally_menu' );



function shift_tally_menu(){
	add_submenu_page( 'tools.php', 'Shift Tally', 'Shift Tally', 'manage_options', 'shift-tally', array($this, 'maddy_tally_html'));
}

function maddy_tally_html(){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}


}

/* Method to lookup upcoming shifts for a given user */
/*function listAllShiftsForUser($netid, $time = 'upcoming') {
	$args=array(
		'post_type' => 'shifts',
		'post_status' => 'publish',
		'meta_query' => array(
			array('key' => '801', 'value' => $netid),
			array('key' => '802', 'value' => $netid),
			array('key' => '803', 'value' => $netid)
		)
	);
	$shifts = null;
	$shifts = new WP_Query($args);

	ob_start();
	if( $shifts->have_posts() ) {
		echo '<ul>';
		while ($shifts->have_posts()){
			$shifts->the_post();
			$date = new DateTime(get_field('date'));
			if(date_format($date, 'Ymd') >= date('Ymd') && $time != 'all') {
			 ?>
				<script>console.log("Hello");</script>
			 	<?php echo get_the_title(); ?>
			 	<i> on <?php echo date_format($date, 'l, M. jS'); ?></i>
			 </li><?php
			}
		}

		echo '</ul>';
	}
	$return = ob_get_clean();
	?><script>console.log("Hello");</script><?php
	wp_reset_query();
	return $return;
}*/







/* Stop Adding Functions Below this Line */
?>
