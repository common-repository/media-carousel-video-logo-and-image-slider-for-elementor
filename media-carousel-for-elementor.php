<?php
/**
 Plugin Name: Media Carousel - Video, Logo and Image Slider for Elementor
 Description: Media Carousel for Elementor lets you add Image, Logo, Video with Elementor Page Builder. 
 Author: Plugin Devs
 Author URI: https://plugin-devs.com/
 Plugin URI: https://plugin-devs.com/product/media-carousel-slider-for-elementor/
 Version: 0.9.5
 License: GPLv2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Domain Path: languages
 Text Domain: media-carousel-for-elementor
 */

// Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) { exit; }

 /**
  * Main class for Media Carousel
  */
class WB_MC
 {
 	
 	private static $instance;

	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new WB_MC();
            self::$instance->init();
        }
        return self::$instance;
    }

    //Empty Construct
 	function __construct(){}
 	
 	//initialize Plugin
 	public function init(){
 		$this->defined_constants();
 		$this->include_files();
		add_action( 'elementor/init', array( $this, 'wb_create_category') ); // Add a custom category for panel widgets
 	}

 	//Defined all constants for the plugin
 	public function defined_constants(){
 		define( 'WB_MC_PATH', plugin_dir_path( __FILE__ ) );
		define( 'WB_MC_URL', plugin_dir_url( __FILE__ ) ) ;
		define( 'WB_MC_VERSION', '0.9.5' ) ; //Plugin Version
		define( 'WB_MC_MIN_ELEMENTOR_VERSION', '2.0.0' ) ; //MINIMUM ELEMENTOR Plugin Version
		define( 'WB_MC_MIN_PHP_VERSION', '5.4' ) ; //MINIMUM PHP Plugin Version
		define( 'WB_MC_PRO_LINK', 'https://plugin-devs.com/product/media-carousel-slider-for-elementor/' ) ; //Pro Link
 	}

 	//Include all files
 	public function include_files(){

 		require_once( WB_MC_PATH . 'functions.php' );
 		require_once( WB_MC_PATH . 'admin/media-carousel-utils.php' );
 		if( is_admin() ){
 			require_once( WB_MC_PATH . 'admin/admin-pages.php' );	
 			require_once( WB_MC_PATH . 'class-plugin-deactivate-feedback.php' );	
 			require_once( WB_MC_PATH . 'support-page/class-support-page.php' );	
 		}
 		//require_once( WB_MC_PATH . 'admin/notices/support.php' );
 	}

 	//Elementor new category register method
 	public function wb_create_category() {
	   \Elementor\Plugin::$instance->elements_manager->add_category( 
		   	'web-builder-element',
		   	[
		   		'title' => esc_html( 'Web Builders Element', 'news-ticker-for-elementor' ),
		   		'icon' => 'fa fa-plug', //default icon
		   	],
		   	2 // position
	   );
	}

 }

function wb_media_carousel_register_function(){
	$wb_media_carousel = WB_MC::getInstance();
	if( is_admin() ){
		$wb_mc_feedback = new WB_MC_Usage_Feedback(
			__FILE__,
			'webbuilders03@gmail.com',
			false,
			true
		);
	}
}
add_action('plugins_loaded', 'wb_media_carousel_register_function');


add_action('wp_footer', 'wb_mc_display_custom_css');
function wb_mc_display_custom_css(){
	$custom_css = get_option( 'wb_mc_custom_css' );
	$css ='';
	if ( ! empty( $custom_css ) ) {
		$css .= '<style type="text/css">';
		$css .= '/* Custom CSS */' . "\n";
		$css .= $custom_css . "\n";
		$css .= '</style>';
	}
	echo $css;
}

add_action('wp_footer', 'wb_mc_display_custom_js');
function wb_mc_display_custom_js(){
	$custom_js = get_option( 'wb_mc_custom_js' );
	$js ='';
	if ( ! empty( $custom_js ) ) {
		$js .= '<script>';
		$js .= '/* Custom JS */' . "\n";
		$js .= $custom_js . "\n";
		$js .= '</script>';
	}
	echo $js;
}

/**
 * Submenu filter function. Tested with Wordpress 4.1.1
 * Sort and order submenu positions to match your custom order.
 *
 */
function wb_mc_order_submenu( $menu_ord ) {

  global $submenu;

  // Enable the next line to see a specific menu and it's order positions
  //echo '<pre>'; print_r( $submenu['wbel-media-carousel'] ); echo '</pre>'; exit();

  $arr = array();

  $arr[] = $submenu['wbel-media-carousel'][1];
  $arr[] = $submenu['wbel-media-carousel'][2];
  $arr[] = $submenu['wbel-media-carousel'][5];
  $arr[] = $submenu['wbel-media-carousel'][4];

  $submenu['wbel-media-carousel'] = $arr;

  return $menu_ord;

}

// add the filter to wordpress
add_filter( 'custom_menu_order', 'wb_mc_order_submenu' );
