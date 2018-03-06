<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="overflow container"></span>
            </div>          
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        $('#alerts').hide;

    });
    function Get_Details(id,emp_code)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/leavedetail/' + id + '/' + emp_code,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script> 

<?php $i = 0; ?>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Leave Form</h1>
    </div>
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Employee Name</th>
                                <th>Applied Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total Leave</th>
                                <th>Leave Type</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Comment</th>
                                <th>Medical Certificate</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $auth = $this->Session->read('Auth');
                            $i = 1;
                            if (!empty($leavelist)) {
                                foreach ($leavelist as $list) {
                                    if ($list['LeaveDetail']['status'] == 1) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    } elseif ($list['LeaveDetail']['leave_status'] == 2) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    } elseif ($list['LeaveDetail']['leave_status'] == 3) {
                                        $btnClass = "uk-badge uk-badge-warning";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    } elseif ($list['LeaveDetail']['leave_status'] == 4) {
                                        $btnClass = "uk-badge uk-badge-primary";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    } elseif ($list['LeaveDetail']['leave_status'] == 5) {
                                        $btnClass = "uk-badge uk-badge-success";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    } else {
                                        $btnClass = "uk-badge uk-badge-danger";
                                        $btnStatus = $this->Common->findSatus($list['LeaveDetail']['leave_status']);
                                    }
                                    ?>    
                                    <tr> 
                                        <td><?php echo $i; ?></td>
                                        
                                        <td><?php echo $this->Common->getempname($list['MstEmpLeave']['emp_code']); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['MstEmpLeave']['applied_date'])); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['MstEmpLeave']['start_date'])); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['MstEmpLeave']['end_date'])); ?></td>   
                                        <td><?php echo $list['MstEmpLeave']['total_leave']; ?></td>
                                        <td><?php echo $this->Common->findLeaveType($list['LeaveDetail']['leave_code']); ?></td>
                                        <td><?php echo $list['LeaveDetail']['leave_reason']; ?></td>
                                        <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>  
                                        <td><?php echo $list['LeaveDetail']['remark'] ?></td>
                                        <?php if (empty($list['MstEmpLeave']['leave_image']) || $list['LeaveDetail']['leave_code'] != 'PAR0000527') { ?>
                                            <td>N/A</td>
                                        <?php } else { ?> <td><a href="<?php echo $this->webroot . $list['MstEmpLeave']['leave_image']; ?>" target = 'blank'>Download</a></td> <?php } ?>
                                        <td>
                                            <!-- <ul class="edit-delete-icon"> -->
                                            <!-- <li style="border-right:none;"> -->
                                            <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $list['MstEmpLeave']['leave_id']; ?>','<?php echo $list['MstEmpLeave']['emp_code']; ?>')" class="uk-badge uk-badge-success" title="Click to View." >View</a>
                                            
                                            <!-- </li> -->
                                            <?php $status = $this->Common->findSatus($list['LeaveDetail']['leave_status']); 
                                           
                                            ?>

                                            <?php if ($status == 'Parked' || $status == 'Rejected') { ?>
                                                <a class="uk-badge uk-badge-success" href="<?php echo $this->webroot; ?>leaves/editSubmit/<?php echo base64_encode($list['LeaveDetail']['leave_id']); ?>/" title="Click to Edit.">Edit</a>

                                            <?php } ?>

                                            <?php if ($status == 'Parked' || $status == 'Posted') { ?>
                                                <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>leaves/deleteLeaveDetails/<?php echo base64_encode($list['LeaveDetail']['leave_id']); ?>/" title="Click to Edit." onclick="return confirm('Are you sure?')" >Delete</a>    
                                                <?php
                                            }
                                            if (!empty($leave_level_sequence[$i - 1]) && $status != 'Rejected'):
                                                if ($leave_level_sequence[$i - 1]['WfDtAppMapLvl']['lvl_sequence'] <= $max_level_sequence && $leave_level_sequence[$i - 1] != null) :
                                                    ?>
                                                    <!-- <li style="border-right:none;"> -->
                                                    <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>leaves/revoke/<?php echo base64_encode($list['LeaveDetail']['leave_id']); ?>/" title="Click to Revoke.">Revoke</a>
                                                    <!-- </li> -->
                                                    <?php
                                                endif;
                                            endif;
                                            ?>

                                            <!-- </ul> -->
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            else {
                                ?>

                                <tr>
                                    <td colspan="12">
                                        No records found
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 

                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
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

            <div id="container" ></div>
        </div>

