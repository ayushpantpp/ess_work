<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave List</h3>

        <span class="momStatus"></span>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">   
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>
                                <th>Name</th>
                                <th>Applied Date</th>
                                <th>Start Date</th>
                                <th>End Date</th>                                    
                                <th>Medical Certificate</th>
                                <th class="filter-false remove sorter-false">Update Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $auth = $this->Session->read('Auth'); ?>

                            <?php if (count($pending_leave_employee) == 0) { ?>
                                <tr class="cont">
                                    <td style="text-align:center;" colspan="8">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            $i = 1;
                            //print_r($pending_leave_employee);
                            //pr($this->params['paging']);
                            foreach ($pending_leave_employee as $pending_detail) {
                                $empname = $this->Common->getempinfo($pending_detail['LeaveDetail']['emp_code']);
                                @$ctr = (($this->params['paging']['LeaveDetail']['options']['page'] * $this->params['paging']['LeaveDetail']['options']['limit']) - $this->params['paging']['LeaveDetail']['options']['limit']) + $i;
                                ?>
                                <tr>
                                    <td><?php echo $ctr; ?></td>
                                    <td><?php echo $empname; ?></td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['applied_date'])); ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['start_date'])); ?>
                                    </td>
                                    <td><?php echo date("d-m-Y", strtotime($pending_detail['MstEmpLeave']['end_date'])); ?>
                                    </td>
                                        <?php if (empty($pending_detail['MstEmpLeave']['leave_image']) && $pending_detail['LeaveDetail']['leave_code'] != 'PAR0000527') { ?>
                                        <td>N/A</td>
                                        <?php } else { ?> <td><a href="<?php echo $this->webroot . $pending_detail['MstEmpLeave']['leave_image']; ?>" target = 'blank'>Download</a></td> <?php } ?>
                                    <td>
                                        <?php
                                        if ($pending_detail['LeaveWorkflow']['status'] == '4') {
                                            echo "<span class='uk-badge uk-badge-danger'>".$this->Common->findSatus(4)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] != null && $pending_detail['LeaveDetail']['leave_status'] == '6') {
                                            echo "<span class='uk-badge uk-badge-danger'>".$this->Common->findSatus(6)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['status'] == '5') {
                                            echo "<span class='uk-badge uk-badge-success'>".$this->Common->findSatus(5)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] == null && $pending_detail['LeaveWorkflow']['status'] == '3') {
                                            echo "<span class='uk-badge uk-badge-primary'>".$this->Common->findSatus(3)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] != null && $pending_detail['LeaveDetail']['leave_status'] == '2') {
                                            echo "<span class='uk-badge uk-badge-primary'>".$this->Common->findSatus(2)."</span>";
                                        } else if ($pending_detail['LeaveWorkflow']['fw_date'] == null && $pending_detail['LeaveDetail']['leave_status'] != '5') {
                                            ?>
                                            <!-- <ul class="edit-delete-icon">
                                                <li> -->
                                            <a class="uk-badge uk-badge-warning" href="<?php
                                            echo $this->webroot . 'leaves/editleave/'
                                            . base64_encode($pending_detail['MstEmpLeave']['comp_code'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['leave_id'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['emp_code'])
                                            ;
                                            ?>"  Title="Process Leave">Approve/Reject</a>
                                            <!-- </li> -->
                                            <!-- <li style="border:none;">
                                                <a href="<?php
                                            echo $this->webroot . 'leaves/editleave/'
                                            . base64_encode($pending_detail['MstEmpLeave']['comp_code'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['leave_id'])
                                            . '/' . base64_encode($pending_detail['MstEmpLeave']['emp_code'])
                                            ?>" id="dialog_link" class="icon-thumbs-down" title="Reject" >

                                                </a>
                                            </li> -->
                                            <!-- </ul> -->
    <?php } ?>

                                    </td>

                                </tr>
    <?php $i++;
} ?>

                        </tbody>

                        <div id="dialog" title="Remark/Comment" style="display:none">
                            <div>
                                <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 600px; height:200px;" onKeypress="getcmtval()" > </textarea>
                                <div class="ui-widget" id="errdis" style="display:none">
                                    <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
                                        <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                                            <strong></strong> Please write rejection reason.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="wf_id" name="wf_id" value=''/>
                        <input type="hidden" id="leaveno" name="leave_no" value=""/>
                        <input type="hidden" id="ccode" name="comp_code" value=""/>
                        <input type="hidden" id="stdate" name="start_date" value=""/>
                        <input type="hidden" id="eddate" name="end_date" value=""/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>