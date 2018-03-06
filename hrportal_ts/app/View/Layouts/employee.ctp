<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="PRAGMA" value="NO-CACHE"/>
<meta http-equiv="Expires" content="Mon, 01 Jan 1990 12:00:00 GMT"/>
<title>Ess India Portal</title>
<link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot.('img/favicon.png');?>"/>
<?php
echo $this->Html->css('Base.css');
echo $this->Html->css('style.css');
echo $this->Html->css('start/jquery-ui-1.8.13.custom.css');
echo $this->Html->css('essbilling.css');	
echo $this->Html->script('jquery-1.5.1.min.js');
echo $this->Html->script('jquery-ui-1.8.13.custom.min.js');
echo $this->Html->script('jquery.dropdownPlain.js');
echo $this->Html->script('custom.js');
echo $this->Html->css('custom.css');
echo $this->Html->css('BreadCrumb.css');
echo $this->Html->css('vtip.css');
echo $this->Html->script('jquery.jBreadCrumb.1.1.min.js');
echo $this->Html->script('jquery.qtip-1.0.0-rc3-dm-min.js');
if (strtolower($this->name) == "travels" && strtolower($this->action) == "trvoucher") {
	echo $this->Html->script('jquery-ui-timepicker-addon.js');
}    
echo $this->Html->script('common.js'); 
?>
<?php $flash = $this->Session->flash(); ?>
<?php if($flash!='') { ?>
<script>
	//javascript:window.history.forward(-1);
	jQuery(document).ready(function(){
        jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message"><?php echo $flash; ?></div>');
        if(jQuery('.new-messsages').html().indexOf("flash_error")!=-1)
                jQuery('#response-message').errorStyle();
        else
                jQuery('#response-message').highlightStyle();
        jQuery('#response-message').show().delay(10000).fadeOut(900); 
});
</script>
<?php } ?>

<style>
#overlay {
    background-color: rgba(0, 0, 0, 0.8);
    z-index: 999;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    display: none;
    margin:0 auto;
    padding-top:300px;   
}	
</style>
<script>
function createMsg(msg,type) {
       jQuery('.new-messsages').html('<div style="float:left" id="response-message">' + msg +'</div>');
        if(type=='error') {
          jQuery('#response-message').errorStyle();
        } else if(type=='success') {
          jQuery('#response-message').highlightStyle();
        } else {
          jQuery('#response-message').highlightStyle();
        }
jQuery('#response-message').show().delay(20000).fadeOut(900);

     }
$(document).ready(function() { $("#cl").click(function() { 
$("#overlay").show(); }) });

</script></head>
<body>
	<div id="overlay" align="center" style="font-size:12px; color: #FFFFFF;">
		<?php echo $this->Html->image("../img/loadingbar.gif"); ?><br/><b>Please Wait....</b> 
	</div>
	<div class="body-bg">
		<div class="wrpper">
			<!-- Header Starts -->
			<div class="new-messsages"  style="margin-top:10px; margin-left:390px; color: crimson;"></div>
			<?php echo $this->element('innerheader'); ?>
			<!-- Header Ends -->

			<!-- Center Content Starts -->
			<div class="center-content">
				<div id="" class="new-m"><?php echo $this->Session->flash(); ?></div>
					<!-- Left Content Starts -->
					<?php echo $content_for_layout; ?>
					<!-- Left Ends Starts -->
	
					<!-- Right Content Starts -->
					<?php if($this->params['controller']=="users" && $this->params['action']=="dashboard" && isset($_SESSION['Auth']['User']) && $_SESSION['Auth']['User']['user_type']=='Employees') { ?>
						<?php echo $this->element('innerright'); ?>
					<?php } ?>
					<!-- Right Content Starts -->
				</div>
			<!-- Center Content Ends -->
		</div>
	</div>
    <!-- Footer Starts -->
    <?php //echo $this->element('footer'); ?>
	<div>
        <?php //echo $this->element('sql_dump'); ?>
		<?php echo $this->element('footer'); ?>
	</div>
</body>
</html>
