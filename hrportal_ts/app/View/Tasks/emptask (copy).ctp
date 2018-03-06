<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
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
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','../www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-65191727-1', 'auto');
        ga('send', 'pageview');
    </script>


<!-- page content -->
        <?php $auth=$this->Session->read('Auth');
                        $elogin=$auth['MyProfile']['emp_firstname'];
                        $ecode=$auth['MyProfile']['emp_code'];?>
 <div id="page_content">
     
      <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions">
            <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Archive"><i class="md-icon material-icons">&#xE149;</i></a>
            <a href="#" data-uk-tooltip="{pos:'bottom'}" title="Print"><i class="md-icon material-icons">&#xE8AD;</i></a>
            <div data-uk-dropdown>
                <i class="md-icon material-icons">&#xE5D4;</i>
                <div class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Other Action</a></li>
                        <li><a href="#">Other Action</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <h1>Issue Tracker</h1>
        <span class="uk-text-upper uk-text-small"><a href="#">Project Name</a></span>
    </div>
     
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        
    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Complete</th>
                                <th>Details</th>
                                <th>Remark</th>
                                <th>Task Forward</th>
                                <th>Notification</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Task Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Complete</th>
                                <th>Details</th>
                                <th>Remark</th>
                                <th>Task Forward</th>
                                <th>Notification</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>

                        <tbody>
                <?php $j=1;?>
                            <?php $status=array(0=>'Very High',1=>'High',2=>'Medium',3=>'Low');?>
                            <?php $statusnew=array(0=>'Pending',1=>'Pending',2=>'Pending',3=>'Pending',4=>'Pending',5=>'Pending',6=>'Complete');?>
                      <?php foreach($assignedTask as $data) {?>
                            <tr>

                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $j;?></span></td>
                                <td><?php echo $data['TaskAssign']['tname']?></td>

                                <td class="uk-text-small"><?php echo $data['TaskAssign']['starttime']?></td>
                                <td class="uk-text-small"><?php echo $data['TaskAssign']['endtime']?></td>
                                <td><span class="uk-badge uk-badge-warning">critical</span></td>
                                <td><span class="uk-badge uk-badge-outline uk-text-upper">closed</span></td>
                                    <?php if($data['TaskAssign']['tpriority'] == '0'){$per = 'uk-badge uk-badge-danger';}
                                     if($data['TaskAssign']['tpriority'] == '1'){$per = 'uk-badge uk-badge-warning';}
                                     if($data['TaskAssign']['tpriority'] == '2'){$per = 'uk-badge uk-badge-info';}
                                     if($data['TaskAssign']['tpriority'] == '3'){$per = 'uk-badge uk-badge-success';}
                                    ?> 
                                <td class="<?php echo $per;?>"><?php echo $new= $data['TaskAssign']['tpriority']; die; echo $status[$new];?></td>
                            <?php if($data['Assigned']['cstatus'] == '0'){$per = 0;}
                                       
                                    if($data['Assigned']['cstatus'] == '1'){$per = 0;}
                                    if($data['Assigned']['cstatus'] == '2'){$per = 10;}
                                    if($data['Assigned']['cstatus'] == '3'){$per = 30;}
                                    if($data['Assigned']['cstatus'] == '4'){$per = 50;}
                                    if($data['Assigned']['cstatus'] == '5'){$per = 80;}
                                    if($data['Assigned']['cstatus'] == '6'){$per = 100;}
                                    if($data['Assigned']['cstatus'] == '7'){$per = 100;}
                                ?>          
                                <td> <?php if($data['Assigned']['cstatus'] == 7){ echo "Approved";}else{?>
                                    <select id = "workstatus" onchange="return updatestatus(this.value,'<?php echo $data['TaskAssign']['tid']; ?>','<?php echo $ecode; ?>');" <?php if($data['Assigned']['cstatus'] == '6'){
                                     echo 'disabled';
                                } ?> >
                                       <option value = "0" <?php if($data['Assigned']['cstatus'] == '0'){
                                        $per = 0;
                                        echo "selected = 'selected'";
                                }?> >New</option>
                                        <option value = "1" <?php if($data['Assigned']['cstatus'] == '1'){
                                        $per = 0;
                                        echo "selected = 'selected'";
                                }?>>Start</option>
                                        <option value = "2" <?php if($data['Assigned']['cstatus'] == '2'){
                                        $per = 10;
                                        echo "selected = 'selected'";
                                }?>>complete 10-20%</option>
                                        <option value = "3" <?php if($data['Assigned']['cstatus'] == '3'){
                                        $per = 30;
                                        echo "selected = 'selected'";
                                }?>>complete 30-40%</option>
                                        <option value = "4" <?php if($data['Assigned']['cstatus'] == '4'){
                                        $per = 50;
                                        echo "selected = 'selected'";
                                }?>>complete 50-60%</option>
                                        <option value = "5" <?php if($data['Assigned']['cstatus'] == '5'){
                                        $per = 80;
                                        echo "selected = 'selected'";
                                }?>>complete 70-80%</option>
                                        <option value = "6" <?php if($data['Assigned']['cstatus'] == '6'){
                                        $per = 100;
                                        echo "selected = 'selected'";echo ' '; echo "disabled = 'disabled'";
                                } ?>>Complete</option>
                                    </select></td>
                                 <?php } ?>  
                                <td><?php echo $per;?><div class="progress tight">
                                        <div class="uk-badge uk-badge-success" style="width: <?php echo $per;?>;"> </div>
                                    </div></td>
                                <td><a href="#popup1" data-uk-modal="{ center:true }" 
                                       onclick="Get_Details('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="Click to View.">Click To View</a></td>
                                <td><a href="#popup2" data-uk-modal="{ center:true }" 
                                       onclick="Get_Details2('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="Click to Remark.">Remarks</a></td><td>
                                 <?php if($data['TaskAssign']['status'] == '7'){ echo "--N/A--"; } else {?>
                                 <?php if($auth['MyProfile']['desg_code']== 'PAR0000019'){ ?>
                                    <a href="taskforward/<?php echo $data['TaskAssign']['tid']?>" class="btn btn-info btn-xs" class="view vtip" title="Click to Task Forward">Task Forward</a>
                                <?php } else {?>
                                    <!--<a href="forwardemp/<?php //echo $data['TaskAssign']['tid']?>" class="btn btn-info btn-xs" class="view vtip" title="Click to Remark.">Task Forward..</a>-->
                                    <a href="taskforward/<?php echo $data['TaskAssign']['tid']?>" class="btn btn-info btn-xs" class="view vtip" title="Click to Task Forward">Task Forward</a>
                                 <?php } }?>
                                </td>     
                                <td><?php if($data['Assigned']['statusid']!=8){echo "--No Alert--";}
                                     else{ ?>
                                    <a href="#popup5" data-uk-modal="{center:true }"
                                       onclick="Get_Details5('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="New Alert">View Alert</a>
                                       <?php } ?>
                                </td>
                                <td>
                                    <?php 
                                    if($data['TaskAssign']['assignby']==$elogin)
                                     {
                                     ?>
                                     <?php if($data['TaskAssign']['status'] == '7'){ echo "Edit";} else {?>
                                    <a href="taskedit/<?php echo $data['TaskAssign']['tid']?>"  title="Click to Task Edit.">Edit</a><?php }?>
                                    |<a href="taskdelete/<?php echo $data['TaskAssign']['tid']?>"  title="Click to Task Delete.">Delete</a>
                                    <?php
                                     }
                                       else{ echo "--";}
                                      ?>
                                </td>

                               <?php $j++;?>
                            </tr>
                           <?php }?>


                        </tbody>
                    </table>
                </div>
                <ul class="uk-pagination ts_pager">
                    <li data-uk-tooltip title="Select Page">
                        <select class="ts_gotoPage ts_selectize"></select>
                    </li>
                    <li class="first"><a href="javascript:void(0)"><i class="uk-icon-angle-double-left"></i></a></li>
                    <li class="prev"><a href="javascript:void(0)"><i class="uk-icon-angle-left"></i></a></li>
                    <li><span class="pagedisplay"></span></li>
                    <li class="next"><a href="javascript:void(0)"><i class="uk-icon-angle-right"></i></a></li>
                    <li class="last"><a href="javascript:void(0)"><i class="uk-icon-angle-double-right"></i></a></li>
                    <li data-uk-tooltip title="Page Size">
                        <select class="pagesize ts_selectize">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>

<div class="uk-modal" id="popup1">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>
<div class="uk-modal" id="popup2">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>
<div class="uk-modal" id="popup5">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>



<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="#new_issue" data-uk-modal="{ center:true }">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>

<div class="uk-modal" id="new_issue">
    <div class="uk-modal-dialog">
        <form class="uk-form-stacked">
            <div class="uk-margin-medium-bottom">
                <label for="task_title">Title</label>
                <input type="text" class="md-input" id="Task_title" name="snippet_title"/>
            </div>
            <div class="uk-margin-medium-bottom">
                <label for="task_description">Description</label>
                <textarea class="md-input" id="task_description" name="task_description"></textarea>
            </div>
            <div class="uk-margin-medium-bottom">
                <label for="task_assignee" class="uk-form-label">Assignee</label>
                <select class="uk-form-width-medium" name="task_assignee" id="task_assignee" data-md-selectize-inline>
                    <option value="user_me">Me</option>
                    <option value="user_1">Kayley Pouros</option>
                    <option value="user_2">Santiago Bogan</option>
                    <option value="user_3">Darien Gusikowski</option>
                    <option value="user_4">Flavio Mante</option>
                </select>
            </div>
            <div class="uk-margin-medium-bottom">
                <label for="task_priority" class="uk-form-label">Priority</label>
                <div>
                    <span class="icheck-inline">
                        <input type="radio" name="task_priority" id="task_priority_minor" data-md-icheck />
                        <label for="task_priority_minor" class="inline-label uk-badge uk-badge-success">MINOR</label>
                    </span>
                    <span class="icheck-inline">
                        <input type="radio" name="task_priority" id="task_priority_critical" data-md-icheck />
                        <label for="task_priority_critical" class="inline-label uk-badge uk-badge-warning">CRITICAL</label>
                    </span>
                    <span class="icheck-inline">
                        <input type="radio" name="task_priority" id="task_priority_blocker" data-md-icheck />
                        <label for="task_priority_blocker" class="inline-label uk-badge uk-badge-danger">BLOCKER</label>
                    </span>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save">Add Issue</button>
            </div>
        </form>
    </div>
</div>
<!-- google web fonts -->
<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>

<!-- common functions -->
<script src="assets/js/common.min.js"></script>
<!-- uikit functions -->
<script src="assets/js/uikit_custom.min.js"></script>
<!-- altair common functions/helpers -->
<script src="assets/js/altair_admin_common.min.js"></script>

<!-- page specific plugins -->
<!-- tablesorter -->
<script src="/psckenya/css/bower_components/tablesorter/dist/js/jquery.tablesorter.min.js"></script>
<script src="/psckenya/css/bower_components/tablesorter/dist/js/jquery.tablesorter.widgets.min.js"></script>
<script src="/psckenya/css/bower_components/tablesorter/dist/js/widgets/widget-alignChar.min.js"></script>
<script src="/psckenya/css/bower_components/tablesorter/dist/js/extras/jquery.tablesorter.pager.min.js"></script>

<!--  issues list functions -->
<script src="assets/js/pages/pages_issues.min.js"></script>

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
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','../www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-65191727-1', 'auto');
    ga('send', 'pageview');
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
<script type="text/javascript">

    function updatestatus(status,id,ecode){
      jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/updatestatus/'+status+'/'+id+'/'+ecode,
        success: function(data){
            //alert(data);
           window.location.reload();
        }
    });
       

    }

    function Get_Details(id)
    {
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/view2/'+id,
        success: function(data){
            jQuery('.HRcontent').html(data);
        }
    });
    }
  
    function Get_Details2(id)
    {
    //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/remark/'+id,
        success: function(data){
            jQuery('.HRcontent1').html(data);
        }
    });
    }

   function Get_Details5(id)
    {
    //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/alert/'+id,
        success: function(data){
            //alert(data);
            jQuery('.HRcontent5').html(data);
        }
    });
    }   

    function tooltip(id){
         $.get('<?php echo $this->webroot;?>tasks/tooltip/'+id, function(data){
        $('#dialog_'+id).html(data);
         //$('[data-toggle="dialog"]').tooltip();           
        });

    }
    function tooltip_left(id){
        $('#dialog_'+id).html('');

    }

    $(function () {
        $.noConflict();
         //$('[data-toggle="tooltip"]').tooltip();
        $.get('<?php echo $this->webroot;?>tasks/chartdata', function(data){
            var jsonArr = JSON.parse(data);
            //setPieChart(4,'Resource',jsonArr);
       
        });
        
       setMeterChart(0,'Completed',[<?php print_r($count);?>]);
       setMeterChart(1,'Pending',[<?php print_r($count1);?>]);
       setMeterChart(2,'Not Started',[<?php print_r($count2);?>]);
  
 function setMeterChart(id,titleText,chartData){
     
    $('#container'+id).highcharts({
    chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: titleText + ' Tasks'
            },
                exporting:
                { enabled: false },

                credits:{
                enabled: false
                }, pane: {
                startAngle: -120,
                endAngle: 120,
                background: [{
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: 0,
                max: 20,

                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',

                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'Task'
                },
                plotBands: [{
                    from: 0,
                    to: 5,
                    color: '#55BF3B' // green
                }, {
                    from: 5,
                    to: 10,
                    color: '#DDDF0D' // yellow
                }, {
                    from: 10,
                    to: 20,
                    color: '#DF5353' // red
                }]
            },

            series: [{
                name: titleText + ' :',
                data: chartData,
                tooltip: {
                    valueSuffix: 'Tasks'
                }
            }]

        },
        // Add some life
        function (chart) {
            /*if (!chart.renderer.forExport) {
                setInterval(function () {
                    var point = chart.series[0].points[0],
                        newVal,
                        inc = Math.round((Math.random() - 0.5) * 2);

                    newVal = point.y + inc;
                    if (newVal < 0 || newVal > 20) {
                        newVal = point.y - inc;
                    }

                    point.update(newVal);

                }, 300);
            }*/
        });
}
    function setPieChart(id,title,chartData){
        $('#container3').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: title + ' Allocation'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.1f}%</b>'
            },
            plotOptions: { 
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                    enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Brands',
                colorByPoint: true,
                data: chartData
            }]
        });
    }
});


</script>
