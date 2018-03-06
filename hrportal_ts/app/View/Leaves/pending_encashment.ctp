<?php
$i = 0;$p=1; ?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Leave Encashment Approval</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content  margin-bottom">
                <?php  echo $this->form->create('Leaves', array('url' => '', 'name' => 'Form1', 'action' => 'filter_encashment', 'inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));s  ?>
                <div data-uk-grid-margin="" class="uk-grid">
                    <div class="uk-width-medium-1-8 uk-row-first">
                        <label><h4>Filters</h4></label>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <?php echo $this->form->input('month', array('label' => false, 'type' => 'select', 'options' => $months, 'value' => $current_month, 'class' => "md-input", 'required' => true, 'id' => 'first_name',"data-md-selectize")); ?>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <?php echo $this->form->input('year', array('label' => false, 'type' => 'select', 'options' => $years, 'value' => $current_year, 'class' => "md-input","data-md-selectize", 'required' => true)); ?>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <?php echo $this->form->input('status', array('label' => false, 'type' => 'select', 'options' => $status, 'value' => $current_status, 'class' => "md-input", 'required' => true,"data-md-selectize")); ?>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <input type="submit" class="md-btn md-btn-success" value="GO" name='post_Salary'>
                        <input type="submit" class="md-btn md-btn-primary" value="EXPORT" name='post_Salary'>
                    </div>
                </div>  
                </form>
                <hr class="uk-grid-divider margin-bottom">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>

                                <th scope="row">Sr.No</th>
                                <th>Employee Name</th>
                                <th>Company Name</th>
                                <th>Department</th>
                                <th>Encash Leave</th>
                                <th>Leave Opening Balance</th>
                                <th>Leave Avail</th>
                                <th>Leave Balance </th>
                                <th> Created At</th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($pending_encsh_dt)) { ?>
                            <tr class="even-pointer">
                                <td style="text-align:center;" colspan="11">
                                    <em>--No Records Found--</em>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php foreach ($pending_encsh_dt as $ench) {
                                if ($i % 2 == 0)
                                    $class = 'even-pointer';
                                else
                                    $class = 'odd-pointer';
                                ?>
                            <tr calss = $class>
                                <td><?php echo $ctr = (($this->params['paging']['LeaveEncshDt']['page']*$this->params['paging']['LeaveEncshDt']['limit'])-$this->params['paging']['LeaveEncshDt']['limit'])+$p;?></td> 
                                <td><?php echo $this->Common->getempinfo($ench['LeaveEncsh']['emp_code']); ?></td>
                                <td><?php $comp_name = $this->Common->findCompanyNameByCode($ench['LeaveEncsh']['comp_code']);
                                echo $comp_name; ?></td>
                                <td><?php $dept_name = $this->Common->getdepartmentbyid($ench['LeaveEncsh']['dept_code']);
                                echo $dept_name; ?></td>
                                <td><?php echo $this->Common->findLeaveType($ench['LeaveEncshDt']['leave_id']); ?></td>
                                <td><?php echo $ench['LeaveEncshDt']['leave_op']; ?></td>
                                <td><?php echo $ench['LeaveEncshDt']['leave_avail']; ?></td>
                                <td><?php echo $ench['LeaveEncshDt']['leave_bal']; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($ench['LeaveEncshDt']['created_at'])); ?></td>
                                <td>
                                        <?php
                                        if ($ench['LeaveEncshDt']['leaveencash_status'] == 4) {
                                            echo $this->Common->findSatus(4);
                                        } else if ($ench['LeaveEncshWorkflow']['fw_date'] != null && $ench['LeaveEncshWorkflow']['encash_status'] == 6) {
                                            echo $this->Common->findSatus(6);
                                        } else if ($ench['LeaveEncshDt']['leaveencash_status'] == 5) {
                                            echo $this->Common->findSatus(5);
                                        } else if ($ench['LeaveEncshWorkflow']['fw_date'] != null && $ench['LeaveEncshDt']['leaveencash_status'] == 2) {
                                            echo $this->Common->findSatus(2);
                                        } else if ($ench['LeaveEncshWorkflow']['fw_date'] == null && $ench['LeaveEncshDt']['leaveencash_status'] != 5) {
                                            ?>
                                    <!--<ul class="edit-delete-icon">
                                        <li> -->
                                    <a href="<?php
                                            echo $this->webroot . 'leaves/leaveEncshWf/'
                                            . '/' . base64_encode($ench['LeaveEncshDt']['leave_encsh_id'])
                                            . '/' . base64_encode($ench['LeaveEncshDt']['emp_code'])
                                            ;
                                            ?>" Title="Process Leave">Approve/Reject</a>
                                    <!--</li>-->
                                    <!-- <li style="border:none;">
                                        <a href="<?php
                                            echo $this->webroot . 'leaves/leaveEncshWf/'
                                            . '/' . base64_encode($ench['LeaveEncshDt']['leave_encsh_id'])
                                            . '/' . base64_encode($ench['LeaveEncshDt']['emp_code'])
                                            ?>" id="dialog_link" class="icon-thumbs-down" title="Reject" >

                                        </a>
                                    </li> -->
                                    <!--</ul>-->
                                        <?php } ?>

                                </td>
                            </tr>
                                <?php $i++;$p++;
                            } ?>
                        </tbody>
                    </table>
                </div>

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


        </div>

    </div>
</div>

