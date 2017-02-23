<?php
	require_once('../../../wp-load.php');
	
	$rank = $_POST['rank'];
	$shift_id = $_POST['id'];
	$name = $_POST['name'];
	
	// Clear means the shift is empty and we're okay to proceed
	$clear = true;
	$already_registered = get_post_meta($shift_id, $rank, true);
	if($already_registered != '') {
		$clear = false;
	}
	
	if($clear) {
		if($rank == '801' || $rank == '802' || $rank == '803') {
			$query = update_post_meta($shift_id, $rank, $name);
		}
	
		if ($query == true) {
			$return = array("code" => 1, "message" => "You have successfully signed up.");
		} else {
			$return = array("code" => 0, "message" => "Uh oh, it looks like there may have been an error. (Bad query)");
		}
	} else {
		$return = array("code" => 0, "message" => "Uh oh, somebody has already signed up for that shift.");
	}
	wp_reset_query();  // Restore global post data stomped by the_post().	
	echo json_encode($return);
?>