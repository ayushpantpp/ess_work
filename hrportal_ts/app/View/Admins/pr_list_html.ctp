<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
        <div class="tab-fixed">
            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
                    <th scope="row" width="5%"><?php echo $this->form->checkbox('selectall',array('value'=>'selectall','hiddenField' => false)); ?></th>
                    <th scope="row" width="10%">Employee ID<?php //echo $this->Paginator->sort('Employee ID', 'vc_emp_code'); ?></th>
                    <th width="35%">Employee Name<?php //echo $this->Paginator->sort('Employee Name', 'vc_emp_name'); ?></th>
                    <th  width="5%">Action</th>
                </tr>
                <?php $zebraClass = "";?>
                <?php foreach($data as $employee): ?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                    <td><?php echo $this->form->checkbox('select',array('value'=>$employee['UserDetail']['emp_code'], 'hiddenField' => false)); ?></td>
                    <td><?php echo $employee['UserDetail']['emp_code']; ?></td>
                    <td><?php echo $employee[0]['emp_name']; ?></td>
                    <td>
                       <ul class="edit-delete-icon">
                         <li style="border:none;"><a href="#" id="<?php echo $employee['UserDetail']['emp_code'] ?>" class="assign vtip" title="Assign"></a></li>
                       </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <div class="navigation">
            <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->options(array('url'=>$this->passedArgs)); ?>
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
            </div>            
        </div>
    </div>
</div>

 
