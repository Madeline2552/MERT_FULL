<?php
/**
 * Weclome Page Class
 *
 * @package     EMG
 * @since       1.3.29
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * EMG_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.3.29
 */
class EMG_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @since 1.3.29
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'emg_admin_menus') );
		add_action( 'admin_head', array( $this, 'emg_admin_head' ) );
		add_action( 'admin_init', array( $this, 'emg_welcome_page' ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_admin_menus() {

			// What's New / Overview
    		add_submenu_page('edit.php?post_type=easymediagallery', 'What\'s New', 'What\'s New<span class="emg-menu-blink">NEW</span>', $this->minimum_capability, 'emg-whats-new', array( $this, 'emg_about_screen') );
			
			// Changelog Page
    		add_submenu_page('edit.php?post_type=easymediagallery', EASYMEDIA_NAME.' Changelog', EASYMEDIA_NAME.' Changelog', $this->minimum_capability, 'emg-changelog', array( $this, 'emg_changelog_screen') );
			
			// Getting Started Page
    		add_submenu_page('edit.php?post_type=easymediagallery', 'Getting started with '.EASYMEDIA_NAME.'', 'Getting started with '.EASYMEDIA_NAME.'', $this->minimum_capability, 'emg-getting-started', array( $this, 'emg_getting_started_screen') );
			
			// Free Plugins Page
    		add_submenu_page('edit.php?post_type=easymediagallery', 'Free Install Plugins', 'Free Install Plugins', $this->minimum_capability, 'emg-free-plugins', array( $this, 'free_plugins_screen') );
			
			// Premium Plugins Page
    		add_submenu_page('edit.php?post_type=easymediagallery', 'Premium Plugins', 'Premium Plugins', $this->minimum_capability, 'emg-premium-plugins', array( $this, 'premium_plugins_screen') );
			
			// Addons Page
    		//add_submenu_page('edit.php?post_type=easymediagallery', 'Addons', 'Addons', $this->minimum_capability, 'emg-addons', array( $this, 'addons_plugins_screen') );
						
			// Demo Page
    		add_submenu_page('edit.php?post_type=easymediagallery', 'Demo', 'Demo', $this->minimum_capability, 'emg-demo', array( $this, 'demo_plugins_screen') );
			
			// Earn EXTRA
    		add_submenu_page('edit.php?post_type=easymediagallery', 'Earn EXTRA MONEY', 'Earn EXTRA MONEY', $this->minimum_capability, 'emg-earn-xtra-money', array( $this, 'emg_affiliate_plugins_screen') );
			
				
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_admin_head() {
		remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-changelog' );
		remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-getting-started' );
		remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-addons' );
		//remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-demo' );
		remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-earn-xtra-money' );
		//remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-free-plugins' );
		remove_submenu_page( 'edit.php?post_type=easymediagallery', 'emg-premium-plugins' );
		
		// Badge for welcome page
		$badge_url = EASYMEDG_PLUGIN_URL . 'css/images/assets/emg-logo.png';
		?>
        
        <script type="text/javascript">
        
				jQuery(document).ready(function($) {
					
					if ( $( '.emgtabs' ).length ) {	
				
					var emgTabsPos = $('.emgtabs').offset();
				
					$(window).scroll(function(){
						
						if($(window).scrollTop() > emgTabsPos.top) {
							
							$('.emgtabs').addClass('emgtabfixed');
							
							}
							
							else {
								
								$('.emgtabs').removeClass('emgtabfixed');
								
								}
								
						});	
					
					}
					
				});
                
         </script>       
        
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		
		.emg-container-cnt .feature-section p {
			max-width: 100% !important;	
		}
		
		.emg-badge {
			padding-top: 150px;
			height: 128px;
			width: 128px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .emg-badge {
			position: absolute;
			top: 0;
			right: 0;
		}
		
		.emgtabs{
			width:auto;
			height:50px;
			padding:10px;
			margin-top: 50px;
			}
		
		.emgtabfixed {
			position: fixed;
			-webkit-box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			box-shadow: 0px 0px 17px -4px rgba(0,0,0,0.75);
			background:#EAEAEA;
			z-index: 999;
			margin: 0px auto;
			width: 100%;
			/* max-width: 1050px; */
			left: 0px;
			top: 0px;
			padding-left: 210px;
			padding-top: 32px;
			box-sizing: content-box;
			
			-webkit-animation: fadein 1s; /* Safari, Chrome and Opera > 12.1 */
			-moz-animation: fadein 1s; /* Firefox < 16 */
        	-ms-animation: fadein 1s; /* Internet Explorer */
         	-o-animation: fadein 1s; /* Opera < 12.1 */
            animation: fadein 1s;
			
			}
			
			@keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Firefox < 16 */
			@-moz-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Safari, Chrome and Opera > 12.1 */
			@-webkit-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Internet Explorer */
			@-ms-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}

			/* Opera < 12.1 */
			@-o-keyframes fadein {
    			from { opacity: 0; }
    			to   { opacity: 1; }
			}
			
		.emgtabfixed h2 {
			border-bottom : 1px dashed #DADADA !important;
		}
		
		.emg-menu-blink {
			
			padding:0px 6px 0px 6px;
			background-color: #E74C3C;
			border-radius:9px;
			-moz-border-radius:9px;
			-webkit-border-radius:9px;
			margin-left:5px;
			color:#fff;
			font-size:10px !important;
    		outline:none;
    		text-decoration: none;
		}
		
		.emgwpage a:focus {box-shadow: none !important; }

		.emg-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}

		.about-wrap .feature-section {
			margin-top: 20px;
		}
		
		
		.about-wrap .feature-section .plugin-card h4 {
    		margin: 0px 0px 12px;
    		font-size: 18px;
    		line-height: 1.3;
		}
		
		.about-wrap .feature-section .plugin-card-top p {
    		font-size: 13px;
    		line-height: 1.5;
    		margin: 1em 0px;
		}	
				
		.about-wrap .feature-section .plugin-card-bottom {
    		font-size: 13px;
		}	
		
		.customh3 {

		}
		
		
		.customh4 {
			display:inline-block;
			border-bottom: 1px dashed #CCC;
		}
		
		
		.emg-dollar {
		
		background: url('<?php echo EASYMEDG_PLUGIN_URL . 'includes/images/aff-dollar.png'; ?>') no-repeat;
		color: #2984E0;
			
		}
		
		.emg-affiliate-screenshots {
			-webkit-box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			-moz-box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			box-shadow: -3px 1px 15px -4px rgba(0,0,0,0.75);
			float: right;
			margin: 20px 0 30px 30px !important;
		}
		
		
		.button_loading {
    		background: url('<?php echo EASYMEDG_PLUGIN_URL . 'includes/images/gen-loader.gif'; ?>') no-repeat 50% 50%;
    		/* apply other styles to "loading" buttons */
			display:inline-block;
			position:relative;
			width: 16px;
			height: 16px;
			top: 17px;
			margin-left: 10px;
			}
			
		.emg-aff-note {
			color:#F00;
			font-size:12px;
			font-style:italic;
		}
		
		

		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Navigation tabs
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_tabs() {
		$selected = isset( $_GET['page'] ) ? $_GET['page'] : 'emg-whats-new';
		?>
        
        <div class="emgtabs">
        
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php echo $selected == 'emg-whats-new' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-whats-new' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( 'What\'s New', 'easy-media-gallery' ); ?>
			</a>
			<a class="nav-tab <?php echo $selected == 'emg-getting-started' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-getting-started' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( 'Getting Started', 'easy-media-gallery' ); ?>
			</a>
            
			<!--<a class="nav-tab <?php //echo $selected == 'emg-addons' ? 'nav-tab-active' : ''; ?>" href="<?php //echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-addons' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php //_e( 'Addons', 'easy-media-gallery' ); ?>
			</a>-->
            
			<a class="nav-tab <?php echo $selected == 'emg-free-plugins' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-free-plugins' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( 'Free Plugins', 'easy-media-gallery' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'emg-premium-plugins' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-premium-plugins' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( 'Premium Plugins', 'easy-media-gallery' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'emg-demo' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-demo' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( 'Demo', 'easy-media-gallery' ); ?>
			</a>
            
			<a class="nav-tab <?php echo $selected == 'emg-earn-xtra-money' ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-earn-xtra-money' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>">
				<?php _e( '<span class="emg-dollar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Extra Money</span>', 'easy-media-gallery' ); ?>
			</a>
            
		</h2>
        
       </div>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_about_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>
            
            <?php emg_lite_get_news();  ?>

			<div class="emg-container-cnt">
				<h3 class="customh3"><?php _e( 'New Welcome Page', 'easy-media-gallery' );?></h3>

				<div class="feature-section">

					<p><?php _e( 'Version 1.3.29 introduces a comprehensive welcome page interface. The easy way to get important informations about this product and other related plugins.', 'easy-media-gallery' );?></p>
                    
					<p><?php _e( 'In this page, you will find four important Tabs named What\'s New, Getting Started, Addons, Free Plugins, Premium Plugins and Demo.', 'easy-media-gallery' );?></p>

				</div>
			</div>

			<div class="emg-container-cnt">
				<h3 class="customh3"><?php _e( 'ADDONS', 'easy-media-gallery' );?></h3>

				<div class="feature-section">

					<p><?php _e( 'Need some Pro version features to be applied in your Free version? What you have to do just go to <strong>Addons</strong> page and choose any Addons that you want to install. All listed addons are Premium version.', 'easy-media-gallery' );?></p>

				</div>
			</div>

			<div class="emg-container-cnt">
				<h3><?php _e( 'Additional Updates', 'easy-media-gallery' );?></h3>

				<div class="feature-section col three-col">
                
					<div>

						<h4><?php _e( 'Language Packs Update', 'easy-media-gallery' );?></h4>
						<p><?php _e( 'We\'ve improved Language Packs to compatible with <a href="https://translate.wordpress.org/projects/wp-plugins/easy-media-gallery" target="_blank">translate.wordpress.org</a> translation system', 'easy-media-gallery' );?></p>

					</div>
                
					<div>

						<h4><?php _e( 'CSS Clean and Optimization', 'easy-media-gallery' );?></h4>
						<p><?php _e( 'We\'ve improved some css class to make your gallery for look fancy and better.', 'easy-media-gallery' );?></p>

					</div>

					<div>

						<h4><?php _e( 'Disable Notifications', 'easy-media-gallery' );?></h4>
						<p><?php _e( 'In this version you will no longer see some annoying notifications in top of gallery editor page. Thanks for who suggested it.' ,'easy-media-gallery' );?></p>
                        
					</div>

					<div class="last-feature">

						<h4><?php _e( 'Improved Some Core Function', 'easy-media-gallery' );?></h4>
						<p><?php _e( ' Some functions has been improved to be more robust and fast so you can generate your gallery/albums only in seconds.', 'easy-media-gallery' );?></p>

					</div>

				</div>
			</div>

			<div class="return-to-dashboard">&middot;<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'emg-changelog' ), 'edit.php?post_type=easymediagallery' ) ) ); ?>"><?php _e( 'View the Full Changelog', 'easy-media-gallery' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Changelog Screen
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_changelog_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage">
			<h1><?php _e( EASYMEDIA_NAME. ' Changelog', 'easy-media-gallery' ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">
				<h3><?php _e( 'Full Changelog', 'easy-media-gallery' );?></h3>
				<div>
					<?php echo $this->emg_parse_readme(); ?>
				</div>
			</div>

		</div>
		<?php
	}

	/**
	 * Render Getting Started Screen
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_getting_started_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<p class="about-description"><?php _e( 'There are no complicated instructions for using Easy Media Gallery because this plugin designed to make all easy. Please watch the following video and we believe that you will easily to understand it just in minutes :', 'easy-media-gallery' ); ?></p>

			<div class="emg-container-cnt">
				<div class="feature-section">
                	<h3 style="font-style:italic;"><?php _e( 'How to Create Simple Photo Albums', 'easy-media-gallery' );?></h3>
                <div style="padding:3px; border: solid 1px rgb(198, 198, 198); max-width:853px;"><iframe width="853" height="480" src="https://www.youtube.com/embed/pjHvRoV2Bn8?rel=0" frameborder="0" allowfullscreen></iframe></div><br />
                	<h3 style="font-style:italic;"><?php _e( 'How to Create Simple Gallery', 'easy-media-gallery' );?></h3>
               <div style="padding:1px; border: solid 1px rgb(198, 198, 198); max-width:853px;"><iframe width="853" height="480" src="https://www.youtube.com/embed/H1Z3fidyEbE?rel=0" frameborder="0" allowfullscreen></iframe></div>
                <h4><?php _e( 'Video Tutorials on Youtube Channel', 'easy-media-gallery' );?></h4>
                You can learn more by watching the video from <a href="https://www.youtube.com/GhozyLab" target="_blank">Youtube Channel</a>
			</div>
            <hr />
            </div>

			<div class="emg-container-cnt">
				<h3><?php _e( 'Need Help?', 'easy-media-gallery' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Phenomenal Support','easy-media-gallery' );?></h4>
					<p><?php _e( 'We do our best to provide the best support we can. If you encounter a problem or have a question, post a question in the <a href="https://wordpress.org/support/plugin/easy-media-gallery" target="_blank">support forums</a>.', 'easy-media-gallery' );?></p>
					<h4><?php _e( 'Need Even Faster Support?', 'easy-media-gallery' );?></h4>
					<p><?php _e( 'Just upgrade to <a target="_blank" href="https://ghozy.link/eqiz9">Pro version</a> and you will get Priority Support are there for customers that need faster and/or more in-depth assistance.', 'easy-media-gallery' );?></p>

				</div>
			</div>

			<div class="emg-container-cnt">
				<h3><?php _e( 'Stay Up to Date', 'easy-media-gallery' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Get Notified of Addons Releases','easy-media-gallery' );?></h4>
					<p><?php _e( 'New Addons that make '.EASYMEDIA_NAME.' even more powerful are released nearly every single week. Subscribe to the newsletter to stay up to date with our latest releases. <a target="_blank" href="http://eepurl.com/bq3RcP" target="_blank">Signup now</a> to ensure you do not miss a release!', 'easy-media-gallery' );?></p>

				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render Free Plugins
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function free_plugins_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">

				<div class="feature-section">
					<?php echo emg_free_plugin_page(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	/**
	 * Render Premium Plugins
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function premium_plugins_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage" id="ghozy-featured">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">
			<p style="margin-bottom:50px;"class="about-description"></p>

				<div class="feature-section">
					<?php echo emg_premium_plugins(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render Addons Page
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function addons_plugins_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage" id="ghozy-addons">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">
			<p style="margin-bottom:50px;"class="about-description"></p>

				<div class="feature-section">
					<?php echo emg_lite_get_addons_feed(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	/**
	 * Render Affiliate Page
	 *
	 * @access public
	 * @since 1.3.77
	 * @return void
	 */
	public function emg_affiliate_plugins_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage" id="ghozy-featured">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">
			<p style="margin-bottom:25px;"class="about-description"></p>

				<div class="feature-section">
					<?php echo emg_earn_xtra_money(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	
	/**
	 * Render DEMO Page
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function demo_plugins_screen() {
		list( $display_version ) = explode( '-', EASYMEDIA_VERSION );
		?>
		<div class="wrap about-wrap emgwpage" id="ghozy-demo">
			<h1><?php printf( __( 'Welcome to '.EASYMEDIA_NAME.'', 'easy-media-gallery' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for installing '.EASYMEDIA_NAME.'. This plugin is ready to make your gallery more fancy and better!', 'easy-media-gallery' ), $display_version ); ?></div>
			<div class="emg-badge"><?php printf( __( 'Version %s', 'easy-media-gallery' ), $display_version ); ?></div>

			<?php $this->emg_tabs(); ?>

			<div class="emg-container-cnt">
			<p class="about-description"></p>

				<div class="feature-section">
                
        <h3><?php _e('DEMO ( Video )', 'easy-media-gallery'); ?></h2>
        <p><?php _e('This plugin comes with instructional training videos that walk you through every aspect of setting up your new media gallery. We recommend to following these videos to create new media. This user manual is only intended to be a reference guide.', 'easy-media-gallery'); ?></p>
                
                
					<?php echo easmedia_demo_page(); ?>
				</div>
			</div>

		</div>
		<?php
	}
	
	
	

	/**
	 * Parse the EMG readme.txt file
	 *
	 * @since 1.3.29
	 * @return string $readme HTML formatted readme file
	 */
	public function emg_parse_readme() {
		$file = file_exists( EMG_DIR_CL . 'readme.txt' ) ? EMG_DIR_CL . 'readme.txt' : null;

		if ( ! $file ) {
			$readme = '<p>' . __( 'No valid changelog was found.', 'easy-media-gallery' ) . '</p>';
		} else {
			$readme = file_get_contents( $file );
			$readme = nl2br( esc_html( $readme ) );
			$readme = explode( '== Changelog ==', $readme );
			$readme = end( $readme );

			$readme = preg_replace( '/`(.*?)`/', '<code>\\1</code>', $readme );
			$readme = preg_replace( '/[\040]\*\*(.*?)\*\*/', ' <strong>\\1</strong>', $readme );
			$readme = preg_replace( '/[\040]\*(.*?)\*/', ' <em>\\1</em>', $readme );
			$readme = preg_replace( '/= (.*?) =/', '<h4>Version: \\1</h4>', $readme );
			$readme = preg_replace( '/\[(.*?)\]\((.*?)\)/', '<a href="\\2">\\1</a>', $readme );
			$readme = str_replace("*","<span class='dashicons dashicons-arrow-right'></span>", $readme );
		}

		return $readme;
	}

	/**
	 * Sends user to the Welcome page on first activation of EMG as well as each
	 * time EMG is upgraded to a new version
	 *
	 * @access public
	 * @since 1.3.29
	 * @return void
	 */
	public function emg_welcome_page() {	
		
    if ( is_admin() && get_option( 'Activated_Emg_Plugin' ) == 'emg-activate' && !is_network_admin() ) {
		
		$emg_optval = get_option( 'easy_media_opt' );
		
		if ( !is_array( $emg_optval ) ) update_option( 'easy_media_opt', array() );		
		
		$tmp = get_option( 'easy_media_opt' );
		if ( isset( $tmp['easymedia_deff_init'] ) != '1' ) {
			
			easymedia_1st_config();
			
			}
		
		delete_option( 'Activated_Emg_Plugin' );
		
		wp_safe_redirect( admin_url( 'edit.php?post_type=easymediagallery&page=emg-free-plugins' ) ); exit;
		
    	}

	}
}
new EMG_Welcome();
