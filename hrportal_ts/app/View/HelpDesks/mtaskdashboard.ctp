

<!-- page content -->
<?php
$auth = $this->Session->read('Auth');
$elogin = $auth['MyProfile']['emp_firstname'];
?>
<?php $statusnew = array(0 => 'Very High', 1 => 'High', 2 => 'Medium', 3 => 'Low'); ?>
<?php $status = array(0 => 'New', 1 => 'Start', 2 => 'Working', 3 => 'Working', 4 => 'Working', 5 => 'Working', 6 => 'Complete', 7 => 'Approved'); ?>
<?php $fstatus = array(0 => 'New', 1 => 'Start', 2 => 'Working', 3 => 'Working', 4 => 'Working', 5 => 'Working', 6 => 'Complete', 7 => 'Approved'); ?>           
<script type="text/javascript">
    function updatestatus1(fstatus, id) {
        //alert(fstatus);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/updatestatus1/' + fstatus + '/' + id,
            success: function (data) {
                //alert(data);
                window.location.reload();
            }
        });
    }

    function Get_Details(id) {   //alert(id);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/view2/' + id,
            success: function (data) {
               jQuery('.HRcontent').html(data);
            }
        });
    }

    function Get_Details6(id)
    {  // alert(id);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/getalert/' + id,
            success: function (data) {
                //alert(data);
                jQuery('.HRcontent6').html(data);
            }
        });
    }

    function Get_Details7(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/alertcomment/' + id,
            success: function (data) {
                //alert(data);
                jQuery('.HRcontent7').html(data);
            }
        });
    }


    function Get_Details5(id)
    {
        //alert(id);
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>tasks/alert/' + id,
            success: function (data) {
                //alert(data);
                jQuery('.HRcontent5').html(data);
            }
        });
    }


</script>  
<script type="text/javascript">


    function tooltip(id) {
        $.get('<?php echo $this->webroot; ?>tasks/tooltip/' + id, function (data) {
            $('#dialog_' + id).html(data);
            //$('[data-toggle="dialog"]').tooltip();           
        });

    }
    function tooltip_left(id) {
        $('#dialog_' + id).html('');

    }
</script>

<!-- page content -->


<div id="page_content">

        <div class="uk-sticky-placeholder" style="height: 81px;"><div data-uk-sticky="{ top: 48, media: 960 }" id="page_heading" style="position: fixed; top: 48px; width: 1048px; left: 240px;" class="uk-sticky-init uk-active">
            <div class="heading_actions">
                <a title="Archive" data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>
                <a data-uk-tooltip="{pos:'bottom'}" href="#"><i class="md-icon material-icons"></i></a>

            </div>
            <h1>Task Assigned</h1>
            <span class="uk-text-upper uk-text-small"><a href="#">Task Assigned</a></span>
        </div></div>
    <?php echo $flash = $this->Session->flash();?>

    <div id="page_content_inner">
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                        <th>S.No.</th>
                        <th>Task Name</th>
                        <th>Assign To</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Task Priority</th>
                        <th>Employee Status</th>
                        <th>Employee Complete</th>
                        <th>Status</th>
                        <th>Details</th>
                        <th>Notification</th>
                        <th>Action</th>
                        <th>Task Forward</th>
                        <th class="filter-false remove sorter-false uk-text-center" >Alert</th>
                            </tr>     
                        </thead>
                        <tfoot>
                            <tr >
                                <th scope="row">S.No.</th>
                                <!--<th class="column-title">Task ID</th>--> 
                                <th >Task Name</th>
                                <th >Assign To</th>
                                <th >Start Date</th>
                                <th >End Date</th>
                                <th >Task Priority</th>
                                <th >Employee Status</th>
                                <th >Employee Complete</th>
                                <th >Status</th>
                                <th >Details</th>
                                <th >Notification</th>
                                <th >Action</th>
                                <th >Task Forward</th>
                                <th >Alert</th>
                            </tr>
                        </tfoot>
                        <tbody><?php $j = 1; ?>
<?php foreach ($tabledata as $data) { ?>
                                <tr>
                                    <td><?php echo $j ?></td>
                                    <!--<td><?php //echo $data['TaskAssign']['tid'] ?></td>-->
                                    <td><?php echo $data['TaskAssign']['tname'] ?></td>
                                    <td onmouseover="tooltip(<?php echo $data['TaskAssign']['tid']; ?>)" onmouseout="tooltip_left(<?php echo $data['TaskAssign']['tid']; ?>)"><?php echo $data['TaskAssign']['assignto'] ?> <div id="dialog_<?php echo $data['TaskAssign']['tid']; ?>"></div></td>
                                    <td><?php echo $data['TaskAssign']['starttime'] ?></td>
                                    <td><?php echo $data['TaskAssign']['endtime'] ?></td>
                                        <?php
                                        if ($data['TaskAssign']['tpriority'] == '0') {
                                            $per = 'uk-badge uk-badge-danger';
                                        }
                                        if ($data['TaskAssign']['tpriority'] == '1') {
                                            $per = 'uk-badge uk-badge-warning';
                                        }
                                        if ($data['TaskAssign']['tpriority'] == '2') {
                                            $per = 'uk-badge uk-badge-primary';
                                        }
                                        if ($data['TaskAssign']['tpriority'] == '3') {
                                            $per = 'uk-badge uk-badge-success';
                                        }
                                        ?> 
                                    <td ><a href="" class="<?php echo $per; ?>" ><?php
                                                $new = $data['TaskAssign']['tpriority'];
                                                echo $statusnew[$new];
                                        ?> </a></td>
                                    <td><a href="" class="uk-badge uk-badge-primary" ><?php $newstatus = $data['TaskAssign']['status'];
                                        echo $status[$newstatus];
                                        ?> </a></td>
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
                                    <td><div class="uk-progress">
                                            <div class="uk-progress-bar" style="width: <?php echo $per; ?>%;"><?php echo $per; ?>%</div>
                                        </div>
                                    </td>
                                    <td><?php
                                        if ($data['TaskAssign']['fstatus'] == 7) {
                                            echo "Approved";
                                        } else {
                                            ?>           
                                            <select id = "workstatus" onchange="return updatestatus1(this.value, '<?php echo $data['TaskAssign']['tid']; ?>');" <?php
                                            if ($data['TaskAssign']['fstatus'] == '6') {
                                                echo 'disabled';
                                            }
                                                        ?> >
                                                <option value = "0" <?php
                                            if ($data['TaskAssign']['fstatus'] == '0') {
                                                $per = 0;
                                                echo "selected = 'selected'";
                                            }
                                            ?> >New</option>
                                                <option value = "1" <?php
                                            if ($data['TaskAssign']['fstatus'] == '1') {
                                                $per = 0;
                                                echo "selected = 'selected'";
                                            }
                                            ?>>Start</option>

                                                <option value = "2" <?php
                                            if ($data['TaskAssign']['fstatus'] == '2') {
                                                $per = 10;
                                                echo "selected = 'selected'";
                                            }
                                            ?>>Done 10-20%</option>

                                                <option value = "3" <?php
                                            if ($data['TaskAssign']['fstatus'] == '3') {
                                                $per = 30;
                                                echo "selected = 'selected'";
                                            }
                                            ?>>Done 30-40%</option>

                                                <option value = "4" <?php
                                       if ($data['TaskAssign']['fstatus'] == '4') {
                                           $per = 50;
                                           echo "selected = 'selected'";
                                       }
                                            ?>>Done 50-60%</option>

                                                <option value = "5" <?php
                                            if ($data['TaskAssign']['fstatus'] == '5') {
                                                $per = 80;
                                                echo "selected = 'selected'";
                                            }
                                            ?>>Done 70-80%</option>

                                                <option value = "6" <?php
                                    if ($data['TaskAssign']['fstatus'] == '6') {
                                        $per = 100;
                                        echo "selected = 'selected'";
                                        echo ' ';
                                        echo "disabled = 'disabled'";
                                    }
                                            ?>>Complete</option>

                                            </select></td>

                                        <?php } ?>           
                                    <td><a href="#popup1" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-primary"
                                           onclick="Get_Details('<?php echo $data['TaskAssign']['tid'] ?>')" class="view vtip" title="Click to View.">View</a></td>

                                    <td>
                                        <?php
                                        if ($data['TaskAssign']['fstatus'] == '7') {
                                            echo "--N/A--";
                                        } else {
                                            ?>
                                               <?php if ($data['Alert']['statusid'] == 3 AND $data['Alert']['emp_reply'] != "") { ?>

                                                <a href="#popup6" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-primary"
                                                   onclick="Get_Details6('<?php echo $data['TaskAssign']['tid'] ?>')" title="Click to show Alert Update.">Show Update</a>
                                        <?php
                                    } elseif ($data['Alert']['statusid'] == 1 AND $data['Alert']['emp_reply'] != "") {
                                        ?>
                                                <a href="#popup7" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-danger"
                                                   onclick="Get_Details7('<?php echo $data['TaskAssign']['tid'] ?>')"  title="Click to Send Alert.">Task Alert</a>

                                                  <!--<a href="sendalert/<?php //echo $data['TaskAssign']['tid']   ?>" class="btn btn-success btn-xs" title="Click to Send Alert.">Task Alert</a>-->

        <?php } elseif ($data['Alert']['statusid'] == 8) {
            ?>
                                                <a href="" disabled="disabled"  class="uk-badge uk-badge-danger" title="Alert Send Successfully.">Alert Sent</a>

        <?php } else { ?>
                                         <!--<a href="sendalert/<?php echo $data['TaskAssign']['tid'] ?>" class="btn btn-success btn-xs" title="Click to Send Alert.">Task Alert</a>-->
                                                <a href="#popup7" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-primary"
                                                   onclick="Get_Details7('<?php echo $data['TaskAssign']['tid'] ?>')" class="view" title="Click to Send Alert.">Task Alert</a>
        <?php
        }
    }
    ?>


                                    </td>
                                    <td>
    <?php
    if ($data['TaskAssign']['fstatus'] == '7') {
        echo "Edit";
    } else {
        ?>


                                            <a href="taskedit/<?php echo $data['TaskAssign']['tid'] ?>"  class="uk-badge uk-badge-success"  title="Click to Task Edit.">Edit</a><?php } ?>
    <?php
    if ($data['TaskAssign']['assignby'] == $elogin) {
        ?>
                                            <a href="taskdelete/<?php echo $data['TaskAssign']['tid'] ?>"  class="uk-badge uk-badge-danger"  title="Click to Task Delete.">Delete</a>
        <?php
    }
    ?>
                                    </td>
                                    <td>
    <?php
    if ($data['TaskAssign']['fstatus'] == '7') {
        echo "--N/A--";
    } else {
        ?>
                                            <a href="taskforward/<?php echo $data['TaskAssign']['tid'] ?>"  class="uk-badge uk-badge-sucess" class="view vtip" title="Click to Task Forward.">Task Forward</a>
    <?php } ?>
                                    </td> 
                                    <td><?php
    if ($data['Alert']['statusid'] != 8) {
        echo "No Alert";
    } else {
        ?>
                                            <a href="#popup5" data-uk-modal="{ center:true }"  class="uk-badge uk-badge-primary"
                                               onclick="Get_Details5('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="New Alert">View Alert</a>
    <?php } ?>
                                    </td>
    <?php $j++; ?>
                                </tr>
<?php } ?>

                        </tbody>
                    </table>
                    
                </div>
                <div>
                    <ul class="uk-pagination uk-pagination-right">
                    <?php
                      echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                      echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                      echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                    ?>
                    </ul>
                    </div>
            </div>
        </div>
    </div>
</div>




        <div class="uk-modal" id="popup1">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div>
                <div class="uk-modal-footer uk-text-right" >
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div> 
        <div class="uk-modal" id="popup5">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent5"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div> 
            </div>
        </div>
        <div class="uk-modal" id="popup6">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent6"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div> 
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div>
        <div class="uk-modal" id="popup7">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent7"> 
                    <div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
                </div> 

            </div>
        </div>
        <div class="uk-modal" id="popup2">
            <div class="uk-modal-dialog">
                <div><p><h3> Task Remark:    </h3></p> </div>
                <div class="HRcontent"> 
                    <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
                </div> 
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div>


    </div>
</div>
















