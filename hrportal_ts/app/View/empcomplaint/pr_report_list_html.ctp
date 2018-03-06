<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
        <div>
            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
		    <?php $desc_width=30; ?>
		    <?php $colspan=6; ?>
		    <?php  if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")=="Customers") { ?>
                    <th><?php echo $this->Paginator->sort('Customer Name', ''); ?></th>
                    <th width="20%"><?php echo $this->Paginator->sort('Project Name', ''); ?></th>
		    <?php $desc_width=17; ?>
		    <?php $colspan=8; ?>
		    <?php } }?>
                    <th width="12%"><?php echo $this->Paginator->sort('Complaint Number', 'vc_complain_no'); ?></th>
                    <th width="10%"><?php echo $this->Paginator->sort('Complaint Date', 'dt_complain_date'); ?></th>
                    <th width="10%"><?php echo $this->Paginator->sort('Logged By', 'vc_logged_by'); ?></th>
		    <th width="<?php echo $desc_width; ?>%"><?php echo $this->Paginator->sort('Description', 'vc_desc'); ?></th>
                    <th width="12%"><?php echo $this->Paginator->sort('Severity', 'vc_priority'); ?></th>
                    <th width="10%"><?php echo $this->Paginator->sort('Attended By', 'vc_emp_name'); ?></th>
                    <th width="12%"><?php echo $this->Paginator->sort('Action Taken', 'vc_priority'); ?></th>
                    <th width="10%"><?php echo $this->Paginator->sort('Close Date', 'dt_real_closure'); ?></th>
                    <th width="12%"><?php echo $this->Paginator->sort('Stage', 'vc_stage'); ?></th>
                    <th width="5%"><?php echo $this->Paginator->sort('Man Hours', 'vc_manhours'); ?></th>
                </tr>
                <?php $zebraClass = ""; ?>
                <?php if(count($data)==0) {?>
                    <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                        <td style="text-align:center;" colspan="<?php echo $colspan;?>">
                             <em>--No Records Found--</em>   
                        </td>
                    </tr>                        
                <?php }
          
		 ?>                
                <?php foreach($data as $complaint): $newstr =array(); ?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
		<?php if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")=="Customers") { ?>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Projects']['Customerdetails']['vc_customer_name']; ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Projects']['vc_project_name']; ?></td>
		<?php } } ?>
                    <td><?php echo $complaint['Empcomplaint']['vc_complain_no']; ?></td>
                    <td><?php echo str_replace("00:00:00", "", date('d-M-Y',strtotime($complaint['Empcomplaint']['dt_complain_date']))); ?></td>
                     <td><?php echo ucwords(strtolower($complaint['Empcomplaint']['vc_logged_by'])); ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Empcomplaint']['vc_desc']; ?></td>
                    <td><?php echo $complaint['Empcomplaint']['vc_priority']; ?></td>
                    <td><?php echo ucwords(strtolower($complaint['Complain_Employee']['Employees']['vc_emp_name'])); ?></td>
                   <td><?php if(!empty($complaint['Complain_Annotation']['0']['vc_remark'])){ for($xx = 0; $xx < count($complaint['Complain_Annotation']); $xx++){ $newstr[] = $complaint['Complain_Annotation'][$xx]['vc_remark'];} echo implode(" - ", $newstr);} ?></td>
                    <td><?php if($complaint['Empcomplaint']['dt_real_closure']!=""){ echo date('d-M-Y H:i:s',strtotime($complaint['Empcomplaint']['dt_real_closure']));} ?></td>
                    <td><?php echo $complaint['Empcomplaint']['vc_stage']; ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Empcomplaint']['vc_manhours']; ?></td>
                  
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

 