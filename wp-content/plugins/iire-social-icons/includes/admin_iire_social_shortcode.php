<?php
// Admin Page for Social Icons Shortcode - 10-20-2012

function iire_admin_social_shortcode() {
	global $wpdb;
	global $blog_id;
	
	$table_name = $wpdb->get_blog_prefix($blog_id)."iire_social";

	// UPDATE OPTIONS
	if (isset($_POST['sc_icon_theme'])){
		foreach($_POST as $k=>$v){
			if ($k != 'tab') {
				$fields .= $k."='".mysql_escape_string(trim($v))."', ";
				$value = mysql_escape_string(trim($v));		
				$wpdb->query("UPDATE ".$table_name." SET option_value = '$value' WHERE option_name = '$k'");
			}	
		}	
	}		
	
	// GET SETTINGS
	$settings = array();		
	$rs = $wpdb->get_results("SELECT * FROM $table_name");
	foreach ($rs as $row) {
		$settings[$row->option_name] = $row->option_value;
	}		


	// Shortcode Theme
	if ($settings['sc_icon_theme'] == '') {
		$th = 'default';
	} else {
		$th = $settings['sc_icon_theme'];
	}		

	// Shortcode Container Orientation
	if ($settings['sc_orientation'] == 'horizontal') { $ot = 'horizontal';	} else { $ot = 'vertical'; }	

	// Shortcode Icon Size
	if ($settings['sc_icon_size'] == '') {
		$iconsize = 'icon64';
		$sz = '64';
	} else {
		$iconsize = 'icon'.$settings['sc_icon_size'];
		$sz = $settings['sc_icon_size'];						
	}		

	// Shortcode Icon Spacing	
	for ( $x = 0; $x <= 25; $x++ ) {
		if ($settings['sc_icon_spacing'] == $x) { $sp = 'sp'.$x; }
	}		

	// Shortcode Icon Dropshadow	
	if ($settings['sc_dropshadow'] == '1') { 
		$ds = ' dropshadow';
	} else {
		$ds = '';
	}		
	$dshz = $settings['sc_dropshadow_horizontal_offset']; 		
	$dsvt = $settings['sc_dropshadow_vertical_offset']; 
	$dsblur = $settings['sc_dropshadow_blur']; 						
	$dscolor = $settings['sc_dropshadow_color']; 

	// Shortcode Icon Rounded Corners		
	if ($settings['sc_roundedcorners'] == '1') {
		$rc = ' roundedcorners';
		$rctl = $settings['sc_roundedcorners_topleft'];
		$rctr = $settings['sc_roundedcorners_topright']; 
		$rcbl = $settings['sc_roundedcorners_bottomleft']; 
		$rcbr = $settings['sc_roundedcorners_bottomright']; 		
	} else {
		$rc = '';	
	}

	// Shortcode Icon Opacity
	$opacity = $settings['sc_icon_opacity'];	
	if ($opacity >= 10 && $opacity < 100) { 
		$op = ' opacity';
		$opval = $opacity/100;
	} else {
		$op = '';
		$opval = "100";		
	}	
	
	// Shortcode Icon Background Colors
	if ($settings['sc_icon_bgcolor'] == '1') {	
		$bg = ' bgcolor';
		$bup = '#'.$settings['sc_icon_bgcolor_up'];
		$bov = '#'.$settings['sc_icon_bgcolor_hover']; 
	} else {
		$bg = '';
		$bup = 'none';
		$bov = 'none'; 			
	}		
		
	//Add Classes											
	$addclasses = $iconsize.' '.$th.' '.$ot.' '.$sp.$ds.$rc.$op.$bg;
?>	

<style>
	div#viewport { width:auto; min-width:680px; min-height:360px; height:auto; padding:10px; background-color:#EDEDED; position:relative; top:0px; left:0px; background-image: url('<?php echo IIRE_SOCIAL_URL ?>/includes/images/preview_shortcode.png'); background-repeat:no-repeat; background-position: top right;}

	<?php echo $settings['css']; ?>	
	
	.opacity { opacity:<?php echo $opval; ?>; }

	.roundedcorners { 
		border-top-left-radius:<?php echo $rctl; ?>px;
		border-top-right-radius:<?php echo $rctr; ?>px;
		border-bottom-left-radius:<?php echo $rcbl; ?>px;		
		border-bottom-right-radius:<?php echo $rcbr; ?>px;
		-moz-border-radius-topleft:<?php echo $rctl; ?>px;
		-moz-border-radius-topright:<?php echo $rctr; ?>px;
		-moz-border-radius-bottomleft:<?php echo $rcbl; ?>px;
		-moz-border-radius-bottomright:<?php echo $rcbr; ?>px;						
		-webkit-border-top-left-radius:<?php echo $rctl; ?>px;
		-webkit-border-top-right-radius:<?php echo $rctr; ?>px; 
		-webkit-border-bottom-left-radius:<?php echo $rcbl; ?>px; 
		-webkit-border-bottom-right-radius:<?php echo $rcbr; ?>px;						 
	}

	.dropshadow { -moz-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; -webkit-box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; box-shadow: <?php echo $dshz; ?>px <?php echo $dsvt; ?>px <?php echo $dsblur; ?>px #<?php echo $dscolor; ?>; }	


	/* 16 x 16 Icons */
	.icon16.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/16_sprite.png); }
	.icon16.iphone{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/16_sprite.png); }
	.icon16.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/16_sprite.png); }
	.icon16.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/16_sprite.png); }
	.icon16.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/16_sprite.png); }	
	.icon16.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/16_sprite.png); }
	.icon16.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/16_sprite.png); }	
	.icon16.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/16_sprite.png); }	
	.icon16.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/16_sprite.png); }
	.icon16.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/16_sprite.png); }	
	.icon16.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/16_sprite.png); }								
	.icon16.symbols_black{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/16_sprite.png); }
	.icon16.symbols_gray{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/16_sprite.png); }
	.icon16.symbols_white{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/16_sprite.png); }
	.icon16.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/16_sprite.png); }							
	.icon16.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/16_sprite.png); }
	.icon16.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/16_sprite.png); }
	.icon16.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/16_sprite.png); }
	.icon16.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/16_sprite.png); }
	.icon16.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/16_sprite.png); }				


	/* 24 x 24 Icons */
	.icon24.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/24_sprite.png); }
	.icon24.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/24_sprite.png); }
	.icon24.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/24_sprite.png); }
	.icon24.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/24_sprite.png); }
	.icon24.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/24_sprite.png); }	
	.icon24.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/24_sprite.png); }
	.icon24.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/24_sprite.png); }		
	.icon24.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/24_sprite.png); }	
	.icon24.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/24_sprite.png); }
	.icon24.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/24_sprite.png); }	
	.icon24.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/24_sprite.png); }								
	.icon24.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/24_sprite.png); }
	.icon24.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/24_sprite.png); }
	.icon24.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/24_sprite.png); }
	.icon24.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/24_sprite.png); }
	.icon24.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/24_sprite.png); }
	.icon24.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/24_sprite.png); }
	.icon24.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/24_sprite.png); }
	.icon24.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/24_sprite.png); }
	.icon24.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/24_sprite.png); }					


	/* 32 x 32 Icons */
	.icon32.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/32_sprite.png); }
	.icon32.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/32_sprite.png); }
	.icon32.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/32_sprite.png); }
	.icon32.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/32_sprite.png); }
	.icon32.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/32_sprite.png); }	
	.icon32.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/32_sprite.png); }
	.icon32.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/32_sprite.png); }		
	.icon32.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/32_sprite.png); }	
	.icon32.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/32_sprite.png); }
	.icon32.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/32_sprite.png); }	
	.icon32.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/32_sprite.png); }							
	.icon32.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/32_sprite.png); }
	.icon32.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/32_sprite.png); }
	.icon32.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/32_sprite.png); }
	.icon32.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/32_sprite.png); }
	.icon32.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/32_sprite.png); }
	.icon32.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/32_sprite.png); }
	.icon32.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/32_sprite.png); }
	.icon32.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/32_sprite.png); }
	.icon32.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/32_sprite.png); }					


	/* 48 x 48 Icons */
	.icon48.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/48_sprite.png); }
	.icon48.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/48_sprite.png); }
	.icon48.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/48_sprite.png); }
	.icon48.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/48_sprite.png); }
	.icon48.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/48_sprite.png); }	
	.icon48.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/48_sprite.png); }
	.icon48.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/48_sprite.png); }		
	.icon48.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/48_sprite.png); }	
	.icon48.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/48_sprite.png); }
	.icon48.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/48_sprite.png); }	
	.icon48.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/48_sprite.png); }								
	.icon48.symbols_black{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/48_sprite.png); }
	.icon48.symbols_gray{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/48_sprite.png); }
	.icon48.symbols_white{ background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/48_sprite.png); }
	.icon48.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/48_sprite.png); }
	.icon48.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/48_sprite.png); }
	.icon48.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/48_sprite.png); }
	.icon48.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/48_sprite.png); }
	.icon48.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/48_sprite.png); }
	.icon48.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/48_sprite.png); }					


	/* 64 x 64 Icons */
	.icon64.default { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/64_sprite.png); }
	.icon64.iphone { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/64_sprite.png); }
	.icon64.circular_cutouts { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/64_sprite.png); }
	.icon64.chrome_panels { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/64_sprite.png); }		
	.icon64.eco_green { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/64_sprite.png); }
	.icon64.gold_bars { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/64_sprite.png); }
	.icon64.light_bulbs { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/64_sprite.png); }		
	.icon64.post_it_notes { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/64_sprite.png); }	
	.icon64.punch_thru { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/64_sprite.png); }
	.icon64.red_alert { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/64_sprite.png); }		
	.icon64.stickers { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/64_sprite.png); }		
	.icon64.symbols_black { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/64_sprite.png); }				
	.icon64.symbols_gray { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/64_sprite.png); }
	.icon64.symbols_white { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/64_sprite.png); }
	.icon64.wood_crates { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/64_sprite.png); }
	.icon64.custom1 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/64_sprite.png); }
	.icon64.custom2 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/64_sprite.png); }
	.icon64.custom3 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/64_sprite.png); }
	.icon64.custom4 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/64_sprite.png); }
	.icon64.custom5 { background-color: <?php echo $bup; ?>; background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/64_sprite.png); }					
		

	/* Icon Hover Colors */	
	.icon<?php echo $sz; ?>.default:hover, .icon<?php echo $sz; ?>.iphone:hover, .icon<?php echo $sz; ?>.circular_cutouts:hover, .icon<?php echo $sz; ?>.chrome_panels:hover, .icon<?php echo $sz; ?>.eco_green:hover, .icon<?php echo $sz; ?>.gold_bars:hover, .icon<?php echo $sz; ?>.post_it_notes:hover, .icon<?php echo $sz; ?>.punch_thru:hover, .icon<?php echo $sz; ?>.red_alert:hover, .icon<?php echo $sz; ?>.wood_crates:hover, .icon<?php echo $sz; ?>.stickers:hover, .icon<?php echo $sz; ?>.symbols_black, .icon<?php echo $sz; ?>.symbols_gray, .icon<?php echo $sz; ?>.symbols_white, .icon<?php echo $sz; ?>.custom1:hover, .icon<?php echo $sz; ?>.custom2:hover, .icon<?php echo $sz; ?>.custom3:hover, .icon<?php echo $sz; ?>.custom4:hover, .icon<?php echo $sz; ?>.custom5:hover { background-color: <?php echo $bov; ?>; }

	/* CHOOSE ICONS */
	li.choose { width:24px; height:24px; margin:0px; padding:0px; display: inline-table; cursor:pointer; }		
	li.choose.default { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/default/24_sprite.png); }	
	li.choose.iphone { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/iphone/24_sprite.png); }
	li.choose.circular_cutouts { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/circular_cutouts/24_sprite.png); }
	li.choose.chrome_panels { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/chrome_panels/24_sprite.png); }
	li.choose.eco_green { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/eco_green/24_sprite.png); }			
	li.choose.gold_bars { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/gold_bars/24_sprite.png); }
	li.choose.light_bulbs { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/light_bulbs/24_sprite.png); }	
	li.choose.post_it_notes { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/post_it_notes/24_sprite.png); }	
	li.choose.punch_thru { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/punch_thru/24_sprite.png); }
	li.choose.red_alert { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/red_alert/24_sprite.png); }	
	li.choose.stickers { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/stickers/24_sprite.png); }						
	li.choose.symbols_black { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_black/24_sprite.png); }
	li.choose.symbols_gray { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_gray/24_sprite.png); }
	li.choose.symbols_white { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/symbols_white/24_sprite.png); }
	li.choose.wood_crates { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/wood_crates/24_sprite.png); }
	li.choose.custom1 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom1/24_sprite.png); }
	li.choose.custom2 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom2/24_sprite.png); }	
	li.choose.custom3 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom3/24_sprite.png); }	
	li.choose.custom4 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom4/24_sprite.png); }	
	li.choose.custom5 { background-image: url(<?php echo IIRE_SOCIAL_URL ?>themes/custom5/24_sprite.png); }																	
	
	div#iire_social_widget div.move:hover { background-color: <?php echo $bov; ?>; }
</style>



<div class="wrap" style="min-width:680px;">

<div id="icon_iire"><br></div>	
<h2>iiRe Social Icons - Shortcode Settings</h2>
<input type="hidden" id="plugin_path" name="plugin_path" value="<?php echo IIRE_SOCIAL_URL; ?>" class="w400">

<form id="settings" method="POST">

<div id="iire_social_panel_tab"><span>&raquo;</span></div>	<!-- RIGHT PANEL TAB-->

<div id="iire_social_panel_right">	<!-- START RIGHT PANEL -->

	<p id="btnholder" style="text-align:center; padding:0px; margin:20px 0px 20px 0px;"> <input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes"> <a id="reset" class="reset button-secondary">Reset</a> <a id="preview" href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

	<div id="right_panel">	<!-- Start Right Panel Container -->
	
		<!-- Start Theme-->
		<h3 id="icon_theme"><a href="#">Icon Theme</a></h3>
		<div>
			<p><select id="sc_icon_theme" name="sc_icon_theme" class="w185">
				<?php
				$d = "../wp-content/plugins/iire-social-icons/themes/";
				$subd = glob($d . "*");
				foreach($subd as $f) {
					if(is_dir($f)) {
						$theme = str_replace($d,'',$f);
						$theme_name = ucwords(str_replace('_',' ',$theme));
						echo '<option value="'.$theme.'" ';
						if ($settings['sc_icon_theme'] == $theme ) { echo 'selected'; } 
						echo '>'.$theme_name.'</option>';
 					}
				}
				?>																
			</select></p>
			
			<p><img class="icon_theme" src="<?php echo IIRE_SOCIAL_URL; ?>themes/<?php echo $settings['sc_icon_theme']; ?>/screenshot.png" width="185" border="0" /></p>
		</div>
	
		
		<!-- Start Icon Sizes -->
		<h3 id="icon_size"><a href="#">Icon Size &amp; Spacing</a></h3>
		<div>

 			<!-- Size -->
			<p><label>Icon Size:</label>			
			<select id="sc_icon_size" name="sc_icon_size" class="w50">
				<option value="16" <?php if ($settings['sc_icon_size'] =='16') { echo 'selected'; } ?>>16</option>
				<option value="24" <?php if ($settings['sc_icon_size'] =='24') { echo 'selected'; } ?>>24</option>
				<option value="32" <?php if ($settings['sc_icon_size'] =='32') { echo 'selected'; } ?>>32</option>
				<option value="48" <?php if ($settings['sc_icon_size'] =='48') { echo 'selected'; } ?>>48</option>
				<option value="64" <?php if ($settings['sc_icon_size'] =='64') { echo 'selected'; } ?>>64</option>
			</select> px
			</p>
			<div id="sc_size" class="slider"></div>
			
			<p>&nbsp;</p>
 			
			<!-- Spacing -->
			<p><label>Icon Spacing:</label>			
			<select id="sc_icon_spacing" name="sc_icon_spacing" class="w50">
				<?php
				for ( $x = 0; $x <= 25; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_icon_spacing'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			<div id="sc_spacing" class="slider"></div>
			
		</div>
 		<!-- End Icon Sizing -->


		<!-- Start Icon Styling -->
		<h3 id="icon_styling"><a href="#">Icon Styling</a></h3>
		<div>

 			<!-- Dropshadow -->
			<p><label>Drop Shadow?</label>		
			<select id="sc_dropshadow" name="sc_dropshadow" class="w70">
				<option value="0" <?php if ($settings['sc_dropshadow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_dropshadow'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Shadow Color:</label>	
			<input type="text" id="sc_dropshadow_color" name="sc_dropshadow_color" value="<?php echo $settings['sc_dropshadow_color']; ?>" class="w70 color ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">
			</p>

			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Horizontal Offset:</label>
			<select id="sc_dropshadow_horizontal_offset" name="sc_dropshadow_horizontal_offset" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = -10; $x <= 10; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_horizontal_offset'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>

			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Vertical Offset:</label>
			<select id="sc_dropshadow_vertical_offset" name="sc_dropshadow_vertical_offset" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = -10; $x <= 10; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_vertical_offset'] == $x) { 
						echo 'selected';
					}
					if ($x == 0) {
						echo '>None</option>';
					} else {	
						echo '>'.$x.'</option>';
					}	
				}
				?>												
			</select> px
			</p>
			
			<p class="ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>"><label>Blur:</label>
			<select id="sc_dropshadow_blur" name="sc_dropshadow_blur" class="w50 ds <?php if ($settings['sc_dropshadow'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 20; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_dropshadow_blur'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>							

			<p class="ds <?php if ($settings['sc_dropshadow'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>
			<p>&nbsp;</p>			

	
 			<!-- Rounded Corners -->
			<p><label>Rounded Corners?</label>			
			<select id="sc_roundedcorners" name="sc_roundedcorners" class="w70">
				<option value="0" <?php if ($settings['sc_roundedcorners'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_roundedcorners'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Left:</label>
			<select id="sc_roundedcorners_topleft" name="sc_roundedcorners_topleft" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_topleft'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>				

			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Top Right:</label>
			<select id="sc_roundedcorners_topright" name="sc_roundedcorners_topright" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_topright'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>"><label>Bottom Left:</label>
			<select id="sc_roundedcorners_bottomleft" name="sc_roundedcorners_bottomleft" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_bottomleft'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] == '0') { echo 'hidden'; } ?>"><label>Bottom Right:</label>
			<select id="sc_roundedcorners_bottomright" name="sc_roundedcorners_bottomright" class="w50 rc <?php if ($settings['sc_roundedcorners'] =='0') { echo 'hidden'; } ?>">			
				<?php
				for ( $x = 0; $x <= 50; $x++ ) {
					echo '<option value="'.$x.'" ';
					if ($settings['sc_roundedcorners_bottomright'] == $x) { 
						echo 'selected';
					}
					echo '>'.$x.'</option>';
				}
				?>												
			</select> px
			</p>
			
			<p class="rc <?php if ($settings['sc_roundedcorners'] == '0') { echo 'hidden'; } ?>"><br /><br /></p>			
			<p>&nbsp;</p>
			
			<p><label>Background Color?</label>			
			<select id="sc_icon_bgcolor" name="sc_icon_bgcolor" class="w70">
				<option value="0" <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_icon_bgcolor'] == '1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
	
 			<!-- Background Color -->
			<p class="bg <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"><label>Up State:</label>	
			<input type="text" id="sc_icon_bgcolor_up" name="sc_icon_bgcolor_up" value="<?php echo $settings['sc_icon_bgcolor_up']; ?>" class="w70 bg color <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>

			<p class="bg <?php if ($settings['sc_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><label>Hover State:</label>	
			<input type="text" id="sc_icon_bgcolor_hover" name="sc_icon_bgcolor_hover" value="<?php echo $settings['sc_icon_bgcolor_hover']; ?>" class="w70 bg color <?php if ($settings['sc_icon_bgcolor'] == '0') { echo 'hidden'; } ?>"></p>
			
			<p class="bg <?php if ($settings['sc_icon_bgcolor'] =='0') { echo 'hidden'; } ?>"><br />Background colors are best used with the "Symbol" themes.</p>		

			<p>&nbsp;</p>

 			<!-- Opacity -->				
			<p><label>Icon Opacity:</label>	
			<input type="text" id="op" name="sc_icon_opacity" value="<?php echo $settings['sc_icon_opacity']; ?>" class="w50"> %</p>
			<div id="sc_opacity" class="slider"></div>					
			
							
		</div> 
		<!-- End Icons Styling -->
	

		 <!-- Start Icon Links -->
		<h3 id="icon_links"><a href="#">Icon Links</a></h3>
		<div>
 			<!-- Show Title? -->
			<p><label>Show Alt/Title?</label>			
			<select id="link_title" name="link_title" class="w70">
				<option value="0" <?php if ($settings['link_title'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_title'] =='1') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>

			<p>&nbsp;</p>
			
 			<!-- New Window? -->
			<p><label>Open in New Window?</label>			
			<select id="link_target" name="link_target" class="w70">
				<option value="_self" <?php if ($settings['link_target'] =='_self') { echo 'selected'; } ?>>No</option>
				<option value="_blank" <?php if ($settings['link_target'] =='_blank') { echo 'selected'; } ?>>Yes</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
 			<!-- No Follow? -->
			<p><label>No Follow?</label>			
			<select id="link_nofollow" name="link_nofollow" class="w70">
				<option value="0" <?php if ($settings['link_nofollow'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['link_nofollow'] =='1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>			
		</div> 
		<!-- End Icon Links -->
	
		
		<!-- Start Icon Container -->	
		<h3 id="sc_container"><a href="#">Shortcode Container</a></h3>
		<div>
			<p><label class="w80">Type:</label>
			<select id="sc_orientation" name="sc_orientation" class="w100">
				<option value="horizontal" <?php if ($settings['sc_orientation'] =='horizontal') { echo 'selected'; } ?>>Horizontal</option>
				<option value="vertical" <?php if ($settings['sc_orientation'] =='vertical') { echo 'selected'; } ?>>Vertical</option>				
			</select>
			</p>
			
			<p>&nbsp;</p>
			
			<p><label>Alignment:</label>
			<select id="sc_align" name="sc_align" class="w70">
				<option value="left" <?php if ($settings['sc_align'] =='left') { echo 'selected'; } ?>>Left</option>
				<option value="right" <?php if ($settings['sc_align'] =='right') { echo 'selected'; } ?>>Right</option>	
			</select>
			</p>

			<p>&nbsp;</p>
									
			<p><label>Width:</label>
			<input type="text" id="ww" name="sc_width" value="<?php echo $settings['sc_width']; ?>" class="w50"> px</p>			
			<div id="sc_width" class="slider"></div>
			
			<p>&nbsp;</p>

			<p><label>Height:</label>
			<input type="text" id="wh" name="sc_height" value="<?php echo $settings['sc_height']; ?>" class="w50"> px</p>			
			<div id="sc_height" class="slider"></div>
			
			<p>&nbsp;</p>				
			
			<p><label>Padding Top:</label><input type="text" id="sc_pad_top" name="sc_pad_top" value="<?php echo $settings['sc_pad_top']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Left:</label><input type="text" id="sc_pad_left" name="sc_pad_left" value="<?php echo $settings['sc_pad_left']; ?>" class="w35 inline"> px</p>
			<p><label>Padding Bottom:</label><input type="text" id="sc_pad_bottom" name="sc_pad_bottom" value="<?php echo $settings['sc_pad_bottom']; ?>" class="w35 inline"> px</p>		
			<p><label>Padding Right:</label><input type="text" id="sc_pad_right" name="sc_pad_right" value="<?php echo $settings['sc_pad_right']; ?>" class="w35 inline"> px</p>

			<p>&nbsp;</p>
			
			<p><label>Margin Top:</label><input type="text" id="sc_margin_top" name="sc_margin_top" value="<?php echo $settings['sc_margin_top']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Left:</label><input type="text" id="sc_margin_left" name="sc_margin_left" value="<?php echo $settings['sc_margin_left']; ?>" class="w35 inline"> px</p>
			<p><label>Margin Bottom:</label><input type="text" id="sc_margin_bottom" name="sc_margin_bottom" value="<?php echo $settings['sc_margin_bottom']; ?>" class="w35 inline"> px</p>			
			<p><label>Margin Right:</label><input type="text" id="sc_margin_right" name="sc_margin_right" value="<?php echo $settings['sc_margin_right']; ?>" class="w35 inline"> px</p>
		</div>
		<!-- End Icon Container -->



		<!-- Start Shortcode Container -->
		<h3 id="sc_styling"><a href="#">Shortcode Container Styling</a></h3>
		<div>
			<!-- Add Background Color -->
			<p><label>Add Background?</label>
			<select id="sc_background" name="sc_background" class="w70">
				<option value="0" <?php if ($settings['sc_background'] == '0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['sc_background'] == '1') { echo 'selected'; } ?>>Yes</option>			
			</select>
			</p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>
		
		
			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>"><label>Background Color:</label>	
			<input type="text" id="sc_bg_color" name="sc_bg_color" value="<?php echo $settings['sc_bg_color']; ?>" class="w70 color"></p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>">&nbsp;</p>

			<p class="addbg <?php if ($settings['sc_background'] == '0') { echo 'hidden'; } ?>"><label>Border Size:</label>
			<select id="sc_border_size" name="sc_border_size" class="w50">
				<option value="0" <?php if ($settings['sc_border_size'] == '0') { echo 'selected'; } ?>>0</option>
				<option value="1" <?php if ($settings['sc_border_size'] == '1') { echo 'selected'; } ?>>1</option>
				<option value="2" <?php if ($settings['sc_border_size'] == '2') { echo 'selected'; } ?>>2</option>
				<option value="3" <?php if ($settings['sc_border_size'] == '3') { echo 'selected'; } ?>>3</option>
				<option value="4" <?php if ($settings['sc_border_size'] == '4') { echo 'selected'; } ?>>4</option>	
				<option value="5" <?php if ($settings['sc_border_size'] == '5') { echo 'selected'; } ?>>5</option>
				<option value="6" <?php if ($settings['sc_border_size'] == '6') { echo 'selected'; } ?>>6</option>
				<option value="7" <?php if ($settings['sc_border_size'] == '7') { echo 'selected'; } ?>>7</option>
				<option value="8" <?php if ($settings['sc_border_size'] == '8') { echo 'selected'; } ?>>8</option>
				<option value="9" <?php if ($settings['sc_border_size'] == '9') { echo 'selected'; } ?>>9</option>
				<option value="10" <?php if ($settings['sc_border_size'] == '10') { echo 'selected'; } ?>>10</option>																																																
			</select> px
			</p>			

			<p class="addbg wbs <?php if ($settings['sc_background'] == '0' || $settings['sc_border_size'] == '0' ) { echo 'hidden'; } ?>"><label>Border Color:</label>	
			<input type="text" id="sc_border_color" name="sc_border_color" value="<?php echo $settings['sc_border_color']; ?>" class="w70 color"></p>


			<p>&nbsp;</p>
			
			<p>Custom CSS:</p>				
			<textarea id="sc_css" name="sc_css" cols="20" rows="3" class="w100p h120"><?php echo $settings['sc_css']; ?></textarea>	
		</div>
		<!-- End Shortcode Container -->		


 		<!-- Start Email -->		
		<h3 id="email"><a href="#">Email Settings</a></h3>
		<div>
			<!-- Recipient -->
			<p><label>Recipient:</label>
			<input type="text" id="email_recipient" name="email_recipient" value="<?php echo $settings['email_recipient']; ?>" class="w100p">
			</p>

 			<!-- CC -->
			<p><label>CC:</label>			
			<input type="text" id="email_cc" name="email_cc" value="<?php echo $settings['email_cc']; ?>" class="w100p">
			</p>
			
 			<!-- BCC -->
			<p><label>BCC:</label>			
			<input type="text" id="email_bcc" name="email_bcc" value="<?php echo $settings['email_bcc']; ?>" class="w100p">
			</p>

 			<!-- Subject -->
			<p><label>Subject:</label>			
			<input type="text" id="email_subject" name="email_subject" value="<?php echo $settings['email_subject']; ?>" class="w100p">
			</p>
			
 			<!-- Message -->
			<p><label>Message:</label>	
			<textarea id="email_message" name="email_message" cols="20" rows="3" class="w100p h120"><?php echo $settings['email_message']; ?></textarea>						
			</p>			
		</div>	
		<!-- End Email -->
		
		
 		<!-- Start General -->		
		<h3 id="general"><a href="#">General Settings</a></h3>
		<div>

			<!-- Add This Sharing -->
			<p><label>Add This?</label>
			<select id="addthis" name="addthis" class="w70">
				<option value="0" <?php if ($settings['addthis'] =='0') { echo 'selected'; } ?>>No</option>
				<option value="1" <?php if ($settings['addthis'] =='1') { echo 'selected'; } ?>>Yes</option>		
			</select></p>
			<p class="addthis2 <?php if ($settings['addthis'] == '1') { echo 'hidden'; } ?>"><br />Included the Add This sharing code with your shortcode?</p>
							
			<p class="addthis <?php if ($settings['addthis'] == '0') { echo 'hidden'; } ?>"><label>Analytics Key:</label>
			<input type="text" id="addthis_key" name="addthis_key" value="<?php echo $settings['addthis_key']; ?>" class="w100p">
			<br />For more information, please visit <a href="http://addthis.com" target="_blank">http://addthis.com</a></p>										
		</div>	
		<!-- End General -->
		
		
 		<!-- Start Registration -->		
		<h3 id="registration"><a href="#">Registration</a></h3>
		<div>
			<p><label>Your Email:</label>			
			<input id="registration_email" name="registration_email" type="text" value="<?php echo $settings['registration_email'] ?>" class="registration">
			</p>
			<p><label>Activation Key:</label>				
			<input id="registration_key" name="registration_key" type="text" value="<?php echo $settings['registration_key'] ?>" class="registration">
			</p>
			<p>&nbsp;</p>			
			<p><input type="submit" name="submit" id="activate" class="button-secondary" value="Activate Registration"></p>				
		</div>	
		<!-- End Registration -->			
			

	</div><!-- End Right Panel Container -->

</div>	<!-- END RIGHT PANEL -->






	<h3>Shortcode Designer <span class="instructions">(Double-click icon to edit link and title... Drag icon to change position... Drag to Trash to remove.)</span></h3>

	<div id="viewport">
		<?php
		$wid = 'width:'.$settings['sc_width'].'px; '; 
		$hgt = 'height:'.$settings['sc_height'].'px; ';
		
		if ($settings['sc_pad_top'] != '0' || $settings['sc_pad_right'] != '0' || $settings['sc_pad_bottom'] != '0' || $settings['sc_pad_left'] != '0') {		
			$pad = 'padding: '.$settings['sc_pad_top'].'px '.$settings['sc_pad_right'].'px '.$settings['sc_pad_bottom'].'px '.$settings['sc_pad_left'].'px; ';
		} else {
			$pad = '';			
		}	
		
		if ($settings['sc_margin_top'] != '0' || $settings['sc_margin_right'] != '0' || $settings['sc_margin_bottom'] != '0' || $settings['sc_margin_left'] != '0') {			
			$mar = 'margin: '.$settings['sc_margin_top'].'px '.$settings['sc_margin_right'].'px '.$settings['sc_margin_bottom'].'px '.$settings['sc_margin_left'].'px; ';
		} else {
			$mar = '';			
		}	
		
		if ($settings['sc_background'] == '0') {		
			$bdg = 'background: none; ';
		} else {
			$bdg = 'background-color:#'.$settings['sc_bg_color'].'; ';			
		}	
		
		if ( $settings['sc_border_size'] != '0') {
			$bor = 'border:#'.$settings['sc_border_color'].' '.$settings['sc_border_size'].'px solid;';
		} else {
			$bor = '';			
		}						
		
		echo '<div id="iire_social_shortcode" class="iire_social_shortcode" style="'.$wid.$hgt.$pad.$mar.$bdg.$bor.'">'; 
		echo stripslashes($settings['sc_icons']);		
		echo '</div>';		
		?>
		<div id="trash" title="Drop Icon to Remove"></div>
	</div> <!-- End Viewport -->

	<h3>Icons <span class="instructions">(Click an icon below to add it to the Shortcode Designer.)</span></h3>

	<div id="chooseicons">
		<ul id="chooseicons">
			<li class="choose <?php echo $th; ?>" id="iire-facebook" alt="https://facebook.com/stephen.russell.904" title="Facebook" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-twitter" alt="http://twitter.com/srussell13/" title="Twitter" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-linkedin" alt="http://linkedin.com/pub/stephen-russell/1/223/b82" title="Linked In" lang=""></li>		
			<li class="choose <?php echo $th; ?>" id="iire-youtube" alt="http://youtube.com/user/iirepr2" title="You Tube" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-pinterest" alt="http://pinterest.com" title="Pinterst" lang=""></li>						
			<li class="choose <?php echo $th; ?>" id="iire-email" alt="srussell@iireproductions.com" title="Email Me!" lang="Use the email settings for this information!"></li>
			<li class="choose <?php echo $th; ?>" id="iire-rss" alt="<?php echo get_option('siteurl'); ?>/feed.rss" title="RSS Feed" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-favorite" alt="" title="Add to Favorites" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-link" alt="http://" title="Custom Link" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-website" alt="http://" title="Alternate Website" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-info1" alt="http://" title="More Information" lang=""></li>			
			<li class="choose <?php echo $th; ?>" id="iire-info2" alt="http://" title="More Information" lang=""></li>	
			<li class="choose <?php echo $th; ?>" id="iire-chat" alt="http://" title="Chat" lang=""></li>
			<li class="choose <?php echo $th; ?>" id="iire-contact" alt="http://" title="Contact Page" lang=""></li>			
			
			<li class="choose trial <?php echo $th; ?>" id="iire-activerain" alt="http://activerain.com/srussell13" title="Active Rain" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-aim" alt="http://aim.com" title="AIM" lang=""></li>				
			<li class="choose trial <?php echo $th; ?>" id="iire-amazon" alt="http://amazon.com" title="Amazon" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="iire-android" alt="http://android.com" title="Android" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-aol" alt="http://aol.com" title="AOL" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="iire-apple" alt="http://apple.com" title="Apple" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-badoo" alt="http://badoo.com" title="Badoo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-bebo" alt="http://bebo.com" title="Bebo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-blinklist" alt="http://blinklist.com" title="Blinklist" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="iire-blogger" alt="http://blogger.com" title="Blogger" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-cafemom" alt="http://cafemom.com" title="Cafe Mom" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-delicious" alt="http://delicious.com" title="Delicious" lang=""></li>							
			<li class="choose trial <?php echo $th; ?>" id="iire-deviantart" alt="http://deviantart.com" title="Deviant Art" lang=""></li>															
			<li class="choose trial <?php echo $th; ?>" id="iire-digg" alt="http://digg.com" title="Digg" lang=""></li>		
			<li class="choose trial <?php echo $th; ?>" id="iire-dribbble" alt="http://dribbble.com" title="Dribbble" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-feedburner" alt="http://feedburner.com" title="Feed Burner" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-flickr" alt="http://flickr.com" title="Flickr" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-friendfeed" alt="http://friendfeed.com" title="Friend Feed" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-friendster" alt="http://friendster.com" title="Friendster" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-foursquare" alt="http://foursquare.com" title="Foursquare" lang=""></li>										
			<li class="choose trial <?php echo $th; ?>" id="iire-google" alt="http//google.com/" title="Google" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-googleplus" alt="https://plus.google.com/u/0/110362418117155780512/posts" title="Google +" lang=""></li>							
			<li class="choose trial <?php echo $th; ?>" id="iire-gmail" alt="http//mail.google.com/" title="Gmail" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-hi5" alt="http://hi5.com" title="Hi 5" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-instagram" alt="http://instagram.com" title="Instagram" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-lastfm" alt="http://lastfm.com" title="Last FM" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="iire-livejournal" alt="http://livejournal.com" title="Live Journal" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-microsoft" alt="http://microsoft.com" title="Microsoft" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="iire-meetup" alt="http://meetup.com" title="Meet Up" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-mylife" alt="http://mylife.com" title="My Life" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-myspace" alt="http://myspace.com" title="My Space" lang=""></li>				
			<li class="choose trial <?php echo $th; ?>" id="iire-ning" alt="http://ning.com" title="Ning" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-newsvine" alt="http://newsvine.com" title="News Vine" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-orkut" alt="http://orkut.com" title="Orkut" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-picasa" alt="http://picasa.com" title="Picasa" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-reddit" alt="http://reddit.com" title="Reddit" lang=""></li>						
			<li class="choose trial <?php echo $th; ?>" id="iire-sharethis" alt="http://sharethis.com" title="Share This" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-skype" alt="srussell.iireproductions" title="Skype" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-slashdot" alt="http://slashdot.com" title="Slash Dot" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="iire-slideshare" alt="http://slideshare.net" title="Slide Share" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-soundcloud" alt="http://soundcloud.com" title="Sound Cloud" lang=""></li>								
			<li class="choose trial <?php echo $th; ?>" id="iire-spotify" alt="http://spotify.com" title="Spotify" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-stumbleupon" alt="http://stumbleupon.com" title="Stumble Upon" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-tagged" alt="http://taqged.com" title="Tagged" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-technorati" alt="http://technorati.com" title="Technorati" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-tumblr" alt="http://tumblr.com" title="Tumblr" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-vimeo" alt="http://vimeo.com" title="Vimeo" lang=""></li>	
			<li class="choose trial <?php echo $th; ?>" id="iire-wordpress" alt="http://wordpress.com" title="Wordpress" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-xing" alt="http://xing.com" title="Xing" lang=""></li>			
			<li class="choose trial <?php echo $th; ?>" id="iire-yahoo" alt="http://yahoo.com" title="Yahoo" lang=""></li>
			<li class="choose trial <?php echo $th; ?>" id="iire-yelp" alt="http://yelp.com" title="Yelp"></li>																															

			<li class="choose hidden <?php echo $th; ?>" id="iire-addthis" alt="http://www.addthis.com/bookmark.php?v=250" title="Add This" lang=""></li>	
		</ul>

		<input type="hidden" id="sc_addclasses" name="sc_addclasses" value="<?php echo $addclasses; ?>" class="w400">
	</div>

<p class="submit" align="left"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes">&nbsp;&nbsp;&nbsp;<a id="reset" class="reset button-secondary">Reset</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo get_option('siteurl'); ?>" target="_blank" class="preview button-secondary" title="Preview will launch in new tab/window!">Preview</a></p>

<h3>[iire_social_icons] <span class="instructions">(Add this shortcode to any post or page to include these icons.)</span></h3>


<h3>Quick Start</h3>
<ol>
<li>Add this shortcode [iire_social_icons] to any post or page.</li>
<li>Go to "iiRe Social Icons", "Shortcode Settings".</li>
<li>In the Icons section, click an icon to add it to the Shortcode Designer.</li>
<li>Repeat the previous step to add additional icons.</li>
<li>Double-click each icon in the Shortcode Designer to edit the link and title.</li>
<li>Click "Icon Theme" in the side panel, choose a theme i.e. "Circular Cutouts" or use the "Default" theme.</li>
<li>Click "Save Changes".</li>
<li>Click "Preview" to view the output in the section where you placed the widget!</li>
<li>To quickly reset all the settings, click "Start Over". This will reload all the default values.</li>
</ol>

<p>&nbsp;</p>

<h3>Additional Free Themes</h3>
<p>You can find <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-icons/plugins-iire-social-icons-free-themes/" target="_blank">additional free themes</a> on our website!</p>

<p>To install additional themes via FTP:<p>
<ul>
<li>1. Download the desired icon theme to your hardrive and unzip. (The name of the zip file is the name of the theme folder)</li>
<li>2. Upload the icon theme folder to the /wp-content/plugins/iire-social-icons/themes/ directory.</li>
</ul>

<p>&nbsp;</p>


<h3>Notes</h3>
<p>To use the identical settings for the shortcode generated in the Widget Designer, go to "Widget Settings", "General Settings", set "Clone Widget Settings" to "Yes" and save your changes.</p>
<p>The Shortcode Designer works independently!!  You can create vastly different settings for the shortcode (which is best used is a page or post) or the widget (which is best used as a sidebar widget).</p>


<textarea id="sc_icons" name="sc_icons" cols="20" rows="3" class="h150" style="width:100%; visibility: hidden;"><?php echo stripslashes($settings['sc_icons']); ?></textarea>
<textarea id="sc_output" name="sc_output" cols="20" rows="3" class="h150" style="width:100%;  visibility: hidden;"><?php echo stripslashes($settings['sc_output']); ?></textarea>


<!-- EDIT ICON SETTINGS -->
<div id="editdialog" title="Edit Icon Settings" style="display:none;">
	<p>Enter your site link and a title.</p>
	<p align="left">Link:&nbsp;&nbsp;<input type="text" id="choose_url" value="" class="choose_url" style="display:inline; width:250px"></p>
	<p align="left">Title: <input type="text" id="choose_title" value="" class="choose_title" style="display:inline; width:250px"></p>
	<p align="left"><span id="instructions"></span></p>
	<input type="hidden" value="" class="choose_id">
	<p align="right"><a id="edit_close" class="button-secondary">Close</a></p>			
</div>


<!-- UNLOCK DIALOG -->
<div id="unlockdialog" title="Unlock Features" style="display:none;">
	<p align="center">Please consider making a donation<br/>or upgrading to the full version<br/>to unlock this feature.</p>
	<p align="center">Visit <a href="http://iireproductions.com/web/website-development/wordpress-plugins/plugins-social-media-icons/" target="_blank">iiRe Productions</a> for more information.</p>
	<p align="right"><a id="unlock_close" class="button-secondary">Close</a></p>			
</div>

<input id="registration_version" name="registration_version" type="hidden" value="<?php echo $settings['registration_version'] ?>" class="registration">
<input id="registration_activated" name="registration_activated" type="hidden" value="<?php echo $settings['registration_activated'] ?>" class="registration">
<input id="registration_expired" name="registration_expired" type="hidden" value="<?php echo $settings['registration_expired'] ?>" class="registration">

</form>

<div id="codepreview" style="visibility: hidden;"><?php echo stripslashes($settings['sc_output']); ?></div>

</div><!-- End Settings -->

</div> <!-- End Wrap -->

<?php
}
?>