<?php


/*
|--------------------------------------------------------------------------
| CONTROL, REGISTER & ENQUEUE FRONT END SCRIPTS / STYLES
|--------------------------------------------------------------------------
*/
function easymedia_frontend_stylesheet() {
	        wp_enqueue_style( 'easymedia_styles', EASYMEDG_PLUGIN_URL .'css/frontend.css' );
}
add_action( 'wp_print_styles', 'easymedia_frontend_stylesheet' );


function easymedia_frontend_script() {	
	
	( easy_get_option( 'easymedia_disen_autopl' ) == '1' ) ? $audautoplay = 'true' : $audautoplay = 'false';
	( easy_get_option( 'easymedia_disen_audio_loop' ) == '1' ) ? $audioloop = 'true' : $audioloop = 'false';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplaya = '&autoplay=1' : $autoplaya = '';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayb = '?autoplay=1' : $autoplayb = '';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayc = '1' : $autoplayc = '0';	
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayd = 'true' : $autoplayd = 'false';		
	( easy_get_option( 'easymedia_disen_rclick' ) == '1' ) ? $disenrclck = 'true' : $disenrclck = 'false';	
			
	$eparams = array(
		'nblaswf' => plugins_url( '/swf/NonverBlaster.swf' , __FILE__ ),
  		'audiovol' => easy_get_option( 'easymedia_audio_vol' ),
  		'audioautoplay' => $audautoplay,
  		'audioloop' => $audioloop,
  		'vidautopa' => $autoplaya,
  		'vidautopb' => $autoplayb,  
  		'vidautopc' => $autoplayc, 
		'vidautopd' => $autoplayd,	
		'drclick' => $disenrclck,
		'ajaxcid' => easy_get_option( 'easymedia_ajax_con_id' ),					
  		'ajaxpth' => admin_url('admin-ajax.php'),  // @since 1.2.9.5
		'ajaxnonce' => wp_create_nonce( 'medialoader' ), // @since 1.3.29	
  		'ovrlayop' => easy_get_option( 'easymedia_overlay_opcty' ) / 100,   
		);

	wp_localize_script( 'easymedia-core', 'EasyLite', $eparams );		
	
}
add_action( 'wp_enqueue_scripts', 'easymedia_frontend_script' );


function easymedia_frontend_prop()
{   
		$boxstyle = EASYMEDG_PLUGIN_URL . 'css/styles/mediabox';
		echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen,projection\" href=\"$boxstyle/Light.css\" />\n";
		
ob_start(); ?>

<!-- Easy Media Gallery Lite START (version <?php echo EASYMEDIA_VERSION; ?>)-->       
    
    <script type="text/javascript">
	/*<![CDATA[*/
	/* Easy Media Gallery */
    jQuery(document).ready(function($) {	
		var add = "easymedia";
jQuery('.da-thumbs a[rel!="easymedia"]').attr('rel', function (i, old) {
    return old ? old + ' ' + add : add; });		
    });
    /*]]>*/</script>

    <!--[if lt IE 9]>
<script src="<?php echo plugins_url( 'js/func/html5.js' , __FILE__ );  ?>" type="text/javascript"></script>
<![endif]-->  


<!-- Easy Media Gallery Lite  END  -->   
    
	<?php echo ob_get_clean();		
}
add_action( 'wp_head', 'easymedia_frontend_prop' );

?>