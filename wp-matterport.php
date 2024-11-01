<?php
/*
 @package   shortcode-gallery-for-matterport-showcase
 @license   GPL v2 or later
 
 Plugin Name: Matterport Shortcode 
 Plugin URI: https://mpembed.com/matterport-wordpress-plugin/
 Description: Embed Matterport 3D Tour Galleries with cached thumbnails and titles that open in a pop-up viewer!  Bundled with Magnific Popup by Dmitry Semenov.
 Version: 2.2.2
 Author: Julien Berthelot / MPEmbed.com
 Author URI: http://www.mpembed.com
 License: GPL2
 Domain Path: /languages
 Text Domain: shortcode-gallery-for-matterport-showcase 

 Copyright 2022 MPEmbed

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License, version 2, as
 published by the Free Software Foundation.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

$wpms_db_version = '1.0';

$installed_ver = get_option( "wpms_db_version" );
if ( $installed_ver != $wpms_db_version ) {
	wpms_install();
	update_option( "wpms_db_version", $wpms_db_version );
}

function wpms_install() {
	global $wpdb;
	global $wpms_db_version;
	$table_name = $wpdb->prefix . 'wpms';
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		name tinytext NOT NULL,
		data text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	add_option( 'wpms_db_version', $wpms_db_version );
}

function myplugin_update_db_check() {
    global $wpms_db_version;
    if ( get_site_option( 'wpms_db_version' ) != $wpms_db_version ) {
        wpms_install();
    }
}
add_action( 'plugins_loaded', 'myplugin_update_db_check' );

register_activation_hook( __FILE__, 'wpms_install' );

function wpms_scripts() {
	wp_enqueue_script('jquery');	
	wp_register_script( 'magnific', plugins_url( 'magnific.min.js', __FILE__ ), '1.1.0', array('jquery'), true );
	wp_enqueue_script( 'magnific' );
 	wp_register_style( 'magnific', plugins_url( 'magnific.css', __FILE__ ), false, '1.1.0' );
	wp_enqueue_style( 'magnific' );
	wp_register_script( 'wp-matterport', plugins_url( 'wp-matterport.js', __FILE__ ), '2.2.2', array('jquery','magnific'), true );
	wp_enqueue_script( 'wp-matterport' );
	wp_register_style( 'wp-matterport', plugins_url( 'wp-matterport.css', __FILE__ ), false, '2.2.2' );
	wp_enqueue_style( 'wp-matterport' );
}
add_action( 'wp_enqueue_scripts', 'wpms_scripts' );

if (is_admin()) {
	function wpms_my_enqueue($hook) {
		if ( 'toplevel_page_wpms-options' != $hook ) { return; }
		wpms_scripts(); 
	}
	add_action( 'admin_enqueue_scripts', 'wpms_my_enqueue' );
	
	// Add Plugin Settings Links
	function matterport_plugin_add_settings_link( $links ) {
	    $settings_link = '<a href="admin.php?page=wpms-options">' . __( 'Settings / Cache Management' ) . '</a>';
	    array_push( $links, $settings_link );
	  	return $links;
	}
	$plugin = plugin_basename( __FILE__ );
	add_filter( "plugin_action_links_$plugin", 'matterport_plugin_add_settings_link' );
}	

// Admin
if (is_admin()) {
	include_once('wp-matterport-admin.php');
}

// Add Shortcode
function matterport_embed_shortcode( $atts ) {
	$date_format = get_option('date_format');
	// Attributes
	extract( shortcode_atts(
		array(

// Plugin Related
			'embed' => NULL, // Added v1.9
			'window' => NULL,
			'address' => NULL,
			'showstats' => NULL,
			'nocache' => NULL,
			'cols' => 1,
			'label' => NULL,
			'welcome' => NULL,
			'width' => NULL,
			'height' => NULL,

// Launching 3D Showcase			
			'help' => NULL,
			'hl' => NULL,
//			'nt' => NULL, -- NO NEED TO SUPPORT
//			'play' => NULL, -- NO NEED TO SUPPORT
			'qs' => NULL,
			'ts' => NULL,

// Visibility
			'brand' => NULL,
			'dh' => NULL, // Added v1.7.1
			'gt' => NULL, // Added v1.7.1
			'hr' => NULL, // Added v1.7.1
			'mls' => NULL,
			'mt' => NULL, // Added v1.7.1
			'portal' => NULL, // Added v2.1
			'pin' => NULL, // Added v2.1

// User Interface			
			'f' => NULL,
			'lang' => NULL,
			'guides' => NULL,
			'hhl' => NULL,
			'kb' => NULL,
			'lp' => NULL,
			'mf' => NULL,
			'st' => NULL,
			'title' => NULL,
			'tourcta' => NULL,

// VR

			'vr' => NULL,
			'vrcoll' => NULL,
			'wh' => NULL,
			'showdate' => NULL,
			'src' => '',

// Other
			'start' => NULL,
			'showcase_version' => NULL,

			'admin' => NULL,
			'nozoom' => NULL,
			'maxzoom' => NULL,
			'minzoom' => NULL,
			'zoomtrans' => NULL,

// PREMIUM
			'mpu' => NULL,
			'mpv' => NULL,
			'mpembed' => NULL,

// MPEmbed
			'details' => NULL,
			'hdir' => NULL,
			'mdir' => NULL,
			'stats' => NULL,
			'compactdetails' => NULL,
			
			'mdirsearch' => NULL,
			'openmt' => NULL,

			'logo' => NULL,
			'image' => NULL,

			'minimap' => NULL,
			'minimapurl' => NULL,
			'minimaptags' => NULL,
			'minimaprotation' => NULL,
			'minimapsetrotation' => NULL,
			'minimapnopano' => NULL,
			'fadehotspots' => NULL,
			'hotspots' => NULL,			

			'filter' => NULL,
			'minimapfilter' => NULL,

			'bgmusic' => NULL,
			'bgmusicloop' => NULL,
			'bgmusicvol' => NULL,
			'bgmusicpaused' => NULL,
			'bgmusicpauseonmedia' => NULL,

			'nofade' => NULL,
			'scaleui' => NULL,
			'tint' => NULL,
			
			'spaces' => NULL,
			'reels' => NULL, // deprecated

			'copyright' => NULL,
			'ga' => NULL,
			'aa' => NULL,
			'c' => NULL
			
		), $atts )
	);
	
	if (substr_count($src,','))
	    $tours = explode(',',$src);
	else
	    $tours = array($src);
	if (($title != NULL && strlen($title) > 1) || $label != NULL) {
		// Backwards compatibility with v1.7 and before
		if ($label == NULL)
			$label = esc_html($title);
		if (substr_count($label,';'))
			$titles = explode(';',$label);
		else
			$titles = array($label);
	}
    ob_start();
?>
        <div class="wpm-gallery">
<?php
	$i = 0;
	$link = "";
	$params = "";
	
// Plugin Related
	if ($width!=NULL && $height !=NULL)
		$height = NULL;

// Launching a 3D Showcase
	if ($help!=NULL && ($help == 1 || $help == 0 || $help == 2))
	    $params .= '&amp;help=' . $help;
	if ($hl!=NULL && ($hl == 1 || $hl == 0))
	    $params .= '&amp;hl=' . $hl;		
	if ($hhl!=NULL && ($hhl == 1 || $hhl == 0)) // Undocumented
	    $params .= '&amp;hhl=' . $hhl;	
	if ($qs!=NULL && ($qs == 0 || $qs == 1))
	    $params .= '&amp;qs=' . $qs;
	if ($ts!=NULL)
            $params .= '&amp;ts=' . preg_replace("/[^0-9,.]/", "", $ts);
	// Play omitted

// Visibility
	if ($brand!=NULL && ($brand == 1 || $brand == 0))
	    $params .= '&amp;brand=' . $brand;

	// Undocumented
	if ($title!=NULL && ($title == 1 || $title == 0 || $title == 2))
	    $params .= '&amp;title=' . $title;

	if ($dh!=NULL && $dh == 0) // Added 1.7.1
		$params .= '&amp;dh=0';
	if ($gt!=NULL && $gt == 0) // Added 1.7.1
		$params .= '&amp;gt=0';
	if ($hr!=NULL && $hr == 0) // Added 1.7.1
		$params .= '&amp;hr=0';
	if ($mls!=NULL && ($mls == 1 || $mls == 2))
	    $params .= '&amp;mls=' . $mls;
	if ($mt!=NULL && $mt == 1)
	    $params .= '&amp;mt=1';
	if ($pin!=NULL && $pin == 0) // Added 1.7.1
		$params .= '&amp;pin=0';
	if ($portal!=NULL && $portal == 0) // Added 1.7.1
		$params .= '&amp;portal=0';
	
// User Interface
	if ($f!=NULL && $f == 0)
	    $params .= '&amp;f=0';
	if ($lang != NULL)
	    $params .= '&lang=' . $lang;
	if ($wh!=NULL && ($wh == 1 || $wh == 0))
	    $params .= '&amp;wh=' . $wh;

// Zooming
	if ($nozoom!=NULL && $nozoom == 1)
	    $params .= '&nozoom=1';
	if ($maxzoom!=NULL)
	    $params .= '&maxzoom=' . $maxzoom;
	if ($minzoom!=NULL)
	    $params .= '&minzoom=' . $minzoom;
	if ($zoomtrans!=NULL && ($zoomtrans == 1 || $zoomtrans == 0))
	    $params .= '&zoomtrans=' . $zoomtrans;

// Guided Tours
	if ($guides!=NULL && $guides == 0)
	    $params .= '&amp;guides=0';
	if ($kb!=NULL && $kb == 0)
	    $params .= '&amp;kb=' . $kb;
	if ($lp!=NULL && $lp == 0)
	    $params .= '&amp;lp=' . $lp;
	if ($mf!=NULL && $mf == 0)
	    $params .= '&amp;mf=0';
	if ($st!=NULL && ($st > 0 && is_int($st)))
	    $params .= '&amp;st=' . $st;
	if ($tourcta!=NULL && ($tourcta == 0 || $tourcta == 2))
	    $params .= '&amp;tourcta=' . $tourcta;

// Virtual Reality	
	if ($vr!=NULL && $vr == 0)
	    $params .= '&amp;vr=0';
	if ($vrcoll!=NULL && $vrcoll == 1)
	    $params .= '&amp;vrcoll=1';

// MPEmbed
	$ismpembed = array(
		'details','minimap','mdir','hdir','mdirsearch','copyright','logo','image','minimapurl','reels','spaces','nofade','ga', 'aa', 'filter','minimapfilter','fadehotspots','hotspots','tint','c','mpv','mpu','stats',
		'minimapnopano', 'minimaprotation', 'minimapsetrotation', 'minimaptags', 
		'bgmusic', 'bgmusicloop', 'bgmusicvol', 'bgmusicpaused', 'bgmusicpauseonmedia', 
		'compactdetails', 'openmt'
	);
	if ($mpu!=NULL && strlen($mpu) <= 4 && is_numeric($mpu))
	    $params .= '&amp;mpu=' . $mpu;
	if ($mpv!=NULL && strlen($mpv) <= 10)
	    $params .= '&amp;mpv=' . $mpv;
	if ($details!=NULL && ($details == 1 || $details == 2 || $details == 3))
	    $params .= '&amp;details=' . $details;
	if ($minimap!=NULL && ($minimap == 1 || $minimap == 2 || $minimap == 3))
	    $params .= '&amp;minimap=' . $minimap;
	if ($mdir!=NULL && ($mdir == 1 || $mdir == 2 || $mdir == 3))
	    $params .= '&amp;mdir=' . $mdir;
	if ($hdir!=NULL && ($hdir == 1 || $hdir == 2 || $hdir == 3))
	    $params .= '&amp;hdir=' . $hdir;
	if ($stats!=NULL && is_int($stats))
	    $params .= '&amp;stats=' . $stats;
	if ($mdirsearch!=NULL && $mdirsearch == 1)
	    $params .= '&amp;mdir=' . $mdirsearch;
	if ($copyright!=NULL && strlen($copyright) > 5)
	    $params .= '&amp;copyright=' . str_replace(" ","%20",$copyright);
	if ($logo!=NULL && strlen($logo) > 5)
	    $params .= '&amp;logo=' . urlencode($logo);
	if ($image!=NULL && strlen($image) > 5)
	    $params .= '&amp;image=' . urlencode($image);
	
	if ($compactdetails!=NULL && ($compactdetails == 1))
	    $params .= '&amp;compactdetails='.$compactdetails;
	if ($openmt!=NULL && strlen($openmt) == 11)
	    $params .= '&amp;openmt='.$openmt;


// BG Music
	if ($bgmusic!=NULL && strlen($bgmusic) > 5)
	    $params .= '&amp;bgmusic=' . urlencode($bgmusic);
	if ($bgmusicloop!=NULL && $bgmusicloop == 1)
	    $params .= '&amp;bgmusicloop=1';
	if ($bgmusicvol!=NULL && is_numeric($bgmusicvol) && $bgmusicvol > 0.1 && bgmusic <= 1)
	    $params .= '&amp;bgmusicvol=' . $bgmusicvol;
	if ($bgmusicpaused!=NULL && $bgmusicpaused == 1)
	    $params .= '&amp;bgmusicpaused=1';
	if ($bgmusicpauseonmedia!=NULL && $bgmusicpauseonmedia == 1)
	    $params .= '&amp;bgmusicpauseonmedia=1';
	
	
// Minimap
	if ($minimapurl!=NULL && strlen($minimapurl) > 5)
	    $params .= '&amp;minimapurl=' . urlencode($minimapurl);
	if ($minimaprotation!=NULL && strlen($minimaprotation) > 5)
	    $params .= '&amp;stats=' . $stats;
	if ($minimapsetrotation!=NULL && is_int($minimapsetrotation) && $minimapsetrotation > 0 && $minimapsetrotation < 360)
	    $params .= '&amp;minimapsetrotation=' . $minimapsetrotation;
	if ($minimaptags!=NULL && $minimaptags == 1)
	    $params .= '&amp;minimaptags=1';
	if ($minimapfilter!=NULL && strlen($minimapfilter) >= 5)
	    $params .= '&amp;minimapfilter=' . $minimapfilter;	
	if ($minimapnopano!=NULL && $minimapnopano == 1)
	    $params .= '&amp;minimapnopano=' . $minimapnopano;	
	if ($fadehotspots!=NULL && $fadehotspots == 1)
	    $params .= '&amp;fadehotspots=' . $fadehotspots;
	if ($hotspots!=NULL && $hotspots == 2)
	    $params .= '&amp;hotspots=' . $hotspots;

// Reels / Spaces
	if ($reels!=NULL && substr_count(",",$reels) > 1)
	    $params .= '&amp;reels=' . $reels;
	if ($spaces!=NULL && substr_count(",",$spaces) > 1)
	    $params .= '&amp;spaces=' . $spaces;
	if ($nofade!=NULL && $nofade == 1)
	    $params .= '&amp;nofade=' . $nofade;
	if ($ga!=NULL && strlen($ga) >= 14)
	    $params .= '&amp;ga=' . $ga;
	if ($aa!=NULL && strlen($aa) >= 8)
	    $params .= '&amp;aa=' . $aa;
	if ($filter!=NULL && strlen($filter) >= 5)
	    $params .= '&amp;filter=' . $filter;
	if ($tint!=NULL && strlen($tint) == 6)
	    $params .= '&amp;tint=' . $tint;
	if ($c!=NULL && $c == 'cn')
	    $params .= '&amp;c=' . $c;
	
// Advanced
	if (count($tours) > 1 && $start!=NULL)
	    $params .= '&amp;start=' . $start;

	foreach ($tours as $src) {
		if (strlen($src) == 0)
			continue;
		$src = str_replace("https://my.matterport.com/show/?m=", "", $src);
		$src = str_replace("https://mpembed.com/show/?m=", "", $src);
		$link = 'https://my.matterport.com/show/?m=' . $src . $params;
		
		
		
		if ($showcase_version != NULL && $showcase_version == 3)
			$link = str_replace('/show/','/showcase-beta/', $link);
		
		// Auto Enable MPEmbed if parameters are used.
		$mpembed = 0;
		foreach($ismpembed as $var) {
			if (isset($$var))
				$mpembed = 1;
		}
		if ($mpembed == 1)
			$link = str_replace('https://my.matterport.com/show/?m=', 'https://mpembed.com/show/?m=', $link);
		
		// Mitigate Cross Site Scripting (XSS) vulnerability by refusing // and " in src param
		//echo "[src ".$src."]";
		if (strpos($src, '//') !== false || strpos($src, '"') !== false)
			continue;
		
		// Extract Space ID
		$spaceid = substr($src, 0, 11);
		if (!ctype_alnum($spaceid)){  //make sure $spaceid is alphanumeric only
			$spaceid = '';
		}
		//echo "[spaceid ".$spaceid."]";
		
		// Let's see if we have the data cached in the database...
		global $wpdb;
		
		// Get Space's data
		$cachedTour = $wpdb->get_var(
			$wpdb->prepare("
					SELECT data 
					FROM {$wpdb->prefix}wpms 
					WHERE name=%s
					LIMIT 1
				", [ urldecode($src) ]
			)
		);
	//	echo "<pre>".json_encode($cachedTour, JSON_PRETTY_PRINT)."</pre>";
		
		// Pull JSON object from Wordpress Transients as array
		if (strlen($cachedTour) > 1)
			$thisTour = json_decode($cachedTour, TRUE);
		// Otherwise, let's go and find it!
		else {
			// Connect to JSON Feed
			$json = 'https://my.matterport.com/api/v1/player/models/' . $spaceid . '/?format=json';
		    /*if (function_exists("curl_init")) {
				$curl_options = array(
					CURLOPT_URL => $json,
					CURLOPT_HEADER => 0,
					CURLOPT_RETURNTRANSFER => TRUE,
					CURLOPT_TIMEOUT => 0,
					CURLOPT_SSL_VERIFYPEER => 0,
					CURLOPT_ENCODING => 'gzip,deflate',
				);
				$ch = curl_init();
				curl_setopt_array( $ch, $curl_options );
				$output = curl_exec( $ch );
				curl_close($ch);*/
				$output = wp_remote_get($json);
				
			if (isset($output["body"])){   //check if json returned content
				
				$arr = json_decode($output["body"],true);
				
				$values = array("name","address","contact_name","contact_phone","formatted_contact_phone","contact_email");
				
				foreach($values as $value) {
					if (isset($arr[$value]))
						$thisTour[$value] = $arr[$value];
					else
						$thisTour[$value] = "";
				}
				$thisTour["nodes"] 			= (isset($arr['sweeps']) ? count($arr['sweeps']) : 0);
				$thisTour["player_options"] = (isset($arr['player_options']) ? $arr['player_options'] : "");
				$thisTour["is_vr"] 			= (isset($arr['is_vr']) ? $arr['is_vr'] : false);
				$thisTour["created"] 		= (isset($arr["created"]) ? $arr["created"] : "");
				$thisTour["modified"] 		= (isset($arr["modified"]) ? $arr["modified"] : "");
				/*}*/
				$thisTour["image"] = 'http://my.matterport.com/api/v1/player/models/' . $spaceid . '/thumb';

				// Save data to Wordpress to cache for next time...
				$jsonData = wp_json_encode($thisTour);
				$table_name = $wpdb->prefix . 'wpms'; 
				if ($thisTour != null) {
					if (!($wpdb->insert( $table_name, // Custom Table wp_wpms
						array( 
							'time' => (isset($arr["created"]) ? $arr["created"] : ""),
							'name' => $src, 
							'data' => $jsonData 
						) 
					))) {
					unset($thisTour);
					}
				}
			}	
		}
?>
            <div class="wpm<?php 
	    if ($cols > 1 && is_numeric($cols))
        	echo ' wpm-cols' . esc_html($cols);
        ?>">
<?php
		if (!isset($thisTour)) {
?>
                <div class="wpm-img" style="color: #fff; padding: 10px; font-size: 10px">
				Private or invalid tour id: <?php echo esc_html($src) ?>
				</div>
<?php
		}
		else {
// --
			// If title parameter is used in shortcode ...
			if (isset($titles[$i]) && strlen($titles[$i]) > 2) {
				$thisTour["name"] = esc_html($titles[$i]);
				if (strlen($thisTour["name"]) < 1)
					$thisTour["name"] = "hidden";
			}

			// if width / height parameters not present, default is 960 x 540 - but if cols > 1, default to 640 x 360
			if ($width == NULL && $height == NULL) {
				if ($cols != 1)
					$width = 640;
				else
					$width = 960;
			}
			
			if (!is_numeric($width)){
				if ($cols != 1)
					$width = 640;
				else
					$width = 960;
			}
			
			if (!is_numeric($height)){
					$height = NULL;
			}
			
			$thisTour["image"] = '//my.matterport.com/api/v1/player/models/' . $spaceid . '/thumb/';
			if ($height != NULL)
				$thisTour["image"] .= '?height=' . $height;
			else
				$thisTour["image"] .= '?width=' . $width;


			$class = 'wpm-tour wpm' . $src;
			if ($window == NULL && $embed == NULL) {
				$class .= ' wpm-overlay';
			}
			if ($embed != NULL) {
				$class .= ' wpm-embedded';
			}
			if ($window != NULL && !preg_match('/^[A-Za-z0-9_]+$/',$window)){
				$window = NULL;
			}
			
			
			
?>		

                <div class="wpm-img">
					<?php if ($embed != NULL) { ?>
						<a href="#" data-width="<?php echo esc_html($width) ?>" data-src="<?php echo esc_url($link) ?>&play=1" class="<?php echo esc_html($class) ?>"
					<?php } else {?>	
						<a href="<?php echo esc_url($link) ?>&play=1" class="<?php echo esc_html($class) ?>"
                    <?php 
                    }
                    
				if ($window != NULL)
					echo ' target="' . esc_html($window) . '"';
					?>>
					<img src="<?php echo esc_html($thisTour["image"]) ?>" />
                        <b>&#9658;</b>
                        <i><?php 
						
							if (isset($welcome) && strlen($welcome) > 2)
								echo esc_html($welcome);
							else
								esc_html_e('Explore 3D Space', 'wp-matterport'); 
						?></i>			
                    </a>
                </div>
                <div class="wpm-info">
<?php
			if ($thisTour["name"] != "hidden") {
?>
                	<span class="wpm-title"><a class="<?php echo ($window ? 'wpm-overlay ' : '')?>wpm-tour" href="<?php echo esc_url($link) ?>&amp;play=1<?php
					
				if ($window != NULL)
					echo '" target="' . esc_html($window);					

					?>"><?php echo esc_html($thisTour["name"]) ?></a></span>
<?php
			}
			if (isset($thisTour["address"]) && $address!=NULL) {
				if (!is_array($thisTour["address"]))
					$thisAddress = json_decode($thisTour["address"]);
				else
					$thisAddress = (object) $thisTour["address"];
?>
					<div class="wpm-address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
<?php
				if (isset($thisAddress->address_1) && strlen($thisAddress->address_1) > 2) {
?>				
						<span class="wpm-street" itemprop="streetAddress"><?php 
					echo esc_html($thisAddress->address_1);
					if (isset($thisAddress->address_2) && strlen($thisAddress->address_2) > 2)
						echo '<span>' . esc_html($thisAddress->address_2) . '</span>'; 
						?></span>
<?php
				}
				if (isset($thisAddress->city) && strlen($thisAddress->city) > 2)
					echo "\t\t\t\t\t\t<span class='wpm-city' itemprop='addressLocality'>" . esc_html($thisAddress->city) . "</span>\n";
				if (isset($thisAddress->state) && strlen($thisAddress->state) > 2)
					echo "\t\t\t\t\t\t<span class='wpm-state' itemprop='addressRegion'>" . esc_html($thisAddress->state) . "</span>\n";
				if (isset($thisAddress->zip) && strlen($thisAddress->zip) > 2)
					echo "\t\t\t\t\t\t<span class='wpm-zip' itemprop='postalCode'>" . esc_html($thisAddress->zip) . "</span>\n";
?>
					</div>
<?php
			}
			if ($showstats!=NULL && isset($thisTour["nodes"])) {
				echo "\t\t\t\t\t<span class=\"wpm-nodes\">\n";
				echo "\t\t\t\t\t\t<span class=\"wpm-scans\">" . esc_html($thisTour["nodes"]) . " ";
				esc_html_e('Scans','wp-matterport');
				echo "</span>\n";
				if (isset($thisTour["floors"]) && $thisTour["floors"] > 1) {
					echo "\t\t\t\t\t\t<span class=\"wpm-floors\">" . esc_html($thisTour["floors"]);
					esc_html_e('Floors','wp-matterport');
					echo "</span>\n";
				}
				echo "\t\t\t\t\t</span>\n";
			}
			if ($showdate != NULL) {
				if ($showdate == 'modified')
					echo "\t\t\t\t\t" . '<div class="wpm-date">' . esc_html(__('Last modified','wp-matterport')) . ': ' . esc_html(gmdate($date_format,strtotime($thisTour["modified"]))) . '</div>';
				else
					echo '<div class="wpm-date">' . esc_html(__('Created, wpst modified: ','wp-matterport')) . ': ' . esc_html(gmdate($date_format,strtotime($thisTour["created"]))) . '</div>';
			}
			echo "\t\t\t\t</div>\n";
		}
		echo "\t\t\t</div>\n";

		$i++;

	    		if ($admin != NULL) {
		?>
			<div style="text-align: center; width:100%; margin-bottom: 20px;">
				<?php 
				$nonce = wp_create_nonce( 'MP_refresh_'.$src, 'refresh_nonce');
				echo esc_html($src) . ' - ';
				?>
				<a href="<?php echo esc_url($_SERVER["PHP_SELF"]) ?>?page=wpms-options&amp;refresh=<?php echo urlencode($src) ?>&amp;_wpnonce=<?php echo esc_html($nonce); ?>"><?php esc_html_e('Reload Thumbnail / Information','wp-matterport'); ?></a> | 
				<a href="https://my.matterport.com/models/<?php echo urlencode($src) ?>" target="_blank"><?php esc_html_e('MyMatterport','wp-matterport'); ?></a>
			</div>
		<?php
		}
		
	}
	echo "\t\t</div>\n";
	return ob_get_clean();
}
add_shortcode( 'matterport', 'matterport_embed_shortcode' );
