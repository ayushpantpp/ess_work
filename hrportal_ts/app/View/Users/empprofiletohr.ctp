<?php
//pr($attach_temp_val);
?>
<form action="" method="post" name="hr_emp_form" id="hr_emp_form" enctype="multipart/form-data">
<a href="javascript:void(0)" id="hr_per_save" onclick="return hrEmpProfileSave();">Save</a>
	<fieldset>
		<legend>Official Detail</legend>
		<table>
			<tr><td>Emp Name </td><td><?php if(!empty($user_val['MyProfile']['emp_nm'])) echo $user_val['MyProfile']['emp_nm'] ?></td></tr>
			<tr><td>Emp Id </td><td><?php if(!empty($user_val['MyProfile']['emp_id'])) echo $user_val['MyProfile']['emp_id'] ?></td></tr>
			<tr><td>Card Number </td><td><?php if(!empty($user_val['MyProfile']['emp_card_no'])) echo $user_val['MyProfile']['emp_card_no'] ?></td></tr>
			<tr><td>Department </td><td><?php if(!empty($user_val['MyProfile']['emp_dept_id'])) echo $dept_val['MyProfiledept']['dept_nm'] ?></td></tr>
			<tr><td>Designation </td><td><?php if(!empty($user_val['MyProfile']['emp_desg_id'])) echo $this->Userdetail->findSetup($user_val['MyProfile']['emp_desg_id'], $user_val['MyProfile']['ho_org_id']) ?></td></tr>
			<tr><td>Date of Birth </td><td><?php if(!empty($user_val['MyProfile']['emp_dob'])) echo date('d-m-Y',strtotime($user_val['MyProfile']['emp_dob'])) ?></td></tr>
			<tr><td>Date of Joining </td><td><?php if(!empty($user_val['MyProfile']['emp_doj'])) echo date('d-m-Y',strtotime($user_val['MyProfile']['emp_doj'])) ?></td></tr>
			<tr><td>Matrial Status </td><td><?php if(!empty($user_val['MyProfile']['emp_mrtl_stat'])) echo '<label id="div_emp_mrtl_stat_old">'.$this->UserDetail->findDetailType($user_val['MyProfile']['emp_mrtl_stat']).'</label>' ?>
			
			<?php if(!empty($temp_val['UserTempdata']['emp_mrtl_stat'])) { echo'<label id="" class="label_left">'.$this->UserDetail->findDetailType($temp_val['UserTempdata']['emp_mrtl_stat']).'</label><input type="checkbox" name="checkbox_emp_mrtl_stat" value="1" class="label_left">'; } ?>

			</td></tr>
			<tr><td>Sponsor Name </td><td><?php if(!empty($user_val['MyProfile']['spon_nm'])) echo $user_val['MyProfile']['spon_nm'] ?></td></tr>
			<tr><td>Entity Name </td><td><?php if(!empty($user_val['MyProfile']['emp_eo_nm'])) echo $user_val['MyProfile']['emp_eo_nm'] ?></td></tr>
			<tr><td>Location </td><td><?php if(!empty($user_val['MyProfile']['emp_loc_id'])) echo $this->Userdetail->findSetup($user_val['MyProfile']['emp_loc_id'], $user_val['MyProfile']['ho_org_id']) ?></td></tr>
			<tr><td>Gender </td><td><?php if(!empty($user_val['MyProfile']['emp_gen'])) echo $this->Userdetail->findSetup($user_val['MyProfile']['emp_gen'], $user_val['MyProfile']['ho_org_id']); ?></td></tr>
			
			<tr><td>Group Detail </td><td><?php if(!empty($user_val['MyProfile']['emp_grp_id'])) echo $this->Userdetail->findSetup($user_val['MyProfile']['emp_grp_id'], $user_val['MyProfile']['ho_org_id']) ?></td></tr>
			<tr><td>Pan Card No. </td><td><?php if(!empty($user_val['MyProfile']['emp_pan_no'])) echo $user_val['MyProfile']['emp_pan_no'] ?></td></tr>
			<tr><td>Working Status </td><td><?php if(!empty($user_val['MyProfile']['wrk_stat'])) echo $att_val['MyProfileatt']['att_nm'] ?></td></tr>
			<tr><td>Working Status Date </td><td><?php if(!empty($user_val['MyProfile']['wrk_stat_dt'])) echo date('d-m-Y',strtotime($user_val['MyProfile']['wrk_stat_dt'])) ?></td></tr>
			<tr><td>Nationality </td><td><?php if(!empty($user_val['MyProfile']['emp_nation'])) echo $this->Userdetail->findCountry($user_val['MyProfile']['emp_nation']) ?></td></tr>
			<tr><td>Requirement Area Flag </td><td><?php if(!empty($user_val['MyProfile']['req_area_flg']))  echo $user_val['MyProfile']['req_area_flg'] ?></td></tr>
			<tr><td>Image </td><td>
			<?php if(!empty($img_val['MyProfileimage']['img_path'])){ echo '<div id="div_user_img_old"><img src="'.$img_val['MyProfileimage']['img_path'].'"></div>'; }?>
			<?php if(!empty($tempimg_val['UserImgtempdata']['img_file_nm'])){ echo '<label id="div_user_img_new"><img src="http://'.$_SERVER['HTTP_HOST'].$this->webroot.'user_img/'.$tempimg_val['UserImgtempdata']['img_file_nm'].'" height="50" width="50"></label><input type="checkbox" name="checkbox_emp_img" value="1" class="label_left">'; }?></td></tr>
		</table>
	</fieldset>
<!--/form>
<form action="" method="post" name="hr_perdetail_form" id="hr_perdetail_form"-->
<fieldset>

<legend>Detail (Personal Detail)</legend>
<table>
    <tr>
		<td>Current Address </td>
		<td><label id="div_emp_curr_add" class="label_left"><?php if(!empty($user_val['MyProfile']['emp_curr_add'])) echo $user_val['MyProfile']['emp_curr_add'] ?></label>
		<?php if(!empty($temp_val['UserTempdata']['emp_curr_add'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['emp_curr_add'].'</label><input type="checkbox" name="checkbox_curadd" value="1" class="label_left">'; } ?></td>
	</tr>
    <tr>
		<td>Permanent Address </td>
		<td><label id="div_emp_perm_add" class="label_left"><?php if(!empty($user_val['MyProfile']['emp_perm_add'])) echo $user_val['MyProfile']['emp_perm_add'] ?></label>
		<?php if(!empty($temp_val['UserTempdata']['emp_perm_add'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['emp_perm_add'].'</label><input type="checkbox" name="checkbox_peradd" value="1" class="label_left">'; } ?></td></tr>
    <tr>
		<td>Primary Phone number </td>
		<td><label id="div_emp_phone1" class="label_left"><?php if(!empty($user_val['MyProfile']['emp_phone1'])) echo $user_val['MyProfile']['emp_phone1'] ?></label>
		<?php if(!empty($temp_val['UserTempdata']['emp_phone1'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['emp_phone1'].'</label><input type="checkbox" name="checkbox_priphn" value="1" class="label_left">'; } ?></td>
	</tr>
    <tr>
		<td>Secondary Phone number </td>
		<td><label id="div_emp_phone2" class="label_left"><?php if(!empty($user_val['MyProfile']['emp_phone2'])) echo $user_val['MyProfile']['emp_phone2'] ?></label>
		<?php if(!empty($temp_val['UserTempdata']['emp_phone2'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['emp_phone2'].'</label><input type="checkbox" name="checkbox_sec_phn" value="1" class="label_left">'; } ?></td>
	</tr>
</table>
</fieldset>
<!--/form>
<form action="" method="post" name="otherdetail_form" id="otherdetail_form"-->
<fieldset>
<legend>Other Detail</legend>
<table>
    <tr><th>Detail Type</th><th>Document No.</th><th>Issue Place</th><th>Document Issue Date</th><th>Document Expiry Date</th><th>Issued By</th><th></th></tr>
    <?php
    if (count($other_val) > 0) {
       foreach($other_val as $othval)
       {?>
        <tr>
            <td><label id="div_oth_dtl_typ_id"><?php if(!empty($othval['MyProfileotherdetail']['oth_dtl_typ_id'])) echo $this->Userdetail->findDetailType($othval['MyProfileotherdetail']['oth_dtl_typ_id']) ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['oth_dtl_typ_id'])) { echo'<label id="" class="label_left">'.$this->Userdetail->findDetailType($temp_val['UserTempdata']['oth_dtl_typ_id']).'</label>'; } ?>
			
			</td>
            <td><label id="div_emp_doc_no"><?php if(!empty($othval['MyProfileotherdetail']['emp_doc_no'])) echo $othval['MyProfileotherdetail']['emp_doc_no'] ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['doc_no'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['doc_no'].'</label>'; } ?>
			</td>
            <td><label id="div_doc_issue_place"><?php if(!empty($othval['MyProfileotherdetail']['doc_issue_place'])) echo $othval['MyProfileotherdetail']['doc_issue_place'] ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['doc_issue_place'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['doc_issue_place'].'</label>'; } ?>
			</td>
            <td><label id="div_doc_issue_dt"><?php if(!empty($othval['MyProfileotherdetail']['doc_issue_dt'])) echo date('d-m-Y',strtotime($othval['MyProfileotherdetail']['doc_issue_dt'])) ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['doc_issue_dt']) && $temp_val['UserTempdata']['doc_issue_dt']!='1970-01-01 00:00:00') { echo'<label id="" class="label_left">'.date('d-m-Y',strtotime($temp_val['UserTempdata']['doc_issue_dt'])).'</label>'; } ?>
			</td>
            <td><label id="div_doc_exp_dt"><?php if(!empty($othval['MyProfileotherdetail']['doc_exp_dt'])) echo date('d-m-Y',strtotime($othval['MyProfileotherdetail']['doc_exp_dt'])) ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['doc_exp_dt']) && $temp_val['UserTempdata']['doc_exp_dt']!='1970-01-01 00:00:00') { echo'<label id="" class="label_left">'.date('d-m-Y',strtotime($temp_val['UserTempdata']['doc_exp_dt'])).'</label>'; } ?>
			</td>
            <td><label id="div_iss_auth"><?php if(!empty($othval['MyProfileotherdetail']['iss_auth'])) echo $othval['MyProfileotherdetail']['iss_auth'] ?></label>
			
			<?php if(!empty($temp_val['UserTempdata']['iss_auth'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['iss_auth'].'</label>'; } ?>
			</td>
			<td>
			<?php if(!empty($temp_val['UserTempdata']['oth_dtl_typ_id']) || !empty($temp_val['UserTempdata']['emp_doc_no']) || !empty($temp_val['UserTempdata']['doc_issue_place']) || !empty($temp_val['UserTempdata']['iss_auth'])) { ?>
			<input type="checkbox" name="checkbox_oth_dtl_<?php echo $othval['MyProfileotherdetail']['oth_dtl_typ_id'];?>" value="1" class="label_left">
			<input type="hidden" name="hidden_oth_dtl" value="<?php echo $othval['MyProfileotherdetail']['oth_dtl_typ_id'];?>">
			
			<?php } ?>
			</td>
        </tr>
    <?php
       } } 
	   ?>
</table>
</fieldset>
<!--/form>

<form-->
<fieldset>
<legend>Attachment</legend>
<table>
    <tr><th>File Name</th></tr>
    <?php
    if (count($attach_val) > 0) {
        foreach($attach_val as $attval)
        {
        ?>
        <tr>
            <td>
                <?php if(!empty($attval['MyProfileattach']['disp_fl_nm'])) echo $attval['MyProfileattach']['disp_fl_nm'] ?>
            </td>
        </tr>
    <?php }
    }?>
	<?php 
	 if (count($attach_temp_val) > 0) {
        foreach($attach_temp_val as $attach_tempval)
        {
        ?>
        <tr>
            <td>
                <?php if(!empty($attach_tempval['Userattachtempdata']['doc_nm'])) echo $attach_tempval['Userattachtempdata']['doc_nm'] ?>
				<input type="checkbox" name="check_attach_doc_<?php echo $attach_tempval['Userattachtempdata']['id'];?>" class="check_attach_doc" value="1">
				<input type="hidden" name="hidden_attach_doc" value="<?php echo $attach_tempval['Userattachtempdata']['id'];?>">
            </td>
        </tr>
    <?php }
    }
	//$attach_temp_val);Userattachtempdata
	?>
</table>
</fieldset>
<!--/form>
<form action="" method="post" name="depntdetail_form" id="depntdetail_form"-->
<fieldset>
<legend>Dependent Details</legend>
<table>
    <tr><th>Member Name</th><th>Date of birth</th><th>Relation</th><th>Occupation</th><th>Gender</th><th></th></tr>
    <?php if (count($depnt_val) > 0) {
      foreach($depnt_val as $depntval)
      {
        ?>
        <tr>
            <td><?php if(!empty($depntval['MyProfiledepnt']['mem_nm'])) echo '<label>'.$depntval['MyProfiledepnt']['mem_nm'].'</label>'; ?>
			<?php if(!empty($temp_val['UserTempdata']['mem_nm'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['mem_nm'].'</label>'; } ?>
			</td>
            <td><?php if(!empty($depntval['MyProfiledepnt']['mem_dob'])) echo '<label>'.date('d-m-Y',strtotime($depntval['MyProfiledepnt']['mem_dob'])).'</label>'; ?>
			
			<?php if(!empty($temp_val['UserTempdata']['mem_dob']) && $temp_val['UserTempdata']['mem_dob']!='1970-01-01 00:00:00') { echo'<label id="" class="label_left">'.date('d-m-Y',strtotime($temp_val['UserTempdata']['mem_dob'])).'</label>'; } ?>
			</td>
            <td><?php if(!empty($depntval['MyProfiledepnt']['mem_rel'])) echo '<label>'.$depntval['MyProfiledepnt']['mem_rel'].'</label>'; ?>
			
			<?php if(!empty($temp_val['UserTempdata']['mem_rel'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['mem_rel'].'</label>'; } ?>
			</td>
            <td><?php if(!empty($depntval['MyProfiledepnt']['mem_occu'])) echo '<label>'.$depntval['MyProfiledepnt']['mem_occu'].'</label>'; ?>
			
			<?php if(!empty($temp_val['UserTempdata']['mem_occu'])) { echo'<label id="" class="label_left">'.$temp_val['UserTempdata']['mem_occu'].'</label>'; } ?>
			</td>
            <td> 
                <?php if(!empty($depntval['MyProfiledepnt']['mem_gen'])) echo '<label>'.$this->Userdetail->findSetup($depntval['MyProfiledepnt']['mem_gen'], $depntval['MyProfiledepnt']['ho_org_id']).'</label>'; ?>
				
				<?php if(!empty($temp_val['UserTempdata']['mem_gen'])) { echo'<label id="" class="label_left">'.$this->Userdetail->findSetup($temp_val['UserTempdata']['mem_gen'], $depntval['MyProfiledepnt']['ho_org_id']).'</label>'; } ?>
            </td>
			<td>
			<?php if(!empty($temp_val['UserTempdata']['mem_nm']) || !empty($temp_val['UserTempdata']['mem_rel']) || !empty($temp_val['UserTempdata']['mem_occu']) || !empty($temp_val['UserTempdata']['mem_gen'])) { ?>
			
				<input type="checkbox" name="checkbox_depnt_dtl_<?php echo $user_val['MyProfile']['emp_code'];?>" value="1" class="label_left">
				<input type="hidden" name="hidden_depnt_dtl" value="<?php echo $user_val['MyProfile']['emp_code'];?>">
			
			<?php } ?>
			</td>
        </tr>
		
    <?php 
      }
      } ?>
</table>
</fieldset>
<!--/form>
<form action="" method="post" name="paydetail_form" id="paydetail_form"-->
<fieldset>
<legend>Payment Detail</legend>
<table>   
    <tr><td>Account No. </td><td><?php  if(!empty($user_val['MyProfile']['acc_no'])) echo '<label id="div_acc_no">'.$user_val['MyProfile']['acc_no'].'</label>'; ?>
	<?php if(!empty($temp_val['UserTempdata']['acc_no'])) { echo '<label id="">'.$temp_val['UserTempdata']['acc_no'].'</label>'; ?>
	<td><input type="checkbox" name="checkbox_acc_no" value="1" class="label_left"></td>
	<?php } ?>
	</td></tr>
</table>
</fieldset>
<input type="hidden" name="doc_id" value="<?php echo $_REQUEST['doc_id'];?>">
<input type="hidden" name="hidden_emp_code" value="<?php echo $user_val['MyProfile']['emp_code'];?>">
</form>

<script>
function hrEmpProfileSave()
{
	$.ajax({
      url : 'hrEmpProfileSave',
      type: 'POST',
	  data: $("#hr_emp_form").serialize(),
      success : function(response){
		if(response==1)
		{
			alert("Data saved successfully.");
			location.reload();
		}
		else
		{	
			alert("Data not saved .");
		}
    }
	});
}

</script>

<style>
.label_left{float:left;margin-right:10px;}
</style>