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
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>List of Data Type Details</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content ">
<?php
$termServ = array('Term1','Term2','Term3','Term4');
$retGround= array('RetGround1','RetGround2','RetGround3','RetGround4');
$secnodments = array('Second1','Second2','Second3','Second4');
$gender = array('Male', 'Female');
foreach($Record as $rec);
     echo $this->Form->create('doc', array('url' =>array('controller' => 'Boards', 'action' =>'data_type_details_edit'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
     echo $this->form->input('rec_id', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['id'], 'class' => "md-input"));
     echo $this->form->input('data_type_id', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['data_type_id'], 'class' => "md-input"));

if ($val == '2') {
    //For Appointment
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Appointment</h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="req_cat">Serial Number</label>
                <?php
                echo $this->form->input('seri_Num', array('type' => 'text', 'label' => false, 'disabled' => 'disabled', 'value' => $rec['serial_num'], 'required' => true, 'class' => "md-input"));
                echo $this->form->input('seriNum', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['serial_num'], 'class' => "md-input"));
                ?>
            </div>
        </div>

        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="id_no">ID No. <span class="req">*</span></label>
    <?php echo $this->form->input('id_no', array('type' => 'text', 'label' => false, 'required' => true,'value'=>$rec['id_no'], 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="p_no">P No. <span class="req">*</span></label>
    <?php echo $this->form->input('p_no', array('type' => 'text', 'label' => false, 'value'=>$rec['p_no'],'required' => true, 'value'=>$rec['p_no'], 'class' => "md-input"));
    ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="title">Title <span class="req">*</span></label>
                <?php
                array_unshift($title, '--Select--');
                echo $this->form->input('title', array('label' => false, 'type' => "select", 'empty' => '-- Select --','default'=>$rec['title'], 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="surname">Surname <span class="req">*</span></label>
    <?php echo $this->form->input('surname', array('type' => 'text', 'label' => false, 'required' => true, 'value'=>$rec['surname'],'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="firstname">First name <span class="req">*</span></label>
    <?php echo $this->form->input('firstname', array('type' => 'text', 'label' => false, 'required' => true, 'value'=>$rec['firstname'], 'class' => "md-input")); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="other_name">Other names </label>
    <?php echo $this->form->input('other_name', array('type' => 'text', 'label' => false, 'value'=>$rec['other_name'], 'class' => "md-input")); ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
    <div class="uk-grid" data-uk-grid-margin > 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="dob">Date of Birth <span class="req">*</span></label>
                <?php
                echo $this->form->input('dob', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value'=>date("d/m/Y", strtotime($rec['dob'])), 'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="gender">Gender <span class="req">*</span></label>
                <?php
                echo $this->form->input('gender', array('label' => false, 'type' => "select",'default'=>$rec['gender'], 'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="dob">Qualification <span class="req">*</span></label>
                <?php
                echo $this->form->input('qualification', array('type' => "text", 'label' => false, 'required' => true, 'value'=>$rec['qualification'],'class' => "md-input"));
                ?>
            </div>
        </div>

    </div> 

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Academic <span class="req">*</span></label>
    <?php echo $this->form->textarea('acad', array('label' => false, 'required' => true,  'value'=>$rec['academic'],'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Professional <span class="req">*</span></label>
    <?php echo $this->form->textarea('prof', array('label' => false, 'required' => true,  'value'=>$rec['professional'],'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Experience <span class="req">*</span></label>
    <?php echo $this->form->textarea('exp', array('label' => false, 'required' => true, 'value'=>$rec['experience'], 'class' => "md-input")); ?>                
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-1">
            <div class="parsley-row">
                <label for="department">Physical Disability <span class="req">*</span></label>
                <?php
                $options = array('0' => 'Yes', '1' => 'No');
                $attributes = array('legend' => false, 'value'=>$rec['physical_disability'],'lable' => false, 'onclick' => 'phydisbl(this.value)', 'default' => '1', 'required' => true);
                echo $this->Form->radio('ph_disa', $options, $attributes);
                ?>
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-3">
            <div class="parsley-row" id="disbl_dets" >
                <label for="disabl_det">Disability Details <span class="req">*</span></label>
                <?php
                if($rec['physical_disability']=='0'){
                    $dsbled = "";
                }else{
                    $dsbled = "disabled";
                }
                echo $this->form->input('disabl_det', array('label' => false, 'type' => "text",'value'=>$rec['disable_details'], 'id' => 'disbl_det', 'disabled'=>$dsbled, 'class' => "md-input"));
                ?>
            </div>
        </div> 

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="ministry">Ministry <span class="req">*</span></label>
                <?php
                echo $this->form->input('ministry', array('label' => false, 'type' => "select",'default'=>$rec['ministry_id'], 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
                $department = $this->common->findDepartmentList();
                echo $this->form->input('department', array('label' => false, 'type' => "select", 'default'=>$rec['department_code'],'empty' => '-- Select --', 'required' => true, 'options' => $department, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="doa">Data of First Appointment <span class="req">*</span></label>
                <?php
                echo $this->form->input('doa', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}','value'=>date("d/m/Y", strtotime($rec['d_o_appointment'])), 'class' => "md-input"));
                ?>

            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="doca">Data of Current Appointment <span class="req">*</span></label>
                <?php
                echo $this->form->input('doca', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value'=>date("d/m/Y", strtotime($rec['d_o_c_appointment'])),'class' => "md-input"));
                ?>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Current Designation <span class="req">*</span></label>
                <?php
                $Designation = $this->common->getDesignationList();
                array_unshift($Designation, '--Select--');
                echo $this->form->input('curr_desig', array('label' => false, 'type' => "select",'default'=>$rec['currenct_designation'], 'empty' => '-- Select --', 'required' => true, 'options' => $Designation, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Recommended Designation<span class="req">*</span></label>
                <?php
                $Designations = $this->common->getDesignationList();
                array_unshift($Designations, '--Select--');
                echo $this->form->input('recomm_desig', array('label' => false, 'type' => "select",'default'=>$rec['recommended_designation'], 'empty' => '-- Select --', 'required' => true, 'options' => $Designations, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Recommended Term of Services<span class="req">*</span></label>
                <?php
                echo $this->form->input('recomm_t_serv', array('label' => false, 'type' => "select",'default'=>$rec['recomm_term_services'],'empty' => '-- Select --', 'required' => true, 'options' => $termServ, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Justification</label>
                <?php
                echo $this->form->input('justification', array('label' => false, 'type' => "text",'value'=>$rec['justification'], 'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Notes</label>
                <?php
                echo $this->form->input('notes', array('label' => false, 'type' => "text", 'value'=>$rec['notes'],'class' => "md-input"));
                ?>
            </div>
        </div>
    </div>
<?php } elseif ($val == '3') { 
    //For Promotion...
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Promotion</h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="req_cat">Serial Number</label>
                <?php
                echo $this->form->input('seri_Num', array('type' => 'text', 'label' => false, 'disabled' => 'disabled', 'value' => $rec['serial_num'], 'required' => true, 'class' => "md-input"));
                echo $this->form->input('seriNum', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['serial_num'], 'class' => "md-input"));
                ?>
            </div>
        </div>

        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="id_no">ID No. <span class="req">*</span></label>
    <?php echo $this->form->input('id_no', array('type' => 'text', 'label' => false, 'value'=>$rec['id_no'],'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="p_no">P No. <span class="req">*</span></label>
    <?php echo $this->form->input('p_no', array('type' => 'text', 'label' => false,'value'=>$rec['p_no'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="title">Title <span class="req">*</span></label>
                <?php
                array_unshift($title, '--Select--');
                echo $this->form->input('title', array('label' => false, 'type' => "select", 'default'=>$rec['title'],'empty' => '-- Select --', 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="surname">Surname <span class="req">*</span></label>
    <?php echo $this->form->input('surname', array('type' => 'text', 'label' => false,'value'=>$rec['surname'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="firstname">First name <span class="req">*</span></label>
    <?php echo $this->form->input('firstname', array('type' => 'text', 'label' => false,'value'=>$rec['firstname'], 'required' => true, 'class' => "md-input")); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="other_name">Other names </label>
    <?php echo $this->form->input('other_name', array('type' => 'text', 'value'=>$rec['other_name'],'label' => false, 'class' => "md-input")); ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
    <div class="uk-grid" data-uk-grid-margin > 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="dob">Date of Birth <span class="req">*</span></label>
                <?php
                echo $this->form->input('dob', array('type' => "text", 'value'=>date("d/m/Y", strtotime($rec['dob'])),'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="gender">Gender <span class="req">*</span></label>
                <?php
                echo $this->form->input('gender', array('label' => false, 'default'=>$rec['gender'],'type' => "select", 'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="dob">Promotion Type <span class="req">*</span></label>
                <?php
                $Designations = array('Promotion 1', 'Promotion 2', 'Promotion 3', 'Promotion 4');
                //array_unshift($Designations,'--Select--');
                echo $this->form->input('promotype', array('label' => false, 'type' => "select",'default'=>$rec['promotion_type'], 'empty' => '-- Select --', 'required' => true, 'options' => $Designations, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>

    </div> 

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Academic <span class="req">*</span></label>
    <?php echo $this->form->textarea('acad', array('label' => false, 'required' => true,'value'=>$rec['academic'], 'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Professional <span class="req">*</span></label>
    <?php echo $this->form->textarea('prof', array('label' => false, 'required' => true, 'value'=>$rec['professional'], 'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Experience <span class="req">*</span></label>
    <?php echo $this->form->textarea('exp', array('label' => false, 'required' => true,'value'=>$rec['experience'], 'class' => "md-input")); ?>                
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-1">
            <div class="parsley-row">
                <label for="department">Physical Disability <span class="req">*</span></label>
                <?php
                $options = array('0' => 'Yes', '1' => 'No');
                $attributes = array('legend' => false, 'lable' => false, 'default'=>$rec['physical_disability'],'onclick' => 'phydisbl(this.value)', 'default' => '1', 'required' => true);
                echo $this->Form->radio('ph_disa', $options, $attributes);
                ?>
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-3">
            <div class="parsley-row" id="disbl_dets" >
                <label for="disabl_det">Disability Details <span class="req">*</span></label>
                <?php
                echo $this->form->input('disabl_det', array('label' => false, 'type' => "text",'value'=>$rec['disable_details'], 'id' => 'disbl_det', 'disabled' => 'disabled', 'class' => "md-input"));
                ?>
            </div>
        </div> 

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="ministry">Ministry <span class="req">*</span></label>
                <?php
                echo $this->form->input('ministry', array('label' => false, 'type' => "select", 'default'=>$rec['ministry_id'],'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
                $department = $this->common->findDepartmentList();
                echo $this->form->input('department', array('label' => false, 'type' => "select", 'default'=>$rec['department_code'],'empty' => '-- Select --', 'required' => true, 'options' => $department, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="doa">Data of First Appointment <span class="req">*</span></label>
                <?php
                echo $this->form->input('doa', array('type' => "text", 'label' => false, 'required' => true, 'value'=>date("d/m/Y", strtotime($rec['d_o_appointment'])), 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                ?>

            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="doca">Data of Current Appointment <span class="req">*</span></label>
                <?php
                echo $this->form->input('doca', array('type' => "text", 'label' => false,'value'=>date("d/m/Y", strtotime($rec['d_o_c_appointment'])), 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                ?>

            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Current Designation <span class="req">*</span></label>
                <?php
                $Designation = $this->common->getDesignationList();
                array_unshift($Designation, '--Select--');
                echo $this->form->input('curr_desig', array('label' => false, 'type' => "select",'default'=>$rec['currenct_designation'], 'empty' => '-- Select --', 'required' => true, 'options' => $Designation, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Recommended Designation<span class="req">*</span></label>
                <?php
                $Designations = $this->common->getDesignationList();
                array_unshift($Designations, '--Select--');
                echo $this->form->input('recomm_desig', array('label' => false, 'type' => "select", 'default'=>$rec['recommended_designation'],'empty' => '-- Select --', 'required' => true, 'options' => $Designations, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Recommended Term of Services<span class="req">*</span></label>
                <?php
                echo $this->form->input('recomm_t_serv', array('label' => false, 'type' => "select",'default'=>$rec['recomm_term_services'], 'empty' => '-- Select --', 'required' => true, 'options' => $termServ, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Justification</label>
                <?php
                echo $this->form->input('justification', array('label' => false, 'type' => "text",'value'=>$rec['justification'], 'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Notes</label>
                <?php
                echo $this->form->input('notes', array('label' => false, 'type' => "text",'value'=>$rec['notes'],'class' => "md-input"));
                ?>
            </div>
        </div>
    </div>
<?php
} elseif ($val == '5') {
    //For Redesignation ....
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Re-Designation</h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="req_cat">Serial Number</label>
                <?php
                echo $this->form->input('seri_Num', array('type' => 'text', 'label' => false, 'disabled' => 'disabled', 'value' => $rec['serial_num'], 'required' => true, 'class' => "md-input"));
                echo $this->form->input('seriNum', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['serial_num'], 'class' => "md-input"));
                ?>
            </div>
        </div>

        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="id_no">ID No. <span class="req">*</span></label>
    <?php echo $this->form->input('id_no', array('type' => 'text', 'label' => false, 'value'=>$rec['id_no'],'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="p_no">P No. <span class="req">*</span></label>
    <?php echo $this->form->input('p_no', array('type' => 'text', 'label' => false,'value'=>$rec['p_no'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="title">Title <span class="req">*</span></label>
                <?php
                array_unshift($title, '--Select--');
                echo $this->form->input('title', array('label' => false, 'type' => "select", 'empty' => '-- Select --','default'=>$rec['title'], 'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="surname">Surname <span class="req">*</span></label>
    <?php echo $this->form->input('surname', array('type' => 'text', 'label' => false,'value'=>$rec['surname'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="firstname">First name <span class="req">*</span></label>
    <?php echo $this->form->input('firstname', array('type' => 'text', 'label' => false,'value'=>$rec['firstname'], 'required' => true, 'class' => "md-input")); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="other_name">Other names </label>
    <?php echo $this->form->input('other_name', array('type' => 'text', 'value'=>$rec['other_name'],'label' => false, 'class' => "md-input")); ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
    <div class="uk-grid" data-uk-grid-margin > 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="dob">Date of Birth <span class="req">*</span></label>
    <?php
    echo $this->form->input('dob', array('type' => "text", 'label' => false,'value'=>date("d/m/Y", strtotime($rec['dob'])), 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}',  'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="gender">Gender <span class="req">*</span></label>
    <?php
    echo $this->form->input('gender', array('label' => false, 'type' => "select", 'default'=>$rec['gender'],'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
    ?>
            </div>
        </div>

    </div> 

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Academic <span class="req">*</span></label>
    <?php echo $this->form->textarea('acad', array('label' => false, 'required' => true,'value'=>$rec['academic'], 'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Professional <span class="req">*</span></label>
    <?php echo $this->form->textarea('prof', array('label' => false, 'required' => true,  'value'=>$rec['professional'],'class' => "md-input")); ?>                
            </div>
        </div>

        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="subject">Experience <span class="req">*</span></label>
    <?php echo $this->form->textarea('exp', array('label' => false, 'required' => true, 'value'=>$rec['experience'],'class' => "md-input")); ?>                
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="ministry">Ministry <span class="req">*</span></label>
                <?php
                echo $this->form->input('ministry', array('label' => false, 'type' => "select", 'default'=>$rec['ministry_id'],'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
                $department = $this->common->findDepartmentList();
                echo $this->form->input('department', array('label' => false, 'type' => "select",'default'=>$rec['department_code'], 'empty' => '-- Select --', 'required' => true, 'options' => $department, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
    </div>
    <div class="uk-grid" data-uk-grid-margin  >

        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Current Designation <span class="req">*</span></label>
                <?php
                $Designation = $this->common->getDesignationList();
                array_unshift($Designation, '--Select--');
                echo $this->form->input('curr_desig', array('label' => false, 'type' => "select", 'default'=>$rec['currenct_designation'],'empty' => '-- Select --', 'required' => true, 'options' => $Designation, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Recommended Designation<span class="req">*</span></label>
                <?php
                $Designations = $this->common->getDesignationList();
                array_unshift($Designations, '--Select--');
                echo $this->form->input('recomm_desig', array('label' => false, 'type' => "select", 'default'=>$rec['recommended_designation'],'empty' => '-- Select --', 'required' => true, 'options' => $Designations, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Justification</label>
                <?php
                echo $this->form->input('justification', array('label' => false, 'type' => "text",'value'=>$rec['justification'],'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Notes</label>
                <?php
                echo $this->form->input('notes', array('label' => false, 'type' => "text",'value'=>$rec['notes'],'class' => "md-input"));
                ?>
            </div>
        </div>
    </div>
<?php }elseif ($val == '6') {
    //For Secondment / Transfer of Service ....
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center">Secondment / Transfer of Service</h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="req_cat">Serial Number</label>
                <?php
                echo $this->form->input('seri_Num', array('type' => 'text', 'label' => false, 'disabled' => 'disabled', 'value' => $rec['serial_num'], 'required' => true, 'class' => "md-input"));
                echo $this->form->input('seriNum', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['serial_num'], 'class' => "md-input"));
                ?>
            </div>
        </div>

        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="id_no">ID No. <span class="req">*</span></label>
    <?php echo $this->form->input('id_no', array('type' => 'text', 'label' => false,'value'=>$rec['id_no'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="p_no">P No. <span class="req">*</span></label>
    <?php echo $this->form->input('p_no', array('type' => 'text', 'label' => false,'value'=>$rec['p_no'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="title">Title <span class="req">*</span></label>
                <?php
                array_unshift($title, '--Select--');
                echo $this->form->input('title', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'default'=>$rec['title'],'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="surname">Surname <span class="req">*</span></label>
    <?php echo $this->form->input('surname', array('type' => 'text', 'label' => false, 'value'=>$rec['surname'],'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="firstname">First name <span class="req">*</span></label>
    <?php echo $this->form->input('firstname', array('type' => 'text', 'label' => false,'value'=>$rec['firstname'], 'required' => true, 'class' => "md-input")); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="other_name">Other names </label>
    <?php echo $this->form->input('other_name', array('type' => 'text','value'=>$rec['other_name'], 'label' => false, 'class' => "md-input")); ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
    <div class="uk-grid" data-uk-grid-margin > 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="dob">Date of Birth <span class="req">*</span></label>
    <?php
    echo $this->form->input('dob', array('type' => "text", 'label' => false,'value'=>date("d/m/Y", strtotime($rec['dob'])), 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="gender">Gender <span class="req">*</span></label>
    <?php
    echo $this->form->input('gender', array('label' => false, 'type' => "select", 'default'=>$rec['gender'],'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
    ?>
            </div>
        </div>

    </div> 
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="ministry">Ministry <span class="req">*</span></label>
                <?php
                echo $this->form->input('ministry', array('label' => false, 'type' => "select",'default'=>$rec['ministry_id'], 'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
                $department = $this->common->findDepartmentList();
                echo $this->form->input('department', array('label' => false, 'type' => "select", 'default'=>$rec['department_code'],'empty' => '-- Select --', 'required' => true, 'options' => $department, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Current Designation <span class="req">*</span></label>
                <?php
                $Designation = $this->common->getDesignationList();
                array_unshift($Designation, '--Select--');
                echo $this->form->input('curr_desig', array('label' => false, 'type' => "select", 'default'=>$rec['currenct_designation'],'empty' => '-- Select --', 'required' => true, 'options' => $Designation, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Term of Services <span class="req">*</span></label>
                <?php
                echo $this->form->input('recomm_t_serv', array('label' => false, 'type' => "select",'default'=>$rec['recomm_term_services'], 'empty' => '-- Select --', 'required' => true, 'options' => $termServ, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Secondment \ Services Transfer <span class="req">*</span></label>
                <?php
                echo $this->form->input('secondment', array('label' => false, 'type' => "select", 'default'=>$rec['secondment_transfer_id'],'empty' => '-- Select --', 'required' => true, 'options' => $secnodments, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Justification</label>
                <?php
                echo $this->form->input('justification', array('label' => false, 'type' => "text", 'value'=>$rec['justification'], 'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Notes</label>
                <?php
                echo $this->form->input('notes', array('label' => false, 'type' => "text",'value'=>$rec['notes'],'class' => "md-input"));
                ?>
            </div>
        </div>
    </div>
<?php }elseif ($val == '4' || $val == '7' || $val == '8' || $val == '9' || $val == '10' || $val == '11') {
        if($val == '4'){
            $lable = "Retirement";
        }elseif($val == '7'){
            $lable = "Authority to Recruit";
        }elseif($val == '8'){
            $lable = "Guidance / Adivsory";
        }elseif($val == '9'){
            $lable = "Establishment / Abolition of offices";
        }elseif($val == '10'){
            $lable = "Noting of Decisions / Concerns";
        }elseif($val == '11'){
            $lable = "Approval of Schemes of Services";
        }
    ?>
    <br>
    <hr>
    <h3 class="heading_a" style="text-align: center"><?php echo $lable;?></h3>
    <hr>
    <div  class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="req_cat">Serial Number</label>
                <?php
                echo $this->form->input('seri_Num', array('type' => 'text', 'label' => false, 'disabled' => 'disabled', 'value' => $rec['serial_num'], 'required' => true, 'class' => "md-input"));
                echo $this->form->input('seriNum', array('type' => 'hidden', 'label' => false, 'required' => true, 'value' => $rec['serial_num'], 'class' => "md-input"));
                ?>
            </div>
        </div>

        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="id_no">ID No. <span class="req">*</span></label>
    <?php echo $this->form->input('id_no', array('type' => 'text', 'label' => false,'value'=>$rec['id_no'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3" >
            <div class="parsley-row">
                <label for="p_no">P No. <span class="req">*</span></label>
    <?php echo $this->form->input('p_no', array('type' => 'text', 'label' => false, 'value'=>$rec['p_no'],'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="title">Title <span class="req">*</span></label>
                <?php
                array_unshift($title, '--Select--');
                echo $this->form->input('title', array('label' => false, 'type' => "select", 'empty' => '-- Select --', 'default'=>$rec['title'],'required' => true, 'options' => $title, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4" >
            <div class="parsley-row">
                <label for="surname">Surname <span class="req">*</span></label>
    <?php echo $this->form->input('surname', array('type' => 'text', 'label' => false,'value'=>$rec['surname'], 'required' => true, 'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="firstname">First name <span class="req">*</span></label>
    <?php echo $this->form->input('firstname', array('type' => 'text', 'label' => false, 'value'=>$rec['firstname'],'required' => true, 'class' => "md-input")); ?>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="parsley-row">
                <label for="other_name">Other names </label>
    <?php echo $this->form->input('other_name', array('type' => 'text', 'value'=>$rec['other_name'],'label' => false, 'class' => "md-input")); ?>
            </div>
        </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin></div>
    <div class="uk-grid" data-uk-grid-margin > 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="dob">Date of Birth <span class="req">*</span></label>
    <?php
    echo $this->form->input('dob', array('type' => "text", 'label' => false,'value'=>date("d/m/Y", strtotime($rec['dob'])), 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}',  'class' => "md-input"));
    ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="gender">Gender <span class="req">*</span></label>
    <?php
    echo $this->form->input('gender', array('label' => false, 'type' => "select",'default'=>$rec['gender'], 'empty' => '-- Select --', 'required' => true, 'options' => $gender, 'class' => "md-input", 'data-md-selectize'));
    ?>
            </div>
        </div>

    </div> 
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="ministry">Ministry <span class="req">*</span></label>
                <?php
                echo $this->form->input('ministry', array('label' => false, 'type' => "select", 'default'=>$rec['ministry_id'],'empty' => '-- Select --', 'required' => true, 'options' => $Ministry, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
                $department = $this->common->findDepartmentList();
                echo $this->form->input('department', array('label' => false, 'type' => "select", 'default'=>$rec['department_code'],'empty' => '-- Select --', 'required' => true, 'options' => $department, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        
    </div>
    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Current Designation <span class="req">*</span></label>
                <?php
                $Designation = $this->common->getDesignationList();
                array_unshift($Designation, '--Select--');
                echo $this->form->input('curr_desig', array('label' => false, 'type' => "select", 'default'=>$rec['currenct_designation'],'empty' => '-- Select --', 'required' => true, 'options' => $Designation, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="parsley-row">
                <label for="department">Term of Services <span class="req">*</span></label>
                <?php
                echo $this->form->input('recomm_t_serv', array('label' => false, 'type' => "select", 'empty' => '-- Select --','default'=>$rec['recomm_term_services'], 'required' => true, 'options' => $termServ, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
    </div>

    <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Retirement Grounds <span class="req">*</span></label>
                <?php
                echo $this->form->input('ret_ground', array('label' => false, 'type' => "select", 'default'=>$rec['retirement_ground_id'],'empty' => '-- Select --', 'required' => true, 'options' => $retGround, 'class' => "md-input", 'data-md-selectize'));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Justification</label>
                <?php
                echo $this->form->input('justification', array('label' => false, 'type' => "text",  'value'=>$rec['justification'],'class' => "md-input"));
                ?>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Notes</label>
                <?php
                echo $this->form->input('notes', array('label' => false, 'type' => "text",'value'=>$rec['notes'],'class' => "md-input"));
                ?>
            </div>
        </div>
    </div>
<?php } ?>
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('data_type_detail_list/'.$val) ?>">Cancel</a>                       
                    </div>
                </div>
     <?php echo $this->Form->end();?>
            </div></div></div></div>