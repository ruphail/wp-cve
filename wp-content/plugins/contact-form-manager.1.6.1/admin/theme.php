<?php
if (! defined('ABSPATH'))
    exit();
if (get_option('xyz_cfm_tinymce_filter') == "1") {
    require (dirname(__FILE__) . '/tinymce_filters.php');
}
global $wpdb;
$_POST = stripslashes_deep($_POST);
$_GET = stripslashes_deep($_GET);

$_POST = xyz_trim_deep($_POST);

$xyz_cfm_Message = '';
if(isset($_GET['msg'])){
    $xyz_cfm_Message = intval($_GET['msg']);
    
}
if($xyz_cfm_Message == 1){
    
    ?>
<div class="system_notice_area_style1" id="system_notice_area">
	Themes successfully updated.&nbsp;&nbsp;&nbsp;<span
		id="system_notice_area_dismiss">Dismiss</span>
</div>
<?php 
}


$product_edition=0;
$theme_details =$wpdb->get_results($wpdb->prepare(" SELECT * FROM ".$wpdb->prefix."xyz_cfm_theme_details  WHERE product_edition= %d  ORDER BY id  ", $product_edition));



if (isset($_POST) && isset($_POST['styleSubmit'])) {
    
    if (! isset($_REQUEST['_wpnonce']) || ! wp_verify_nonce($_REQUEST['_wpnonce'], 'edit_theme_style')) {
        
        wp_nonce_ays('edit_theme_style');
        
        exit();
    }
    
    foreach( $theme_details as $entrypost ) {
        
       
        $xyz_cfm_theme_style=$_POST['style_edit_'.$entrypost->id];
        $wpdb->update($wpdb->prefix . 'xyz_cfm_theme_details', array(
            'content' => $xyz_cfm_theme_style,
                        
        ), array(
            'id' => $entrypost->id
        ));
        
        
            }
            
            header("Location:".admin_url('admin.php?page=contact-form-manager-theme&msg=1'));
            
            ?>
<script>
document.location.href="admin.php?page=contact-form-manager-theme&msg=1";
 </script> 
 <?php
 
            
            
?>
<div class="system_notice_area_style1" id="system_notice_area">
Themes successfully updated.&nbsp;&nbsp;&nbsp;<span
id="system_notice_area_dismiss">Dismiss</span>
</div>

<?php             
}


?>
<form name="frmmainForm" id="frmmainForm" method="post">
		<?php wp_nonce_field( 'edit_theme_style' );?>

<table style="width: 99%; background-color: #F9F9F9; border: 1px solid #E4E4E4; border-width: 1px; float: left;">
					
<?php

foreach( $theme_details as $entry ) {

    ?>
    
    
	<tr>
	
	<tr>
    <td style="border-bottom: 1px solid #F9F9F9;">
    <span style="font-size: 22px;"> </span></td>
	</tr>
	<tr>
    <td style="border-bottom: 1px solid #F9F9F9;">
    <span style="font-size: 22px;"><?php echo $entry->name ;?> - Style</span></td>
	</tr>
	<tr>
	<td style="border-bottom: 1px solid #F9F9F9;">
    <textarea style="width: 1000px; height: 300px;" name="style_edit_<?php echo $entry->id; ?>">
       <?php  
    if (isset($_POST["style_edit_".$entry->id])) {
            echo esc_textarea($_POST["style_edit_".$entry->id]);
        } else {
            echo esc_textarea($entry->content);
        }
     ?></textarea></td>
	</tr>
    <?php 
}
?>
<tr>
<td style="text-align: left;">
		<div style="height:50px;width:500px;margin:10px"><input class="submit_cfm" style="padding: 10px 15px 10px 15px;margin-left: 0px !important;" name="styleSubmit" type="submit" value=" Update"></div>
				</td>


</tr>
<tr>

</table>
</form>