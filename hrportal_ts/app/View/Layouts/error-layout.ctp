<!doctype html>
<!--[if lte IE 9]> 
<html class="lte-ie9" lang="en"> 
<![endif]-->
<!--[if gt IE 9]><!--> 
<html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>

        <link rel="icon" type="image/png" href="<?php echo $this->webroot ?>images/psc_logo" sizes="16x16">
        <link rel="icon" type="image/png" href="<?php echo $this->webroot ?>images/psc_logo" sizes="32x32">

        <link REL="SHORTCUT ICON" href ="<?php echo $this->Html->url('/images', true);?>/<?php echo $uservalues['Auth']['User']['logo']; ?>"/>   
        <title>ESS(Employee Self Service)</title>

        <!-- additional styles for plugins -->

        <!-- kendo UI -->
        
        <!-- uikit -->
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

        
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/error_page.min.css" />


        <!-- matchMedia polyfill for testing media queries in JS -->
        <!--[if lte IE 9]>
            <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.addListener.js"></script>
        <![endif]-->
       

    </head>
    <body class="error_page">
        
        <?php echo $this->fetch('content'); ?>   

        
    </body>
</html>
