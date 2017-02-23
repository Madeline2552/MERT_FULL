<?php
	require_once('../../../wp-load.php');
	
	$year = date('Y');
	$month = date('m');
	
	$args=array(
		'post_type' => 'shifts',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'caller_get_posts'=> 1
	);
	$shifts = null;
	$shifts = new WP_Query($args);
	$events = array();
	
	$users_query = get_users();
	$users = array();
	foreach($users_query as $user) {
		$users[$user->user_login] = $user->display_name;
	}
	
	get_currentuserinfo();
	$rank = get_user_meta($current_user->ID, 'rank', true);
	if($rank == 'FTO') $rank = '801';
	$netid = $current_user->user_login;
	$name = $users[$netid];
	if($name == null || !$name || $name == '') $name = $netid;
	
	if( $shifts->have_posts() ) {
		while ($shifts->have_posts()) : $shifts->the_post();
		
			if(get_field('time')) {$time = get_field('time');} else {$time = '';}
			
			/* Add these classNames to generate the pretty dots on the calendar, styled with CSS */
			$classes = array();
			if(get_field('801') == '') $classes[] = 'needs-801';
			if(get_field('802') == '') $classes[] = 'needs-802';
			if(get_field('803') == '') $classes[] = 'needs-803';
			
			/* Makes open shifts darker */
			if(get_field($rank) == '') {
				//$textColor = '#000'; else $textColor = null; //We won't use this anymore
				$classes[] = 'open-for-users-rank';
			}
			
			/* Convert NetIDs to display names for dispay */
			$s801 = $users[get_field('801')];
			if($s801 == null || !$s801 || $s801 == '') $s801 = get_field('801');
			$s802 = $users[get_field('802')];
			if($s802 == null || !$s802 || $s802 == '') $s802 = get_field('802');
			$s803 = $users[get_field('803')];
			if($s803 == null || !$s803 || $s803 == '') $s803 = get_field('803');
			
			if ( current_user_can( 'manage_options' ) ) {$editlink = get_edit_post_link(); } else {$editlink = false;}
			$events[] = array(
				'id' => get_the_ID(),
				'title' => get_the_title(),
				'start' => get_field('date'),
				'time' => $time,
				'allDay' => true,
				'url' => get_permalink(),
				's801' => $s801,
				's802' => $s802,
				's803' => $s803,
				'className' => $classes,
				'description' => get_the_excerpt(),
				'editlink' => $editlink,
				'userName' => $netid,
				'userRank' => $rank
			);
		
		endwhile;
	}
	wp_reset_query();  // Restore global post data stomped by the_post().	
	echo json_encode($events);

?>
