<?php
if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);
$xyz_cfm_SmtpId = intval($_GET['id']);
$xyz_cfm_SmtpStatus = intval($_GET['status']);
$xyz_cfm_pageno = intval($_GET['pageno']);
//print_r($_REQUEST['_wpnonce']);die;
if (
		! isset( $_REQUEST['_wpnonce'] )
		|| ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'status-smtp_'.$xyz_cfm_SmtpId )
) {
	wp_nonce_ays( 'status-smtp_'.$xyz_cfm_SmtpId );die;

	

} 
else {


if($xyz_cfm_SmtpId=="" || !is_numeric($xyz_cfm_SmtpId)){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp'));
	exit();
}
$campCount = $wpdb->query( $wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE id= %d",$xyz_cfm_SmtpId) ) ;
if($campCount==0){
	header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=3'));
	exit();
}else{
	
	$xyz_cfm_default = $wpdb->get_results($wpdb->prepare( "SELECT * FROM ".$wpdb->prefix."xyz_cfm_sender_email_address WHERE id= %d ", $xyz_cfm_SmtpId) ) ;
	$xyz_cfm_default = $xyz_cfm_default[0];
	
	if($xyz_cfm_default->set_default != 1){
	
		if($xyz_cfm_SmtpStatus == 0){
		
			$wpdb->update($wpdb->prefix.'xyz_cfm_sender_email_address', array('status'=>$xyz_cfm_SmtpStatus), array('id'=>$xyz_cfm_SmtpId));
			header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=1&pagenum='.$xyz_cfm_pageno));
			
			
			?><script>
			document.location.href="admin.php?page=contact-form-manager-manage-smtp&smtpmsg=1&pagenum=<?php echo $xyz_cfm_pageno ?>";
			</script>
			<?php
			exit();
			
		}elseif($xyz_cfm_SmtpStatus == 1){
			
			$wpdb->update($wpdb->prefix.'xyz_cfm_sender_email_address', array('status'=>$xyz_cfm_SmtpStatus), array('id'=>$xyz_cfm_SmtpId));	
			
			header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=2&pagenum='.$xyz_cfm_pageno));
			
			
			?><script>
			document.location.href="admin.php?page=contact-form-manager-manage-smtp&smtpmsg=2&pagenum=<?php echo $xyz_cfm_pageno ?>";
			</script>
			<?php
			exit();
		}
		
	}else{
		
		header("Location:".admin_url('admin.php?page=contact-form-manager-manage-smtp&smtpmsg=4'));
	
		?><script>
		document.location.href="admin.php?page=contact-form-manager-manage-smtp&smtpmsg=4";
		</script>
		<?php
		exit();
	}
}

}