<!doctype html>
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
    
    <body class="sidebar_main_open sidebar_main_swipe" onload="startTime()">
        <?php echo $this->element('header') ?>
        <?php echo $this->element('left_menu') ?>
        <?php echo $this->fetch('content'); ?>   
        <?php echo $this->element('header_right') ?>
         <?php //echo $this->element('footer'); ?>
        <script src="<?php echo $this->webroot ?>js/js/common.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/uikit_custom.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/altair_admin_common.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/pages/page_contact_list.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/d3/d3.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/metrics-graphics/dist/metricsgraphics.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/chartist/dist/chartist.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/maplace-js/dist/maplace.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/peity/jquery.peity.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/countUp.js/countUp.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/handlebars/handlebars.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/custom/handlebars_helpers.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/clndr/src/clndr.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/fitvids/jquery.fitvids.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/pages/dashboard.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/ion.rangeslider/js/ion.rangeSlider.min.js"></script>
        <script src="<?php echo $this->webroot ?>js/js/uikit_htmleditor_custom.min.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/jquery.inputmask/dist/jquery.inputmask.bundle.js"></script>
        <script>altair_forms.parsley_validation_config();</script>
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
        <!-- /// conflict file
		<script src="<?php echo $this->webroot ?>theme/js/custom.js"></script> -->
        <script src="<?php echo $this->webroot ?>js/js/custom.js"></script>
        <script src="<?php echo $this->webroot ?>css/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <link href="<?php echo $this->webroot ?>css/cal/jquery-ui.css" rel="stylesheet">
        <script src="<?php echo $this->webroot ?>js/js/pages/jquery-ui.min.js"></script>
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
       <!--  <link href="<?php echo $this->webroot ?>theme/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />-->
       <!-- <script src="<?php echo $this->webroot ?>theme/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script> -->
        
        <script>
            $(function () {
                var $switcher = $('#style_switcher'),
                        $switcher_toggle = $('#style_switcher_toggle'),
                        $theme_switcher = $('#theme_switcher'),
                        $mini_sidebar_toggle = $('#style_sidebar_mini'),
                        $boxed_layout_toggle = $('#style_layout_boxed'),
                        $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                        $body = $('body');
                $switcher_toggle.click(function (e) {
                    e.preventDefault();
                    $switcher.toggleClass('switcher_active');
                });
                $theme_switcher.children('li').click(function (e) {
                    e.preventDefault();
                    var $this = $(this),
                            this_theme = $this.attr('data-app-theme');

                    $theme_switcher.children('li').removeClass('active_theme');
                    $(this).addClass('active_theme');
                    $body
                            .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i')
                            .addClass(this_theme);

                    if (this_theme == '') {
                        localStorage.removeItem('altair_theme');
                    } else {
                        localStorage.setItem("altair_theme", this_theme);
                    }

                });
                // hide style switcher
                $document.on('click keyup', function (e) {
                    if ($switcher.hasClass('switcher_active')) {
                        if (
                                (!$(e.target).closest($switcher).length)
                                || (e.keyCode == 27)
                                ) {
                            $switcher.removeClass('switcher_active');
                        }
                    }
                });

                // get theme from local storage
                if (localStorage.getItem("altair_theme") !== null) {
                    $theme_switcher.children('li[data-app-theme=' + localStorage.getItem("altair_theme") + ']').click();
                }


                // toggle mini sidebar

                // change input's state to checked if mini sidebar is active
                if ((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                    $mini_sidebar_toggle.iCheck('check');
                }

                $mini_sidebar_toggle
                        .on('ifChecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.setItem("altair_sidebar_mini", '1');
                            location.reload(true);
                        })
                        .on('ifUnchecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.removeItem('altair_sidebar_mini');
                            location.reload(true);
                        });


                // toggle boxed layout

                if ((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                    $boxed_layout_toggle.iCheck('check');
                    $body.addClass('boxed_layout');
                    $(window).resize();
                }

                $boxed_layout_toggle
                        .on('ifChecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.setItem("altair_layout", 'boxed');
                            location.reload(true);
                        })
                        .on('ifUnchecked', function (event) {
                            $switcher.removeClass('switcher_active');
                            localStorage.removeItem('altair_layout');
                            location.reload(true);
                        });

                // main menu accordion mode
                if ($sidebar_main.hasClass('accordion_mode')) {
                    $accordion_mode_toggle.iCheck('check');
                }

                $accordion_mode_toggle
                        .on('ifChecked', function () {
                            $sidebar_main.addClass('accordion_mode');
                        })
                        .on('ifUnchecked', function () {
                            $sidebar_main.removeClass('accordion_mode');
                        });


            });
        </script>
    </body>
</html>
