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
            $("#ministry").val('');
            $('#MDA_email').val('');
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
                if (!empty($EditCaseReceive)) {
                    foreach ($EditCaseReceive as $rec)
                        ;
                }
                ?>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'emp_definition_save'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                ?>
                <h3 class="heading_a">Definition</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3"  >
                        <div class="parsley-row">
                            <label for="t_o_org">Type of Organisation <span class="req">*</span></label>
                            <select name="t_o_org" required="required" onchange="return org_name(this.value)" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <option value="1">MDA</option>
                                <option value="2">Commission</option>
                                <option value="3">Independent office</option>
                            </select>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" style="display:none" id="mda">
                        <div class="parsley-row">
                            <label for="department">MDA <span class="req">*</span></label>
                            <select name="ministry" id="ministry" onchange="getmdaemail(this.value)" required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <?php
                                foreach ($Ministry as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;

                                    echo "<option value='" . $value . "'>" . $option . "</option>";
                                }
                                echo $this->form->input('MDA_email', array('type'=>'hidden','id'=>'MDA_email','label'=>false,'required'=>true,'class'=>"md-input"));
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" style="display:none" id="org_name">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Organisation  Name <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('orgname', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
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
                                <option value="">-- Select --</option>
                                <option value="1">Permanent</option>
                                <option value="2">Contract</option>
                                <option value="3">Temporary</option>
                                <option value="4">Out Side Payroll</option>
                                <option value="5">Part Time</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="employment_number" class="fixed">Employment Number <span class="req fixed" id="mend" style="display: none">*</span></label>
                            <?php
                            echo $this->form->input('employment_number', array('type' => 'text','id'=>'emplmnt_number', 'label' => false,  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department" class="fixed">Department </label>
                            <select name="department" id="department"  class="md-input data-md-selectize label-fixed">
                                <option value="">-- Select --</option>
                                <option value="1">Depart1</option>
                                <option value="2">Depart2</option>
                                <option value="3">Depart3</option>
                                <option value="4">Depart4</option>
                                <?php
//                                foreach ($department as $key => $rt) {
//                                    $value = $key;
//                                    $option = $rt;
//
//                                    echo "<option value='" . $value . "'>" . $option . "</option>";
//                                }
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
                            echo $this->form->input('kra_pin', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">ID Number <span class="req fixed">*</span></label>
                            <?php
                            echo $this->form->input('id_number', array('type' => 'text', 'label' => false, 'required' => true, 'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department" class="fixed">Designation </label>
                            <?php
                            echo $this->form->input('designation', array('type' => 'text', 'label' => false,  'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')",'class' => "md-input"));
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
                            <select name="salutation" required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <option value="1">Dr.</option>
                                <option value="2">Mr.</option>
                                <option value="3">Miss.</option>
                                <option value="4">Mrs.</option>
                                <option value="4">Prof.</option>
                                
                            </select> 
                                           
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Surname </label>
                            <?php
                            echo $this->form->input('srname', array('type' => 'text', 'label' => false,  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">First Name <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('fname', array('type' => 'text','required'=>true, 'label' => false,  'class' => "md-input"));
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
                            echo $this->form->input('oth_name', array('type' => 'text', 'label' => false,  'class' => "md-input"));
                            //echo $this->form->input('refnum', array('type'=>'hidden','label'=>false,'required'=>true,'value'=>$RefNum,'class'=>"md-input"));
                            ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Birth <span class="req">*</span></label>
                            <?php
                            $dateOFBirth = strtotime(date('Y-m-d').' -18 year');
                            $date_OF_Birth = date('Y-m-d', $dateOFBirth);
                            echo $this->form->input('dob', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.$date_OF_Birth.'"}', 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Place Of Birth <span class="req">*</span> </label>
                            <?php
                            echo $this->form->input('pob', array('type' => 'text', 'label' => false, 'required' => true,'class' => "md-input"));
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
                                $attributes = array('legend' => false,'lable'=>false,'default'=>'0');
                                echo $this->Form->radio('gender', $options, $attributes);
                           ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Joining <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('doj', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"YYYY-MM-DD",maxDate:"'.date("Y-m-d").'"}',  'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Date of Exit(Resignation)</label>
                            <?php
                            echo $this->form->input('doe', array('type' => "text", 'label' => false,  'data-uk-datepicker' => '{format:"YYYY-MM-DD"}',  'class' => "md-input"));
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
                            <select name="marital_status" required="required"  class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <option value="1">Married</option>
                                <option value="2">Single</option>
                                
                            </select>              
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor">Official Email Address <span class="req">*</span></label>
                            <?php
                            echo $this->form->input('email', array('type' => "email", 'id'=>'email','onblur'=>'return validateEmail()', 'required'=>true,'label' => false, 'class' => "md-input"));
                            ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Employee Mobile Number </label>
                            <?php
                            echo $this->form->input('mobile', array('type' => 'text', 'id'=>'mobile', 'label' => false, 'maxlength'=>'10',  'class' => "md-input"));
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
                            <?php echo $this->form->textarea('phy_add', array('label' => false,  'class' => "md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">Postal Address </label>
                            <?php echo $this->form->textarea('post_add', array('label' => false, 'class' => "md-input")); ?>                
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">Employee Status </label>
                            <?php 
                                $options = array('0' => 'Active', '1' => 'Inactive');
                                $attributes = array('legend' => false,'lable'=>false,'default'=>'0');
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
