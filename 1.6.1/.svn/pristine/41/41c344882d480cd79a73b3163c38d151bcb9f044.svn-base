<?php
if( !defined('ABSPATH') ){ exit();}
global $wpdb;
$xyz_cfm_updateMessage="";
if(isset($_GET['msg'])){
    $xyz_cfm_updateMessage = $_GET['msg'];
}
if($xyz_cfm_updateMessage == 1){
   
        ?>
<div class="system_notice_area_style1" id="system_notice_area">
Thank you for the suggestion. <span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
else if($xyz_cfm_updateMessage == 2){
	?>
<div class="system_notice_area_style0" id="system_notice_area">
Please fill Suggestion Box.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}
else if($xyz_cfm_updateMessage == 3){
    ?>
<div class="system_notice_area_style0" id="system_notice_area">
wp_mail not able to process the request.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php
}

if(isset($_POST['submit_cfm_suggested_feature']))
{
    if (
        ! isset( $_POST['_wpnonce'] )
        || ! wp_verify_nonce( $_POST['_wpnonce'],'cfm_suggestion_feature' )
        ) {
            wp_nonce_ays( 'cfm_suggestion_feature' );
            exit();
            
        }
    
 if (isset($_POST['xyz_cfm_suggestion_box']) && $_POST['xyz_cfm_suggestion_box']!='')
           {
        $xyz_cfm_premium_mail_content=$_POST['xyz_cfm_suggestion_box'];
        $xyz_cfm_to_support_mail='support@xyzscripts.com';
        
       $xyz_cfm_sender_email=get_option('admin_email');
       
       $entries0 = $wpdb->get_results( $wpdb->prepare( 'SELECT display_name FROM '.$wpdb->base_prefix.'users WHERE user_email=%s',array($xyz_cfm_sender_email)));
       foreach( $entries0 as $entry ) {
           $xyz_cfm_sender_name=$entry->display_name;
       }
       
      
        $xyz_cfm_premium_mail_subject="XYZ WP NEWSLETTER  - FEATURE SUGGESTION";
        $xyz_cfm_premium_headers = array('From: '.$xyz_cfm_sender_name.' <'. $xyz_cfm_sender_email .'>' ,'Content-Type: text/html; charset=UTF-8');
        $wp_mail_cfm_send= wp_mail( $xyz_cfm_to_support_mail, $xyz_cfm_premium_mail_subject, $xyz_cfm_premium_mail_content, $xyz_cfm_premium_headers );
        
        if ($wp_mail_cfm_send==true)
        { ?>
<script>
document.location.href="admin.php?page=contact-form-manager-feature&msg=1";
</script>
<?php   header("Location:".admin_url('admin.php?page=contact-form-manager-feature&msg=1'));
        } else
        { ?>
<script>
document.location.href="admin.php?page=contact-form-manager-feature&msg=3";
</script>
<?php  header("Location:".admin_url('admin.php?page=contact-form-manager-feature&msg=3'));
      
        }
        }
        else {
            ?>
<script>
document.location.href="admin.php?page=contact-form-manager-feature&msg=2";
</script>
<?php
header("Location:".admin_url('admin.php?page=contact-form-manager-feature&msg=2'));
            
            
        }
}
?>
<form method="post" >
<?php wp_nonce_field( 'cfm_suggestion_feature' );?>
<h2>Contribute And Get Rewarded</h2>
<table style="border:1px solid #DFDFDF;border-radius:4px; padding:20px;margin-bottom:30px;">
<tr valign="top" >
<td>

<b>* Suggest a feature for this plugin and stand a chance to get a free copy of premium version of this plugin</b>
</td>
</tr>

<tr valign="top" >
<td>
<textarea name="xyz_cfm_suggestion_box" style="width:800px;height:250px !important;"  class="xyz_cfm_suggestion_box"></textarea>
</td>
</tr>
<tr>
<td>

<input style="margin:10px 0 20px 0;" id="submit_cfm_suggested_feature" class="submit_cfm" name="submit_cfm_suggested_feature"  type="submit"  value="Send Mail To Us" >
</td>
</tr>
</table>
</form>




