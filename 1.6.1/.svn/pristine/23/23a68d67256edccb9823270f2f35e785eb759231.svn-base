<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;

$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_cfm_SmtpId = intval($_GET['id']);
$xyz_cfm_pageno = intval($_GET['pageno']);

if (
		! isset( $_REQUEST['_wpnonce'] )
		|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'trash-smtp_'.$xyz_cfm_SmtpId )
) {
	wp_nonce_ays( 'trash-smtp_'.$xyz_cfm_SmtpId );
	
	exit();

} else {

	



if($xyz_cfm_SmtpId=="" || !is_numeric($xyz_cfm_SmtpId)){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp'));
	exit();

}
$emailCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE id= %d LIMIT %d,%d",$xyz_cfm_SmtpId,0,1) ) ;

if($emailCount==0){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=3'));
	exit();
}else{
	
	
	$xyz_cfm_default = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE id= %d ", $xyz_cfm_SmtpId) ) ;
	$xyz_cfm_default = $xyz_cfm_default[0];
	
	if($xyz_cfm_default->set_default != 1){
		
		$wpdb->query( $wpdb->prepare( "DELETE FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE id= %d",$xyz_cfm_SmtpId) ) ;
		
		header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=5&pagenum='.$xyz_cfm_pageno));
		?><script>
		document.location.href="admin.php?page=contact-form-manager-manage-smtp&smtpmsg=5&pagenum=<?php echo $xyz_cfm_pageno ?>";
		</script>
		<?php
		
		exit();
		
	}else{
		header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=6&pagenum='.$xyz_cfm_pageno));
		?><script>
		document.location.href="admin.php?page=contact-form-manager-manage-smtp&smtpmsg=6&pagenum=<?php echo $xyz_cfm_pageno ?>";
		</script>
		<?php
		
		exit();
	}
}
}
