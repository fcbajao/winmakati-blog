<?php
/*
Plugin Name: iiRe Social Icons 
Plugin URI: http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/
Description: Add social media icons and links you your site with a customizable user interface. Majority of social networks are supported!
Author: iiRe Productions
Author URI: http://iireproductions.com/
Version: 0.20
Tags: Social Media, Icons, Facebook, Google, Instagram, Linked In, Pinterest, Skype, Twitter, YouTube
Copyright (C) 2012 iiRe Productions
*/
	
// ASSIGN VERSION
global $wpdb, $iire_social_version;
$iire_version = "0.20";
$last_modified = "10-20-2012";
	
define ('IIRE_SOCIAL_FILE', __FILE__);
define ('IIRE_SOCIAL_BASENAME', plugin_basename(__FILE__));
define ('IIRE_SOCIAL_PATH', trailingslashit(dirname(__FILE__)));
define ('IIRE_SOCIAL_URL', trailingslashit(WP_PLUGIN_URL) . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)));
if ( !defined( 'WP_PLUGIN_DIR' ) )
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );


// INSTALL / UPGRADE
require_once("iire_social_install.php");
register_activation_hook(__FILE__,'iire_social_install');

// UNINSTALL
require_once("uninstall.php");
if ( function_exists('iire_social_uninstall') )
register_uninstall_hook(__FILE__,'iire_social_uninstall');

// INCLUDES
require_once("includes/iire_social_widget.php");

// ADMIN
require_once("includes/admin_iire_social_hooks.php");
require_once("includes/admin_iire_social_home.php");
require_once("includes/admin_iire_social_widget.php");
require_once("includes/admin_iire_social_shortcode.php");

// HEADER
function iire_social_head() {
	if (! is_admin()) {
	
		global $wpdb;
		global $blog_id;

		$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";

		// GET SETTINGS
		$settings = array();		
		$rs = $wpdb->get_results("SELECT * FROM $table_name");
		foreach ($rs as $row) {
			$settings[$row->option_name] = $row->option_value;
		}

		// Widget Cache
		$cache = $settings['css_cache'];
	
		// Widget Container Width
		$wid = $settings['widget_width'];

		// Widget Container Height 
		$hgt = $settings['widget_height'];		
	
		// Widget Container Orientation
		$ot = $settings['widget_orientation'];

		// Widget Container Orientation
		$align = $settings['widget_align'];		

		// Widget Container Padding
		if ($settings['widget_pad_top'] != '0' || $settings['widget_pad_right'] != '0' || $settings['widget_pad_bottom'] != '0' || $settings['widget_pad_left'] != '0') {		
			$pad = $settings['widget_pad_top'].','.$settings['widget_pad_right'].','.$settings['widget_pad_bottom'].','.$settings['widget_pad_left'];
		} else {
			$pad = '';			
		}	
		
		// Widget Container Margin
		if ($settings['widget_margin_top'] != '0' || $settings['widget_margin_right'] != '0' || $settings['widget_margin_bottom'] != '0' || $settings['widget_margin_left'] != '0') {			
			$mar = $settings['widget_margin_top'].','.$settings['widget_margin_right'].','.$settings['widget_margin_bottom'].','.$settings['widget_margin_left'];
		} else {
			$mar = '';			
		}	

		// Add Widget Background?
		$wbk = $settings['widget_background'];
			
		// Widget Container Background Color
		if ( $settings['widget_bg_color'] == '') {		
			$wbgc = '';
		} else {
			$wbgc= $settings['widget_bg_color'];			
		}	

		// Widget Container Border		
		if ( $settings['widget_border_size'] != '0') {
			$wbrc = $settings['widget_border_color'];
			$wbrs = $settings['widget_border_size'];		
		} else {
			$wbrc = '';
			$wbrs = '';					
		}		

		// Widget Icon Theme
		$th = $settings['widget_icon_theme'];

		// Widget Icon Size
		$sz = $settings['widget_icon_size'];

		// Widget Icon Spacing	
		$sp = $settings['widget_icon_spacing'];

		// Widget Icon Dropshadow	
		$ds = $settings['widget_dropshadow'];
	
		$dshz = $settings['widget_dropshadow_horizontal_offset']; 		
		$dsvt = $settings['widget_dropshadow_vertical_offset']; 
		$dsblur = $settings['widget_dropshadow_blur']; 						
		$dscolor = $settings['widget_dropshadow_color']; 

		// Widget Icon Rounded Corners		
		$rc = $settings['widget_roundedcorners'];
		$rctl = $settings['widget_roundedcorners_topleft'];
		$rctr = $settings['widget_roundedcorners_topright']; 
		$rcbl = $settings['widget_roundedcorners_bottomleft']; 
		$rcbr = $settings['widget_roundedcorners_bottomright']; 		

		// Widget Icon Opacity
		$op = $settings['widget_icon_opacity'];	

		// Widget Icon Background Colors
		$bgc = $settings['widget_icon_bgcolor'];
		$bup = $settings['widget_icon_bgcolor_up'];
		$bov = $settings['widget_icon_bgcolor_hover']; 
	
		$w_styles = 'cache='.$cache.'&w='.$wid.'&h='.$hgt.'&a='.$align.'&o='.$ot.'&p='.$pad.'&m='.$mar.'&wbk='.$wbk.'&wbgc='.$wbgc.'&wbrc='.$wbrc.'&wbrs='.$wbrs.'&theme='.$th.'&sz='.$sz.'&sp='.$sp.'&ds='.$ds.'&dshz='.$dshz.'&dsvt='.$dsvt.'&dsblur='.$dsblur.'&dscolor='.$dscolor.'&rc='.$rc.'&rctl='.$rctl.'&rctr='.$rctr.'&rcbl='.$rcbl.'&rcbr='.$rcbr.'&op='.$op.'&bgc='.$bgc.'&bup='.$bup.'&bov='.$bov.'&pluginurl='.IIRE_SOCIAL_URL;
		//echo $w_styles;


		// Shortcode Container Width
		$s_wid = $settings['sc_width'];

		// Shortcode Container Height 
		$s_hgt = $settings['sc_height'];		
	
		// Shortcode Container Orientation
		$s_ot = $settings['sc_orientation'];

		// Shortcode Container Orientation
		$s_align = $settings['sc_align'];		

		// Shortcode Container Padding
		if ($settings['sc_pad_top'] != '0' || $settings['sc_pad_right'] != '0' || $settings['sc_pad_bottom'] != '0' || $settings['sc_pad_left'] != '0') {		
			$s_pad = $settings['sc_pad_top'].','.$settings['sc_pad_right'].','.$settings['sc_pad_bottom'].','.$settings['sc_pad_left'];
		} else {
			$s_pad = '';			
		}	
		
		// Shortcode Container Margin
		if ($settings['sc_margin_top'] != '0' || $settings['sc_margin_right'] != '0' || $settings['sc_margin_bottom'] != '0' || $settings['sc_margin_left'] != '0') {			
			$s_mar = $settings['sc_margin_top'].','.$settings['sc_margin_right'].','.$settings['sc_margin_bottom'].','.$settings['sc_margin_left'];
		} else {
			$s_mar = '';			
		}	

		// Add Shortcode Background?
		$s_wbk = $settings['sc_background'];
			
		// Shortcode Container Background Color
		if ( $settings['sc_bg_color'] == '') {		
			$s_wbgc = '';
		} else {
			$s_wbgc= $settings['sc_bg_color'];			
		}	

		// Shortcode Container Border		
		if ( $settings['sc_border_size'] != '0') {
			$s_wbrc = $settings['sc_border_color'];
			$s_wbrs = $settings['sc_border_size'];		
		} else {
			$s_wbrc = '';
			$s_wbrs = '';					
		}		

		// Shortcode Icon Theme
		$s_th = $settings['sc_icon_theme'];

		// Shortcode Icon Size
		$s_sz = $settings['sc_icon_size'];

		// Shortcode Icon Spacing	
		$s_sp = $settings['sc_icon_spacing'];

		// Shortcode Icon Dropshadow	
		$s_ds = $settings['sc_dropshadow'];
	
		$s_dshz = $settings['sc_dropshadow_horizontal_offset']; 		
		$s_dsvt = $settings['sc_dropshadow_vertical_offset']; 
		$s_dsblur = $settings['sc_dropshadow_blur']; 						
		$s_dscolor = $settings['sc_dropshadow_color']; 

		// Shortcode Icon Rounded Corners		
		$s_rc = $settings['sc_roundedcorners'];
		$s_rctl = $settings['sc_roundedcorners_topleft'];
		$s_rctr = $settings['sc_roundedcorners_topright']; 
		$s_rcbl = $settings['sc_roundedcorners_bottomleft']; 
		$s_rcbr = $settings['sc_roundedcorners_bottomright']; 		

		// Shortcode Icon Opacity
		$s_op = $settings['sc_icon_opacity'];	

		// Shortcode Icon Background Colors
		$s_bgc = $settings['sc_icon_bgcolor'];
		$s_bup = $settings['sc_icon_bgcolor_up'];
		$s_bov = $settings['sc_icon_bgcolor_hover']; 	
	
	
		$s_styles = 'cache='.$cache.'&w='.$s_wid.'&h='.$s_hgt.'&a='.$s_align.'&o='.$s_ot.'&p='.$s_pad.'&m='.$s_mar.'&wbk='.$s_wbk.'&wbgc='.$s_wbgc.'&wbrc='.$s_wbrc.'&wbrs='.$s_wbrs.'&theme='.$s_th.'&sz='.$s_sz.'&sp='.$s_sp.'&ds='.$s_ds.'&dshz='.$s_dshz.'&dsvt='.$s_dsvt.'&dsblur='.$s_dsblur.'&dscolor='.$s_dscolor.'&rc='.$s_rc.'&rctl='.$s_rctl.'&rctr='.$s_rctr.'&rcbl='.$s_rcbl.'&rcbr='.$s_rcbr.'&op='.$s_op.'&bgc='.$s_bgc.'&bup='.$s_bup.'&bov='.$s_bov.'&pluginurl='.IIRE_SOCIAL_URL;
		//echo $s_styles;		
		
		// Live Site		
		wp_enqueue_script( 'social-function', IIRE_SOCIAL_URL.'includes/iire_social_functions.js');
		wp_enqueue_style( 'iire-social-widget-styles', IIRE_SOCIAL_URL.'includes/iire_social_widget_styles.php?'.$w_styles);
		wp_enqueue_style( 'iire-social-shortcode-styles', IIRE_SOCIAL_URL.'includes/iire_social_shortcode_styles.php?'.$s_styles);
		wp_enqueue_style( 'iire-social-widget-sizes', IIRE_SOCIAL_URL.'includes/iire_social_icons'.$sz.'.css');					
		wp_enqueue_style( 'iire-social-shortcode-sizes', IIRE_SOCIAL_URL.'includes/iire_social_icons'.$s_sz.'.css');
	}		
}
add_action('wp_head', 'iire_social_head');


// FOOTER
function iire_social_footer() {
    if (! is_admin() ){
		// Live Site
		wp_enqueue_script( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js');	
		wp_enqueue_style( 'jquery-ui_css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

		global $wpdb;
		global $blog_id;

		$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
	
		// GET SETTINGS
		$settings = array();		
		$rs = $wpdb->get_results("SELECT * FROM $table_name");
		foreach ($rs as $row) {
			$settings[$row->option_name] = $row->option_value;
		}	

		echo '<div id="emaildialog" title="Send A Message" style="display:none;">';
		echo '<p><input type="text" id="email_name" name="email_name" onfocus="if(this.value==this.defaultValue) this.value=\'\';" onblur="if(this.value==\'\') this.value=this.defaultValue;" value="- Your Name -" class="text ui-widget-content ui-corner-all" /></p>';
		echo '<p><input type="text" id="email_sender" name="email_sender" onfocus="if(this.value==this.defaultValue) this.value=\'\';" onblur="if(this.value==\'\') this.value=this.defaultValue;" value="- Your Email -" class="text ui-widget-content ui-corner-all" /></p>';
		echo '<p><textarea id="email_message" name="email_message" cols="5" rows="3" onfocus="if(this.value==this.defaultValue) this.value=\'\';" class="text ui-widget-content ui-corner-all">'.$settings['email_message'].'</textarea></p>';
		echo '<p class="email_message">Enter your name, email address and a message.</p>';
		echo '<input type="hidden" id="email_recipient" name="email_recipient" value="'.$settings['email_recipient'].'">';
		echo '<input type="hidden" id="email_cc" name="email_cc" value="'.$settings['email_cc'].'">';
		echo '<input type="hidden" id="email_bcc" name="email_bcc" value="'.$settings['email_bcc'].'">';				
		echo '<input type="hidden" id="email_subject" name="email_subject" value="'.$settings['email_subject'].'">';
		echo '<input type="hidden" id="plugin_url" name="plugin_url" value="'.IIRE_SOCIAL_URL.'">';		
		echo '</div>';			
   }		
}
add_action('wp_footer', 'iire_social_footer');


// SHORTCODE 
function iire_social_icons() {
	global $wpdb;
	global $blog_id;

	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}	

	$sc = '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>';

	if ($settings['clone_widget_settings'] == '1' ) {
		$sc .= '<div id="iire_social_widget" class="iire_social_widget">';	
		$sc .= stripslashes($settings['widget_output']);
		$sc .= '</div>';		
	} else {
		$sc .= '<div id="iire_social_shortcode" class="iire_social_shortcode">';		
		$sc .= stripslashes($settings['sc_output']);
		$sc .= '</div>';		
	}		
	return $sc;	
}
add_shortcode('iire_social_icons', 'iire_social_icons');
?>