<?php
/*
Plugin Name: Ultimate Social Media PLUS
Plugin URI: http://ultimatelysocial.com
Description: The best social media plugin on the market. And 100% FREE. Allows you to add social media & share icons to your blog (esp. Facebook, Twitter, Email, RSS, Pinterest, Instagram, Google+, LinkedIn, Share-button). It offers a wide range of design options and other features. 
Author: UltimatelySocial
Text Domain: ultimate-social-media-plus
Domain Path: /languages
Author URI: http://ultimatelysocial.com
Version: 2.5.1
License: GPLv2
*/

global $wpdb;
/* define the Root for URL and Document */

define('SFSI_PLUS_DOCROOT',    dirname(__FILE__));
define('SFSI_PLUS_PLUGURL',    plugin_dir_url(__FILE__));
define('SFSI_PLUS_WEBROOT',    str_replace(getcwd(), home_url(), dirname(__FILE__)));
define('SFSI_PLUS_DOMAIN',	   'ultimate-social-media-plus');

/* load all files  */
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsi_socialhelper.php');
include(SFSI_PLUS_DOCROOT.'/libs/sfsi_install_uninstall.php');
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsi_buttons_controller.php');
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsi_iconsUpload_contoller.php');
include(SFSI_PLUS_DOCROOT.'/libs/sfsi_Init_JqueryCss.php');
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsi_floater_icons.php');
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsi_frontpopUp.php');
include(SFSI_PLUS_DOCROOT.'/libs/controllers/sfsiocns_OnPosts.php');
include(SFSI_PLUS_DOCROOT.'/libs/sfsi_widget.php');
include(SFSI_PLUS_DOCROOT.'/libs/sfsi_plus_subscribe_widget.php');

/* plugin install and uninstall hooks */ 
register_activation_hook(__FILE__, 'sfsi_plus_activate_plugin' );
register_deactivation_hook(__FILE__, 'sfsi_plus_deactivate_plugin');
register_uninstall_hook(__FILE__, 'sfsi_plus_Unistall_plugin');

/*Plugin version setup*/
if(!get_option('sfsi_plus_pluginVersion') || get_option('sfsi_plus_pluginVersion') < 2.51)
{
	add_action("init", "sfsi_plus_update_plugin");
}

//shortcode for the ultimate social icons {Monad}
add_shortcode("DISPLAY_ULTIMATE_PLUS", "DISPLAY_ULTIMATE_PLUS");
function DISPLAY_ULTIMATE_PLUS($args = null, $content = null)
{
	$instance = array("showf" => 1, "title" => '');
	$sfsi_plus_section8_options = get_option("sfsi_plus_section8_options");
	$sfsi_plus_section8_options = unserialize($sfsi_plus_section8_options);
	$sfsi_plus_place_item_manually = $sfsi_plus_section8_options['sfsi_plus_place_item_manually'];
	if($sfsi_plus_place_item_manually == "yes")
	{
		$return = '';
		if(!isset($before_widget)): $before_widget =''; endif;
		if(!isset($after_widget)): $after_widget =''; endif;
		
		/*Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$show_info = isset( $instance['show_info'] ) ? $instance['show_info'] : false;
		global $is_floter;	      
		$return.= $before_widget;
			/* Display the widget title */
			if ( $title ) $return .= $before_title . $title . $after_title;
			$return .= '<div class="sfsi_plus_widget">';
				$return .= '<div id="sfsi_plus_wDiv"></div>';
				/* Link the main icons function */
				$return .= sfsi_plus_check_visiblity(0);
		  		$return .= '<div style="clear: both;"></div>';
			$return .= '</div>';
		$return .= $after_widget;
		return $return;
	}
	else
	{
		return __('Kindly go to setting page and check the option "Place them manually"', SFSI_PLUS_DOMAIN);
	}
}
//adding some meta tags for facebook news feed {Monad}
function sfsi_plus_checkmetas()
{
	if ( ! function_exists( 'get_plugins' ) )
	{
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$all_plugins = get_plugins();
	foreach($all_plugins as $key => $plugin)
	{
		if(is_plugin_active($key))
		{
			if(preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Name']) || preg_match("/(seo|search engine optimization|meta tag|open graph|opengraph|og tag|ogtag)/im", $plugin['Description']))
			{
				update_option("adding_plustags", "no");
				break;
			}
			else
			{
				update_option("adding_plustags", "yes");
			}
		}
	}
}
if ( ! is_admin() )
{
	sfsi_plus_checkmetas();
}

add_action('wp_head', 'ultimateplusfbmetatags');
function ultimateplusfbmetatags()
{
	$metarequest = get_option("adding_plustags");
	$post_id = get_the_ID();
	
	$feed_id = sanitize_text_field(get_option('sfsi_plus_feed_id'));
	$verification_code = get_option('sfsi_plus_verificatiom_code');
	if(!empty($feed_id) && !empty($verification_code) && $verification_code != "no" )
	{
	    echo '<meta name="specificfeeds-verification-code-'.$feed_id.'" content="'.$verification_code.'"/>';
	}
	
	if($metarequest == 'yes' && !empty($post_id))
	{	
	   $post = get_post( $post_id );
	   $attachment_id = get_post_thumbnail_id($post_id);
	   $title = str_replace('"', "", strip_tags(get_the_title($post_id)));
	   $description = $post->post_content;
	   $description = str_replace('"', "", strip_tags($description));
	   $url = get_permalink($post_id);
	
		//checking for disabling viewport meta tag
		$option5 =  unserialize(get_option('sfsi_plus_section5_options',false));
		if(isset($option5['sfsi_plus_disable_viewport']))
		{
			$sfsi_plus_disable_viewport = $option5['sfsi_plus_disable_viewport'];	 
		}
		else
		{
			$sfsi_plus_disable_viewport = 'no';
		}
		if($sfsi_plus_disable_viewport == 'no')
		{
	   		echo ' <meta name="viewport" content="width=device-width, initial-scale=1">';
		}
		//checking for disabling viewport meta tag
		
	   if($attachment_id)
	   {
	       $feat_image = wp_get_attachment_url( $attachment_id );
		   if (preg_match('/https/',$feat_image))
		   {
				   echo '<meta property="og:image:secure_url" content="'.$feat_image.'" data-id="sfsi-plus"/>';
		   }
		   else
		   {
				   echo '<meta property="og:image" content="'.$feat_image.'" data-id="sfsi-plus"/>';
		   }
		   $metadata = wp_get_attachment_metadata( $attachment_id );
		   if(isset($metadata) && !empty($metadata))
		   {
			   if(isset($metadata['sizes']['post-thumbnail']))
			   {
					$image_type = $metadata['sizes']['post-thumbnail']['mime-type'];
			   }
			   else
			   {
					$image_type = '';  
			   }
			   if(isset($metadata['width']))
			   {
					$width = $metadata['width'];
			   }
			   else
			   {
					$width = '';  
			   }
			   if(isset($metadata['height']))
			   {
					$height = $metadata['height'];
			   }
			   else
			   {
					$height = '';  
			   }
		   }
		   else
		   {
				$image_type = '';
				$width = '';
				$height = '';  
		   }
		   echo '<meta property="og:image:type" content="'.$image_type.'" data-id="sfsi-plus"/>';
		   echo '<meta property="og:image:width" content="'.$width.'" data-id="sfsi-plus"/>';
		   echo '<meta property="og:image:height" content="'.$height.'" data-id="sfsi-plus"/>';
	  	   echo '<meta property="og:description" content="'.$description.'" data-id="sfsi-plus"/>';
	       echo '<meta property="og:url" content="'.$url.'" data-id="sfsi-plus"/>';
	   	   echo '<meta property="og:title" content="'.$title.'" data-id="sfsi-plus"/>';
   		}
	}
}

//Get verification code
if(is_admin())
{	
	$code 		= sanitize_text_field(get_option('sfsi_plus_verificatiom_code'));
	$feed_id 	= sanitize_text_field(get_option('sfsi_plus_feed_id'));
	if(empty($code) && !empty($feed_id))
	{
		add_action("init", "sfsi_plus_getverification_code");
	}
}
function sfsi_plus_getverification_code()
{
	$feed_id = sanitize_text_field(get_option('sfsi_plus_feed_id'));
	$curl = curl_init();  
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://www.specificfeeds.com/wordpress/getVerifiedCode_plugin',
        CURLOPT_USERAGENT => 'sf get verification',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => array(
            'feed_id' => $feed_id
        )
    ));
    
	// Send the request & save response to $resp
	$resp = curl_exec($curl);
	$resp = json_decode($resp);
	update_option('sfsi_plus_verificatiom_code', $resp->code);
	curl_close($curl);
}

//functionality for before and after single posts
add_filter( 'the_content', 'sfsi_plus_beforaftereposts' );
function sfsi_plus_beforaftereposts( $content )
{
	$org_content = $content;
	$icons_before = '';
	$icons_after = '';
	if(is_single())
	{
		$option8=  unserialize(get_option('sfsi_plus_section8_options',false));
		$lineheight = $option8['sfsi_plus_post_icons_size'];
		$lineheight = sfsi_plus_getlinhght($lineheight);
		$sfsi_plus_display_button_type = $option8['sfsi_plus_display_button_type'];
		$txt=(isset($option8['sfsi_plus_textBefor_icons']))? $option8['sfsi_plus_textBefor_icons'] : "Please follow and like us:" ;
		$float = $option8['sfsi_plus_icons_alignment'];
		if($float == "center")
		{
			$style_parent= 'text-align: center;';
			$style = 'float:none; display: inline-block;';
		}
		else
		{
			$style_parent= '';
			$style = 'float:'.$float;
		}
		if($option8['sfsi_plus_display_before_posts'] == "yes" && $option8['sfsi_plus_show_item_onposts'] == "yes")
		{
			$icons_before .= '<div class="sfsibeforpstwpr" style="'.$style_parent.'">';
				if($sfsi_plus_display_button_type == 'standard_buttons')
				{
					$icons_before .= sfsi_plus_social_buttons_below($content = null);
				}
				else
				{
					$icons_before .= "<div class='sfsi_plus_Sicons' style='".$style."'>";
						$icons_before .= "<div style='float:left;margin:0 0px; line-height:".$lineheight."px'><span>".$txt."</span></div>";
						$icons_before .= sfsi_plus_check_posts_visiblity(0 , "yes");
					$icons_before .= "</div>";
				}
			$icons_before .= '</div>';
			/*$icons_before .= '</br>';*/
		}
		if($option8['sfsi_plus_display_after_posts'] == "yes" && $option8['sfsi_plus_show_item_onposts'] == "yes")
		{
			/*$icons_after .= '</br>';*/
			$icons_after .= '<div class="sfsiaftrpstwpr"  style="'.$style_parent.'">';
			if($sfsi_plus_display_button_type == 'standard_buttons')
			{
				$icons_after .= sfsi_plus_social_buttons_below($content = null);
			}
			else
			{
				$icons_after .= "<div class='sfsi_plus_Sicons' style='".$style."'>";
					$icons_after .= "<div style='float:left;margin:0 0px; line-height:".$lineheight."px'><span>".$txt."</span></div>";
					$icons_after .= sfsi_plus_check_posts_visiblity(0 , "yes");
				$icons_after .= "</div>";
			}
			$icons_after .= '</div>';
		}
	}
	$content = $icons_before.$org_content.$icons_after;
	return $content;
}

//showing before and after blog posts
add_filter( 'the_content', 'sfsi_plus_beforeafterblogposts' );
function sfsi_plus_beforeafterblogposts( $content )
{
	if ( is_home() ) 
	{
		$icons_before = '';
		$icons_after = '';
		$sfsi_section8=  unserialize(get_option('sfsi_plus_section8_options',false));
		$lineheight = $sfsi_section8['sfsi_plus_post_icons_size'];
		$lineheight = sfsi_plus_getlinhght($lineheight);
		
		global $id, $post;
		$sfsi_plus_display_button_type = $sfsi_section8['sfsi_plus_display_button_type'];
		$sfsi_plus_show_item_onposts = $sfsi_section8['sfsi_plus_show_item_onposts'];
		$permalink = get_permalink($post->ID);
		$post_title = $post->post_title;
		$sfsiLikeWith="45px;";
		if($sfsi_section8['sfsi_plus_icons_DisplayCounts']=="yes")
		{
			$show_count=1;
			$sfsiLikeWith="75px;";
		}   
		else
		{
			$show_count=0;
		} 
		
		//checking for standard icons
		if(!isset($sfsi_section8['sfsi_plus_rectsub']))
		{
			$sfsi_section8['sfsi_plus_rectsub'] = 'no';
		}
		if(!isset($sfsi_section8['sfsi_plus_rectfb']))
		{
			$sfsi_section8['sfsi_plus_rectfb'] = 'yes';
		}
		if(!isset($sfsi_section8['sfsi_plus_rectgp']))
		{
			$sfsi_section8['sfsi_plus_rectgp'] = 'yes';
		}
		if(!isset($sfsi_section8['sfsi_plus_rectshr']))
		{
			$sfsi_section8['sfsi_plus_rectshr'] = 'yes';
		}
		if(!isset($sfsi_section8['sfsi_plus_recttwtr']))
		{
			$sfsi_section8['sfsi_plus_recttwtr'] = 'no';
		}
		if(!isset($sfsi_section8['sfsi_plus_rectpinit']))
		{
			$sfsi_section8['sfsi_plus_rectpinit'] = 'no';
		}
		if(!isset($sfsi_section8['sfsi_plus_rectfbshare']))
		{
			$sfsi_section8['sfsi_plus_rectfbshare'] = 'no';
		}
		
		//checking for standard icons
		$txt=(isset($sfsi_section8['sfsi_plus_textBefor_icons']))? $sfsi_section8['sfsi_plus_textBefor_icons'] : "Please follow and like us:" ;
		$float = $sfsi_section8['sfsi_plus_icons_alignment'];
		if($float == "center")
		{
			$style_parent= 'text-align: center;';
			$style = 'float:none; display: inline-block;';
		}
		else
		{
			$style_parent= '';
			$style = 'float:'.$float;
		}
		
		if(
			$sfsi_section8['sfsi_plus_display_before_blogposts'] == "yes" &&
			$sfsi_section8['sfsi_plus_show_item_onposts'] == "yes"
		)
		{
			//icon selection
			$icons_before .= "<div class='sfsibeforpstwpr' style='".$style_parent."'>";
				$icons_before .= "<div class='sfsi_plus_Sicons ".$float."' style='".$style."'>";
					if($sfsi_plus_display_button_type == 'standard_buttons')
					{
						if(
							$sfsi_section8['sfsi_plus_rectsub']		== 'yes' ||
							$sfsi_section8['sfsi_plus_rectfb']		== 'yes' ||
							$sfsi_section8['sfsi_plus_rectgp']		== 'yes' ||
							$sfsi_section8['sfsi_plus_rectshr'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_recttwtr'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_rectpinit'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_rectfbshare'] == 'yes' 
						)
						{
							$icons_before .= "<div style='display: inline-block;margin-bottom: 0; margin-left: 0; margin-right: 8px; margin-top: 0; vertical-align: middle;width: auto;'><span>".$txt."</span></div>";
						}
						if($sfsi_section8['sfsi_plus_rectsub'] == 'yes')
						{
							if($show_count){$sfsiLikeWithsub = "93px";}else{$sfsiLikeWithsub = "64px";}
							if(!isset($sfsiLikeWithsub)){$sfsiLikeWithsub = $sfsiLikeWith;}
							$icons_before.="<div class='sf_subscrbe' style='display: inline-block;vertical-align: middle;width: auto;'>".sfsi_plus_Subscribelike($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectfb'] == 'yes' || $sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
						{
							if($show_count){}else{$sfsiLikeWithfb = "48px";}
							if(!isset($sfsiLikeWithfb)){$sfsiLikeWithfb = $sfsiLikeWith;}
							$icons_before .= "<div class='sf_fb' style='display: inline-block; vertical-align: middle;width: auto;'>".sfsi_plus_FBlike($permalink,$show_count)."</div>";
						}
						/*if($sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
						{
							if($show_count){}else{$sfsiLikeWithfbshare = "48px";}
							if(!isset($sfsiLikeWithfbshare)){$sfsiLikeWithfbshare = $sfsiLikeWith;}
							$icons_before .= "<div class='sf_fbshare' style='display: inline-block; vertical-align: middle;width: auto;'>".sfsi_plus_FBlike($permalink,$show_count)."</div>";
						}*/
						if($sfsi_section8['sfsi_plus_recttwtr'] == 'yes')
						{
							if($show_count){$sfsiLikeWithtwtr = "77px";}else{$sfsiLikeWithtwtr = "56px";}
							if(!isset($sfsiLikeWithtwtr)){$sfsiLikeWithtwtr = $sfsiLikeWith;}
							$icons_before.="<div class='sf_twiter' style='display: inline-block;vertical-align: middle;width: auto;'>".sfsi_plus_twitterlike($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectpinit'] == 'yes')
						{
							if($show_count){$sfsiLikeWithpinit = "100px";}else{$sfsiLikeWithpinit = "auto";}
							$icons_before.="<div class='sf_pinit' style='display: inline-block;vertical-align: middle;text-align:left;width: ".$sfsiLikeWithpinit."'>".sfsi_plus_pinitpinterest($permalink,$show_count)."</div>";
						}
						
						if($sfsi_section8['sfsi_plus_rectgp'] == 'yes')
						{
							if($show_count){$sfsiLikeWithpingogl = "63px";}else{$sfsiLikeWithpingogl = "auto";}
							$icons_before .= "<div class='sf_google'  style='display: inline-block;vertical-align: middle;width: ".$sfsiLikeWithpingogl.";'>".sfsi_plus_googlePlus($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectshr'] == 'yes')
						{
							$icons_before .= "<div class='sf_addthis'  style='display: inline-block;vertical-align: middle;width: auto;margin-top: 6px;'>".sfsi_plus_Addthis_blogpost($show_count, $permalink, $post_title)."</div>";
						}
					}
					else
					{
						$icons_before .= "<div style='float:left;margin:0 0px; line-height:".$lineheight."px'><span>".$txt."</span></div>";
						$icons_before .= sfsi_plus_check_posts_visiblity(0 , "yes");
					}
				$icons_before .= "</div>";
			$icons_before .= "</div>";
			//icon selection
			if( $id && $post && $post->post_type == 'post' )
			{
				$content = $icons_before.$content;
			}
			else
			{
				$contnet = $content;
			}
		}
		if($sfsi_section8['sfsi_plus_display_after_blogposts'] == "yes" && $sfsi_section8['sfsi_plus_show_item_onposts'] == "yes")
		{
			//icon selection
			$icons_after .= "<div class='sfsiaftrpstwpr' style='".$style_parent."'>";
				$icons_after .= "<div class='sfsi_plus_Sicons ".$float."' style='".$style."'>";
					
					if($sfsi_plus_display_button_type == 'standard_buttons')
					{
						if(
							$sfsi_section8['sfsi_plus_rectsub'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_rectfb'] 		== 'yes' ||
							$sfsi_section8['sfsi_plus_rectgp'] 		== 'yes' ||
							$sfsi_section8['sfsi_plus_rectshr'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_recttwtr'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_rectpinit'] 	== 'yes' ||
							$sfsi_section8['sfsi_plus_rectfbshare'] == 'yes' 
						)
						{
							$icons_after .= "<div style='display: inline-block;margin-bottom: 0; margin-left: 0; margin-right: 8px; margin-top: 0; vertical-align: middle;width: auto;'><span>".$txt."</span></div>";
						}
						if($sfsi_section8['sfsi_plus_rectsub'] == 'yes')
						{
							if($show_count){$sfsiLikeWithsub = "93px";}else{$sfsiLikeWithsub = "64px";}
							if(!isset($sfsiLikeWithsub)){$sfsiLikeWithsub = $sfsiLikeWith;}
							$icons_after.="<div class='sf_subscrbe' style='display: inline-block;vertical-align: middle; width: auto;'>".sfsi_plus_Subscribelike($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectfb'] == 'yes' || $sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
						{
							if($show_count){}else{$sfsiLikeWithfb = "48px";}
							if(!isset($sfsiLikeWithfb)){$sfsiLikeWithfb = $sfsiLikeWith;}
							$icons_after .= "<div class='sf_fb' style='display: inline-block; vertical-align: middle;width: auto;'>".sfsi_plus_FBlike($permalink,$show_count)."</div>";
						}
						/*if($sfsi_section8['sfsi_plus_rectfbshare'] == 'yes')
						{
							if($show_count){}else{$sfsiLikeWithfbshare = "48px";}
							if(!isset($sfsiLikeWithfbshare)){$sfsiLikeWithfbshare = $sfsiLikeWith;}
							$icons_before .= "<div class='sf_fbshare' style='display: inline-block; vertical-align: middle;width: auto;'>".sfsi_plus_FBlike($permalink,$show_count)."</div>";
						}*/
						if($sfsi_section8['sfsi_plus_recttwtr'] == 'yes')
						{
							if($show_count){$sfsiLikeWithtwtr = "77px";}else{$sfsiLikeWithtwtr = "56px";}
							if(!isset($sfsiLikeWithtwtr)){$sfsiLikeWithtwtr = $sfsiLikeWith;}
							$icons_after.="<div class='sf_twiter' style='display: inline-block;vertical-align: middle;width: auto;'>".sfsi_plus_twitterlike($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectpinit'] == 'yes')
						{
							if($show_count){$sfsiLikeWithpinit = "100px";}else{$sfsiLikeWithpinit = "auto";}
						 	$icons_after.="<div class='sf_pinit' style='display: inline-block;text-align:left;vertical-align: middle;width: ".$sfsiLikeWithpinit."'>".sfsi_plus_pinitpinterest($permalink,$show_count)."</div>";
						}
						
						if($sfsi_section8['sfsi_plus_rectgp'] == 'yes')
						{
							if($show_count){$sfsiLikeWithpingogl = "63px";}else{$sfsiLikeWithpingogl = "auto";}
							$icons_after .= "<div class='sf_google' style='display: inline-block;vertical-align: middle;width: ".$sfsiLikeWithpingogl.";'>".sfsi_plus_googlePlus($permalink,$show_count)."</div>";
						}
						if($sfsi_section8['sfsi_plus_rectshr'] == 'yes')
						{
							$icons_after .= "<div class='sf_addthis'  style='display: inline-block;vertical-align: middle;width: auto;margin-top: 6px;'>".sfsi_plus_Addthis_blogpost($show_count, $permalink, $post_title)."</div>";
						}
					}
					else
					{
						$icons_after .= "<div style='float:left;margin:0 0px; line-height:".$lineheight."px'><span>".$txt."</span></div>";
						$icons_after .= sfsi_plus_check_posts_visiblity(0 , "yes");
					}
				$icons_after .= "</div>";
			$icons_after .= "</div>";
			//icon selection
			$content = $content.$icons_after;
		}	
	}
	return $content;
}

//getting line height for the icons
function sfsi_plus_getlinhght($lineheight)
{
	if( $lineheight < 16)
	{
		$lineheight = $lineheight*2;
		return $lineheight;
	}
	elseif( $lineheight >= 16 && $lineheight < 20 )
	{
		$lineheight = $lineheight+10;
		return $lineheight;
	}
	elseif( $lineheight >= 20 && $lineheight < 28 )
	{
		$lineheight = $lineheight+3;
		return $lineheight;
	}
	elseif( $lineheight >= 28 && $lineheight < 40 )
	{
		$lineheight = $lineheight+4;
		return $lineheight;
	}
	elseif( $lineheight >= 40 && $lineheight < 50 )
	{
		$lineheight = $lineheight+5;
		return $lineheight;
	}
	$lineheight = $lineheight+6;
	return $lineheight;
}

//sanitizing values
function sfsi_plus_string_sanitize($s) {
    $result = preg_replace("/[^a-zA-Z0-9]+/", " ", html_entity_decode($s, ENT_QUOTES));
    return $result;
}

add_action('admin_notices', 'sfsi_plus_admin_notice', 10);
function sfsi_plus_admin_notice()
{
	if(isset($_GET['page']) && $_GET['page'] == "sfsi-plus-options")
	{
		$style = "overflow: hidden; margin:12px 3px 0px;";
	}
	else
	{
		$style = "overflow: hidden;"; 
	}
	
	if(get_option("sfsi_plus_curlErrorNotices") == "yes")
	{ 
		$url = "?sfsiPlus-dismiss-curlNotice=true";
		?>
		<div class="error" style="<?php echo $style; ?>">
			<div class="alignleft" style="margin: 9px 0;">
				<?php	_e('There seems to be an error on your website which prevents the plugin to work properly. Please check the FAQ:', SFSI_PLUS_DOMAIN ); ?>
                <a href="http://www.ultimatelysocial.com/faq">
					<?php _e('Click here',SFSI_PLUS_DOMAIN); ?>
				</a>
                <p style="text-align:left">
                	<b><?php _e('Error', SFSI_PLUS_DOMAIN); ?>: <?php echo ucfirst(get_option("sfsi_plus_curlErrorMessage")); ?></b>
                </p>
			</div>
			<p class="alignright">
				<a href="<?php echo $url; ?>">
                <?php
					_e('Dismiss', SFSI_PLUS_DOMAIN);
				?>
                </a>
			</p>
		</div>
	<?php }
	
	if(get_option("sfsi_plus_show_notification_plugin") == "yes")
	{ 
		$url = "?sfsiPlus-dismiss-notice=true";
		?>
		<div class="updated" style="<?php echo $style; ?>"">
			<div class="alignleft" style="margin: 9px 0;">
				<b>
                	<?php _e( 'New feature in the Ultimate Social Media PLUS plugin: ', SFSI_PLUS_DOMAIN); ?>
                </b>  
                
				<?php _e( 'You can now add a subscription form to increase sign-ups (under question 8).', SFSI_PLUS_DOMAIN); ?>
                
                <a href="<?php echo site_url();?>/wp-admin/admin.php?page=sfsi-plus-options" style="color:#7AD03A; font-weight:bold;">
                	<?php _e( 'Check it out', SFSI_PLUS_DOMAIN); ?>
                </a>
			</div>
			<p class="alignright">
				<a href="<?php echo $url; ?>">
                	<?php _e( 'Dismiss', SFSI_PLUS_DOMAIN); ?>
                </a>
			</p>
		</div>
	<?php }
}

add_action('admin_init', 'sfsi_plus_dismiss_admin_notice');
function sfsi_plus_dismiss_admin_notice()
{
	if ( isset($_REQUEST['sfsiPlus-dismiss-curlNotice']) && $_REQUEST['sfsiPlus-dismiss-curlNotice'] == 'true' )
	{
		update_option( 'sfsi_plus_curlErrorNotices', "no" );
		header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-plus-options");
	}
	
	if ( isset($_REQUEST['sfsiPlus-dismiss-notice']) && $_REQUEST['sfsiPlus-dismiss-notice'] == 'true' )
	{
		update_option( 'sfsi_plus_show_notification_plugin', "no" );
		header("Location: ".site_url()."/wp-admin/admin.php?page=sfsi-plus-options");
	}
}

add_action('plugins_loaded', 'sfsi_plus_load_domain');
function sfsi_plus_load_domain() 
{
	$plugin_dir = basename(dirname(__FILE__)).'/languages';
	load_plugin_textdomain( 'ultimate-social-media-plus', false, $plugin_dir );
}

function sfsi_plus_get_bloginfo($url)
{
	$web_url = get_bloginfo($url);
	
	//Block to use feedburner url
	if (preg_match("/(feedburner)/im", $web_url, $match))
	{
		$web_url = site_url()."/feed";
	}
	return $web_url;
}
?>