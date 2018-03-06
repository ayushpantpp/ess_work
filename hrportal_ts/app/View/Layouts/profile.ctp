<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="PRAGMA" value="NO-CACHE">
<meta http-equiv="Expires" content="Mon, 01 Jan 1990 12:00:00 GMT">
<title>Ess India Portal</title>
<link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot.('img/favicon.png');?>">
        <?php
//------------------------------Js----------------------------------------------
        echo $this->Html->script('jquery-1.5.1.min.js');
        echo $this->Html->script('jquery-ui-1.8.13.custom.min.js');
        echo $this->Html->script('i18n/grid.locale-en.js');
        echo $this->Html->script('jquery.jstree.js');
        echo $this->Html->script('auto-width.js');
        echo $this->Html->script('ts.js');
        echo $this->Html->script('ajax.js');
        echo $this->Html->script('formvalidator.js');
        echo $this->Html->script('jquery.form.js');
        echo $this->Html->script('function.js');

        echo $this->Html->script('jquery.lightbox-0.5.js');
        echo $this->Html->script('jquery.dropdownPlain.js');
	    echo $this->Html->script('jquery.jBreadCrumb.1.1.js');
        echo $this->Html->script('jquery.ajaxmanager.js');
        echo $this->Html->script('jquery.easing.1.3.js');
        echo $this->Html->script('jquery.qtip-1.0.0-rc3-dm-min.js');
        echo $this->Html->script('download.jQuery.js');
        echo $this->Html->script('timesheet.js');
  //------------------------------CSS-------------------------------------------
	echo $this->Html->css('Base.css');
	echo $this->Html->css('BreadCrumb.css');
        echo $this->Html->css('vtip.css');
        echo $this->Html->css('jquery.lightbox-0.5.css');        
        echo $this->Html->css('jquery_validation/screen.css');
        echo $this->Html->css('style.css');
        echo $this->Html->css('start/jquery-ui-1.8.13.custom.css');
//-----------------------------------------------------------------------------     
//---------------------Code Confliction-----------------------------------------
?>
    <?php $flash = $this->Session->flash(); ?>
    <?php if($flash!='') { ?>
    <script>
        javascript:window.history.forward(-1);
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
</head>
<body>
    <div class="body-bg">
<div class="wrpper">
<!-- Header Starts -->
<div class="new-messsages"  style="margin-top:10px; margin-left:390px; color: crimson;"></div>
 <?php //echo $this->element('innerheader'); ?>

  <!-- Header Ends -->

  <!-- Center Content Starts -->
  <div class="center-content">
        <div id="" class="new-m"><?php echo $this->Session->flash(); ?></div>
        <!-- Left Content Starts -->
            <?php echo $content_for_layout; ?>
	<!-- Left Ends Starts -->
	
  </div>
  <!-- Center Content Ends -->
</div>
    </div>
        <!-- Footer Starts -->
    <?php echo $this->element('profile_footer'); ?>
        <?php echo $this->Html->script('common.js');?>
        <?php //echo $this->Html->script('chat.js');?>
<!-- Footer Ends -->
<!--
<div class="cust-chat">
        <div class="online-chat-box">
            <div class="online-box-panel">
                <b>Online Users</b><div class="chat-action">
                <a class="chat-off" href="#"></a>
            </div>
            </div>
            <div class="chat-rooms-list-container">
                <select class="chat-rooms-list">
                </select>
                <ul class="chat-rooms-actions">
                    <li class="chat"><a href="#" class="vtip" title="Chat">Chat</a></li>
                    <li class="delete vtip" title="Delete">Delete</li>
                </ul>
            </div>
            <div class="chat-member-add-container" style="display:none;">
                <input id="chat-member-name" type="text"/><input id="chat-member-id" type="hidden"/><a class="chat-room-add-member" href="#">Add Member</a>
            </div>
            <div class="chat-box-txt1">
                <ul style="padding-left:5px">

                </ul>
            </div>
            <div  class="chat-rooms-add-container">
                <input type="text"/><a href="#">Add Room</a>
            </div>        
        </div>
        <div class="chat-box-nav-right" style="display: none;">
            <div class="chat-box-panel-nav">
                <div><?php echo $this->Html->image('arrow-right.png'); ?></div>
            </div>
        </div>
        <div class="chat-box-nav-left" style="display: none;">
            <div class="chat-box-panel-nav">
                <div><?php echo $this->Html->image('arrow-left.png'); ?></div>
            </div>
        </div>    
</div>
    <div class="chat-box-dummy" style="display:none">
        <div class="chat-box-panel">
            <div class="chat-image"><?php echo $this->Html->image('default-chat-image.png'); ?></div>
            <div class="chat-status"><?php echo $this->Html->image('online-chat-icon.png'); ?></div>
            <div class="chat-room-name"></div>
            <div class="chat-action">
                <a href="#" class="chat-box-expand"></a>
                <a href="#" class="chat-box-close"></a>
            </div>
        </div>        
        <div class="chat-box-txt">
                    <form>
                    <input type='hidden'id="chat_max_id" name="chat_max_id" value="0" autocomplete="off" />
                    <input type='hidden'id="vc_room_id" name="vc_room_id" value="0" autocomplete="off" />
                    <?php $auth= $this->Session->read('Auth'); ?>
                    <input type='hidden' id="vc_emp_id_makess" value="<?php echo $auth['Employees']['vc_emp_id_makess'] ; ?> " autocomplete="off" />
                    </form>
             <ul>
                <li class="msg-name-time-on"><b>Me<span>13:51</span></b>No Spectical</li>                
             </ul>
        </div>
        <input type="text" id="chat-text" autocomplete="off" />
    </div -->
</body>
</html>
