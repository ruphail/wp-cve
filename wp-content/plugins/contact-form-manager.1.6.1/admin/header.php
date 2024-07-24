<?php if ( ! defined( 'ABSPATH' ) ) exit;?>
<style type="text/css">
</style>

<style>
	a.xyz_cfm_link:hover{text-decoration:underline;} 
	.xyz_cfm_link{text-decoration:none;font-weight: bold;} 
</style>

<?php 
if(!$_POST && (isset($_GET['cfm_blink'])&&isset($_GET['cfm_blink'])=='en')){
	if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'],'cfm-blk')){
		wp_nonce_ays( 'cfm-blk');
		exit;
	} 
	update_option('xyz_credit_link',"cfm");
?>
<div class="system_notice_area_style1" id="system_notice_area">
Thank you for enabling backlink.
 &nbsp;&nbsp;&nbsp;<span id="system_notice_area_dismiss">Dismiss</span>
</div>
<style type="text/css">
	.xyz_blink{
		display:none !important;
	}
</style>
<?php
}

if(get_option('xyz_credit_link')=="0" &&(get_option('xyz_cfm_credit_dismiss')=="0")){
	?>
<div style="float:left;background-color: #FFECB3;border-radius:5px;padding: 0px 5px;margin-top: 10px;border: 1px solid #E0AB1B" id="xyz_backlink_div">
	
	Please do a favour by enabling backlink to our site. <a class="xyz_cfm_backlink" style="cursor: pointer;" >Okay, Enable</a>
 <a id="xyz_cfm_dismiss" style="cursor: pointer;" >Dismiss</a>.



<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('.xyz_cfm_backlink').click(function(){
		xyz_filter_blink(1)
	});

	jQuery('#xyz_cfm_dismiss').click(function(){
		xyz_filter_blink(-1)
	});
	
	function xyz_filter_blink(stat){
		var backlink_nonce= '<?php echo wp_create_nonce('backlink');?>';
		var dataString = { 
				action: 'ajax_backlink', 
				enable: stat ,
				_wpnonce: backlink_nonce
			};
	

		jQuery.post(ajaxurl, dataString, function(response) {
			if(response==1)
	        	alert("You do not have sufficient permissions");
			else if(response=="cfm"){
			jQuery('#xyz_cfm_backlink').hide();
			jQuery("#xyz_backlink_div").html('Thank you for enabling backlink !');
			jQuery("#xyz_backlink_div").css('background-color', '#D8E8DA');
			jQuery("#xyz_backlink_div").css('border', '1px solid #0F801C');
			}

			else if(response==-1){
				jQuery("#xyz_backlink_div").remove();
		}
		});	
	};
});
</script>
</div>
	<?php 
}
?>

<style>
#text {margin:50px auto; width:500px}
.hotspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}

#tt {position:absolute; display:block; }
#tttop {display:block; height:5px; margin-left:5px;}
#ttcont {display:block; padding:2px 10px 3px 7px;  margin-left:-400px; background:#666; color:#FFF}
#ttbot {display:block; height:5px; margin-left:5px; }
</style>

<div style="margin-top: 10px">
<table style="float:right; ">
<tr>
<td  style="float:right;" >
	<a class="xyz_cfm_link" style="margin-left:8px;margin-right:12px;"  target="_blank" href="http://xyzscripts.com/donate/5">Donate</a>
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://help.xyzscripts.com/docs/contact-form-manager/faq/">FAQ</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://help.xyzscripts.com/docs/contact-form-manager/">README</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" style="margin-left:8px;" target="_blank" href="http://xyzscripts.com/wordpress-plugins/contact-form-manager/details">About</a> |
</td>
<td style="float:right;">
	<a class="xyz_cfm_link" target="_blank" href="http://xyzscripts.com">XYZScripts</a> |
</td>

</tr>
</table>
</div>

<div style="clear: both"></div>
