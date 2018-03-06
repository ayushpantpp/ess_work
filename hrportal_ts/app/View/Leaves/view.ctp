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
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/leavedetail/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script> 

<?php $i = 0; ?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    //echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Leave List</b>
                            </h3>
                        </div>

            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Total</th>
                                <th>Leave Type</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Medical</th>
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
                                        $btnClass = "uk-badge uk-badge-danger";
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
                                        <td><?php echo date('d-M-Y', strtotime($list['MstEmpLeave']['start_date'])); ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($list['MstEmpLeave']['end_date'])); ?></td>   
                                        <td><?php echo $list['MstEmpLeave']['total_leave']; ?></td>
                                        <td><?php echo $this->Common->findLeaveType($list['LeaveDetail']['leave_code']); ?></td>
                                        <td><?php echo $list['LeaveDetail']['leave_reason']; ?></td>
                                        <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>  
                                        <?php if (empty($list['MstEmpLeave']['leave_image']) || $list['LeaveDetail']['leave_code'] != 'PAR0000527') { ?>
                                            <td>N/A</td>
                                        <?php } else { ?> <td><a href="<?php echo $this->webroot . $list['MstEmpLeave']['leave_image']; ?>" target = 'blank'>Download</a></td> <?php } ?>
                                        <td>
                                            <!-- <ul class="edit-delete-icon"> -->
                                            <!-- <li style="border-right:none;"> -->
                                            <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $list['MstEmpLeave']['leave_id']; ?>')" class="uk-badge uk-badge-success" title="Click to View." >View</a>
                                            
                                            <!-- </li> -->
                                            <?php $status = $this->Common->findSatus($list['LeaveDetail']['leave_status']); 
                                           
                                            ?>

                                            <?php if ($status == 'Parked' || $status == 'Rejected') { ?>
                                                <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>leaves/editSubmit/<?php echo base64_encode($list['LeaveDetail']['leave_id']); ?>/" title="Click to Edit.">Edit</a>

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
               

            </div>

            <div id="container" ></div>
        </div>

       <script type="text/javascript">
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>leaves/view/"+val; 


 }
 </script>