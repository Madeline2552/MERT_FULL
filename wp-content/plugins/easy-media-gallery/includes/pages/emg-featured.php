<?php

if ( ! defined( 'ABSPATH' ) ) exit;


function emg_premium_plugins() {
	ob_start(); ?>
	<div class="wrap" id="ghozy-featured">
		<?php echo emg_get_feed(); ?>
	</div>
	<?php
	echo ob_get_clean();
}


function emg_get_feed() {
	if ( false === ( $cache = get_transient( 'easymediagallery_featured_feed' ) ) ) {
		$feed = wp_remote_get( 'http://content.ghozylab.com/feed.php?c=featuredplugins', array( 'sslverify' => false ) );
		if ( ! is_wp_error( $feed ) ) {
			if ( isset( $feed['body'] ) && strlen( $feed['body'] ) > 0 ) {
				$cache = wp_remote_retrieve_body( $feed );
				set_transient( 'easymediagallery_featured_feed', $cache, 3600 );
			}
		} else {
			$cache = '<div class="error"><p>' . __( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</div>';
		}
	}
	return $cache;
}