<script>
    function phydisbl(val) {
        if (val == '0') {
            $("#disbl_det").removeAttr("disabled");
            $("#disbl_det").attr('required', true);
        } else {
            $("#disbl_det").attr('disabled', 'disabled');
            $("#disbl_det").removeAttr('required');
        }
    }


</script>

<?php
$termServ = array('Term1','Term2','Term3','Term4');
$retGround= array('RetGround1','RetGround2','RetGround3','RetGround4');
$secnodments = array('Second1','Second2','Second3','Second4');
$gender = array('Male', 'Female');
//if ($val == '2') {
    //For Appointment
if ($val == '1') {
	$heading = 'Promotion under Common establishment';
}elseif ($val == '2') {
	$heading = 'Promotion on Merit';
}elseif ($val == '3') {
	$heading = 'Appointment';
}elseif ($val == '4') {
	$heading = 'Acting appointment / Extension of Acting Appointment';
}elseif ($val == '5') {
	$heading = 'Re-designation';
}elseif ($val == '6') {
	$heading = 'Establishment of Post';
}elseif ($val == '7') {
	$heading = 'Internal Requests originating from Committees/ Directorates <br/>(Temporary waivers on requirements of Schemes of Service, Establishment/Abolitions of Offices, Approval of Schemes of Service etc)';
}elseif ($val == '8') {
	$heading = 'Retirement - under â€˜50 Yearâ€™ Rule/Medical grounds/reorganization of Government/Abolition of office';
}elseif ($val == '9') {
	$heading = 'Secondment/Transfer of Service';
}elseif ($val == '10') {
	$heading = 'Unpaid Leave / Extension of Unpaid leave';
}elseif ($val == '11') {
	$heading = 'Appointment on Local Agreement Terms / Renewal of Appointment on Local Agreement Terms / <br>Appointment on Local Agreement Terms Upon Attainment of the mandatory retirement age';
}elseif ($val == '12') {
	$heading = 'Corrigendum, Appeal against/Review/Variation/rescission of Commissionâ€™s decision';
}elseif ($val == '13') {
	$heading = 'Noting of general information from MDAâ€™s';
}elseif ($val == '14') {
	$heading = 'Guidance/Advisory on Issues Relating Public Service Commission Mandate';
}elseif ($val == '15') {
	$heading = 'Authority to take up offer of appointment beyond stipulated period';
}elseif ($val == '16') {
	$heading = 'Authority to Advertise/Appointment Under Delegated Powers';
}elseif ($val == '17') {
	$heading = 'Translation of Terms of Service';
}elseif ($val == '18') {
	$heading = 'Complaints on issues relating the mandate of the Public Service Commission';
}elseif ($val == '19') {
	$heading = 'Extension of Retirement Age for Persons with Disability';
}elseif ($val == '20') {
	$heading = 'Appointment of Authorized officers';
}

 
    //For Promotion...
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-3" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<?php if ($val == '4') { ?>
			<div class="uk-width-medium-1-3" >
				<div class="parsley-row">
					<label for="req_cat">Is it Request for a fresh Acting Appointment or <br/>Is it Request for extension of existing Appointment</label>
					<?php
					echo $this->form->input('request_type_for_acting_appointment.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-3" >
				<div class="parsley-row">
					<label for="req_cat">Date of the current Acting Appointment</label>
					<?php
					echo $this->form->input('date_of_current_acting_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			<?php if($val == '9' || $val == '10')
			{	?>
		<div class="uk-width-medium-1-3" >
				<div class="parsley-row">
					<label for="req_cat">Recipient MDA / Organization</label>
					<?php
					echo $this->form->input('request_type_for_acting_appointment.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>

			<?php
			if($val=='9'){
			?>
			<div class="uk-width-medium-1-3" >
				<div class="parsley-row">
					<label for="req_cat">Is the organization declared public service <br>( in case of transfer of service)</label>
					<?php
					echo $this->form->input('date_of_current_acting_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<?php 		
				} 
			}			
			?>
			
		</div>
				
		
		
</div>
<?php
//}

?>

<div id="newclone" >
   <input type="hidden" name="clone_count" id="clone_count" value="1">
</div>
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('data_type_details') ?>">Cancel</a>                       
                    </div>
					<div class="uk-width-1-4 uk-margin-top">                            
                        <div class="md-btn md-btn-primary" id="aaa" onclick="addmorefield();">Add More</div>                       
                    </div>
                    <div class="uk-width-1-4 uk-margin-top">                            
                        <div class="md-btn md-btn-danger" id="remove" style="display: none" onclick="removefield();">Remove</div>                       
                    </div>
       </div>
