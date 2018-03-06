<?php $auth = $this->Session->read('Auth');
    $news_url = $this->Common->getNewsUrl();
 ?>
<link rel="stylesheet" href="<?php echo $this->webroot ?>css/style4.css"/>
<style>
    .fc-scroller {
    height: 335px !important;
    overflow: hidden;
}
</style>    
<script>
            function startTime() {
                var today = new Date();
                var d = today.toDateString();
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('cur_date').innerHTML =
                       d + " " + h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) {
                    i = "0" + i
                }
                ;  // add zero in front of numbers < 10
                return i;
            }
        </script>
<script type="text/javascript"> 
<!-- 
rssfeed_url = new Array(); rssfeed_url[0]="<?php echo $news_url;?>";  rssfeed_frame_width="100%"; rssfeed_frame_height=""; rssfeed_scroll="on"; 
rssfeed_scroll_step="3"; rssfeed_scroll_bar="off"; rssfeed_target="_blank"; rssfeed_font_size="12"; rssfeed_font_face="sans-serif"; rssfeed_border="off"; 
rssfeed_title="on"; rssfeed_title_name=""; rssfeed_title_bgcolor="#3366ff"; rssfeed_title_color="#fff"; rssfeed_title_bgimage="http://"; rssfeed_footer="off"; 
rssfeed_footer_name="rss feed"; rssfeed_footer_bgcolor=""; rssfeed_footer_color="#333"; rssfeed_footer_bgimage="http://"; rssfeed_item_title_length="50"; 
rssfeed_item_title_color="#666"; rssfeed_item_bgcolor="#fff"; rssfeed_item_bgimage="http://"; rssfeed_item_border_bottom="on"; 
rssfeed_item_source_icon="off"; rssfeed_item_date="off"; rssfeed_item_description="on"; rssfeed_item_description_length="100%"; 
rssfeed_item_description_color="#666"; rssfeed_item_description_link_color="#333"; rssfeed_item_description_tag="off"; rssfeed_no_items="3"; 
rssfeed_cache = "5ab6f6d5e5b6cc1406c7hjcbc77f61jhjea38"; 
//--> 
</script> <div id="fb-root"></div>

<div id="page_content" >
    <div id="page_content_inner">
        <?php //echo $flash = $this->Session->flash(); ?> 
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                               <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data"><?php echo $leave_count; ?>/30</span></div>
                               <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->webroot;?>Leaves/view" title="Click to view applied leaves">Leaves taken (this month).</a></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $leave_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->Html->url('/conveyence_expenses/view'); ?>" title="Click to view conyevance applied">Conveyance claimed.</a> 
                    </span>
                            <h2 class="uk-margin-remove">Rs.<span class="countUpMe">0<noscript><?php echo $conveyance_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                                    <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->Html->url('/travels/view'); ?>" title="Click to view travel applied">Travel claimed.</a> 
                    </span>
                            <h2 class="uk-margin-remove">Rs.<span class="countUpMe">0<noscript><?php echo $travel_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                                    <span class="uk-text-muted uk-text-small"><a href="<?php echo $this->Html->url('/Holidays/holidaylisting'); ?>" title="Click to view list of holidays">Holiday (this month)</a> 
                    </span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">0<noscript><?php echo $holidays_count; ?></noscript></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium" data-uk-grid-margin>
           <div class="uk-width-medium-1-2">
                <div class="uk-grid uk-grid-width-large-1-1 uk-grid-width-medium-1-1 uk-grid-medium" data-uk-grid-margin>
                    <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <script type="text/javascript" src="http://feed.surfing-waves.com/js/rss-feed.js"></script> 
                        </div>
                    </div>
                </div>
                
                </div>
                <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium" data-uk-grid-margin>
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
                </div><div>
                    <div class="md-card">
                        <div class="md-card-content">
                               <p>
                            <script type="text/javascript" src="http://www.brainyquote.com/link/quotebr.js"></script>
                        </p>
                           <div id="cur_date" class="md-list-heading uk-text-danger"></div>     
                        </div>
                    </div>
                </div>
                </div> 
            </div>
            <div class="uk-width-medium-1-2">
                <div class="md-card">
                    <div class="md-card-content">
                        <div id="calendar_selectable"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
           
            <div class="uk-width-medium-7-10">
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
                                            <td ><a href="" class="<?php echo $per; ?>" ><?php $new = $data['TaskAssign']['tpriority'];
                                        echo $status[$new];
                                            ?></a></td>
                                            <?php
                                            if ($data['Assigned']['cstatus'] == '0') {
                                                $per = 0;
                                            }

                                            if ($data['Assigned']['cstatus'] == '1') {
                                                $per = 0;
                                            }
                                            if ($data['Assigned']['cstatus'] == '2') {
                                                $per = 10;
                                            }
                                            if ($data['Assigned']['cstatus'] == '3') {
                                                $per = 30;
                                            }
                                            if ($data['Assigned']['cstatus'] == '4') {
                                                $per = 50;
                                            }
                                            if ($data['Assigned']['cstatus'] == '5') {
                                                $per = 80;
                                            }
                                            if ($data['Assigned']['cstatus'] == '6') {
                                                $per = 100;
                                            }
                                            if ($data['Assigned']['cstatus'] == '7') {
                                                $per = 100;
                                            }
                                            ?>          
                                            <td class="uk-width-3-10">
                                                <div class="uk-progress uk-progress-mini uk-progress-warning uk-margin-remove">
                                                    <?php
                                                    if ($data['Assigned']['cstatus'] == 7) {
                                                        echo "Approved";
                                                    } else {
                                                        ?>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '0') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '1') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '2') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '3') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '4') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
                                                    <?php if ($data['Assigned']['cstatus'] == '5') { ?>
                                                        <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"></div>
                                                    <?php } ?>
    <?php if ($data['Assigned']['cstatus'] == '6') { ?>
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
        </div> 

    </div>
</div>

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
                                data:'title=' + e+'&color='+ d+ '&date='+ a ,
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



