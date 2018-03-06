<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Ess India Portal</title>
        <link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot . ('img/favicon.png'); ?>">
            <?php
            echo $this->Html->css('acl/base.css');
            echo $this->Html->css('acl/style.css');
            echo $this->Html->css('acl/start/jquery-ui-1.8.13.custom.css');
            echo $this->Html->css('acl/essbilling.css'); 
            echo $this->Html->script('acl/jquery-1.5.1.min.js'); 
            echo $this->Html->script('acl/jquery-ui-1.8.13.custom.min.js'); 
            echo $this->Html->script('acl/jquery.dropdownPlain.js'); 
            echo $this->Html->script('acl/jquery.jstree.js'); 
            
            echo $this->Html->css('acl/default/style.css'); 
            
            echo $this->Html->script('acl/custom.js'); 
            echo $this->Html->css('acl/custom.css'); 
            echo $this->Html->css('acl/bread_crumb.css');
            echo $this->Html->css('acl/vtip.css');
            /* ====== Breadcrumb ================== */
            echo $this->Html->script('acl/jquery.jBreadCrumb.1.1.js');

            /* ====== Qtip ================== */
            echo $this->Html->script('acl/jquery.qtip-1.0.0-rc3-dm-min.js');
            echo $this->Html->script('acl/jquery.autocomplete.js');
            echo $this->Html->script('acl/download.jQuery.js');
            
            echo $this->Html->css('acl/start/jquery-ui-1.8.13.custom.css');
            echo $this->Html->css('acl/jquery.lightbox-0.5.css');
            ?>
            <?php $flash = $this->Session->flash(); ?>
            <?php if ($flash != '') { ?>
                <script>
                    //javascript:window.history.forward(-1);
                    jQuery(document).ready(function () {
                        var xyz = '<?php echo $flash; ?>';
                        jQuery('.new-messsages').html('<div style="float:left" id="response-message">' + jQuery(xyz).text() + '</div>');
                        if (jQuery(xyz).hasClass("flash_error"))
                            jQuery('#response-message').errorStyle();
                        else
                            jQuery('#response-message').highlightStyle();
                        jQuery('#response-message').show().delay(10000).fadeOut(900);
                    });
                </script>
            <?php } ?>
            <script>

                function createMsg(msg, type) {
                    jQuery('.new-messsages').html('<div style="float:left" id="response-message">' + msg + '</div>');
                    if (type == 'error') {
                        jQuery('#response-message').errorStyle();
                    } else if (type == 'success') {
                        jQuery('#response-message').highlightStyle();
                    } else {
                        jQuery('#response-message').highlightStyle();
                    }
                    jQuery('#response-message').show().delay(10000).fadeOut(900);

                }

                $(document).ready(function () {
                    $("#cl").click(function () {
                        $("#overlay").show();
                    })
                });

            </script>
            <style>
                #overlay {
                    background:transparent;
                    filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#90000000,endColorstr=#90000000); 
                    zoom: 1;
                    background-color: rgba(0, 0, 0, 0.6);
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
    </head>
    <body>
       
        <div class="body-bg">
            <div class="wrpper">
                <!-- Header Starts -->
                <div class="new-messsages"  style="margin-top:10px; margin-left:390px; color: crimson;"></div>
                <div class="header">
                    <div class="login-global" style="color:#DDDDDD;">
                        <ul class="site-m-ul">
                            
                        </ul>
                    </div>
                    <div class="logo"><a href="#"><img src="<?php echo $this->webroot; ?>img/ess-logo.png" width="260" height="40" alt="ESS India" border="0"/></a></div>

                    
                <div class="center-content">
                    <?php echo $content_for_layout; ?>
                </div>
            </div>
        </div>
        </div> 
    
        <!-- Foter Starts -->
        <?php //echo $this->element('footer'); ?>
  
        <!-- Footer Ends -->
    </body>
</html>
