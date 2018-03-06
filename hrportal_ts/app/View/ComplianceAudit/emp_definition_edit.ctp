<script>
    function getmdaemail(val) {
        
        if (val != '') { 
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/getMDAemail/' + val,
                success: function (data) {
                    $("#MDA_email").val(data);
                }
            });
        }
    }

    function empl_num(val) {
        if (val == '1') {
            $('#mend').show(); //to show
            $('#emplmnt_number').attr('required', true); //to hide


        } else {
            $('#mend').hide(); //to show
            $('#emplmnt_number').attr('required', false);

        }
    }
    
    function org_name(val) {
        if (val == '1') {
            $('#mda').show(); //to show
            $('#org_name').show(); //to hide
            $("#ministry").attr('required', true);

        } else {
            $('#mda').hide(); //to show
            $('#org_name').show(); //to hide
            $('#MDA_email').val('');
            $("#ministry").val('');
            $("#ministry").attr('disabled', true);
            $("#ministry").attr('required', false);

        }
    }
    
    
     function validateEmail() { 
                var filterValue = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
                var pEmail = $('#MDA_email').val();
                var MDAemail = $('#email').val();
                
                var data = $('#mobile').val();
                  
                    var numbers = /^[0-9]+$/;  
    
                    if(data != ''){
                      if(data.match(numbers)){
                          //return true;
                      }else{
                          alert("Please enter valid mobile number !!");
                            return false;
                      }
                  }
                    
                
               if(pEmail != '' && MDAemail != ''){
                //var name   = pEmail.substring(0, pEmail.lastIndexOf("@"));
                var domain = pEmail.substring(pEmail.lastIndexOf("@") +1);
                
                if (filterValue.test(MDAemail)) {
                    if (MDAemail.indexOf(domain, MDAemail.length - domain.length) != -1)
                    {
                        return true;
                       
                    }
                    else {
                        alert("Email Must be like(yourName@"+domain+"), domain name should be same !");
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            
            
            
            
            
           
    
    var doj = $('#doj').val();
    var doe = $('#doe').val();
    
    
 if(doj!='' && doe!=''){ 
        var date111 = Date.parse(doj);
        var date222 = Date.parse(doe);
        
        if (date111 > date222) {
            alert ("Date of joining should be less than date of exit !!");
            return false;
        }
        
   }
   
}
    
    

</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">

        <h1>Employee Definition</h1>

    </div>


    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                if (!empty($EmployeeDefinition)) {
                    foreach ($EmployeeDefinition as $rec);
                }
                ?>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'emp_definition_edit'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                
                ?>
                <h3 class="heading_a">Definition</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3"  >
                        <div class="parsley-row">
                            <?php echo $this->form->input('emp_define_id', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$rec['CAEmployeeDefinition']['id'],'class'=>"md-input"));?>
                            <label for="t_o_org">Type of Organisation <span class="req">*</span></label>
                            <select name="t_o_org" required="required" onchange="return org_name(this.value)" class="md-input data-md-selectize label-fixed">
                                <option value="">--Select--</option>
                                <?php
                                $t_o_org = array('1'=>'MDA','2'=>'Commission','3'=>'Independent office');
                                foreach ($t_o_org as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['type_of_organisation'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                 
                                ?>
                                
                            </select>

                        </div>
                    </div>
                    <?php if($rec['CAEmployeeDefinition']['type_of_organisation'] == '1'){
                        $display = "style='display:block'";
                        $required = "required='required'";
                    }else{
                        $display = "style='display:none'";
                    }?>
                    <div class="uk-width-medium-1-3" <?=$display;?> id="mda">
                        <div class="parsley-row">
                            <label for="department">MDA <span class="req">*</span></label>
                            <select name="ministry" id="ministry" <?=$required;?>  class="md-input data-md-selectize label-fixed">
                                <?php
                                
                                foreach ($Ministry as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['ministry_id'] == $value ){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                if($rec['CAEmployeeDefinition']['ministry_id']!='' || $rec['CAEmployeeDefinition']['ministry_id']!='0'){
                                    $emailID = $this->Common->getMinistryEmailByID($rec['CAEmployeeDefinition']['ministry_id']);
                                }else{
                                    $emailID = '';
                                }
                                
                                echo $this->form->input('MDA_email', array('type'=>'hidden','id'=>'MDA_email', 'value'=>$emailID, 'label'=>false,'required'=>true,'class'=>"md-input"));
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" id="org_name">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Organisation  Name <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('orgname', array('type' => 'text', 'label' => false, 'required' => true,'value'=>$rec['CAEmployeeDefinition']['organisation_name'], 'class' => "md-input"));
                            
                            ?>                
                        </div>
                    </div>


                </div>

                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="nature_employment">Nature of Employment<span class="req">*</span></label>
                            <select name="nature_employment" required="required" onchange="return empl_num(this.value);" class="md-input data-md-selectize label-fixed">
                                <?php
                                $n_o_e = array('1'=>'Permanent','2'=>'Contract','3'=>'Temporary','4'=>'Out Side Payroll','5'=>'Part Time');
                                foreach ($n_o_e as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['nature_of_employment'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                ?>
                                
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="employment_number" class="fixed">Employment Number <span class="req fixed" id="mend" style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('employment_number', array('type' => 'text','id'=>'emplmnt_number', 'value'=>$rec['CAEmployeeDefinition']['employment_number'] ,'label' => false,  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department" class="fixed">Department </label>
                            <select name="department" id="department"  class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- SELECT --</option>
                                <?php
                                $department= array('1'=>'Depart1','2'=>'Depart2','3'=>'Depart3','4'=>'Depart4');
                                foreach ($department as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['department_id'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                ?>
                                
                            </select>              
                        </div>
                    </div>
                    
                </div>       
                <div  class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="kra_pin" class="fixed">KRA PIN <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('kra_pin', array('type' => 'text', 'label' => false, 'required' => true,'value'=>$rec['CAEmployeeDefinition']['kra_pin'], 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">ID Number <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('id_number', array('type' => 'text', 'label' => false, 'required' => true,'value'=>$rec['CAEmployeeDefinition']['id_number'], 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department" class="fixed">Designation </label>
                            <?php
                            echo $this->form->input('designation', array('type' => 'text', 'label' => false, 'value'=>$rec['CAEmployeeDefinition']['designation_id'], 'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?> 
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin ></div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Salutation <span class="req">*</span></label>
                            <select name="salutation"  required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- SELECT --</option>
                                <?php
                                $saluta= array('1'=>'Dr.','2'=>'Mr.','3'=>'Miss.','4'=>'Mrs.','4'=>'Prof.');
                                
                                foreach ($saluta as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['salutation'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                ?>
                            </select> 
                                               
                        </div>
                    </div>
                   
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Surname </label>
                            <?php
                            echo $this->form->input('srname', array('type' => 'text', 'label' => false,'value'=>$rec['CAEmployeeDefinition']['surname'],  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                     <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">First Name <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('fname', array('type' => 'text', 'label' => false,'required'=>true,'value'=>$rec['CAEmployeeDefinition']['first_name'],  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Other Name </label>
                            <?php
                            echo $this->form->input('oth_name', array('type' => 'text', 'label' => false, 'value'=>$rec['CAEmployeeDefinition']['othername'], 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Birth <span class="req">*</span></label>
                            <?php
                            $dob = date("Y-m-d", strtotime($rec['CAEmployeeDefinition']['dob']));
                            $dateOFBirth = strtotime(date('Y-m-d').' -18 year');
                            $date_OF_Birth = date('Y-m-d', $dateOFBirth);
                            echo $this->form->input('dob', array('type' => "text", 'label' => false, 'id'=>'dob','data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.$date_OF_Birth.'"}', 'required' => true, 'value' => $dob, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Place Of Birth <span class="req">*</span> </label>
                            <?php
                            echo $this->form->input('pob', array('type' => 'text', 'label' => false, 'required' => true,'value'=>$rec['CAEmployeeDefinition']['place_of_birth'],'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Gender <span class="req">*</span></label>
                            <?php 
                                $options = array('0' => 'Male', '1' => 'Female');
                                $attributes = array('legend' => false,'lable'=>false,'default'=>'0','value'=>$rec['CAEmployeeDefinition']['gender']);
                                echo $this->Form->radio('gender', $options, $attributes);
                           ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Joining <span class="req">*</span></label>
                            <?php
                            $doj = date("Y-m-d", strtotime($rec['CAEmployeeDefinition']['date_of_joining']));
                            echo $this->form->input('doj', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date("Y-m-d").'"}', 'value' => $doj, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Exit(Resignation) </label>
                            <?php
                            if($rec['CAEmployeeDefinition']['date_of_exit']!=''){
                            $doe = date("Y-m-d", strtotime($rec['CAEmployeeDefinition']['date_of_exit']));
                            }else{
                              $doe = '';  
                            }
                            echo $this->form->input('doe', array('type' => "text", 'label' => false,  'data-uk-datepicker' => '{format:"YYYY-MM-DD"}', 'value' => $doe, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department" class="fixed">Marital Status <span class="req">*</span></label>
                            <select name="marital_status"  required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <?php
                                if($dependentExist == '1'){
                                    $mar_status= array('1'=>'Married');
                                }elseif($dependentExist == '0'){
                                    $mar_status= array('1'=>'Married','2'=>'Single');
                                }
                                
                                foreach ($mar_status as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAEmployeeDefinition']['marital_status'] == $value){
                                        echo "<option value='" . $value . "' selected='selected'>" . $option . "</option>";
                                    }else{
                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                    }
                                }
                                ?>
                            </select>              
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Official Email Address <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('email', array('type' => "email", 'id'=>'email', 'onblur'=>'return validateEmail()', 'label' => false,'value'=>$rec['CAEmployeeDefinition']['official_email'], 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Employee Mobile Number </label>
                            <?php
                            echo $this->form->input('mobile', array('type' => 'text','id'=>'mobile' , 'maxlength'=>'10','label' => false,'value'=>$rec['CAEmployeeDefinition']['emp_mobile'],  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin ></div>
                <div class="uk-grid" data-uk-grid-margin >
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">Physical Address </label>
                            <?php echo $this->form->textarea('phy_add', array('label' => false,'value'=>$rec['CAEmployeeDefinition']['physical_add'],  'class' => "md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">Postal Address </label>
                            <?php echo $this->form->textarea('post_add', array('label' => false, 'value'=>$rec['CAEmployeeDefinition']['postal_add'],'class' => "md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">Employee Status </label>
                            <?php 
                                $options = array('0' => 'Active', '1' => 'Inactive');
                                $attributes = array('legend' => false,'lable'=>false,'default'=>'0','value'=>$rec['CAEmployeeDefinition']['emp_status']);
                                echo $this->Form->radio('emp_status', $options, $attributes);
                           ?>
                        </div>
                    </div>
                </div> 
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" onclick="return validateEmail();" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/emp_definition') ?>">Cancel</a>                       
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>