<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>ESS(Employee Self Service)</title>
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
            <!-- NEW THEME WISE -->
            
            
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

    <!-- altair admin -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/css/main.min.css" media="all">
	<!-- dropify -->
    <link rel="stylesheet" href="<?php echo $this->webroot ?>css/skins/dropify/css/dropify.css">
    

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot ?>css/bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    <script>
        /* Sidebar Menu active class */
        $(function () {
            var url = window.location;
            $('#sidebar-menu a[href="' + url + '"]').parent('li').addClass('act_item');
            $('#sidebar-menu a').filter(function () {
                return this.href == url;
            }).parent('li').addClass('act_item').parent('ul').slideDown().parent().addClass('current_section');
        });

        /** ******  /left menu  *********************** **/

        </script>

            
            
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
        <div id="overlay" align="center" style="font-size:12px; color: #FFFFFF;">
            <?php echo $this->Html->image("img/loadingbar.gif"); ?><br/><b>Please Wait....</b> 
        </div>
    </body>
    
    <body class="sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php echo $this->element('header') ?>
    <!-- left main menu sidebar -->
    <?php echo $this->element('left_menu') ?>
    
    <?php echo $this->fetch('content'); ?>   

    <!-- secondary sidebar -->
    <?php echo $this->element('header_right') ?>
    <!-- google web fonts -->
    <!-- common functions -->
	<script src="<?php echo $this->webroot ?>js/js/costom.js"></script>
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
	
	<script src="<?php echo $this->webroot ?>js/js/custom.js"></script>

	
	<!--  forms validation functions -->
    <script src="<?php echo $this->webroot ?>js/js/pages/forms_validation.min.js"></script>
	
	
	
	<div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Colors</h4>
            <ul class="switcher_app_themes" id="theme_switcher">
				<li class="switcher_theme_h active_theme" data-app-theme="app_theme_h">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>			
                <li class="switcher_theme_a" data-app-theme="app_theme_a">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_b" data-app-theme="app_theme_b">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_c" data-app-theme="app_theme_c">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_d" data-app-theme="app_theme_d">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_e" data-app-theme="app_theme_e">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_f" data-app-theme="app_theme_f">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_g" data-app-theme="app_theme_g">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                
                <li class="switcher_theme_i" data-app-theme="app_theme_i">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
            </ul>
        </div>
        
    </div>
    
    <script>
        $(function() {
            // enable hires images
            altair_helpers.retina_images();
            // fastClick (touch devices)
            if(Modernizr.touch) {
                FastClick.attach(document.body);
            }
        });
    </script>
   

    

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


        // toggle boxed layout

            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });

        // main menu accordion mode
            if($sidebar_main.hasClass('accordion_mode')) {
                $accordion_mode_toggle.iCheck('check');
            }

            $accordion_mode_toggle
                .on('ifChecked', function(){
                    $sidebar_main.addClass('accordion_mode');
                })
                .on('ifUnchecked', function(){
                    $sidebar_main.removeClass('accordion_mode');
                });


        });
    </script>
</body>
    
    
    <!-- Footer Starts -->
        <?php //echo $this->element('footer'); ?>
        <?php echo $this->Html->script('acl/common.js'); ?>
        <?php echo $this->element('sql_dump'); ?>
        <!-- Footer Ends -->
    
</html>
