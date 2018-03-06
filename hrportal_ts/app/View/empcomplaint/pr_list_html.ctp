
<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
        <div class="tab-fixed">
            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
		    <?php $desc_width=57; ?>
		    <?php $colspan=6; ?>
		    <?php  if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")=="Customers") { ?>
                    <th><?php echo $this->Paginator->sort('Customer Name', ''); ?></th>
                    <th width="20%"><?php echo $this->Paginator->sort('Project Name', ''); ?></th>
		    <?php $desc_width=17; ?>
		    <?php $colspan=8; ?>
		    <?php } }?>
                    <th width="12%"><?php echo $this->Paginator->sort('Complaint Number', 'vc_complain_no'); ?></th>
                    <th width="10%"><?php echo $this->Paginator->sort('Complaint Date', 'dt_complain_date'); ?></th>
		    <th width="<?php echo $desc_width; ?>%"><?php echo $this->Paginator->sort('Description', 'vc_desc'); ?></th>
                    <th width="6%"><?php echo $this->Paginator->sort('Severity', 'vc_priority'); ?></th>
                    <th width="17%"><?php echo $this->Paginator->sort('Stage', 'vc_stage'); ?></th>
                    <th  width="9%">Action</th>
                </tr>
                <?php $zebraClass = ""; ?>
                <?php if(count($data)==0) {?>
                    <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                        <td style="text-align:center;" colspan="<?php echo $colspan;?>">
                             <em>--No Records Found--</em>   
                        </td>
                    </tr>                        
                <?php } 
		//print_r($data);
		 ?>                
                <?php foreach($data as $complaint): ?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
		<?php if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")=="Customers") { ?>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Projects']['Customerdetails']['vc_customer_name']; ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Projects']['vc_project_name']; ?></td>
		<?php } } ?>
                    <td><?php echo $complaint['Empcomplaint']['vc_complain_no']; ?></td>
                    <td><?php echo str_replace("00:00:00", "", date('d-M-Y',strtotime($complaint['Empcomplaint']['dt_complain_date']))); ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Empcomplaint']['vc_desc']; ?></td>
                    <td><?php echo $complaint['Empcomplaint']['vc_priority']; ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Empcomplaint']['vc_stage']; ?></td>
                    <td align="center">
                       <input type="hidden" name="nu_project_code" value="<?php echo $complaint['Projects']['nu_project_code']; ?>"></input>
                       <input type="hidden" name="vc_complain_no" value="<?php echo $complaint['Empcomplaint']['vc_complain_no']; ?>"></input>
                       <ul class="edit-delete-icon">
                         
                       <?php if($this->Session->check("Auth.user_type")) {if($this->Session->read("Auth.user_type")!="Customers") { ?>
                           <li><?php if (!empty($mgr)) { if($complaint['Complain_Employee']['vc_complain_no'] == "") { ?>
                           <a href="#" class="vtip assign" title="Assign" id="assign_<?php echo $complaint['Empcomplaint']['vc_complain_no']; ?>">A</a><a class="vtip" title="Assigned" id="assigned_<?php echo $complaint['Empcomplaint']['vc_complain_no']; ?>" style="display:none;">Assign</a><?php } else { ?><a class="vtip" title="Assigned">Assign</a> <?php } ?></li>
                           <li style="border-right:none;"><a href="<?php echo $this->webroot.'empcomplaint/edit/'.$complaint['Empcomplaint']['vc_complain_no'];?>" class="edit vtip" title="Edit">Edit</a></li>
                           <?php } else { ?>
                           <li style="border-right:none;"><a href="<?php echo $this->webroot.'empcomplaint/view/'.$complaint['Empcomplaint']['vc_complain_no'];?>" class="view vtip" title="View">View</a></li>
                           <?php } ?>
                         <?php } else {?>
			   <li style="border-right:none;"><a href="<?php echo $this->webroot.'empcomplaint/view/'.$complaint['Empcomplaint']['vc_complain_no'];?>" class="view vtip" title="View">View</a></li>
			 <?php } }?>
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

 