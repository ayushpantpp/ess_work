<div class="travel-voucher1">
        <div class="input-boxs-timesheet">
                <div class="tab-fixed">
                        <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                                <tr class="head">
                                        <th scope="row" width="10%">Employee ID<?php //echo $this->Paginator->sort('', 'vc_emp_code'); ?></th>
                                        <th width="35%">Employee Name<?php //echo $this->Paginator->sort('vc_emp_name', 'Employee Name'); ?></th>
                                        
                                        <th  width="12%">Action</th>
                                </tr>
                                <?php $zebraClass = ""; ?>
                                <?php foreach ($data as $employee): ?>
                                        <tr class="<?php echo $zebraClass = ($zebraClass == "cont") ? "cont1" : "cont"; ?>">
                                                <td><?php echo $employee['UserDetail']['emp_code'] . " :" . $employee['UserDetail']['emp_code']; ?></td>
                                                <td><?php echo $employee[0]['emp_name']; ?></td>
                                                <td>
                                                        <ul class="edit-delete-icon">
                                                                <li style="border:none;"><a href="#<?php echo $employee['UserDetail']['emp_code'] ?>" id="employee_<?php echo $employee['UserDetail']['emp_code'] ?>" class="edit vtip" title="Edit"></a></li>
                                                        </ul>
                                                        <ul class="edit-delete-icon">
                                                                <li style="border:none;"><a href="#<?php echo $employee['UserDetail']['emp_code'] ?>" id="delete_employee_<?php echo $employee['UserDetail']['emp_code'] ?>" class="delete vtip" title="Delete"></a></li>
                                                        </ul>
                                                        <ul class="edit-delete-icon">
                                                                <li style="border:none;"><a href="#<?php echo $employee['UserDetail']['emp_code'] ?>" id="reset_employee_<?php echo $employee['UserDetail']['emp_code'] ?>" class="shuffle vtip" title="Reset Password"></a></li>
                                                        </ul>
                                                </td>
                                        </tr>
                                <?php endforeach; ?>
                        </table>
                        <div class="navigation">
                                <?php echo $this->Paginator->counter(); ?> Pages
                                <?php echo $this->Paginator->options(array('url' => $this->passedArgs)); ?>
                                <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
                                <?php echo $this->Paginator->numbers(); ?>
                                <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                        </div>            
                </div>
        </div>
</div>
<script>

</script>
