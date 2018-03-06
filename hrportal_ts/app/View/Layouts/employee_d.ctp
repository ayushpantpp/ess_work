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

        <link REL="SHORTCUT ICON" href ="<?php echo $this->Html->url('/images', true);?>/<?php //echo $uservalues['Auth']['User']['logo']; ?>"/>   
        <title>ESS(Employee Self Service)</title>

        <!-- additional styles for plugins -->

        <!-- kendo UI -->
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/kendo-ui/styles/kendo.material.min.css"/>

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
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <!-- altair admin -->
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/css/main.min.css" media="all">
        <!-- dropify -->
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/skins/dropify/css/dropify.css">
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/error_page.min.css" />


       </head>
        <!-- main header -->
        <!-- left main menu sidebar -->
        <?php echo $this->element('header_1') ?>
        


        <?php echo $this->fetch('content'); ?>   

        <!-- secondary sidebar -->
        <!-- google web fonts -->
        
        <!-- common functions -->
        
        <script src="<?php echo $this->webroot ?>js/js/common.min.js"></script>
        <!-- uikit functions -->
        
        
        
        <script src="<?php echo $this->webroot ?>js/js/uikit_custom.min.js"></script>
        <!-- altair common functions/helpers -->
        <script src="<?php echo $this->webroot ?>js/js/altair_admin_common.min.js"></script>
        
        <!--  contact list functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/page_contact_list.min.js"></script>

        <!-- page specific plugins -->
        <!-- d3 -->
        <script src="<?php echo $this->webroot ?>css/bower_components/d3/d3.min.js"></script>
        <!-- metrics graphics (charts) -->
        <script src="<?php echo $this->webroot ?>css/bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
        <!-- chartist (charts) -->
        <script src="<?php echo $this->webroot ?>css/bower_components/chartist/dist/chartist.min.js"></script>
        <!-- maplace (google maps) 
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
        <script src="<?php echo $this->webroot ?>css/bower_components/maplace-js/dist/maplace.min.js"></script>
        <!-- peity (small charts) -->
        <script src="<?php echo $this->webroot ?>css/bower_components/peity/jquery.peity.min.js"></script>
        <!-- easy-pie-chart (circular statistics) -->
        <script src="<?php echo $this->webroot ?>css/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <!-- countUp -->
        <script src="<?php echo $this->webroot ?>css/bower_components/countUp.js/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="<?php echo $this->webroot ?>css/bower_components/handlebars/handlebars.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/custom/handlebars_helpers.min.js"></script>
        <!-- CLNDR -->
        <script src="<?php echo $this->webroot ?>css/bower_components/clndr/src/clndr.js"></script>
        <!-- fitvids -->
        <script src="<?php echo $this->webroot ?>css/bower_components/fitvids/jquery.fitvids.js"></script>

        <!--  dashbord functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/dashboard.min.js"></script>

        <!-- ionrangeslider -->
        <script src="<?php echo $this->webroot ?>css/bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
        <!-- htmleditor (codeMirror) -->
        <script src="<?php echo $this->webroot ?>js/js/uikit_htmleditor_custom.min.js"></script>

        <script src="<?php echo $this->webroot ?>css/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
        <script>
        // load parsley config (altair_admin_common.js)
        altair_forms.parsley_validation_config();
        </script>
        <!--  forms advanced functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/forms_advanced.min.js"></script>

        <script src="<?php echo $this->webroot ?>css/bower_components/parsleyjs/dist/parsley.min.js"></script>



        <script src="<?php echo $this->webroot ?>js/js/kendoui_custom.min.js"></script>

        <!--  Advanced calendar functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/kendoui.min.js"></script>

        <!-- datatables -->
        <script src="<?php echo $this->webroot ?>css/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
        <!-- datatables colVis-->
        <script src="<?php echo $this->webroot ?>css/bower_components/datatables-colvis/js/dataTables.colVis.js"></script>
        <!-- datatables tableTools-->
        <script src="<?php echo $this->webroot ?>css/bower_components/datatables-tabletools/js/dataTables.tableTools.js"></script>
        <!-- datatables custom integration -->
        <script src="<?php echo $this->webroot ?>js/js/custom/datatables_uikit.min.js"></script>

        <!--  datatables functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/plugins_datatables.min.js"></script>
        <!-- easytree -->
        <link rel="stylesheet" href="<?php echo $this->webroot ?>css/easy_tree/ui.easytree.min.css">
        <!-- easytree -->
        <script src="<?php echo $this->webroot ?>js/easy_tree/jquery.easytree.min.js"></script>
        <!--  easytree functions -->
        <script src="<?php echo $this->webroot ?>js/easy_tree/plugins_tree.min.js"></script>
        <!-- tablesorter -->
        <script src="<?php echo $this->webroot ?>css/bower_components/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>

        <!--  tablesorter functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/plugins_tablesorter.min.js"></script>

        <!--  issues list functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/pages_issues.min.js"></script>
        <!--  dropify -->
        <script src="<?php echo $this->webroot ?>js/js/custom/dropify/dist/js/dropify.min.js"></script>
        <!--  form file input functions -->
        <script src="<?php echo $this->webroot ?>js/js/pages/forms_file_input.min.js"></script>
        <!--	<script src="<?php echo $this->webroot ?>theme/js/custom.js"></script> -->
	<script src="<?php echo $this->webroot ?>js/js/custom.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <link href="<?php echo $this->webroot ?>css/cal/jquery-ui.css" rel="stylesheet">
        <script src="<?php echo $this->webroot ?>js/js/pages/jquery-ui.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/pages/forms_validation.min.js"></script>
         </body>
</html>
