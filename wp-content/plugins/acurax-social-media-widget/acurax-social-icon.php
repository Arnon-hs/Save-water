<?php
/* 
Plugin Name: Social Media Widget by Acurax
Plugin URI: http://www.acurax.com/products/floating-social-media-icon-plugin-wordpress/
Description: A Simple Wordpress Plugin Which Allow You To Add Widget Which Links Social Media Icons to Your Social Media Profiles Twitter,Facebook,Pinterest,Youtube,Rss Feed,Linkedin,google plus. You can define icon style size for each widget.
Author: Acurax 
Version: 3.1
Author URI: http://www.acurax.com/home.php
License: GPLv2 or later
*/
/*
Copyright 2008-current  Acurax International  ( website : www.acurax.com )
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/ 
define('ACX_SOCIALMEDIA_WIDGET_TOTAL_THEMES', 24);
define('ACX_SMW_TOTAL_STATIC_SERVICES', 7);
define('ACX_SMW_VERSION', "3.1");
define("ACX_SMW_BASE_LOCATION",plugin_dir_url( __FILE__ ));
define("ACX_SMW_WP_SLUG","acurax-social-media-widget");

include_once('function.php');
include_once('includes/hooks.php');
include_once('includes/hook_functions.php');
include_once('includes/option_fields.php');

//*************** Include JS in Header ********
function enqueue_acx_social_widget_icon_script()
{
	wp_enqueue_script ( 'jquery' );
}	add_action( 'get_header', 'enqueue_acx_social_widget_icon_script' );
//*************** Include JS in Header Ends Here ********
//*********** Include Additional Menu ********************
function Acurax_Widget_Links($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	$acx_installation_domain = $_SERVER['HTTP_HOST'];
	$acx_installation_domain = str_replace("www.","",$acx_installation_domain);
	$acx_installation_domain = str_replace(".","_",$acx_installation_domain);
	if($acx_installation_domain == "") { $acx_installation_domain = "not_defined";}
	if ($file == $plugin) {
	
		return array_merge( $links, array( 
			'<div id="plugin_page_links"><a href="http://www.acurax.com?utm_source=wp&utm_medium=link&utm_campaign=plugin-page&ref=' . $acx_installation_domain . '" target="_blank">' . __('Acurax International') . '</a>',
			'<a href="http://www.acurax.com/services/wordpress-designing-experts.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page&ref=' . $acx_installation_domain . '" target="_blank">' . __('Wordpress Expert Support') . '</a>',
			'<a href="http://www.acurax.com/services/wordpress-designing-experts.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page&ref=' . $acx_installation_domain . '" target="_blank">' . __('Need Help Configuring Plugins?') . '</a>',
			'<a href="http://www.acurax.com/services/wordpress-designing-experts.php?utm_source=wp&utm_medium=link&utm_campaign=plugin-page&ref=' . $acx_installation_domain . '" target="_blank">' . __('Instant Quick Support') . '</a>'
		));
	}
	return $links;
}	add_filter('plugin_row_meta', 'Acurax_Widget_Links', 10, 2 );
//*********************************************************

//*************** Admin function ***************
function acx_social_widget_icon_admin() 
{
	include(plugin_dir_path( __FILE__ ).'/includes/acx_smw_options.php');
}
function acx_social_widget_icon_help() 
{
	include(plugin_dir_path( __FILE__ ).'/includes/acx_smw_social_help.php');
}
function acx_social_widget_icon_premium() 
{
	include(plugin_dir_path( __FILE__ ).'/includes/acx_smw_premium.php');
}
function acx_social_widget_troubleshoot() 
{
	include(plugin_dir_path( __FILE__ ).'/includes/acx_smw_troubleshoot.php');
}
function acx_social_widget_icon_misc() 
{
	include(plugin_dir_path( __FILE__ ).'/includes/acx_smw_misc.php');
}
$acx_widget_si_current_version=get_option('acx_widget_si_current_version');
	if($acx_widget_si_current_version != "" && $acx_widget_si_current_version < ACX_SMW_VERSION)
	{
		add_action('admin_head','acx_smw_migration_fn');
	}

function acx_smw_migration_fn()
{
	// Getting Option From DB *****************************	
$acx_widget_si_theme = get_option('acx_widget_si_theme');
if($acx_widget_si_theme != '')
{
	update_option('acx_si_theme', $acx_widget_si_theme);
	
}
$acx_widget_si_credit = get_option('acx_widget_si_credit');
if($acx_widget_si_credit != '')
{
	update_option('acx_si_credit', $acx_widget_si_credit);
	
}
$acx_widget_si_facebook = get_option('acx_widget_si_facebook');

if($acx_widget_si_facebook != '')
{
	update_option('acx_si_facebook', $acx_widget_si_facebook);

}
$acx_widget_si_youtube = get_option('acx_widget_si_youtube');
if($acx_widget_si_youtube != '')
{
	update_option('acx_si_youtube', $acx_widget_si_youtube);

}
$acx_widget_si_twitter = get_option('acx_widget_si_twitter');
if($acx_widget_si_twitter != '')
{
	update_option('acx_si_twitter', $acx_widget_si_twitter);

}
$acx_widget_si_linkedin = get_option('acx_widget_si_linkedin');
if($acx_widget_si_linkedin != '')
{
	update_option('acx_si_linkedin', $acx_widget_si_linkedin);
	
}
$acx_widget_si_gplus = get_option('acx_widget_si_gplus');
if($acx_widget_si_gplus != '')
{
	update_option('acx_si_gplus', $acx_widget_si_gplus);
	
}
$acx_widget_si_pinterest = get_option('acx_widget_si_pinterest');
if($acx_widget_si_pinterest != '')
{
	update_option('acx_si_pinterest', $acx_widget_si_pinterest);
	
}
$acx_widget_si_feed = get_option('acx_widget_si_feed');
if($acx_widget_si_feed != '')
{
	update_option('acx_si_feed', $acx_widget_si_feed);

}
$acx_widget_si_icon_size = get_option('acx_widget_si_icon_size');
if($acx_widget_si_icon_size != '')
{
	update_option('acx_si_icon_size', $acx_widget_si_icon_size);
	
}
$acx_si_smw_float_fix = get_option('acx_si_smw_float_fix');
if($acx_si_smw_float_fix != '')
{
	update_option('acx_si_fsmi_float_fix', $acx_si_smw_float_fix);
	
}
$acx_si_smw_theme_warning_ignore = get_option('acx_si_smw_theme_warning_ignore');
if($acx_si_smw_theme_warning_ignore != '')
{
	update_option('acx_si_fsmi_theme_warning_ignore', $acx_si_smw_theme_warning_ignore);
	
}
$acx_si_asmw_hide_expert_support_menu = get_option('acx_si_asmw_hide_expert_support_menu');
if($acx_si_asmw_hide_expert_support_menu != '')
{
	update_option('acx_si_fsmi_hide_expert_support_menu', $acx_si_asmw_hide_expert_support_menu);
	
}
$acx_si_smw_hide_advert = get_option('acx_si_smw_hide_advert');
if($acx_si_smw_hide_advert != '')
{
	update_option('acx_si_fsmi_hide_advert', $acx_si_smw_hide_advert);
	
}
$acx_si_smw_acx_service_banners = get_option('acx_si_smw_acx_service_banners');
if($acx_si_smw_acx_service_banners != '')
{
	update_option('acx_fsmi_acx_service_banners', $acx_si_smw_acx_service_banners);
	
}


// *****************************************************
	
	update_option('acx_widget_si_current_version', ACX_SMW_VERSION);
}

function acx_social_widget_icon_admin_actions()
{
$acx_si_asmw_hide_expert_support_menu = get_option('acx_si_asmw_hide_expert_support_menu');
if ($acx_si_asmw_hide_expert_support_menu == "") {	$acx_si_asmw_hide_expert_support_menu = "no"; }
	add_menu_page(  'Acurax Social Media Widget Configuration', 'Social Media Widget Settings', 'manage_options', 'Acurax-Social-Widget-Settings','acx_social_widget_icon_admin',plugin_dir_url( __FILE__ ).'images/admin.png' ); // 'manage_options' for admin
	
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Icon Premium', 'Premium', 'manage_options', 'Acurax-Social-Widget-Premium' ,'acx_social_widget_icon_premium');
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Icon Misc Settings', 'Misc', 'manage_options', 'Acurax-Social-Widget-Misc' ,'acx_social_widget_icon_misc');
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Troubleshooter', 'Troubleshoot', 'manage_options', 'Acurax-Social-Widget-Troubleshooter' ,'acx_social_widget_troubleshoot');
	if($acx_si_asmw_hide_expert_support_menu == "no") {
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Expert Support', 'Expert Support', 'manage_options', 'Acurax-Social-Widget-Expert-Support' ,'acx_social_widget_troubleshoot');
	}
	add_submenu_page('Acurax-Social-Widget-Settings', 'Acurax Social Widget Help and Support', 'Help', 'manage_options', 'Acurax-Social-Widget-Help' ,'acx_social_widget_icon_help'); 
}
	
if ( is_admin() )
{
	add_action('admin_menu', 'acx_social_widget_icon_admin_actions');
}
?>