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
if($val=='20'){

?>

<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
		
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="title">Title <span class="req">*</span></label>
					<?php
					array_unshift($title, '--Select--');
					echo $this->form->input('title.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="surname">Surname <span class="req">*</span></label>
		<?php echo $this->form->input('surname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="firstname">First name <span class="req">*</span></label>
		<?php echo $this->form->input('firstname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input")); ?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="other_name">Other names </label>
		<?php echo $this->form->input('other_name.', array('type' => 'text', 'label' => false, 'class' => "md-input")); ?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Gender<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Date of Birth<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Personal Number( where applicable)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">National ID Number<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Attached copy of appointment letter<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Effective date of appointment <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Attached copy of the Delegated Authority<span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php
}elseif($val=='19'){
?>
<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="title">Title <span class="req">*</span></label>
					<?php
					array_unshift($title, '--Select--');
					echo $this->form->input('title.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="surname">Surname <span class="req">*</span></label>
		<?php echo $this->form->input('surname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="firstname">First name <span class="req">*</span></label>
		<?php echo $this->form->input('firstname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input")); ?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="other_name">Other names </label>
		<?php echo $this->form->input('other_name.', array('type' => 'text', 'label' => false, 'class' => "md-input")); ?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Gender<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Ethnicity<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Date of Birth<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Personal Number<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">National ID Number<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Job Designation<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Job Group<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Registered with National Council for Persons with Disability (Yes/No)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Medical Board Report (where applicable)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php
	
}elseif($val=='18'){
?>
<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Complainant</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="title">Title <span class="req">*</span></label>
					<?php
					array_unshift($title, '--Select--');
					echo $this->form->input('title.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="surname">Surname <span class="req">*</span></label>
		<?php echo $this->form->input('surname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="firstname">First name <span class="req">*</span></label>
		<?php echo $this->form->input('firstname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input")); ?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="other_name">Other names </label>
		<?php echo $this->form->input('other_name.', array('type' => 'text', 'label' => false, 'class' => "md-input")); ?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Nature of complaint<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification of the Complaint<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Comments from MDA<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Legal opinion – internal<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php
}elseif($val=='16'){
?>
<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Cadre to be appointed (Designation)</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="title">Title <span class="req">*</span></label>
					<?php
					array_unshift($title, '--Select--');
					echo $this->form->input('title.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="surname">Surname <span class="req">*</span></label>
		<?php echo $this->form->input('surname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="firstname">First name <span class="req">*</span></label>
		<?php echo $this->form->input('firstname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input")); ?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="other_name">Other names </label>
		<?php echo $this->form->input('other_name.', array('type' => 'text', 'label' => false, 'class' => "md-input")); ?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Gender<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Personal Number<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">National ID Number<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Job Designation<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Job Group<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Stipulated period of the Offer of Appointment<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php
}elseif($val=='15'){
?>
<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Date of the Commission’s Decision</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Decision’s Minute Number</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">MDA<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Number of vacancies to be filled<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Nature of Advertisement (Internal or Open)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Vacancy position as per the approved establishment(to be retrieved from EMC data as (Authorized – Inputs)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Attached copy of the Treasury’s concurrence on funding<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php	
}elseif($val=='13' && $val=='14'){
?>
<br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Specific Subject Matter</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Remarks by the Submitting Organization<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php if($val=='14'){ ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Legal Opinion (where applicable)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
					
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>
<?php
}elseif($val=='12'){
?>
 <br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Date of the Previous Decision</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Previous Decision’s Minute Number</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">MDA<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="job_requirements_specifications">Reason’s for the Commission Decision (from saved data) - (where applicable)<span class="req">*</span></label>
		<?php
					echo $this->form->input('job_requirements_specifications.', array('label' => false, 'type' => "text", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
		
			<div class="uk-width-medium-1-2" >
				<div class="parsley-row">
					<label for="treasury_concurrence">Is the request for Corrigendum, Appeal against Commission’s Decision, Review of Commission’s Decision, Rescission of Commission’s Decision OR Variation of Commission’s Decision?</label>
					<?php
					echo $this->form->input('treasury_concurrence.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification <span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Attached copy of new material evidence (as or where applicable) <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Notes <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>

<?php
}elseif($val=='6'){ ?>
   <br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Level of the Position to be established<br> (Designation and assigned Job Group)</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification <br>(including Authorized Establishment where applicable)<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="job_requirements_specifications">Job description <span class="req">*</span></label>
		<?php
					echo $this->form->input('job_requirements_specifications.', array('label' => false, 'type' => "text", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
		
			
	
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="treasury_concurrence">Treasury concurrence on funding</label>
					<?php
					echo $this->form->input('treasury_concurrence.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Notes <span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
	</div>


<?php }elseif($val=='7'){ ?>
   <br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="level_of_position">Directorate / Committee</label>
					<?php
					echo $this->form->input('level_of_position.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification"> Type of Request<span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "text", 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="job_requirements_specifications">Nature of Request / Subject Matter <span class="req">*</span></label>
		<?php
					echo $this->form->input('job_requirements_specifications.', array('label' => false, 'type' => "text", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
		
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Date of Receipt at the BMS</label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
	
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
					
			
		</div>
	</div>


<?php }else{
 
    //For Promotion...
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center;"><?= $heading; ?></h3>
	<div id="clonefield">
		<hr style="border-width:5px;border-color: #1976D2;">
		<div  class="uk-grid" data-uk-grid-margin>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">MDA<span class="req">*</span></label>
					<?php
					echo $this->form->input('mda_id.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<?php if ($val == '4') { ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Is it Request for a fresh Acting Appointment or <br/>Is it Request for extension of existing Appointment</label>
					<?php
					echo $this->form->input('request_type_for_acting_appointment.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>


			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Date of the current Acting Appointment</label>
					<?php
					echo $this->form->input('date_of_current_acting_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			
			<?php if ($val == '11') { ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="req_cat">Is the request for Appointment on Local Agreement Terms, Renewal of Appointment on Local Agreement Terms, <br>or Appointment on Local Agreement Terms Upon Attainment of the mandatory retirement age</label>
					<?php
					echo $this->form->input('request_type_for_acting_appointment.', array('label' => false, 'type' => "text", 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			
			
			<?php if($val == '9' || $val == '10')
			{	
		?>
		<div class="uk-width-medium-1-4" >
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
			<div class="uk-width-medium-1-4" >
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
		<div  class="uk-grid" data-uk-grid-margin>
		
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="title">Title <span class="req">*</span></label>
					<?php
					array_unshift($title, '--Select--');
					echo $this->form->input('title.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="surname">Surname <span class="req">*</span></label>
		<?php echo $this->form->input('surname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="firstname">First name <span class="req">*</span></label>
		<?php echo $this->form->input('firstname.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input")); ?>
				</div>
			</div>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="other_name">Other names </label>
		<?php echo $this->form->input('other_name.', array('type' => 'text', 'label' => false, 'class' => "md-input")); ?>
				</div>
			</div>
		 
		 </div>
		<div  class="uk-grid" data-uk-grid-margin>
		
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="gender">Gender <span class="req">*</span></label>
					<?php
					echo $this->form->input('gender.', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="gender">Ethnicity <span class="req">*</span></label>
					<?php
					echo $this->form->input('ethnicity.', array('type' => "text", 'label' => false, 'required' => true, 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="dob">Date of Birth <span class="req">*</span></label>
					<?php
					echo $this->form->input('dob.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dob, 'class' => "md-input"));
					?>
				</div>
			</div>

		</div>
		<div  class="uk-grid" data-uk-grid-margin>
		
			<?php if($val!='8' && $val!='17') {?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="department">Physical Disability <span class="req">*</span></label>
					<?php
					$options = array('0' => 'Yes', '1' => 'No');
					$attributes = array('legend' => false, 'lable' => false, 'onclick' => 'phydisbl(this.value)', 'default' => '1', 'required' => true);
					echo $this->Form->radio('disability', $options, $attributes);
					?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="disabl_det">Disability Details <span class="req">*</span></label>
					<?php
					echo $this->form->input('nature_of_disability.', array('label' => false, 'type' => "textarea", 'id' => 'disbl_det', 'disabled' => 'disabled', 'class' => "md-input"));
					?>
				</div>
			</div> 
			<?php } ?>
			
			
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="id_no">National ID Number <span class="req">*</span></label>
		<?php echo $this->form->input('id_no.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="p_no">Personal Number <span class="req">*</span></label>
		<?php echo $this->form->input('p_no.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			
			</div>
		<div  class="uk-grid" data-uk-grid-margin>
			
			<?php if($val=='8') {?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="department">Date of Birth (in case of Retirement under 50 Year Rule)<span class="req">*</span></label>
					<?php
					echo $this->form->input('dob.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>

			<?php } ?>
		
		</div>
		<div  class="uk-grid" data-uk-grid-margin>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="substantive_job_designation">Substantive Job Designation <span class="req">*</span></label>
					<?php echo $this->form->input('substantive_job_designation.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="substantive_job_group">Substantive Job Group <span class="req">*</span></label>
					<?php
					echo $this->form->input('substantive_job_group.', array('label' => false, 'type' => "text", 'id' => 'substantive_job_designation', 'class' => "md-input"));
					?>
				</div>
			</div> 
	<?php if($val!='9' && $val!='8' && $val!='10' && $val!='11') {?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="date_of_first_appointment">Date of First Appointment <span class="req">*</span></label>
		<?php
					echo $this->form->input('date_of_first_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $date_of_first_appointment, 'class' => "md-input"));
					?>
				</div>
			</div>
	<?php } ?>
	<?php if($val=='11') {?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="id_no">Duration <span class="req">*</span></label>
		<?php
					echo $this->form->input('date_of_first_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
	<?php } ?>
	<?php if($val!='8' && $val!='10') {?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="date_of_current_appointment">Date of Current Appointment <span class="req">*</span></label>
				<?php
					echo $this->form->input('date_of_current_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $date_of_current_appointment, 'class' => "md-input"));
					?>
				</div>
			</div>
	<?php } ?>
		
		
		<?php if($val=='8') {?>
	
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="request_for_retirement">Is it Request for a retirement under ‘50 Year’ Rule, Medical grounds, <br>Reorganization of Government, Abolition of Office or Any other Ground <span class="req">*</span></label>
					<?php echo $this->form->input('request_for_retirement.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="other_requirement_grnd">Description of any other Retirement Ground (where applicable) <span class="req">*</span></label>
					<?php
					echo $this->form->input('other_requirement_grnd.', array('label' => false, 'type' => "textarea", 'id' => 'other_requirement_grnd', 'class' => "md-input"));
					?>
				</div>
			</div> 

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="id_no">Attached copy of the Medical Board Report <br>(in case of Retirement under Medical Ground) <span class="req">*</span></label>
		<?php
					echo $this->form->input('date_of_first_appointment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="p_no">Attached copy of Officer’s Personal Representation <span class="req">*</span></label>
		<?php echo $this->form->input('date_of_current_appointment.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
		
		
		<?php } ?>
		
		
		<?php if($val=='9') {?>
	
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="request_for_secondment_tos">Is it Request for Secondment or Transfer of Service?<span class="req">*</span></label>
					<?php echo $this->form->input('request_for_secondment_tos.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="request_for_fresh_exis_sec">Is it Request for a fresh Secondment or Is it Request for extension of existing Secondment <span class="req">*</span></label>
					<?php
					echo $this->form->input('request_for_fresh_exis_sec.', array('label' => false, 'type' => "text", 'id' => 'request_for_fresh_exis_sec', 'class' => "md-input"));
					?>
				</div>
			</div> 

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="date_of_initial_secondment">Date of initial secondment (in case of extension of existing Secondment) <span class="req">*</span></label>
		<?php
					echo $this->form->input('date_of_initial_secondment.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="secondment_duration">Secondment duration <span class="req">*</span></label>
		<?php echo $this->form->input('secondment_duration.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
		</div>
		<div class="uk-grid" data-uk-grid-margin  >
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="upload_doc_medical">Attached copy of Letter of Appointment<span class="req">*</span></label>
					<?php echo $this->form->input('upload_doc_medical.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="upload_doc_off_per_repre">Attached copy of Officer’s Request <span class="req">*</span></label>
					<?php
					echo $this->form->input('upload_doc_off_per_repre.', array('label' => false, 'type' => "text", 'id' => 'other_requirement_grnd', 'class' => "md-input"));
					?>
				</div>
			</div> 

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="upload_doc_seniority_list">Attached copy of the Authorized officer’s concurrence or comments <span class="req">*</span></label>
		<?php
					echo $this->form->input('upload_doc_seniority_list.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			
		
		
		<?php } ?>
		
		<?php if($val=='10') { ?>
		
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="request_for_fresh_exis_leave">Is it Request for a fresh Unpaid Leave or <br/>Is it Request for extension of existing Unpaid Leave<span class="req">*</span></label>
					<?php echo $this->form->input('request_for_fresh_exis_leave.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="date_of_initial_secondment">Date of initial authority <br/>(in case of extension of existing unpaid leave) <span class="req">*</span></label>
					<?php
					echo $this->form->input('date_of_initial_secondment.', array('label' => false, 'type' => "text", 'id' => 'date_of_initial_secondment', 'class' => "md-input"));
					?>
				</div>
			</div> 

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="upload_doc_off_per_repre">Attached copy of the Letter of Appointment (where necessary) <span class="req">*</span></label>
		<?php
					echo $this->form->input('upload_doc_off_per_repre.', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $dos, 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="upload_doc_seniority_list">Attached copy of the Authorized officer’s concurrence / Comments <span class="req">*</span></label>
		<?php echo $this->form->input('upload_doc_seniority_list.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
	
		
		<?php } ?>
		
		
		<?php if($val!='9' && $val!='8' && $val!='10') {?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="recommended_grade">Recommended Grade/Designation <span class="req">*</span></label>
					<?php echo $this->form->input('recommended_grade.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
		<?php } ?>
		<?php if($val!='9' && $val!='8' && $val!='10' ) {?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="job_group">Job Group <span class="req">*</span></label>
					<?php
					echo $this->form->input('job_group.', array('label' => false, 'type' => "text", 'required' => true, 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div> 
		<?php } ?>
			<?php if ($val == '3' || $val == '1' || $val == '2') { ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="salary_scale">Salary Scale <span class="req">*</span></label>
		<?php
					echo $this->form->input('salary_scale.', array('label' => false, 'type' => "text", 'required' => true, 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			
			<?php if ($val == '3' || $val =='9' || $val=='10') { ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="terms_of_services">Term of Services <span class="req">*</span></label>
		<?php
					echo $this->form->input('terms_of_services.', array('label' => false, 'type' => "textarea", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			
			<?php if ($val == '17') { ?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="terms_of_services">Current Term of Services <span class="req">*</span></label>
		<?php
					echo $this->form->input('terms_of_services.', array('label' => false, 'type' => "text", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="terms_of_services">Proposed Term of Services <span class="req">*</span></label>
		<?php
					echo $this->form->input('terms_of_services.', array('label' => false, 'type' => "textarea", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			<?php if($val!='9' && $val!='8' && $val!='10' ) {?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="job_requirements_specifications">Job Requirements/Specifications <span class="req">*</span></label>
		<?php
					echo $this->form->input('job_requirements_specifications.', array('label' => false, 'type' => "textarea", 'required' => true, 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div>
			<?php } ?>
			
			</div>
		<div  class="uk-grid" data-uk-grid-margin>
		
			<?php if($val!='9' && $val!='8' && $val!='10' ) {?>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="acad_prof_qual">Academic & Professional Qualifications <span class="req">*</span></label>
		<?php echo $this->form->input('acad_prof_qual.', array('type' => 'textarea', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
			<?php } ?>
	
		
		
		<?php if($val!='9' && $val!='8' && $val!='10' ) {?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="related_experience">Related Experience <span class="req">*</span></label>
					<?php echo $this->form->input('related_experience.', array('type' => 'textarea', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
		<?php } ?>
			<?php if($val!='9' && $val!='8' && $val!='10' && $val!='17' ) {?>

			
                <div class="uk-width-medium-1-4 "  id='TextBoxesGroup' >
                        <div class="parsley-row ">
                            <label for="upload_doc_aca_qual_exp"  >Attached Copies of the Academic & Professional Qualifications <span class="req">*</span></label>
                        <div class="md-btn md-btn-primary" style="width:100% !important">
                        <?php 
                        echo $this->form->input('upload_doc_aca_qual_exp.', array('type'=>'file', 'id'=>'first_upload','required'=>true, 'class'=>'upl_doc','label'=>false)); 
                        ?>
                        </div>
                        </div>
                  
					<div id="addme4"></div>
				</div>
				 <div class="uk-width-medium-1-4 upload" >    <br/>  <br/>                     
                    <input type='button' class="md-btn md-btn-primary addButton" onclick="upload_add(4);"  value='Add More' id='addButton4'>
                    <input type='button' class="md-btn md-btn-danger removeButton" onclick="upload_remove(4);" value='Remove' id='removeButton4'>         
                </div>
		
			

		<?php } ?>
		
		</div>
		<div  class="uk-grid" data-uk-grid-margin>
		
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="justification">Justification/Performance Assessment <span class="req">*</span></label>
		<?php
					echo $this->form->input('justification.', array('label' => false, 'type' => "textarea", 'required' => true, 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			
			<?php if( $val=='17' ) {?>

			<div class="uk-width-medium-1-4">
				<div class="parsley-row" id="disbl_dets" >
					<label for="job_group">Treasury’s concurrence on funding (where applicable) <span class="req">*</span></label>
					<?php
					echo $this->form->input('job_group.', array('label' => false, 'type' => "textarea", 'id' => 'job_group', 'class' => "md-input"));
					?>
				</div>
			</div> 
		<?php } ?>
			<?php if ($val == '11' || $val == '4' || $val == '1' ) { ?>
			
			<div class="uk-width-medium-1-4 "  id='TextBoxesGroup' >
                        <div class="parsley-row ">
                            <label for="upload_doc_seniority_list"  >Attached copy of the Seniority list <span class="req">*</span></label>
                        <div class="md-btn md-btn-primary"  style="width:100% !important">
                        <?php 
                        echo $this->form->input('upload_doc_seniority_list.', array('type'=>'file', 'id'=>'first_upload','required'=>true, 'class'=>'upl_doc','label'=>false)); 
                        ?>
                        </div>
                        </div>
                  
					<div id="addme3"></div>
				</div>
				 <div class="uk-width-medium-1-4 upload" >      <br/>                   
                    <input type='button' class="md-btn md-btn-primary addButton" onclick="upload_add(3);"  value='Add More' id='addButton3'>
                    <input type='button' class="md-btn md-btn-danger removeButton" onclick="upload_remove(3);" value='Remove' id='removeButton3'>         
                </div>
			
			<?php } ?>
			
			<?php if ($val == '11') { ?>
			
				<div class="uk-width-medium-1-4 "  id='TextBoxesGroup' >
                        <div class="parsley-row ">
                            <label for="upload_doc_off_per_repre"  >Attached copy of the Officer’s Performance Assessment (in case of Renewal of Appointment on Local Agreement Terms) <span class="req">*</span></label>
                        <div class="md-btn md-btn-primary" style="width:100% !important">
                        <?php 
                        echo $this->form->input('upload_doc_off_per_repre.', array('type'=>'file', 'id'=>'first_upload','required'=>true, 'class'=>'upl_doc','label'=>false)); 
                        ?>
                        </div>
                        </div>
                  
					<div id="addme2"></div>
				</div>
				 <div class="uk-width-medium-1-4 upload " >    <br/>                     
                    <input type='button' class="md-btn md-btn-primary addButton"  onclick="upload_add(2);" value='Add More' id='addButton2'>
                    <input type='button' class="md-btn md-btn-danger removeButton" onclick="upload_remove(2);" value='Remove' id='removeButton2'>         
                </div>
			
			<?php } ?>
	
		
		
		
		<?php if ($val == '4') { ?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="related_experience">Is there supersession (Yes/No)<span class="req">*</span></label>
					<?php echo $this->form->input('related_experience.', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
<b>Reasons for supersession</b>
			
				<div class="uk-width-medium-1-4 "  id='TextBoxesGroup' >
                        <div class="parsley-row ">
                            <label for="upload_doc_draft_of_indent_advert"  >Attached draft of Indent for advertisement of the post <span class="req">*</span></label>
                        <div class="md-btn md-btn-primary" style="width:100% !important">
                        <?php 
                        echo $this->form->input('upload_doc_draft_of_indent_advert.', array('type'=>'file', 'id'=>'first_upload','required'=>true, 'class'=>'upl_doc','label'=>false)); 
                        ?>
                        </div>
                        </div>
                  
					<div id="addme1"></div>
				</div>
				 <div class="uk-width-medium-1-4 upload" >     <br/>                    
                    <input type='button' class="md-btn md-btn-primary addButton" onclick="upload_add(1);"  value='Add More' id='addButton1'>
                    <input type='button' class="md-btn md-btn-danger removeButton" onclick="upload_remove(1);" value='Remove' id='removeButton1'>         
                </div>
			
		<?php }
		?>
		
		<?php if ($val == '2' || $val == '3') { ?>
			<div class="uk-width-medium-1-4">
				<div class="parsley-row">
					<label for="vacancy_position">Vacancy Position <span class="req">*</span></label>
					<?php echo $this->form->input('vacancy_position.', array('type' => 'textarea', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>

		<?php }
		?>

			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="notes">Notes <span class="req">*</span></label>
		<?php
					echo $this->form->input('notes.', array('label' => false, 'type' => "textarea", 'required' => true, 'id' => 'justification', 'class' => "md-input"));
					?>
				</div>
			</div>
			<div class="uk-width-medium-1-4" >
				<div class="parsley-row">
					<label for="request_to_commission">Request to Commission <span class="req">*</span></label>
		<?php echo $this->form->input('request_to_commission.', array('type' => 'textarea', 'label' => false, 'required' => true, 'class' => "md-input"));
		?>
				</div>
			</div>
	
		
</div>
<?php
}

?>
</div>
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
<script type="text/javascript">

   var counter = 2;
	function upload_add(i){
		
       alert(counter);
            if (counter > 10) {
                alert("Only 10 files can upload at a time");
                return false;
			}

            var newTextBoxDiv = $(document.createElement('div')).attr({id: 'TextBoxDiv' + counter, class: "uk-width-medium-1-1  margin-bottom"});

            newTextBoxDiv.after().html('<br><label for="upl_doc">Select File To Upload: <span class="req"><sup>*</sup>&nbsp;</span></label>' +
                    '<div class="parsley-row  md-btn md-btn-primary" style="width:100% !important">' +
                    '<?php echo $this->form->input('upl_doc.', array('type'=>'file','label'=>false,'class'=>'upl_doc','required'=>true)); ?>' +
                    '</div>');

            newTextBoxDiv.appendTo("#addme"+i);
            $('#first_upload').attr('required',true);

            counter++;
        	
	}
	
	function upload_remove(i){
		 alert(counter);
  
            if (counter == 3) {
                 $('#first_upload').attr('required',false);
            }
            if (counter == 1) {
                alert("You can't delete default upload field !");
                return false;
            }
            counter--;
             $("#TextBoxDiv" + counter).remove();
       
	}

</script>