<?php
if ( ! defined( 'ABSPATH' ) ) exit;
function xyz_cfm_admin_notice()
{
	add_thickbox();
	$sharelink_text_array_cfm = array
						(
						"I use Contact Form Manager wordpress plugin from @xyzscripts and you should too.",
						"Contact Form Manager wordpress plugin from @xyzscripts is awesome",
						"Thanks @xyzscripts for developing such a wonderful Contact Form Manager wordpress plugin",
						"I was looking for a Contact Form Manager plugin and I found this. Thanks @xyzscripts",
						"Its very easy to use Contact Form Manager wordpress plugin from @xyzscripts",
						"I installed Contact Form Manager from @xyzscripts,it works flawlessly",
						"Contact Form Manager wordpress plugin that I use works terrific",
						"I am using Contact Form Manager wordpress plugin from @xyzscripts and I like it",
						"The Contact Form Manager plugin from @xyzscripts is simple and works fine",
						"I've been using this Contact Form Manager plugin for a while now and it is really good",
						"Contact Form Manager wordpress plugin is a fantastic plugin",
						"Contact Form Manager wordpress plugin is easy to use and works great. Thank you!",
						"Good and flexible  Contact Form Manager plugin especially for beginners",
						"The best Contact Form Manager wordpress plugin I have used ! THANKS @xyzscripts",
						);
$sharelink_text_cfm = array_rand($sharelink_text_array_cfm, 1);
$sharelink_text_cfm = $sharelink_text_array_cfm[$sharelink_text_cfm];
$xyz_cfm_link = admin_url('admin.php?page=contact-form-manager-manage&cfm_blink=en');
$xyz_cfm_link = wp_nonce_url($xyz_cfm_link,'cfm-blk');
$xyz_cfm_notice = admin_url('admin.php?page=contact-form-manager-manage&cfm_notice=hide');
$xyz_cfm_notice = wp_nonce_url($xyz_cfm_notice,'cfm-shw');

	echo '<style>
	#TB_window { width:50% !important;  height: 100px !important;
	margin-left: 25% !important; 
	left: 0% !important; 
	}
	</style>
	<script type="text/javascript">
			function xyz_cfm_shareon_tckbox(){
			tb_show("Share on","#TB_inline?width=500&amp;height=75&amp;inlineId=show_share_icons_cfm&class=thickbox");
		}
	</script>';
	
	echo '<div id="cfm_notice_td" class="error" style="color: #666666;margin-left: 2px; padding: 5px;line-height:16px;">
	<p>Thank you for using <a href="https://wordpress.org/plugins/contact-form-manager/" target="_blank"> Contact Form Manager </a> plugin from <a href="https://xyzscripts.com/" target="_blank">xyzscripts.com</a>. Would you consider supporting us with the continued development of the plugin using any of the below methods?</p>
	<p>
	<a href="https://wordpress.org/support/view/plugin-reviews/contact-form-manager" class="button xyz_rate_btn" target="_blank">Rate it 5★\'s on wordpress</a>';

	if(get_option('xyz_credit_link')=="0")
		echo '<a href="'.$xyz_cfm_link.'" class="button xyz_backlink_btn xyz_blink">Enable Backlink</a>';
	
	echo '<a class="button xyz_share_btn" onclick=xyz_cfm_shareon_tckbox();>Share on</a>
		<a href="https://xyzscripts.com/donate/5" class="button xyz_donate_btn" target="_blank">Donate</a>
	
		<a href="'.$xyz_cfm_notice.'" class="button xyz_show_btn">Don\'t Show This Again</a>
	</p>
	
	<div id="show_share_icons_cfm" style="display: none;">
	<a class="button" style="background-color:#3b5998;color:white;margin-right:4px;margin-left:100px;margin-top: 25px;" href="http://www.facebook.com/sharer/sharer.php?u=https://wordpress.org/plugins/contact-form-manager/&text='.$sharelink_text_cfm.'" target="_blank">Facebook</a>
	<a class="button" style="background-color:#00aced;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="http://twitter.com/share?url=https://wordpress.org/plugins/contact-form-manager/&text='.$sharelink_text_cfm.'" target="_blank">Twitter</a>
	<a class="button" style="background-color:#007bb6;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="http://www.linkedin.com/shareArticle?mini=true&url=https://wordpress.org/plugins/contact-form-manager/" target="_blank">LinkedIn</a>
	<a class="button" style="background-color:#dd4b39;color:white;margin-right:4px;margin-left:20px;margin-top: 25px;" href="https://plus.google.com/share?&hl=en&url=https://wordpress.org/plugins/contact-form-manager/" target="_blank">Google+</a>
	</div>
	</div>';
	
	
}
$cfm_installed_date = get_option('cfm_installed_date');
if ($cfm_installed_date=="") {
	$cfm_installed_date = time();
}
if($cfm_installed_date < ( time() - (30*24*60*60)))
{
	if (get_option('xyz_cfm_admin_notice_shw') != "hide")
	{
		add_action('admin_notices', 'xyz_cfm_admin_notice');
	}
}
?>