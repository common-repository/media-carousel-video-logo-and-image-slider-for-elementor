<?php
namespace WB_MC;
use WB_MC\MEDIA_CAROUSEL;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Do all addon related works
 */
final class WB_MC_UTILS {
	public function __construct(){
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, WB_MC_MIN_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, WB_MC_MIN_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Enqueue Styles
		add_action( 'admin_enqueue_scripts',  [ $this, 'admin_scripts_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'enqueue_styles' ] );

		// Enqueue Scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'enqueue_scripts' ] );

		// Register widget
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

	}

	/**
	 * Admin Notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ){
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			esc_html( '"%1$s" requires "%2$s" to be installed and activated.', 'media-carousel-for-elementor' ),
			'<strong>' . esc_html( 'Media Carousel for Elementor', 'media-carousel-for-elementor' ) . '</strong>',
			'<strong>' . esc_html( 'Elementor', 'media-carousel-for-elementor' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ){
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html( '"%1$s" requires "%2$s" version %3$s or greater.', 'media-carousel-for-elementor' ),
			'<strong>' . esc_html( 'Media Carousel for Elementor', 'media-carousel-for-elementor' ) . '</strong>',
			'<strong>' . esc_html( 'Elementor', 'media-carousel-for-elementor' ) . '</strong>',
			 WB_MC_MIN_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ){
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html( '"%1$s" requires "%2$s" version %3$s or greater.', 'media-carousel-for-elementor' ),
			'<strong>' . esc_html( 'Media Carousel for Elementor', 'media-carousel-for-elementor' ) . '</strong>',
			'<strong>' . esc_html( 'PHP', 'media-carousel-for-elementor' ) . '</strong>',
			 WB_MC_MIN_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Enqueue Styles
	 * 
	 * Load all required stylesheets
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function enqueue_styles(){

		wp_enqueue_style( 'wb-mc-style', WB_MC_URL . '/assets/css/style.css', array(), '1.0.0', 'all' );
	}

	/**
	 * Enqueue Admin Styles and Scripts
	 * 
	 * Load Admin stylesheets and scripts
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_scripts_styles(){

		wp_enqueue_style( 'wb-mc-admin-style', WB_MC_URL . 'admin/assets/css/admin.css', array(), '1.0.0', 'all' );
		
		wp_enqueue_script( 'wb-mc-admin-script', WB_MC_URL . 'admin/assets/js/admin.js', array('jquery'), '1.0.0', 'all' );

		wp_localize_script( 'wb-mc-admin-script', 'wb_mc_ajax_object',
            array(
            	'ajax_url' => admin_url( 'admin-ajax.php' ),
            ) 
        );
	}

	/**
	 * Enqueue Scripts
	 * 
	 * Load all required scripts
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function enqueue_scripts(){

		//Register FontAwesome for fallback
		wp_register_style(
            'font-awesome-5-all',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/all.min.css',
            false,
            '1.0.0'
        );

        wp_register_style(
            'font-awesome-4-shim',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/css/v4-shims.min.css',
            false,
            '1.0.0'
        );

        wp_register_script(
            'font-awesome-4-shim',
            ELEMENTOR_ASSETS_URL . 'lib/font-awesome/js/v4-shims.min.js',
            false,
            '1.0.0'
        );

		wp_enqueue_script( 'wb-mc-main', WB_MC_URL . 'assets/js/main.js', array(), '1.0.0', true );
	}

	/**
	 * Register Widget
	 * 
	 * Register Elementor Before After Image Comparison Slider From Here
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function register_widgets() {
		$this->includes();
		$this->register_slider_widgets();
	}

	/**
	 * Include Files
	 *
	 * Load widgets php files.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function includes() {

		require_once( WB_MC_PATH . '/widgets/media-carousel.php' );

	}

	/**
	 * Register Media Carousel Widget
	 *
	 * Register the Media Carousel Widget from here
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function register_slider_widgets() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new MEDIA_CAROUSEL\WB_MC_WIDGET() );
	}
}

new WB_MC_UTILS();