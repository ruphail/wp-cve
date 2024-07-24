<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function cfm_network_install($networkwide) {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		// check if it is a network activation - if so, run the activation function for each blog id
		if ($networkwide) {
			$old_blog = $wpdb->blogid;
			// Get all blog ids
			$blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
			foreach ($blogids as $blog_id) {
				switch_to_blog($blog_id);
				cfm_install();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	cfm_install();
}


function cfm_install(){
	
	$pluginName = 'xyz-wp-contact-form/xyz-wp-contact-form.php';
	if (is_plugin_active($pluginName)) {
		wp_die( "The plugin Contact Form Manager cannot be activated because you are using the premium version of this plugin. Back to <a href='".admin_url()."plugins.php'>Plugin Installation</a>." );
	}
	
	global $wpdb;
	$wpdb->show_errors();
	global $current_user; wp_get_current_user();
	
	add_option("xyz_cfm_paging_limit",20);
	add_option("xyz_cfm_tinymce_filter",1);
	add_option("xyz_cfm_mandatory_sign",1);
	add_option("xyz_cfm_DateFormat",2);
	
	add_option("xyz_cfm_hidepmAds",0);
	add_option("xyz_cfm_layout_setting",0);
	add_option("xyz_cfm_recaptcha_type",0);
	
// 	add_option("xyz_cfm_credit_link",0);

	
	if(get_option('xyz_cfm_credit_dismiss') == ""){
	    add_option("xyz_cfm_credit_dismiss",0);
	}
	
	if(get_option('xyz_credit_link') == ""){
		if(get_option('xyz_cfm_credit_link') == 1){
			add_option("xyz_credit_link",'cfm');
		}else{
			add_option("xyz_credit_link",0);
		}
	}
	
	
	$cfm_installed_date = get_option('cfm_installed_date ');
	if ($cfm_installed_date =="") {
		$cfm_installed_date = time();
		update_option('cfm_installed_date', $cfm_installed_date);
	}
	
	
	add_option('xyz_cfm_sendViaSmtp',0);
	add_option('xyz_cfm_SmtpDebug',0);
	
	$xyz_cfm_form = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_form"');
	if(!empty($xyz_cfm_form)){
		$wpdb->query("RENAME TABLE xyz_cfm_form TO ".$wpdb->prefix."xyz_cfm_form");
	}else{
	
		$xyz_cfm_formExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_form"');
		if(empty($xyz_cfm_formExist)){
		
			$queryForm = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_form (
			  `id` int NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `status` int NOT NULL,
			  `form_content` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `submit_mode` int NOT NULL,
			  `to_email` text COLLATE utf8_unicode_ci NOT NULL,
			  `from_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `cc_email` text COLLATE utf8_unicode_ci NOT NULL,
			  `mail_type` int NOT NULL,
			  `mail_subject` text COLLATE utf8_unicode_ci NOT NULL,
			  `mail_body` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `to_email_reply` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `reply_subject` text COLLATE utf8_unicode_ci NOT NULL,
			  `reply_body` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `reply_mail_type` int NOT NULL,
			  `enable_reply` int NOT NULL,
			  `redirection_link` text COLLATE utf8_unicode_ci NOT NULL,
               `theme_id` int NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
			$wpdb->query($queryForm);
		}
	}
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("from_email_id", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`from_email_id` int not null default '0' ,`reply_sender_email_id` int not null default '0')");
		
	}
	
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("theme_id", $tblcolums))
	    $group_flag=1;
	    
	    
	    if($group_flag==0)
	    {
	        $wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`theme_id` int not null)");
	        
	    }
	
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("redisplay_option", $tblcolums))
		$group_flag=1;
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`redisplay_option` int not null default 2)");
		
		
	}
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("newsletter_email_shortcode", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD
				(`newsletter_email_shortcode` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_email_list` text COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_custom_fields` text COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_optin_mode` varchar(225) COLLATE utf8_unicode_ci NOT NULL,
				`newsletter_subscription_status` int(11) NOT NULL )");
		
	}
	
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form");
	if(in_array("bcc_email", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form ADD (`bcc_email` text COLLATE utf8_unicode_ci NOT NULL)");
		
	}
	
	
	/*for newsletter subscription*/
	
	
	
	$xyz_cfm_FormElements = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_form_elements"');
	if(!empty($xyz_cfm_FormElements)){
		$wpdb->query("RENAME TABLE xyz_cfm_form_elements TO ".$wpdb->prefix."xyz_cfm_form_elements");
	}else{
	
		$xyz_cfm_FormElementsExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_form_elements"');
		if(empty($xyz_cfm_FormElementsExist)){
	
			$queryFormElements = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_form_elements (
			  `id` int NOT NULL AUTO_INCREMENT,
			  `form_id` int NOT NULL,
			  `element_diplay_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `element_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `element_type` int NOT NULL,
			  `element_required` int NOT NULL,
			  `css_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `max_length` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
			  `default_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  `cols` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `rows` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			  `options` longtext COLLATE utf8_unicode_ci NOT NULL,
			  `file_size` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
			  `file_type` text COLLATE utf8_unicode_ci NOT NULL,
			  `re_captcha` int NOT NULL,
			  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 " ;
			$wpdb->query($queryFormElements);
			
		}
	}
	
	$group_flag=0;
	$tblcolums = $wpdb->get_col("SHOW COLUMNS FROM  ".$wpdb->prefix."xyz_cfm_form_elements");
	if(in_array("client_view_check_radio_line_break_count", $tblcolums))
		$group_flag=1;
	
	
	if($group_flag==0)
	{
		$wpdb->query("ALTER TABLE ".$wpdb->prefix."xyz_cfm_form_elements ADD (`client_view_check_radio_line_break_count` int not null default '0' ,`client_view_multi_select_drop_down` int not null default '0')");
		
	}
	
	
	
	$xyz_cfm_SenderEmailAddress = $wpdb->get_results('SHOW TABLE STATUS WHERE name="xyz_cfm_sender_email_address"');
	if(!empty($xyz_cfm_SenderEmailAddress)){
		$wpdb->query("RENAME TABLE xyz_cfm_sender_email_address TO ".$wpdb->prefix."xyz_cfm_sender_email_address");
	}else{
	
		$xyz_cfm_SenderEmailAddressExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_sender_email_address"');
		if(empty($xyz_cfm_SenderEmailAddressExist)){
	
			$querySenderEmailAddress = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_sender_email_address (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`authentication` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
			`host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`user` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`port` int(11) NOT NULL,
			`security` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			`set_default` int(1) NOT NULL,
			`status` int(1) NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
			$wpdb->query($querySenderEmailAddress);
			
		}
	}
	
	$form_count = $wpdb->query( 'SELECT * FROM '.$wpdb->prefix.'xyz_cfm_form') ;
	if($form_count == 0){
		
		$xyz_cfm_to_email =  $current_user->user_email;
		
		
		$last_id= $wpdb->get_var("select max(id) from ".$wpdb->prefix."xyz_cfm_form");
		$last_id=($last_id=='')?1:$last_id+1;
		
		/*create default contact form*/
		$wpdb->insert($wpdb->prefix.'xyz_cfm_form', array(
				'name' => 'form'.$last_id, 
				'status'=>1,
				'form_content'=>'',
				'submit_mode'=>2,
				'to_email'=>'',
				'from_email'=>'',
				'sender_name'=>'',
				'reply_sender_name'=>'',
				'reply_sender_email'=>'',
				'cc_email'=>'',
				'mail_type'=>1,
				'mail_subject'=>'',
				'mail_body'=>'',
				'to_email_reply'=>'',
				'reply_subject'=>'',
				'reply_body'=>'',
				'reply_mail_type'=>1,
				'enable_reply'=>1,
				'redirection_link'=>'',
				'from_email_id'=>0,
				'reply_sender_email_id'=>0,
				'redisplay_option'=>2,
				'newsletter_email_shortcode'=>'',
				'newsletter_email_list'=>'',
				'newsletter_custom_fields'=>'',
				'newsletter_optin_mode'	=>	'',
				'newsletter_subscription_status'=>0,
				'bcc_email'=>''
				),
				array('%s','%d','%s','%d','%s','%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%d','%d','%s','%d','%d','%d','%s','%s','%s','%s','%d','%s'));
		$lastid = $wpdb->insert_id;
		
		/*User name*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'yourName',
		'element_type'	=>	'1',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$yourNameId = $wpdb->insert_id;
$nameCode = "[text-".$yourNameId."]";

/*User email*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'yourEmail',
		'element_type'	=>	'2',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$yourEmailId = $wpdb->insert_id;
$emailCode = "[email-".$yourEmailId."]";

/*Subject*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'subject',
		'element_type'	=>	'1',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$xyz_cfm_subjectId = $wpdb->insert_id;
$xyz_cfm_subjectCode = "[text-".$xyz_cfm_subjectId."]";


/*Message*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'message',
		'element_type'	=>	'3',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	45,
		'rows'	=>	6,
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$messageId = $wpdb->insert_id;
$messageCode = "[textarea-".$messageId."]";

/*Submit*/
$wpdb->insert($wpdb->prefix.'xyz_cfm_form_elements', array(
		'form_id'	=>	$lastid,
		'element_name'	=>	'submit',
		'element_type'	=>	'9',
		'element_required'	=>	'1',
		'element_diplay_name'	=>	'Send',
		'css_class'	=>	'',
		'max_length'	=>	'',
		'default_value'	=>	'',
		'cols'	=>	'',
		'rows'	=>	'',
		'options'	=>	'',
		'file_size'	=>	'',
		'file_type'	=>	'',
		're_captcha'	=>	0,
		'client_view_check_radio_line_break_count'	=>	0,
		'client_view_multi_select_drop_down'	=>	0
),
		array(
				'%d','%s','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'
		));
$submitId = $wpdb->insert_id;
$submitCode = "[submit-".$submitId."]";

		
		
		$xyz_cfm_pageCodeDefault ='<table style="width:100%;">
			<tr>
				<td>Your Name</td><td>'.$nameCode.'</td>
			</tr>
			<tr>
			<td>Your Email</td><td>'.$emailCode.'</td>
			</tr>
			<tr>
			<td>Subject</td><td>'.$xyz_cfm_subjectCode.'</td>
			</tr>
			<tr>
			<td>Message Body</td><td>'.$messageCode.'</td>
			</tr>
			<tr>
			<td></td>
			<td>'.$submitCode.'</td>
			</tr>
		</table>';
		
		
		$xyz_cfm_mailBody='Hi,<p>You have a new contact request</p><p>From : '.$emailCode.'<br />Subject : '.$xyz_cfm_subjectCode.'<br />Message Body : '.$messageCode.'</p>Regards<br>'.get_bloginfo('name');
		
		
		$xyz_cfm_mailBodyReplay='<p>Hi '.$nameCode.',</p><p>Thank you for contacting us. Your mail has been received and shall be processed shortly.</p>Regards<br>'.get_bloginfo('name');
		
		$wpdb->update($wpdb->prefix.'xyz_cfm_form',
				array('form_content'=>$xyz_cfm_pageCodeDefault,
						'submit_mode'=>2,
						'to_email'=>$xyz_cfm_to_email,
						'from_email'=>$emailCode,
						'mail_type'=>1,
						'mail_subject'=>$xyz_cfm_subjectCode,
						'mail_body'=>$xyz_cfm_mailBody,
						'to_email_reply'=>$emailCode,
						'reply_subject'=>'Re:'.$xyz_cfm_subjectCode,
						'reply_body'=>$xyz_cfm_mailBodyReplay,
						'reply_mail_type'=>1,
						'enable_reply'=>1,
						'status'=>1
				),
				array('id'=>$lastid));
		
	}
	
	$xyz_cfm_theme_detailsExist = $wpdb->get_results('SHOW TABLE STATUS WHERE name="'.$wpdb->prefix.'xyz_cfm_theme_details"');
	if(empty($xyz_cfm_theme_detailsExist)){
	    
	    $querytheme_details = "CREATE TABLE IF NOT EXISTS  ".$wpdb->prefix."xyz_cfm_theme_details (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
			`content` text  COLLATE utf8_unicode_ci,
			`product_edition` int(11) NOT NULL,
			`preview_image` varchar(255) COLLATE utf8_unicode_ci ,
			PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1";
	    $wpdb->query($querytheme_details);
	    
	}
	
$plain_n_simple1_content='.xyz_cfm_theme_div_id_1{
max-width: 35em; margin:auto;background: #eceeee;
border: 1px solid #42464b;
border-radius: 6px; padding: 2.5em;}
.xyz_cfm_theme_div_id_1 table{border:none !important;}
.xyz_cfm_theme_div_id_1 table tr td{background-color:transparent !important ;  border:none !important; color:#666666;}
.xyz_cfm_theme_div_id_1 input[type=text] {  
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    font-size: 18px;
    color: white;
    font-weight: 300;
    width: 98%;
    margin: 5px 0;
    box-sizing: border-box;
    padding: 15px 20px;
    border: 1px solid #a1a3a3;
    border-radius: 4px;
    box-shadow: 0 1px #fff;
    box-sizing: border-box;
    color: #696969;
    height: 39px;
    transition: box-shadow 0.3s;
    display: block;
    float: left;}
.xyz_cfm_theme_div_id_1 input[type=submit]{width: 98%;
    display: block;
    font-family: Arial, "Helvetica", sans-serif;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    text-decoration: none;
    text-transform: uppercase;
    text-align: center;
    text-shadow: 1px 1px 0px #37a69b;
    padding: 15px;
    position: relative;
    cursor: pointer;
    border: none;
    background-color: #37a69b;
    background-image: linear-gradient(top,#3db0a6,#3111);
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    box-shadow: inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #497a78, 0px 10px 5px #999;}
	
.xyz_cfm_theme_div_id_1 input[type="submit"]:active {
  top:3px;
  box-shadow: inset 0px 1px 0px #2ab7ec, 0px 2px 0px 0px #31524d, 0px 5px 3px #999;
}  
.xyz_cfm_theme_div_id_1 table tr{background-color:transparent !important ;border:none !important; color:#000000;}
.xyz_cfm_theme_div_id_1 table tr td{background-color:transparent !important ; border:none !important; color:#000000;}

.xyz_cfm_theme_div_id_1 select {outline: 0;
    border: none;
    border-radius: 3px;
    font-size: 18px;
    transition-duration: 0.25s;
    font-weight: 300;
    width: 98%;
    padding: 8px 10px;
    margin: 5px 0;
    box-sizing: border-box;
    border: 1px solid #a1a3a3;
    border-radius: 4px;
    box-shadow: 0 1px #fff;
    box-sizing: border-box;
    color: #696969;
    height: 39px;
    transition: box-shadow 0.3s;}
	.xyz_cfm_theme_div_id_1 select option{color:#888888 !important; border-bottom:1px solid #eeeeee !important;}
	.xyz_cfm_theme_div_id_1 textarea{-webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    border: none;
    border-radius: 3px;
    font-size: 18px;
    color: white;
    transition-duration: 0.25s;
    font-weight: 300;
    width: 98%;
    padding: 8px 10px;
    margin: 10px 0 0px;
    box-sizing: border-box;
    padding: 15px 20px;
    border: 1px solid #a1a3a3;
    border-radius: 4px;
    box-shadow: 0 1px #fff;
    box-sizing: border-box;
    color: #696969;
    transition: box-shadow 0.3s;
   }
   .rc-anchor{border: 1px solid rgba(255, 255, 255, 0.4) !important;background-color: rgba(255, 255, 255, 0.2) !important;}
.check_box{position:relative; float:left; margin-top:10px; margin-bottom:10px; margin-right:10px;}';

$theme_name1='Plain N Simple 1';
$first_count= $wpdb->get_var($wpdb->prepare("SELECT count(*)  FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name1));
if($first_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	1,
	    'name'	=>	'Plain N Simple 1',
	    'content'	=>	$plain_n_simple1_content,
	    'product_edition'	=>	0,
	    'preview_image'	=>	'plain-n-simple-1.png'
	  
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
$plain_n_simple2_content='
.xyz_cfm_theme_div_id_2{
max-width: 35em; 
margin:auto;
background: #eeeeee;
padding: 2.5em;}

.xyz_cfm_theme_div_id_2 table{border:none !important;}
.xyz_cfm_theme_div_id_2 table tr{ background-color:transparent !important ; border:none !important; color:#000000;}
.xyz_cfm_theme_div_id_2 table tr td{ background-color:transparent !important ; border:none !important; color:#000000;}
.xyz_cfm_theme_div_id_2 input[type=text] {outline: 0;border: none; background: #D3D3D3; 
border-radius: 3px;font-size: 18px;color: white;transition-duration: 0.25s;font-weight: 300;
width: 98%;padding: 8px 10px;margin: 5px 0;box-sizing: border-box;display: block;
float: left; }
.xyz_cfm_theme_div_id_2 input[type=submit]{padding: 15px 30px; width:98%;
    border-radius: 3px;
    font-size: .9em;
    color: #fff;
    background: #21A957;
    outline: none;
    border: 1px solid #21A957;
    cursor: pointer;
    -webkit-appearance: none;
    text-transform: uppercase;}.xyz_cfm_theme_div_id_2 input[type=submit]:hover {  
    -webkit-transition: .5s all;
    -moz-transition: .5s all;
    -o-transition: .5s all;
    -ms-transition: .5s all;
    transition: .5s all;
    background: #177e40;
}.xyz_cfm_theme_div_id_2 select {outline: 0;border: none; background: #D3D3D3; border-radius: 3px; font-size: 18px;color: #666666;transition-duration: 0.25s;font-weight: 300;width: 98%;padding: 8px 10px;margin: 5px 0;box-sizing: border-box; }
.xyz_cfm_theme_div_id_2 select option{color:#888888 !important; }.xyz_cfm_theme_div_id_2 textarea{outline: 0;border: none; background: #D3D3D3; border-radius: 3px;font-size: 18px;color: white;transition-duration: 0.25s;font-weight: 300;width: 98%;padding: 8px 10px;margin: 5px 0;box-sizing: border-box;}.rc-anchor{border: 1px solid rgba(255, 255, 255, 0.4) !important;background-color: rgba(255, 255, 255, 0.2) !important;}
.check_box{position:relative; float:left; margin-top:10px; margin-bottom:10px; margin-right:10px;}
';
$theme_name2='Plain N Simple 2';
$second_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name2));
if($second_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	2,
	    'name'	=>	'Plain N Simple 2',
	    'content'	=>	$plain_n_simple2_content,
	    'product_edition'	=>	0,
	    'preview_image'	=>	'plain-n-simple-2.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
$orange_glow_content='
.xyz_cfm_theme_div_id_3{
max-width: 35em; 
margin:auto;
box-shadow:0px 0px 4px #dddddd; 
background-color: #272E38;  
padding: 2.5em;}
.xyz_cfm_theme_div_id_3 table tr{background-color:transparent !important ; border:none !important; color:#000000;}


.xyz_cfm_theme_div_id_3 table{border:none !important;}
.xyz_cfm_theme_div_id_3 table tr td{background-color:transparent !important ; border:none !important; color:#ACAFB8;}
.xyz_cfm_theme_div_id_3 input[type=text] {    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    border: none;
    font-size: 18px;
    color: white;
    transition-duration: 0.25s;
    font-weight: 300;
    width: 98%;
    padding: 8px 10px;
    margin: 5px 0;
    box-sizing: border-box;
    padding: 15px 20px;
   background: #272E38;
    border: 1px solid #efa73e;
display: block;
float: left;
}
.xyz_cfm_theme_div_id_3 input[type=submit]{padding: 15px 30px;
    border-radius: 3px;
    font-size: .9em;
    color: #fff;
    background: #efa73e;
    outline: none;
    border: 1px solid #efa73e;
    cursor: pointer;
    -webkit-appearance: none;
    text-transform: uppercase;
    width: 98%;
    border-radius: 0px;}
.xyz_cfm_theme_div_id_3 input[type=submit]:hover {  
    -webkit-transition: .5s all;
    -moz-transition: .5s all;
    -o-transition: .5s all;
    -ms-transition: .5s all;
    transition: .5s all;
    background: transparent;
}
.xyz_cfm_theme_div_id_3 select {outline: 0;
    border: none;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
    font-size: 18px;
    transition-duration: 0.25s;
    font-weight: 300;
    width: 98%;
    padding: 8px 10px;
    margin: 5px 0;
    box-sizing: border-box;
    padding: 15px 20px;
    border-radius: 0px;
    background: #272E38;
    border: 1px solid #efa73e;
	color:#ffffff;
}
.xyz_cfm_theme_div_id_3 select option{color:#888888 !important; border-bottom:1px solid #eeeeee !important;}
.xyz_cfm_theme_div_id_3 textarea{-webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    outline: 0;
    border: none;
    background: #272E38;
    border: 1px solid #efa73e;
    font-size: 18px;
    color: white;
    transition-duration: 0.25s;
    font-weight: 300;
    width: 98%;
    padding: 8px 10px;
    margin: 10px 0 0px;
    box-sizing: border-box;
    padding: 15px 20px;
    border-radius: 0px;
   }
   .rc-anchor{border: 1px solid rgba(255, 255, 255, 0.4) !important;background-color: rgba(255, 255, 255, 0.2) !important;}

.check_box{position:relative; float:left; margin-top:10px; margin-bottom:10px; margin-right:10px;}

';
$theme_name3='Orange Glow';
$third_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name3));
if($third_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	3,
	    'name'	=>	'Orange Glow',
	    'content'	=>	$orange_glow_content,
	    'product_edition'	=>	0,
	    'preview_image'	=>	'orange-glow.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
	
	////////////////////// premium /////////////////////////
	
$theme_name4='Dawn Lake';
$four_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name4));
if($four_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	4,
	    'name'	=>	'Dawn Lake',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'dawn-lake.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}

$theme_name5='Blue N White';
$five_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name5));
if($five_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	5,
	    'name'	=>	'Blue N White',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'blue-n-white.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
$theme_name6='Speed Blur';
$six_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name6));
if($six_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	6,
	    'name'	=>	'Speed Blur',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'speed-blur.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
$theme_name7='Light Coffee';
$seven_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name7));
if($seven_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	7,
	    'name'	=>	'Light Coffee',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'light-coffee.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}
$theme_name8='Dark Gradient';
$eight_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name8));
if($eight_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	8,
	    'name'	=>	'Dark Gradient',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'dark-gradient.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}

$theme_name9='Blue Immerse';
$nine_count= $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM " . $wpdb->prefix . "xyz_cfm_theme_details WHERE name= %s", $theme_name9));
if($nine_count ==0)
{
	$wpdb->insert($wpdb->prefix.'xyz_cfm_theme_details', array(
	    'id'	=>	9,
	    'name'	=>	'Blue Immerse',
	    'content'	=>	'',
	    'product_edition'	=>	1,
	    'preview_image'	=>	'blue-immerse.png'
	    
	),
	    array(
	        '%d','%s','%s','%d','%s'
	    ));
}

}

register_activation_hook( XYZ_CFM_PLUGIN_FILE, 'cfm_network_install' );
