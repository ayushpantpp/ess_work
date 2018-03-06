<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/approvedleaves/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#leaveResponse').html(data);
            }
        });
    }
    function Get_Previous(startdate, enddate, emp_code)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>leaves/appliedleave/' + startdate + '/' + enddate + '/' + emp_code,
            success: function (data) {
                //alert(data);
                jQuery('#leaveResponse').html(data);
            }
        });
    }

</script>    

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="leaveResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Approval</h3>

        <span class="momStatus"></span>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <?php
                    echo $this->form->create('LeaveWorkflow', array(
                        'url' => 'leavewf',
                        'name' => 'leaveapprove',
                        'inputDefaults' => array(
                            'label' => false,
                            'div' => false,
                            'error' => array(
                                'wrap' => 'span',
                                'class' => 'my-error-class'
                            )
                        )
                            )
                    );
                    $leavelist = $leave_name;
                    ?>
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Total Leave</th>
                                <th>Apply Date</th>          
                                <th>Leave Reason</th>
                                <th>Leave Type</th>
                                <th>All Approved leaves</th>
                                <th>All Applied Leaves Till Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $this->Common->getempinfo($empleavedetail[0]['LeaveDetail']['emp_code']); ?></td>
                                <td><?php echo $empleavedetail[0]['MstEmpLeave']['total_leave'] ?></td>
                                <td><?php echo date('d-M-Y', strtotime($empleavedetail[0]['MstEmpLeave']['applied_date'])); ?></td>
                                <td><?php echo $empleavedetail[0]['LeaveDetail']['leave_reason']; ?></td>
                                <td><?php echo $this->Common->findLeaveType($empleavedetail[0]['LeaveDetail']['leave_code']); ?></td>
                                <td><a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-primary" class="view vtip" onclick ="Get_Details('<?php echo $empleavedetail[0]['LeaveDetail']['emp_code'] ?>')" title="Click to View.">View</a></td>
                                <td><a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-success" class="view vtip" onclick ="Get_Previous('<?php echo date('d-M-Y', strtotime($empleavedetail[0]['MstEmpLeave']['start_date'])) ?>', '<?php echo date('d-M-Y', strtotime($empleavedetail[0]['MstEmpLeave']['end_date'])) ?>', '<?php echo $empleavedetail[0]['LeaveDetail']['emp_code'] ?>')" title="Click to View.">View Applied Date</a></td>
                        <input type="hidden" name="LeaveWorkflow[leave_type_id]" value="<?php echo $empleavedetail[0]['LeaveDetail']['leave_code']; ?>" class="emp_leave_type_<?php echo $dt['LeaveDetail']['leave_detail_id']; ?> emp_leave_type">
                        </tr>

                        </tbody>

                    </table>
                    <div class="submit-form" id="leavetype">
                      <!--<input type="button" value="Change all Leaves" onClick="Changeleavetype()" class="btn btn-primary btn-xs" >-->
                    </div>
                

                <div class="x_content">

                    <table style="display:none;" class="table table-striped responsive-utilities jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                                <th>Leave Date</th>
                                <th>Leave Length</th>
                                <th >Type</th>
                                <th colspan="">Leave Action</th>
                                <th id="changeleave"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empleavedetail as $dt) { ?>
                                <tr>
                                    <td><?php echo date('d-M-Y', strtotime($dt['LeaveDetail']['leave_date'])); ?></td>
                                    <td id="lvlength_<?php echo $dt['LeaveDetail']['leave_detail_id'] ?>" class="<?php echo $dt['LeaveDetail']['hlfday_leave_chk'] ?>">
                                        <?php echo ($dt['LeaveDetail']['hlfday_leave_chk'] == 'N') ? 'Full Day' : 'Half Day' ?>

                                    </td>
                                    <td>
                                        <?php
                                        echo $this->form->Input('leave_type', array(
                                            'options' => $leavelist,
                                            'default' => $dt['LeaveDetail']['leave_code'],
                                            'label' => false,
                                            'empty' => false,
                                            'id' => 'lstatus_' . $dt['LeaveDetail']['leave_detail_id'],
                                            'onchange' => 'changeTypeVal(' . $dt['LeaveDetail']['leave_detail_id'] . ',"' . $dt['LeaveDetail']['leave_code'] . '")',
                                            'class' => ' form-control s-form-item s-form-all round_select lstatus_' . $dt['LeaveDetail']['leave_detail_id']));
                                        ?>

                                        <input type="hidden" name="LeaveWorkflow[leave_type]" value="<?php echo $dt['LeaveDetail']['leave_code']; ?>" class="emp_leave_type_<?php echo $dt['LeaveDetail']['leave_detail_id']; ?> emp_leave_type">
                                        <input type="hidden" name="LeaveWorkflow[leave_count][]" value="<?php echo $dt['LeaveDetail']['leave_detail_id']; ?>" class="leave_count">   
                                    </td>
                                    <td>
                                        <?php /* echo $this->form->Input('leave_action[]' , array(
                                          'options'=>array('--Select--','First Half','Second Half','Not Approved'),
                                          'default'=>$dt['LeaveDetail']['leave_action'],
                                          'label'=>false,
                                          'empty'=>false,
                                          'class'=>' form-control s-form-item s-form-all ')); */ ?>
                                        <select name="data[LeaveWorkflow][leave_action][]'" class=" form-control s-form-item s-form-all ">
                                            <option value="1::<?php echo $dt['LeaveDetail']['leave_detail_id'] ?>" <?php
                                            if ($dt['LeaveDetail']['leave_action'] == 1) {
                                                echo 'selected = "selected"';
                                            }
                                            ?>>Approve</option>
                                            <option value="2::<?php echo $dt['LeaveDetail']['leave_detail_id'] ?>" <?php
                                                    if ($dt['LeaveDetail']['leave_action'] == 2) {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>First Half</option>
                                            <option value="3::<?php echo $dt['LeaveDetail']['leave_detail_id'] ?>" <?php
                                            if ($dt['LeaveDetail']['leave_action'] == 3) {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Second Half</option>
                                            <option value="4::<?php echo $dt['LeaveDetail']['leave_detail_id'] ?>" <?php
                                            if ($dt['LeaveDetail']['leave_action'] == 4) {
                                                echo 'selected="selected"';
                                            }
                                            ?>>Not Approved</option>

                                        </select>

                                    </td>
                                    <td colspan="2">
                                        <span id="showltype" style="display:none">
    <?php echo $this->form->Input('leave_type', array('options' => $leavelist, 'default' => $dt['LeaveDetail']['leave_code'], 'label' => false, 'empty' => false, 'id' => 'lstatus', 'onchange' => 'changeAllLvType()', 'class' => 'form-control s-form-item s-form-all round_select')); ?>
                                        </span>
                                    </td>

                                </tr>
<?php } ?>


                        </tbody>

                    </table>


                </div>
                

                <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="">
                    <thead>
                        <tr class="headings">
                            <th></th>
                            <th>Total Leaves</th>
                            <th>Balance Leaves</th>                        
                            <th>Applied Leaves</th>
                            <th>Pending Leaves</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($leaveType as $type) {
                            ?>  
                            <?php
                            if ($i % 2 == 0)
                                $class = "cont1";
                            else
                                $class = "cont";
                            $bal = $type['MstEmpLeaveAllot']['leave_bal'];
                            $total = $type['MstEmpLeaveAllot']['allot_leave'];
                            $applied = $this->Common->countAppliedLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']);
                            ?>
                            <tr class="<?php echo $class; ?>">
                                <th ><?php echo $type['type']['name']; ?></th>
                                <th><?php echo $total; ?></th>
                                <td id="bal_leave_<?php echo $type['type']['id'] ?>"><?php echo $bal; ?></td>
                                <td><?php echo $applied; ?></td>
                                <td id="pending_leave_<?php echo $type['type']['id'] ?>">
<?php echo $this->Common->countPendingLeave($type['MstEmpLeaveAllot']['emp_code'], $type['type']['id']); ?> </td></tr>
<?php
$i++;
}
?>
                    </tbody>
                </table>
                    
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <input type="submit" value="Proceed" class="md-btn md-btn-success">
                    </div>

                </div>
                <br><br>
                    <input type="hidden" name="LeaveWorkflow[leave_id]" value="<?php echo $empleavedetail[0]['LeaveDetail']['leave_id']; ?>">                   
                    <input type="hidden" name="LeaveWorkflow[total_leave]" value="<?php echo $empleavedetail[0]['MstEmpLeave']['total_leave'] ?>" id="hdn_tot_leave">
<?php echo $this->form->end(); ?>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    function Changeleavetype()
    {
        jQuery('#leavetype').hide();
        jQuery('#showltype').show();
        $('#changeleave').html('Change All Leave')
        jQuery('#ch').hide();
        jQuery('#cl').show();
    }
    function setdefault()
    {
        jQuery('#showltype').hide();
        jQuery('#ch').show();
        jQuery('#leavetype').show()
        jQuery('#cl').hide();
    }
    function changeTypeVal(id, tycode)
    {
        var val = jQuery('.lstatus_' + id).val();
        jQuery('.emp_leave_type_' + id).val(tycode);
        jQuery('.emp_leave_type_' + id).val(val);
    }
    function changeAllLvType()
    {
        var val = jQuery("#lstatus").val();
        jQuery(".round_select").val(val);
        jQuery('.emp_leave_type').val(val);
    }


    function CheckLeaveCount()
    {
        var tmpleave = new Array();

        var x = document.getElementsByClassName("leave_count");
        for (i = 0; i < x.length; i++)
        {
            var lvlength = jQuery("#lvlength_" + x[i].value).attr('class');
            var lvtype = jQuery("#lstatus_" + x[i].value).val();
            var bllvval = jQuery('#bal_leave_' + lvtype).html();
            var pendlvval = jQuery('#pending_leave_' + lvtype).html();
            if (!(lvtype in tmpleave))
                tmpleave[lvtype] = 1;
            else
                tmpleave[lvtype] = tmpleave[lvtype] + 1;
            if (lvlength === 'Y')
                tmpleave[lvtype] = tmpleave[lvtype] - 0.5;
            if (parseInt(tmpleave[lvtype]) > (parseInt(bllvval) - parseInt(pendlvval)))
            {
                //if(confirm('Balance leave less than leave assignment. Continue anyway?.'))
                //  return true;
                //else
                alert('Balance leave less than Leave Assigned.');
                //return false;
            }
        }
    }
</script>