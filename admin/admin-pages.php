<?php
add_action('admin_menu', 'wb_mc_menu_page');
function wb_mc_menu_page(){
	global $submenu;
	add_menu_page(
		'Media Carousel Slider for Elementor',
		'Media Carousel Slider for Elementor',
		'manage_options',
		'wbel-media-carousel',
		'wbel_mc_callback',
		'dashicons-image-flip-horizontal',
		'59'
	);

	add_submenu_page(
		'wbel-media-carousel',
		'Custom CSS',
		'Custom CSS',
		'manage_options',
		'wbel-mc-custom-css',
		'wbel_mc_css_callback' 
	);

	add_submenu_page(
		'wbel-media-carousel',
		'Custom JS',
		'Custom JS',
		'manage_options',
		'wbel-mc-custom-js',
		'wbel_mc_js_callback' 
	);

	$link_text = '<span class="wb_mc-up-pro-link" style="font-weight: bold; color: #FCB214">Upgrade To Pro</span>';
			
	$submenu["wbel-media-carousel"][4] = array( $link_text, 'manage_options' , WB_MC_PRO_LINK );
	
	return $submenu;
}

function wbel_mc_callback(){}
function wbel_mc_css_callback(){
	 // The default message that will appear
    $custom_css_default = __( '/*
Welcome to the Custom CSS editor!

Please add all your custom CSS here and avoid modifying the core plugin files. Don\'t use <style> tag
*/');
	    $custom_css = get_option( 'wb_mc_custom_css', $custom_css_default );
?>
	    <div class="wrap">
	        <div id="icon-themes" class="icon32"></div>
	        <h2><?php _e( 'Custom CSS' ); ?></h2>
	        <?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Custom CSS updated.' ) . '</strong></p></div>'; ?>
	 
	        <form id="custom_css_form" method="post" action="options.php" style="margin-top: 15px;">
	 
	            <?php settings_fields( 'wb_mc_custom_css' ); ?>
	 
	            <div id="custom_css_container">
	                <div name="wb_mc_custom_css" id="wb_mc_custom_css" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div>
	            </div>
	 
	            <textarea id="custom_css_textarea" name="wb_mc_custom_css" style="display: none;"><?php echo $custom_css; ?></textarea>
	            <p><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" /></p>
	        </form>
	    </div>
<?php
}

function wbel_mc_js_callback(){
	// The default message that will appear
    $custom_js_default = __( '/*
Welcome to the Custom JS editor!

Please add all your custom JS here and avoid modifying the core plugin files. Don\'t use <script> tag
*/');
	    $custom_js = get_option( 'wb_mc_custom_js', $custom_js_default );
?>
	    <div class="wrap">
	        <div id="icon-themes" class="icon32"></div>
	        <h2><?php _e( 'Custom JS' ); ?></h2>
	        <?php if ( ! empty( $_GET['settings-updated'] ) ) echo '<div id="message" class="updated"><p><strong>' . __( 'Custom JS updated.' ) . '</strong></p></div>'; ?>
	 
	        <form id="custom_js_form" method="post" onsubmit="return false;" action="#" style="margin-top: 15px;">
	 
	            <?php settings_fields( 'wb_mc_custom_js' ); ?>
	 
	            <div id="custom_css_container">
	                <div name="wb_mc_custom_js" id="wb_mc_custom_js" style="border: 1px solid #DFDFDF; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; width: 100%; height: 400px; position: relative;"></div>
	            </div>
	 
	            <textarea id="custom_js_textarea" name="wb_mc_custom_js" style="display: none;"><?php echo $custom_js; ?></textarea>
	            <p><input type="submit" class="button-primary disabled" value="<?php _e( 'Save Changes' ) ?>" /><a href="<?php echo WB_MC_PRO_LINK; ?>" target="_blank" class="button" style="background: #FCB214; color: #fff;font-weight: 700; margin-left: 10px">Upgrade to Pro</a></p>
	        </form>
	    </div>
<?php
}

add_action( 'admin_enqueue_scripts', 'wb_mc_custom_css_js_scripts' );
function wb_mc_custom_css_js_scripts( $hook ) {

	wp_enqueue_script( 'wb_mc_admin_js', WB_MC_URL . 'admin/assets/js/admin.js', array( 'jquery' ), '1.0.0', true );

    if ( ('media-carousel-slider-for-elementor_page_wbel-mc-custom-css' == $hook) || ('media-carousel-slider-for-elementor_page_wbel-mc-custom-js' == $hook) ) {
        wp_enqueue_script( 'ace_code_highlighter_js', WB_MC_URL . 'assets/ace/js/ace.js', '', '1.0.0', true );
        wp_enqueue_script( 'ace_mode_css', WB_MC_URL . 'assets/ace/js/mode-css.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
        wp_enqueue_script( 'ace_mode_js', WB_MC_URL . 'assets/ace/js/mode-javascript.js', array( 'ace_code_highlighter_js' ), '1.0.0', true );
        wp_enqueue_script( 'custom_css_js', WB_MC_URL . 'assets/ace/ace-include.js', array( 'jquery', 'ace_code_highlighter_js' ), '1.0.0', true );
    }
}

add_action( 'admin_init', 'wb_mc_register_custom_css_setting' ); 
function wb_mc_register_custom_css_setting() {
    register_setting( 'wb_mc_custom_css', 'wb_mc_custom_css',  'wb_mc_custom_css_validation');
}

function wb_mc_custom_css_validation( $input ) {
    if ( ! empty( $input['wb_mc_custom_css'] ) )
        $input['wb_mc_custom_css'] = trim( $input['wb_mc_custom_css'] );
    return $input;
}


