<?php
/************************************************ OPTION PAGE ***************************************************/
function acx_smw_nonce_check()
{
	if (!isset($_POST['acx_smw_nonce'])) die("<br><br>Unknown Error Occurred, Try Again... <a href=''>Click Here</a>");
	if (!wp_verify_nonce($_POST['acx_smw_nonce'],'acx_smw_nonce')) die("<br><br>Unknown Error Occurred, Try Again... <a href=''>Click Here</a>");
	if(!current_user_can('manage_options')) die("<br><br>Sorry, You have no permission to do this action...</a>");
} add_action('acx_smw_hook_option_onpost','acx_smw_nonce_check',1);

function acx_smw_nonce_field()
{
	echo "<input name='acx_smw_nonce' type='hidden' value='".wp_create_nonce('acx_smw_nonce')."' />";
	echo "<input name='acx_smw_hidden' type='hidden' value='Y' />";
} add_action('acx_smw_hook_option_fields','acx_smw_nonce_field',10);

function acx_smw_option_form_start()
{
	echo "<form name='acx_smw_form' id='acx_smw_form'  method='post' action='".str_replace( '%7E', '~',$_SERVER['REQUEST_URI'])."'>";
} add_action('acx_smw_hook_option_form_head','acx_smw_option_form_start',100);


function acx_smw_option_form_end()
{
	echo "</form>";
}  add_action('acx_smw_hook_option_form_footer','acx_smw_option_form_end',100);


function acx_smw_option_div_start()
{
	echo "<div id=\"acx_smw_option_page_holder\"> \n";
	echo "<div class=\"acx_smw_option_page_left\"> \n";
} add_action('acx_smw_hook_option_form_head','acx_smw_option_div_start',30);


function acx_smw_option_sidebar_start()
{
	echo "</div> <!-- acx_smw_option_page_left --> \n";
	echo "<div class=\"acx_smw_option_page_right\"> \n";
}  add_action('acx_smw_hook_option_sidebar','acx_smw_option_sidebar_start',10);


function acx_smw_option_sidebar_end()
{
	echo "</div> <!-- acx_smw_option_page_right --> \n";
	acx_smw_hook_function('acx_smw_hook_option_footer');
	echo "</div> <!-- acx_smw_option_page_holder --> \n";
} add_action('acx_smw_hook_option_sidebar','acx_smw_option_sidebar_end',500);

function acx_smw_print_option_page_title()
{
 echo print_acx_smw_option_heading("Acurax Social Icons Options");
} add_action('acx_smw_hook_option_form_head','acx_smw_print_option_page_title',50);

function display_acx_smw_saved_success()
{ ?>
<div class="updated"><p><strong><?php _e('Settings Saved Successfully.'); ?></strong></p></div>
<script type="text/javascript">
 setTimeout(function(){
		jQuery('.updated').fadeOut('slow');
		
		}, 4000);

</script>
<?php
}   add_action('acx_smw_hook_option_onpost','display_acx_smw_saved_success',5000);

function acx_smw_lb_infobox()
{ ?>
<script type="text/javascript">
jQuery( ".smw_info_lb" ).click(function() {
var lb_title = jQuery(this).attr('lb_title');
var lb_content = jQuery(this).attr('lb_content');
var html= '<div id="acx_smw_c_icon_p_info_lb_h" style="display:none;"><div class="acx_smw_c_icon_p_info_c"><span class="acx_smw_c_icon_p_info_close" onclick="smw_remove_info()"></span><h4>'+lb_title+'</h4><div class="acx_smw_c_icon_p_info_content">'+lb_content+'</div></div></div> <!-- acx_smw_c_icon_p_info_lb_h -->';
jQuery( "body" ).append(html)
jQuery( "#acx_smw_c_icon_p_info_lb_h" ).fadeIn();
});

function smw_remove_info()
{
jQuery( "#acx_smw_c_icon_p_info_lb_h" ).fadeOut()
jQuery( "#acx_smw_c_icon_p_info_lb_h" ).remove();
};
</script>
<?php
} add_action('acx_smw_misc_hook_option_footer','acx_smw_lb_infobox');

function acx_smw_service_banners()
{
?>
<div id="acx_smw_sidebar">
<?php $acx_si_smw_acx_service_banners = get_option('acx_si_smw_acx_service_banners');
if ($acx_si_smw_acx_service_banners != "no") { ?>
<div id="acx_ad_banners_smw">
<a href="http://wordpress.acurax.com/?utm_source=smw&utm_campaign=sidebar_banner_1" target="_blank" class="acx_ad_smw_1">
<div class="acx_ad_smw_title"><?php _e('Need Help on Wordpress?','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_title -->
<div class="acx_ad_smw_desc"><?php _e('Instant Solutions for your wordpress Issues','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_desc -->
</a> <!--  acx_ad_smw_1 -->

<a href="http://wordpress.acurax.com/?utm_source=smw&utm_campaign=sidebar_banner_2" target="_blank" class="acx_ad_smw_1">
<div class="acx_ad_smw_title"><?php _e('Unique Design For Better Branding','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_title -->
<div class="acx_ad_smw_desc acx_ad_smw_desc2" style="padding-top: 0px; padding-left: 50px; height: 41px; font-size: 13px; text-align: center;"><?php _e('Get Responsive Custom Designed Website For High Conversion','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_desc -->
</a> <!--  acx_ad_smw_1 -->

<a href="http://wordpress.acurax.com/?utm_source=smw&utm_campaign=sidebar_banner_3" target="_blank" class="acx_ad_smw_1">
<div class="acx_ad_smw_title"><?php _e('Affordable Website Packages','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_title -->
<div class="acx_ad_smw_desc acx_ad_smw_desc3" style="padding-top: 0px; height: 32px; font-size: 13px; text-align: center;"><?php _e('Get Feature Rich Packages For a Custom Designed Website','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_desc -->
</a> <!--  acx_ad_smw_1 -->

</div> <!--  acx_ad_banners_smw -->
<?php } else { ?>


<div class="acx_smw_sidebar_widget">
<div class="acx_smw_sidebar_w_title"><?php _e('We Are Always Available','acurax-social-media-widget');?></div> <!-- acx_ad_smw_title -->
<div class="acx_smw_sidebar_w_content">
<?php _e('We know you are in the process of improving your website, and we the team at Acurax is always available for any help or support that you need. ','acurax-social-media-widget'); ?><a href="http://wordpress.acurax.com/?utm_source=smw&utm_campaign=sidebar_text_1" target="_blank"><?php _e('Get in touch','acurax-social-media-widget') ;?></a>
</div>
</div> <!-- acx_smw_sidebar_widget -->


<div class="acx_smw_sidebar_widget">
<div class="acx_smw_sidebar_w_title"><?php _e('Do You Know?','acurax-social-media-widget'); ?></div> <!-- acx_ad_smw_title -->
<div class="acx_smw_sidebar_w_content acx_smw_sidebar_w_content_p_slide">
</div>
</div> <!-- acx_smw_sidebar_widget -->
<script type="text/javascript">

var acx_smw = new Array("<?php _e('A professionally designed website is the most cost effective marketing tool available in the world today...','acurax-social-media-widget'); ?>","<?php _e('Personalizing your website can create a unique one to one experience and convert your visitors into customers.','acurax-social-media-widget'); ?>","<?php _e('70% of searches from mobile devices are followed up with an action within 1 hour.','acurax-social-media-widget'); ?>");

// jQuery(".acx_smw_sidebar_w_content_p_slide p").height('30px');
function acx_smw_t_rotate()
{
acx_smw_text = acx_smw[Math.floor(Math.random()*acx_smw.length)];
jQuery(".acx_smw_sidebar_w_content_p_slide").fadeOut('slow')
jQuery(".acx_smw_sidebar_w_content_p_slide").text(acx_smw_text);
jQuery(".acx_smw_sidebar_w_content_p_slide").fadeIn('fast');
}
jQuery(document).ready(function() {
acx_smw_t_rotate();
 setInterval(function(){ acx_smw_t_rotate(); }, 8000);
});
</script>
<div class="acx_smw_sidebar_widget">
<div class="acx_smw_sidebar_w_title"><?php _e('Grab The Blending Creativity','acurax-social-media-widget');?></div>
<div class="acx_smw_sidebar_w_content"><?php _e('Make your website user friendly and optimized for mobile devices for better user interaction and satisfaction','acurax-social-media-widget');?> <a href="http://wordpress.acurax.com/?utm_source=smw&utm_campaign=sidebar_text_2" target="_blank"><?php _e('Click Here','acurax-social-media-widget'); ?></a></div>
</div> <!-- acx_smw_sidebar_widget -->
<?php } ?>
<div class="acx_smw_sidebar_widget">
<div class="acx_smw_sidebar_w_title"><?php _e('Rate us on wordpress.org','acurax-social-media-widget'); ?></div>
<div class="acx_smw_sidebar_w_content" style="text-align:center;font-size:13px;"><b><?php _e('Thank you for being with us... If you like our plugin then please show us some love','acurax-social-media-widget');?> </b></br>
<a href="https://wordpress.org/support/view/plugin-reviews/<?php echo ACX_SMW_WP_SLUG; ?>/" target="_blank" style="text-decoration:none;">
<span id="acx_smw_stars">
<span class="dashicons dashicons-star-filled"></span>
<span class="dashicons dashicons-star-filled"></span>
<span class="dashicons dashicons-star-filled"></span>
<span class="dashicons dashicons-star-filled"></span>
<span class="dashicons dashicons-star-filled"></span>
</span>
<span class="acx_smw_star_button button button-primary"><?php _e('Click Here','acurax-social-media-widget'); ?></span>
</a>
<p><?php _e('If you are facing any issues, kindly post them at plugins support forum','acurax-social-media-widget');?> <a href="http://wordpress.org/support/plugin/<?php echo ACX_SMW_WP_SLUG; ?>/" target="_blank"><?php _e('here','acurax-social-media-widget'); ?></a>
</div>
</div> <!-- acx_smw_sidebar_widget -->
</div> <!--  acx_smw_sidebar -->
<?php
}
 add_action('acx_smw_hook_option_sidebar','acx_smw_service_banners');
 add_action('acx_smw_misc_hook_option_sidebar','acx_smw_service_banners',100);
/************************************************ MISC PAGE ***************************************************/
function acx_smw_misc_nonce_check()
{
	if (!isset($_POST['acx_smw_misc_nonce'])) die("<br><br>".__('Unknown Error Occurred, Try Again... ','acurax-social-media-widget')."<a href=''>Click Here</a>");
	if (!wp_verify_nonce($_POST['acx_smw_misc_nonce'],'acx_smw_misc_nonce')) die("<br><br>".__('Unknown Error Occurred, Try Again... ','acurax-social-media-widget')."<a href=''>Click Here</a>");
	if(!current_user_can('manage_options')) die("<br><br>".__('Sorry, You have no permission to do this action...','acurax-social-media-widget')."</a>");
} add_action('acx_smw_misc_hook_option_onpost','acx_smw_misc_nonce_check',1);


function acx_smw_misc_nonce_field()
{
	echo "<input name='acx_smw_misc_nonce' type='hidden' value='".wp_create_nonce('acx_smw_misc_nonce')."' />";
	echo "<input name='acx_smw_misc_hidden' type='hidden' value='Y' />";
} add_action('acx_smw_misc_hook_option_fields','acx_smw_misc_nonce_field',10);

function acx_smw_misc_option_form_start()
{
	echo "<form name='acx_smw_misc_form' id='acx_smw_form'  method='post' action='".str_replace( '%7E', '~',$_SERVER['REQUEST_URI'])."'>";
} add_action('acx_smw_misc_hook_option_form_head','acx_smw_misc_option_form_start',100);


function acx_smw_misc_option_form_end()
{
	echo "</form>";
}  add_action('acx_smw_misc_hook_option_form_footer','acx_smw_misc_option_form_end',100);

function acx_smw_misc_option_div_start()
{
	echo "<div id=\"acx_smw_option_page_holder\"> \n";
	acx_smw_hook_function('acx_smw_misc_hook_option_above_page_left');
	echo "<div class=\"acx_smw_option_page_left\"> \n";
} add_action('acx_smw_misc_hook_option_form_head','acx_smw_misc_option_div_start',30);

function acx_smw_misc_option_sidebar_start()
{
	echo "</div> <!-- acx_smw_option_page_left --> \n";
	echo "<div class=\"acx_smw_option_page_right\"> \n";
}  add_action('acx_smw_misc_hook_option_sidebar','acx_smw_misc_option_sidebar_start',10);


function acx_smw_misc_option_sidebar_end()
{
	echo "</div> <!-- acx_smw_option_page_right --> \n";
	acx_smw_hook_function('acx_smw_misc_hook_option_footer');
	echo "</div> <!-- acx_smw_option_page_holder --> \n";
} add_action('acx_smw_misc_hook_option_sidebar','acx_smw_misc_option_sidebar_end',500);

function acx_smw_misc_print_option_page_title()
{
		$acx_string = __("Acurax Social Widget Misc Settings","acurax-social-media-widget");
 echo print_acx_smw_option_heading($acx_string);
} add_action('acx_smw_misc_hook_option_form_head','acx_smw_misc_print_option_page_title',50);

function display_acx_smw_misc_saved_success()
{ ?>
<div class="updated"><p><strong><?php _e('Acurax Widgets Misc Settings Saved!.','acurax-social-media-widget' ); ?></strong></p></div>
<script type="text/javascript">
		 setTimeout(function(){
				jQuery('.updated').fadeOut('slow');
				
				}, 4000);

		</script>

<?php
}   add_action('acx_smw_misc_hook_option_onpost','display_acx_smw_misc_saved_success',5000);

/*********************************************** Expert Support *************************************************/
function acx_smw_exprt_option_div_start()
{
	echo "<div id=\"acx_smw_option_page_holder\"> \n";
	
} add_action('acx_smw_exprt_hook_option_form_head','acx_smw_exprt_option_div_start',100);


function acx_smw_exprt_option_sidebar_end()
{
acx_smw_hook_function('acx_smw_exprt_hook_option_above_page_left');
	echo "</div> <!-- acx_smw_option_page_holder --> \n";
} 
add_action('acx_smw_exprt_hook_option_sidebar','acx_smw_exprt_option_sidebar_end',500);
/******************************************************* HELP *****************************************************/
function acx_smw_help_option_div_start()
{
	echo "<div id=\"acx_smw_option_page_holder\"> \n";
	acx_smw_hook_function('acx_smw_help_hook_option_above_page_left');
} add_action('acx_smw_help_hook_option_form_head','acx_smw_help_option_div_start',100);


function acx_smw_help_option_sidebar_end()
{

	echo "</div> <!-- acx_smw_option_page_holder --> \n";
} add_action('acx_smw_help_hook_option_sidebar','acx_smw_help_option_sidebar_end',500);




?>