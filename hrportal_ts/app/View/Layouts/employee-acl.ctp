<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Ess India Portal</title>
        <link REL="SHORTCUT ICON" HREF="<?php echo $this->webroot . ('img/favicon.png'); ?>">
        
    <!-- weather icons -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/weather-icons/css/weather-icons.min.css" media="all">
    <!-- metrics graphics (charts) -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/metrics-graphics/dist/metricsgraphics.css">
    <!-- chartist -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/css/main.min.css" media="all">
	<!-- dropify -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/skins/dropify/css/dropify.css">
    

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
            <?php
           
            echo $this->Html->css('acl/style.css');
            echo $this->Html->css('acl/start/jquery-ui-1.8.13.custom.css');
            
            echo $this->Html->script('acl/jquery-1.5.1.min.js'); 
            echo $this->Html->script('acl/jquery-ui-1.8.13.custom.min.js'); 
            echo $this->Html->script('acl/jquery.dropdownPlain.js'); 
            echo $this->Html->script('acl/jquery.jstree.js'); 
            
            echo $this->Html->css('acl/default/style.css'); 
            
            echo $this->Html->script('acl/custom.js'); 
            echo $this->Html->css('acl/custom.css'); 
            echo $this->Html->css('acl/bread_crumb.css');
            echo $this->Html->css('acl/vtip.css');
            
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
    
    <body class="sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php echo $this->element('header') ?>
    <!-- left main menu sidebar -->
    <?php echo $this->element('acl_menu') ?>
    
    <?php echo $this->element('header_right') ?>  
        
    <?php echo $content_for_layout; ?>
    </body>
</html>
