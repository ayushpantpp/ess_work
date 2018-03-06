

<div class="travel-voucher1">
    <div class="input-boxs-timesheet">
        <div>
            <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
		    <?php $desc_width=35; ?>
		    <?php $colspan=6; ?>
		            <th width="15%">Customer Name</th>
                    <th width="15%">Complaint Number</th>
                    <th width="15%">Complaint Date and Time</th>
                    <th width="15%">Posted By</th>
					<th width="15%">Email</th>
		             <th width="">Description</th>
					  <th width="10%">Action Taken</th>
					  <th width="15%">Attended By</th>
					  <th width="10%">Assigned On</th>
                    <th width="10%">Severity</th>
					<th width="10%">Stage</th>
                    <th width="15%">Closure Date and time</th>
                    <th width="10%">Man Hours</th>
    
                </tr>
                <?php $zebraClass = ""; ?>
                <?php if(count($data)==0) {?>
                    <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                        <td style="text-align:center;" colspan="5">
                             <em>--No Records Found--</em>   
                        </td>
                    </tr>                        
                <?php }
		 ?>                
                <?php foreach($data as $complaint): $newstr =array();?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
		            <td><?php echo ucwords(strtolower($complaint['Empcomplaint']['vc_logged_by'])); ?></td>
                    <td><?php echo $complaint['Empcomplaint']['vc_complain_no']; ?></td>
                    <td><?php echo str_replace("00:00:00", "", date('d-M-Y H:I:S',strtotime($complaint['Empcomplaint']['dt_complain_date']))); ?></td>
                    <td><?php echo ucwords(strtolower($complaint['Empcomplaint']['vc_logged_by'])); ?></td>
					<td><?php echo $complaint['Empcomplaint']['vc_email']; ?></td>
					<td><?php echo $complaint['Empcomplaint']['vc_desc']; ?></td>
					<td><?php if(!empty($complaint['Complain_Annotation']['0']['vc_remark'])){ for($xx = 0; $xx < count($complaint['Complain_Annotation']); $xx++){ $newstr[] = $complaint['Complain_Annotation'][$xx]['vc_remark'];} echo implode(" - ", $newstr);} ?></td>
                    <td><?php 
					if(isset($complaint['Complain_Employee']['Employees']['vc_emp_name']))
					{
					echo ucwords(strtolower($complaint['Complain_Employee']['Employees']['vc_emp_name']));
					}else{
					echo "N.A";
					}
					?></td>
					<td><?php if(isset($complaint['Complain_Employee']['dt_created'])){
					echo date('d-M-Y H:i:s',strtotime($complaint['Complain_Employee']['dt_created'])); 
					}else{
					echo 'N.A';}?></td>
					<td><?php echo $complaint['Empcomplaint']['vc_priority']; ?></td>
                    <td style="overflow: hidden;white-space: nowrap;"><?php echo $complaint['Empcomplaint']['vc_stage']; ?></td>
                    <td><?php if($complaint['Empcomplaint']['dt_real_closure']!=""){ echo date('d-M-Y H:i:s',strtotime($complaint['Empcomplaint']['dt_real_closure']));} ?></td>
                    <td align="left"><?php echo $complaint['Empcomplaint']['vc_manhours']; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
                
        </div>
    </div>
</div>

 