<?php
$news_url = $this->Common->getNewsUrl();
$auth = $this->Session->read('Auth'); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.js"
type="text/javascript"></script>
<script src="<?php echo $this->webroot.'css/c3js-chart/c3.min.css'; ?>" ></script>
<script src="<?php echo $this->webroot.'css/c3js-chart/c3.min.js'; ?>" ></script>
<script type="text/javascript"> 
<!-- 
rssfeed_url = new Array(); rssfeed_url[0]="<?php echo $news_url;?>";  rssfeed_frame_width="450px"; rssfeed_frame_height=""; rssfeed_scroll="on"; 
rssfeed_scroll_step="6"; rssfeed_scroll_bar="off"; rssfeed_target="_blank"; rssfeed_font_size="12"; rssfeed_font_face="sans-serif"; rssfeed_border="off"; 
rssfeed_title="on"; rssfeed_title_name=""; rssfeed_title_bgcolor="#3366ff"; rssfeed_title_color="#fff"; rssfeed_title_bgimage="http://"; rssfeed_footer="off"; 
rssfeed_footer_name="rss feed"; rssfeed_footer_bgcolor=""; rssfeed_footer_color="#333"; rssfeed_footer_bgimage="http://"; rssfeed_item_title_length="50"; 
rssfeed_item_title_color="#666"; rssfeed_item_bgcolor="#fff"; rssfeed_item_bgimage="http://"; rssfeed_item_border_bottom="on"; 
rssfeed_item_source_icon="off"; rssfeed_item_date="off"; rssfeed_item_description="on"; rssfeed_item_description_length="120"; 
rssfeed_item_description_color="#666"; rssfeed_item_description_link_color="#333"; rssfeed_item_description_tag="off"; rssfeed_no_items="0"; 
rssfeed_cache = "5ab6f6d5e5b6cc140jkjkkjk6c7cbc77f61ea38"; 
//--> 
</script> 
<link rel="stylesheet" href="<?php echo $this->webroot ?>css/style4.css"/>

<style type="text/css">
    @import url("http://www.google.com/uds/solutions/dynamicfeed/gfdynamicfeedcontrol.css");

    #feedControl {
        margin-top : 0px;
        margin-left: 0px;
        margin-right: 0px;

        font-size: 12px;
        color: #9CADD0;
    }
    .gfg-root{
        height:110px;
    }
</style>
<script type="text/javascript">
        <?php   $x = "[19 ,44,22 ]";
                $y = "[11, 42]";
                
                $leave = '';
                $conve = '';
                $trave = '';
                $moms = '';
                $boms = '';
                
                foreach($leaveType as $key=>$val){
                    $leave .= '["'.$val.'",'.$key.'],';
                }
                
                foreach($ConvType as $key=>$val){
                    $conve .= '["'.$val.'",'.$key.'],';
                }
                
                 foreach($TravType as $key=>$val){
                    $trave .= '["'.$val.'",'.$key.'],';
                }
               
                for($i = 0 ; $i<count($MOMType['a']); $i++){
                    $moms .= '["'.$MOMType['a']['status'][$i].'",'.$MOMType['a']['tot_meeting'][$i].'],';
                   
                }
                
                for($i = 0 ; $i<count($BOMType['a']); $i++){
                    $boms .= '["'.$BOMType['a']['status'][$i].'",'.$BOMType['a']['tot_meeting'][$i].'],';
                   
                }
                
                
              $dayName =  $AttenDAYS;
              $totAtten = $AttenCount;
               
        ?>
    $(function () {
        altair_charts.chartist_charts_leave()
    }), altair_charts = {chartist_charts_leave: function () {

            //////// Start for Leave chart ///////////

            var k = "#chartist_simple_pie";
            if ($(k).length) {
                var m = c3.generate({bindto: k, data: {columns: [["data1", 30], ["data2", 120]], type: "donut", onclick: function (e, t) {
                            console.log("onclick", e, t)
                        }, onmouseover: function (e, t) {
                            console.log("onmouseover", e, t)
                        }, onmouseout: function (e, t) {
                            console.log("onmouseout", e, t)
                        }}, donut: {title: "Leaves", width: 40},
                    color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"]}});
                $(k).waypoint({handler: function () {
                        setTimeout(function () {
                            m.load({columns: [
                               <?=$leave?>
                                ]})
                        }, 1500), setTimeout(function () {
                            m.unload({ids: "data1"}), m.unload({ids: "data2"})
                        }, 2500), this.destroy()
                    }, offset: "80%"}), $window.on("debouncedresize", function () {
                    m.resize()
                })
            }



            ///////////Start for Attendance//////////////

            new Chartist.Bar("#chartist_distributed_series", {
                labels: <?=$dayName?>,
                series: <?=$totAtten?>}, {
                distributeSeries: !0
            });





            //////////// Start for Conveyance ///////////////////// 
            var a = "#c3_chart_donut";
            if ($(a).length) {
                var n = c3.generate({bindto: a, data: {columns: [["data1", 30], ["data2", 120]], type: "donut", onclick: function (e, t) {
                            console.log("onclick", e, t)
                        }, onmouseover: function (e, t) {
                            console.log("onmouseover", e, t)
                        }, onmouseout: function (e, t) {
                            console.log("onmouseout", e, t)
                        }}, donut: {title: "Conveyance", width: 40},
                    color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"]}});
                $(a).waypoint({handler: function () {
                        setTimeout(function () {
                            n.load({columns: [
                                <?=$conve?>
                                ]})
                        }, 1500), setTimeout(function () {
                            n.unload({ids: "data1"}), n.unload({ids: "data2"})
                        }, 2500), this.destroy()
                    }, offset: "80%"}), $window.on("debouncedresize", function () {
                    n.resize()
                })
            }


            //////// Start for Travels chart ///////////

            var x = "#travel_chart";
            if ($(x).length) {
                var y = c3.generate({bindto: x, data: {columns: [["data1", 30], ["data2", 120]], type: "donut", onclick: function (e, t) {
                            console.log("onclick", e, t)
                        }, onmouseover: function (e, t) {
                            console.log("onmouseover", e, t)
                        }, onmouseout: function (e, t) {
                            console.log("onmouseout", e, t)
                        }}, donut: {title: "Travel", width: 40},
                    color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"]}});
                $(x).waypoint({handler: function () {
                        setTimeout(function () {
                            y.load({columns: [
                               <?=$trave?>
                                ]})
                        }, 1500), setTimeout(function () {
                            y.unload({ids: "data1"}), y.unload({ids: "data2"})
                        }, 2500), this.destroy()
                    }, offset: "80%"}), $window.on("debouncedresize", function () {
                    y.resize()
                })
            }


            //////// Start for MOM chart ///////////

            var r = "#mom_chart";
            if ($(r).length) {
                var s = c3.generate({bindto: r, data: {columns: [["data1", 30], ["data2", 120]], type: "donut", onclick: function (e, t) {
                            console.log("onclick", e, t)
                        }, onmouseover: function (e, t) {
                            console.log("onmouseover", e, t)
                        }, onmouseout: function (e, t) {
                            console.log("onmouseout", e, t)
                        }}, donut: {title: "MOM", width: 40},
                    color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"]}});
                $(r).waypoint({handler: function () {
                        setTimeout(function () {
                            s.load({columns: [
                               <?=$moms?>
                                ]})
                        }, 1500), setTimeout(function () {
                            s.unload({ids: "data1"}), s.unload({ids: "data2"})
                        }, 2500), this.destroy()
                    }, offset: "80%"}), $window.on("debouncedresize", function () {
                    s.resize()
                })
            }


            //////// Start for BOM chart ///////////

            var g = "#bom_chart";
            if ($(g).length) {
                var h = c3.generate({bindto: g, data: {columns: [["data1", 30], ["data2", 120]], type: "donut", onclick: function (e, t) {
                            console.log("onclick", e, t)
                        }, onmouseover: function (e, t) {
                            console.log("onmouseover", e, t)
                        }, onmouseout: function (e, t) {
                            console.log("onmouseout", e, t)
                        }}, donut: {title: "BOM", width: 40},
                    color: {pattern: ["#1f77b4", "#ff7f0e", "#2ca02c", "#d62728", "#9467bd", "#8c564b", "#e377c2", "#7f7f7f", "#bcbd22", "#17becf"]}});
                $(g).waypoint({handler: function () {
                        setTimeout(function () {
                            h.load({columns: [
                               <?php echo $boms;?>
                                ]})
                        }, 1500), setTimeout(function () {
                            h.unload({ids: "data1"}), h.unload({ids: "data2"})
                        }, 2500), this.destroy()
                    }, offset: "80%"}), $window.on("debouncedresize", function () {
                    h.resize()
                })
            }

        }



    };


</script>

<div id="page_content">
    <div id="page_content_inner">
        
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                               <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"><?php echo $leave_count; ?>/30</span></div>
                               <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->webroot;?>Leaves/today_leave" title="Click to view employees on leave today">Leaves taken (This month).</a></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $leave_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->Html->url('/conveyence_expenses/employee_expense_report'); ?>" title="Click to view conveyance vouchers">Conveyance claimed.</a> 
                    </span>
                            <h2 class="uk-margin-remove">Rs.<span class="countUpMe">0<noscript><?php echo $conveyance_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                                    <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->Html->url('/travels/employee_travel_report'); ?>" title="Click to view travel vouchers">Travel claimed.</a> 
                    </span>
                            <h2 class="uk-margin-remove">Rs.<span class="countUpMe">0<noscript><?php echo $travel_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                                <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"><?php echo $attendace_Count; ?>/<?php echo $emp_count; ?></span></div>
                                <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->webroot;?>users/attendance_report" title="Click to view today's attendance report">Present/Total Employees</a></span>
                            <h2 class="uk-margin-remove" id="peity_live_text"><?php echo $attendace_Count; ?>/<?php echo $emp_count; ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
            <?php
            $hour = date('H');
            if ($hour >= 20) {
                $greetings = "Good Night";
                $icon = "uk-text-danger uk-icon-star";
            } elseif ($hour > 17) {
                $greetings = "Good Evening";
                $icon = "uk-text-success uk-icon-star-half-o";
            } elseif ($hour > 11) {
                $greetings = "Good Afternoon";
                $icon = "uk-text-warning uk-icon-sun-o";
            } elseif ($hour < 12) {
                $greetings = "Good Morning";
                $icon = "uk-text-primary uk-icon-sun-o";
            }
            ?>
              <?php if ($this->Common->get_admin_option('bday_notify')) { ?>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
           
                        <?php if (!empty($bday_today)) { ?>
                            Today's Birthday
                            <ul class="md-list md-list-addon">
                                <?php foreach ($bday_today as $b) { ?>
                                    <li>
                                        <div class="md-list-addon-element">
                                           <i class="md-list-addon-icon material-icons uk-text-danger">cake</i>
                                        </div>
                                        <div class="md-list-content">
                                            <span class="uk-text-small"><a href="mailto:<?php echo $email['UserDetail']['email'] ?>?subject=Happy%20Birthday&body=Dear%20<?php echo ucwords(strtolower($email['UserDetail']['emp_name'])) ?>,%0D%0A%0D%0AWish%20You%20A%20Very%20Happy%20Birthday.%0D%0AMay god%20bless%20you.%0D%0A%20%0D%0ARegards,%0D%0A" title="Send Birthday Wish"><?php echo ucfirst($b['MyProfile']['emp_full_name']) ?></a></span>
                                            <span class="uk-text-small"><?php echo date('M-d', strtotime($b['MyProfile']['dob'])); ?></span>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                        Upcoming Birthdays
                        <ul class="">
                            <?php foreach ($bday_upcoming as $bu) { ?>
                                <li>
                                    <span class="uk-text-small"><?php echo ucfirst($bu['MyProfile']['emp_firstname']) ?> - <?php echo date('M-d', strtotime($bu['MyProfile']['dob'])); ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
                  
            <?php } ?>

            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                            <div><script type="text/javascript" src="http://feed.surfing-waves.com/js/rss-feed.js"></script> 
                   </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                        <p>
                            <script type="text/javascript" src="http://www.brainyquote.com/link/quotebr.js"></script>
                        </p>
                           <div id="cur_date" class="md-list-heading uk-text-danger"></div>
                        
                    </div>
                </div>
            </div>
        </div>


        <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-3" data-uk-grid-margin>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">Leave Chart<br>(from last one month)</h4>
                        <div id="chartist_simple_pie" class="c3chart"></div>
                    </div>
                </div>
            </div>
            <div>

                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">Conveyance Chart<br>(Current month department wise)</h4>
                        <div id="c3_chart_donut" class="c3chart"></div>
                    </div>
                </div>

            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">Attendance Chart<br>(Current week)</h4>
                        <div id="chartist_distributed_series" class="chartist"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid uk-grid-width-medium-1-2 uk-grid-width-large-1-3" data-uk-grid-margin>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">Travel Chart<br>(Current month department wise)</h4>
                        <div id="travel_chart" class="c3chart"></div>
                    </div>
                </div>
            </div>
            <div>

                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">MOM Chart<br></h4>
                        <div id="mom_chart" class="c3chart"></div>
                    </div>
                </div>

            </div>
            <div>
                <div class="md-card">
                    <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom">Board of Management<br></h4>
                        <div id="bom_chart" class="c3chart"></div>
                    </div>
                </div>
            </div>
        </div>



        <?php echo $flash = $this->Session->flash(); ?> 
<!-- statistics (small charts) -->
        <!-- info cards -->
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
            <div class="uk-width-medium-5-10">
                <div class="md-card">
                    <div class="md-card-content">
                        <div class="uk-overflow-container">
                            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                                <thead>
                                    <tr>
                                        <th class="filter-false remove sorter-false">S.No.</th>
                                        <td class="filter-false remove sorter-false">Task Name</th>
                                        <th class="filter-false remove sorter-false">Priority</th>
                                        <th class="filter-false remove sorter-false">Status</th>
                                    </tr>      
                                </thead>

                                <tbody aria-live="polite" aria-relevant="all">
                                    <?php $status = array(0 => 'Very High', 1 => 'High', 2 => 'Medium', 3 => 'Low'); ?>
                                    <?php $statusnew = array(0 => 'Pending', 1 => 'Pending', 2 => 'Pending', 3 => 'Pending', 4 => 'Pending', 5 => 'Pending', 6 => 'Complete'); ?>

                                    <?php $j = 1; ?>
                                    <?php foreach ($assignedTask as $data) { ?>
                                    <tr>
                                        <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $j; ?></span></td>
                                        <td><?php echo $data['TaskAssign']['tname'] ?></td>
                                            <?php
                                            if ($data['TaskAssign']['tpriority'] == '0') {
                                                $per = 'uk-badge uk-badge-danger';
                                            }
                                            if ($data['TaskAssign']['tpriority'] == '1') {
                                                $per = 'uk-badge uk-badge-warning';
                                            }
                                            if ($data['TaskAssign']['tpriority'] == '2') {
                                                $per = 'uk-badge uk-badge-info';
                                            }
                                            if ($data['TaskAssign']['tpriority'] == '3') {
                                                $per = 'uk-badge uk-badge-success';
                                            }
                                            ?> 
                                        <td ><a href="" class="<?php echo $per; ?>" ><?php
                                                    $new = $data['TaskAssign']['tpriority'];
                                                    echo $status[$new];
                                                    ?></a></td>
                                            <?php
                                            if ($data['TaskAssign']['status'] == '0') {
                                                $per = 0;
                                            }
                                            if ($data['TaskAssign']['status'] == '1') {
                                                $per = 0;
                                            }
                                            if ($data['TaskAssign']['status'] == '2') {
                                                $per = 10;
                                            }
                                            if ($data['TaskAssign']['status'] == '3') {
                                                $per = 30;
                                            }
                                            if ($data['TaskAssign']['status'] == '4') {
                                                $per = 50;
                                            }
                                            if ($data['TaskAssign']['status'] == '5') {
                                                $per = 80;
                                            }
                                            if ($data['TaskAssign']['status'] == '6') {
                                                $per = 100;
                                            }
                                            if ($data['TaskAssign']['status'] == '7') {
                                                $per = 100;
                                            }
                                            ?>          
                                        <td class="uk-width-3-10">
                                            <div class="uk-progress uk-progress-mini uk-progress-warning uk-margin-remove">
                                                    <?php
                                                    if ($data['TaskAssign']['status'] == 7) {
                                                        echo "Approved";
                                                    } else {
                                                        ?>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '0') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '1') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '2') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '3') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '4') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '5') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['TaskAssign']['status'] == '6') { ?>
                                                <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                            </div>
                                        </td>
                                        <?php } ?>  
                                        <?php $j++; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-width-medium-5-10">
                <div class="md-card">
                    <div class="md-card-content">
                        <div id="calendar_selectable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function () {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>
<script>
    $(function () {
        // enable hires images
        altair_helpers.retina_images();
        // fastClick (touch devices)
        if (Modernizr.touch) {
            FastClick.attach(document.body);
        }
    });
</script>
<div id="style_switcher">
    <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
    <div class="uk-margin-medium-bottom">
        <h4 class="heading_c uk-margin-bottom">Colors</h4>
        <ul class="switcher_app_themes" id="theme_switcher">
            <li class="app_style_default active_theme" data-app-theme="">
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
            <li class="switcher_theme_h" data-app-theme="app_theme_h">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
            <li class="switcher_theme_i" data-app-theme="app_theme_i">
                <span class="app_color_main"></span>
                <span class="app_color_accent"></span>
            </li>
        </ul>
    </div>
    <div class="uk-visible-large uk-margin-medium-bottom">
        <h4 class="heading_c">Sidebar</h4>
        <p>
            <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
            <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
        </p>
    </div>
    <div class="uk-visible-large uk-margin-medium-bottom">
        <h4 class="heading_c">Layout</h4>
        <p>
            <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
            <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
        </p>
    </div>
    <div class="uk-visible-large">
        <h4 class="heading_c">Main menu accordion</h4>
        <p>
            <input type="checkbox" name="accordion_mode_main_menu" id="accordion_mode_main_menu" data-md-icheck />
            <label for="accordion_mode_main_menu" class="inline-label">Accordion mode</label>
        </p>
    </div>

</div>








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
<script>
    $(function () {
        $.ajax({
            url: 'get_attendance_details',
            type: 'GET', // Send post data
            async: false,
            success: function (s) {
                json_events = s;
            }
        });
        altair_fullcalendar.calendar_selectable()
    }), altair_fullcalendar = {
        calendar_selectable: function () {
            var t = $("#calendar_selectable"),
                    a = $('<div id="calendar_colors_wrapper"></div>'),
                    e = altair_helpers.color_picker(a).prop("outerHTML");
            t.length && t.fullCalendar({
                header: {
                    left: "title today",
                    center: "",
                    right: "month,agendaWeek,agendaDay prev,next"
                },
                buttonIcons: {
                    prev: "md-left-single-arrow",
                    next: "md-right-single-arrow",
                    prevYear: "md-left-double-arrow",
                    nextYear: "md-right-double-arrow"
                },
                buttonText: {
                    today: " ",
                    month: " ",
                    week: " ",
                    day: " "
                },
                aspectRatio: 2.1,
                defaultDate: moment(),
                selectable: !0,
                selectHelper: !0,
                select: function (a, r) {
                    UIkit.modal.prompt('<h3 class="heading_b uk-margin-medium-bottom">New Event</h3><div class="uk-margin-medium-bottom" id="calendar_colors">Event Color:' + e + "</div>Event Title:", "", function (e) {
                        if ("" !== $.trim(e)) {
                            var o, d = $("#calendar_colors_wrapper").find("input").val();
                            $.ajax({
                                url: 'emp_events',
                                type: 'POST', // Send post data
                                data: 'title=' + e + '&color=' + d + '&date=' + a,
                                async: false,
                                success: function (s) {
                                }
                            });
                            o = {
                                title: e,
                                start: a,
                                end: r,
                                color: d ? d : ""
                            }, t.fullCalendar("renderEvent", o, !0), t.fullCalendar("unselect")
                        }
                    }, {
                        labels: {
                            Ok: "Add Event"
                        }
                    })
                },
                editable: !0,
                eventLimit: !0,
                timeFormat: "(HH)(:mm)",
                events: JSON.parse(json_events)
            })
        }
    };


</script>





