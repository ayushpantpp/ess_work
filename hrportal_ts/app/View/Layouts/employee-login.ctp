<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->

<!-- Mirrored from altair_html.tzdthemes.com/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 09 Feb 2016 09:08:58 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="<?php echo $this->Html->url('/css', true);?>/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="<?php echo $this->Html->url('/css', true);?>/img/favicon-32x32.png" sizes="32x32">
    <title>ESS(Employee Self Service)</title>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
    <link REL="SHORTCUT ICON" href ="<?php echo $this->Html->url('/images', true);?>/<?php echo $logo; ?>"/>
     <?php
        echo $this->Html->css('bower_components/uikit/css/uikit.almost-flat.min.css');		
        echo $this->Html->css('css/login_page.min.css');		
    ?>

</head>
<body class="login_page login_bg_image">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">
            <?php echo $this->fetch('content'); ?> 
        </div>
    </div>
    
    <?php
        // common functions
        echo $this->Html->script('js/common.min.js');
        //core functions 
        echo $this->Html->script('js/altair_admin_common.min.js');
        // login page functions 
        echo $this->Html->script('js/pages/login.min.js');
    ?>   
    
    
    
    
</body>
</html>
