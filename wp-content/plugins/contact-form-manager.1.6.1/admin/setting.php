<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;


if(!$_POST && (isset($_GET['cfm_notice'])&& $_GET['cfm_notice'] == 'hide')){
    if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'],'cfm-shw')){
        wp_nonce_ays( 'cfm-shw');
        exit;
    } 
    update_option('xyz_cfm_admin_notice_shw', "hide");
?>
<style type='text/css'>
    #cfm_notice_td{
        display:none !important;
    }
</style>
<div class="system_notice_area_style1" id="system_notice_area">
Thanks again for using the plugin. We will never show the message again.
 &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

if($_POST){
	//print_r($_REQUEST['_wpnonce'] );die;
	if (
			! isset( $_REQUEST['_wpnonce'] )
			|| ! wp_verify_nonce( $_REQUEST['_wpnonce'],'add-setting' )
	) {
		wp_nonce_ays( 'add-setting');
		exit;
	
	} else {
	
$_POST = stripslashes_deep($_POST);
$_POST = xyz_trim_deep($_POST);

$xyz_cfm_SmtpFlag = 0;

if ($_POST['xyz_cfm_pagelimit']!= ""){
	
	$xyz_cfm_sendViaSmtp = intval($_POST['xyz_cfm_sendViaSmtp']);
	
	if($xyz_cfm_sendViaSmtp == 1){
		
		$checkSMTP = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE set_default='1'");
		if(empty($checkSMTP)){
			$xyz_cfm_SmtpFlag = 1;
		}
		
	}
	if($xyz_cfm_SmtpFlag != 1){

	$xyz_cfm_pagelimit = absint($_POST['xyz_cfm_pagelimit']);
	
	if ($xyz_cfm_pagelimit > 0 ){

			
			$xyz_cfm_filter = intval($_POST['xyz_cfm_filter']);
			$xyz_cfm_mandatory = intval($_POST['xyz_cfm_mandatory']);
			$xyz_cfm_credit = sanitize_text_field($_POST['xyz_cfm_credit']);
		
			$xyz_cfm_recaptchaPrivateKey = sanitize_text_field($_POST['xyz_cfm_recaptchaPrivateKey']);
			$xyz_cfm_recaptchaPublicKey = sanitize_text_field($_POST['xyz_cfm_recaptchaPublicKey']);
			
			$xyz_cfm_sendViaSmtp = intval($_POST['xyz_cfm_sendViaSmtp']);
			$xyz_cfm_SmtpDebug = intval($_POST['xyz_cfm_SmtpDebug']);
			$xyz_cfm_DateFormat = intval($_POST['xyz_cfm_DateFormat']);
			
			$xyz_cfm_hidepmAds = intval($_POST['xyz_cfm_hidepmAds']);
			$xyz_cfm_layout_setting=intval($_POST['xyz_cfm_layout_setting']);
			$xyz_cfm_recaptcha_type=intval($_POST['xyz_cfm_recaptcha_type']);
			
			update_option('xyz_cfm_paging_limit',$xyz_cfm_pagelimit);
			update_option('xyz_cfm_tinymce_filter',$xyz_cfm_filter);
			update_option('xyz_cfm_mandatory_sign',$xyz_cfm_mandatory);
			update_option('xyz_credit_link',$xyz_cfm_credit);
			
			update_option('xyz_cfm_DateFormat',$xyz_cfm_DateFormat);
			
			update_option('xyz_cfm_recaptcha_private_key',$xyz_cfm_recaptchaPrivateKey);
			update_option('xyz_cfm_recaptcha_public_key',$xyz_cfm_recaptchaPublicKey);
			
			update_option('xyz_cfm_sendViaSmtp',$xyz_cfm_sendViaSmtp);
			update_option('xyz_cfm_SmtpDebug',$xyz_cfm_SmtpDebug);
			
			update_option('xyz_cfm_hidepmAds',$xyz_cfm_hidepmAds);
			update_option('xyz_cfm_layout_setting',$xyz_cfm_layout_setting);
			update_option('xyz_cfm_recaptcha_type',$xyz_cfm_recaptcha_type);
?>


<div class="system_notice_area_style1" id="system_notice_area">
	Settings updated successfully. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>


<?php
	}else{
?>

	<div class="system_notice_area_style0" id="system_notice_area">
	Pagination limit must be a positive number. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php 
			}
	}else{
		?>
		<div class="system_notice_area_style0" id="system_notice_area">
		Please set a default SMTP account. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
		</div>
		<?php
	}

	}else{
?>
<div class="system_notice_area_style0" id="system_notice_area">
	Please fill all mandatory fields. &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 
}
}}
?>
<script type="text/javascript">

jQuery(document).ready(function() {

	jQuery('#xyz_cfm_settings').submit(function() {
		var pagingLimit = jQuery.trim(jQuery("#xyz_cfm_pagelimit").val());
		if(pagingLimit == "") {
        	alert("Please fill pagination limit field.");
            return false;
        }
	});
});


</script>
<div>

	<h2>Settings</h2>
	<form method="post" name="xyz_cfm_settings" id="xyz_cfm_settings">
	<?php wp_nonce_field( 'add-setting' );?>
	<div style="width: 100%">
	<fieldset style=" width:99%; border:1px solid #F7F7F7; padding:10px 0px;">
	<legend><b>General</b></legend>
	<table class="widefat xyz_cfm_tab"  style="width:99%;margin: 0 auto">
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_filter">Tiny MCE filters to prevent auto removal of  &lt;br&gt; and &lt;p&gt; tags </label>
				</td>
				<td><select name="xyz_cfm_filter" id="xyz_cfm_filter">
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_filter']) && sanitize_text_field($_POST['xyz_cfm_filter'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_tinymce_filter')=="1"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_filter']) && sanitize_text_field($_POST['xyz_cfm_filter'])=='0') { echo 'selected';}elseif(get_option('xyz_cfm_tinymce_filter')=="0"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_mandatory">Enable <span style="color:red;">*</span>&nbsp;symbol for mandatory form fields</label>
				</td>
				<td><select name="xyz_cfm_mandatory" id="xyz_cfm_mandatory">
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_mandatory']) && sanitize_text_field($_POST['xyz_cfm_mandatory'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_mandatory_sign')=="1"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_mandatory']) && sanitize_text_field($_POST['xyz_cfm_mandatory'])=='0') { echo 'selected';}elseif(get_option('xyz_cfm_mandatory_sign')=="0"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_sendViaSmtp">Send via SMTP</label>
				</td>
				<td><select name="xyz_cfm_sendViaSmtp" id="xyz_cfm_sendViaSmtp">
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_sendViaSmtp']) && sanitize_text_field($_POST['xyz_cfm_sendViaSmtp'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_sendViaSmtp')=="1"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_sendViaSmtp']) && sanitize_text_field($_POST['xyz_cfm_sendViaSmtp'])=='0') { echo 'selected';}elseif(get_option('xyz_cfm_sendViaSmtp')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_SmtpDebug">SMTP Debug</label>
				</td>
				<td><select name="xyz_cfm_SmtpDebug" id="xyz_cfm_SmtpDebug">
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_SmtpDebug']) && sanitize_text_field($_POST['xyz_cfm_SmtpDebug'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_SmtpDebug')=="1"){echo 'selected';} ?>>True</option>
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_SmtpDebug']) && sanitize_text_field($_POST['xyz_cfm_SmtpDebug'])=='0') { echo 'selected';}elseif(get_option('xyz_cfm_SmtpDebug')=="0"){echo 'selected';} ?>>False</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_SmtpDebug">Date format for date picker field</label>
				</td>
				<td><select name="xyz_cfm_DateFormat" id="xyz_cfm_DateFormat">
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_DateFormat']) && sanitize_text_field($_POST['xyz_cfm_DateFormat'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_DateFormat')=="1"){echo 'selected';} ?>>dd/mm/yyyy</option>
						<option value="2"
						<?php if(isset($_POST['xyz_cfm_DateFormat']) && sanitize_text_field($_POST['xyz_cfm_DateFormat'])=='2') { echo 'selected';}elseif(get_option('xyz_cfm_DateFormat')=="2"){echo 'selected';} ?>>mm/dd/yyyy</option>

				</select>
				</td>
			</tr>
				<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_cfm_recaptcha_type">
						ReCaptcha Type</label>
				</td>
				<td id="bottomBorderNone" style="width: 200px !important;"><select name="xyz_cfm_recaptcha_type"
					id="xyz_cfm_recaptcha_type">
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_recaptcha_type']) && $_POST['xyz_cfm_recaptcha_type']==0){ echo 'selected';}elseif(get_option('xyz_cfm_recaptcha_type')==0){echo 'selected';}?>>I'm not a robot </option>
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_recaptcha_type']) && $_POST['xyz_cfm_recaptcha_type']==1){ echo 'selected';}elseif(get_option('xyz_cfm_recaptcha_type')==1){echo 'selected';}?>>Invisible Version 2</option>
			
				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_cfm_recaptchaPrivateKey">ReCaptcha Secret Key</label>
				</td>
				<td ><input  name="xyz_cfm_recaptchaPrivateKey" type="text"
					id="xyz_cfm_recaptchaPrivateKey" value="<?php if(isset($_POST['xyz_cfm_recaptchaPrivateKey']) && sanitize_text_field($_POST['xyz_cfm_recaptchaPrivateKey']) != ""){echo esc_attr ($_POST['xyz_cfm_recaptchaPrivateKey']);}else{echo esc_attr(get_option('xyz_cfm_recaptcha_private_key'));} ?>" />
					&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://www.google.com/recaptcha/admin">Get Secret Key</a>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_cfm_recaptchaPublicKey">ReCaptcha Site Key</label>
				</td>
				<td ><input  name="xyz_cfm_recaptchaPublicKey" type="text"
					id="xyz_cfm_recaptchaPublicKey" value="<?php if(isset($_POST['xyz_cfm_recaptchaPublicKey']) && sanitize_text_field($_POST['xyz_cfm_recaptchaPublicKey']) != ""){echo esc_attr($_POST['xyz_cfm_recaptchaPublicKey']);}else{echo  esc_attr(get_option('xyz_cfm_recaptcha_public_key'));} ?>" />
					&nbsp;&nbsp;&nbsp;<a target="_blank" href="https://www.google.com/recaptcha/admin" >Get Site Key</a>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" ><label for="xyz_cfm_pagelimit">Pagination limit</label>
				</td>
				<td ><input  name="xyz_cfm_pagelimit" type="text"
					id="xyz_cfm_pagelimit" value="<?php if(isset($_POST['xyz_cfm_pagelimit']) && sanitize_text_field($_POST['xyz_cfm_pagelimit']) != ""){echo esc_attr ($_POST['xyz_cfm_pagelimit']);}else{echo  esc_attr (get_option('xyz_cfm_paging_limit'));} ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" class=" settingInput" id="bottomBorderNone"><label for="xyz_cfm_hidepmAds">
						Hide premium version ads</label>
				</td>
				<td id="bottomBorderNone" style="width: 200px !important;"><select name="xyz_cfm_hidepmAds"
					id="xyz_cfm_hidepmAds">
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_hidepmAds']) && $_POST['xyz_cfm_hidepmAds']==0){ echo 'selected';}elseif(get_option('xyz_cfm_hidepmAds')==0){echo 'selected';}?>>No</option>
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_hidepmAds']) && $_POST['xyz_cfm_hidepmAds']==1){ echo 'selected';}elseif(get_option('xyz_cfm_hidepmAds')==1){echo 'selected';}?>>Yes</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_credit">Credit link to author</label>
				</td>
				<td><select name="xyz_cfm_credit" id="xyz_cfm_credit">
						<option value="cfm"
						<?php if(isset($_POST['xyz_cfm_credit']) && sanitize_text_field($_POST['xyz_cfm_credit'])=='cfm') { echo 'selected';}elseif(get_option('xyz_credit_link')=="cfm"){echo 'selected';} ?>>Enable</option>
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_credit']) && sanitize_text_field($_POST['xyz_cfm_credit'])!='cfm') { echo 'selected';}elseif(get_option('xyz_credit_link')!="cfm"){echo 'selected';} ?>>Disable</option>

				</select>
				</td>
			</tr>
			<tr valign="top">
				<td scope="row" ><label for="xyz_cfm_layout_setting">Contact Form Layout</label>
				</td>
				<td><select name="xyz_cfm_layout_setting" id="xyz_cfm_layout_setting">
						<option value="0"
						<?php if(isset($_POST['xyz_cfm_layout_setting']) && intval($_POST['xyz_cfm_layout_setting'])=='0') { echo 'selected';}elseif(get_option('xyz_cfm_layout_setting')=="0"){echo 'selected';} ?>>Single Column</option>
						
						
						<option value="1"
						<?php if(isset($_POST['xyz_cfm_layout_setting']) && intval($_POST['xyz_cfm_layout_setting'])=='1') { echo 'selected';}elseif(get_option('xyz_cfm_layout_setting')=="1"){echo 'selected';} ?>>Two Column </option>
						
				</select>
				</td>
			</tr>
			<tr>
        <td></td>
				<td  style="text-align: left;" >
				<div style="height:50px;width:500px;" ><input class="submit_cfm" name="btnSubmit" type="submit" value=" Update Settings " /></div>
				</td>

			</tr>
			
	</table>
	</fieldset>
	</form>
</div>
