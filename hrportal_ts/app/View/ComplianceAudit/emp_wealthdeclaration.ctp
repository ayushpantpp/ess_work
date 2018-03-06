<script>
    
        $( window ).on( "load", function() {
        $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/emp_wealthdeclaration_selfform/1',
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                   
                    $("#allform").html(data);
                     $("#formid").val('2');
                }
            });
    });
    
    
function replaceFrom(val){

        if (val == '0') {
            //alert(val);
             
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/emp_wealthdeclaration_selfform/1',
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#allform").html(data);
                    $("#formid").val('2');
                }
            });
            
            $('#addmoreform').hide(); 
            $('#removemoreform').hide(); 
        }else if (val == '1') {
        $("#formid").val('1'); 
        var empid= $("#emp_difin_id").val();
          var  form_id= $("#formid").val();
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/emp_wealthdeclaration_spouseform/'+form_id+'/'+empid,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    form_id++;
                    $("#formid").val(form_id);
                    $("#allform").html(data);
                    
                }
            });
            
            $('#addmoreform').show(); 
            $('#removemoreform').show(); 
        }else if(val == '2'){
        $("#formid").val('1'); 
         var empid= $("#emp_difin_id").val();
        var  form__id= $("#formid").val();
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/emp_wealthdeclaration_childrenform/'+form__id+'/'+empid,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    $("#allform").html(data);
                    form__id++;
                    $("#formid").val(form__id);
                }
            });
            
            $('#addmoreform').show(); 
            $('#removemoreform').show(); 
        }else{
            $('#addmoreform').hide(); 
            $('#removemoreform').hide();
        }
        
}

function addFrom(){

         var formid= $("#formid").val();
         var val = $('input[name="data[ComplianceAudit][wealth_depnd_type]"]:checked').val();
         var empid= $("#emp_difin_id").val();
         var formname = '';
        if (val == '1') {
           formname = 'spouseform';
        }else if(val == '2'){
           formname = 'childrenform';
        }
        
        
            $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>ComplianceAudit/emp_wealthdeclaration_'+formname+'/'+formid+'/'+empid,
                //data:'project_id='+val,
                success: function (data) {
                    //alert(data);
                    formid++;
                    $("#allform").append(data);
                    $("#formid").val(formid);
                }
            });
          
    }
    
    function remove(){
    var counte = ($("#formid").val()-1);
    //alert(counte-1);
    if (counte > 1) { 
            
            $('#allform div#allform'+counte+'').last().remove();
            counte--;
            $("#formid").val(counte);
        }else {
            alert("You cannot delete first form !");
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
            $("#ministry").attr('disabled', true);
            $("#ministry").attr('required', false);

        }
    }

function ShowDet(val){ 
   // alert(val);
        //var val=jQuery("#type").val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>ComplianceAudit/show_wealth_declaration/' + val,
            //data:'project_id='+val,
            success: function (data) {
                $("#showdata").html(data);
                
            }
        });
        
    }

</script>

<div id="page_content">
    <div class="uk-modal" id="modal_large">
                                <div class="uk-modal-dialog uk-modal-dialog-large" >
                                    <button type="button" class="uk-modal-close uk-close"></button>
                                    <div id="showdata"></div>
                                </div>
                            </div>
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">

        <h1>Wealth Declaration</h1>

    </div>


    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">  
            <div class="md-card-content large-padding">
                <?php
                if (!empty($EmployeeDefinition)) {
                    foreach ($EmployeeDefinition as $rec)
                        ;
                }
//                echo "<pre>";
//                print_r($rec);
                ?>
                <?php
                echo $this->Form->create('ComplianceAudit', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'emp_wealthdeclaration'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                echo $this->form->input('emp_difin_id', array('type' => 'hidden', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['id'], 'class' => "md-input"));
                ?>
                <div class="md-card-content uk-margin-bottom">
                    <h3 class="heading_a uk-margin-bottom">Declaration of Income,Assets & Liabilities</h3>
                    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-4">
                            <div class="md-input-wrapper md-input-filled">
                                <label for="dor" class="label-fixed">Declaration Type<span class="req">*</span></label>
                                <?php
                                $option = array('1' => 'Initial', '2' => 'Benial', '3' => 'Final');
                                echo $this->form->input('declar_type', array('type' => "select", 'label' => false, 'options' => $option,'default'=>$FormAccessFor, 'empty' => '--Select--', 'required' => true, 'class' => "md-input label-fixed"));
                                ?>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3"></div>
                        <div class="uk-width-medium-1-4">
                            <div class="md-input-wrapper md-input-filled">
                                <?php
                                if (!empty($EmpWealthDecla)) { ?>
                                <span class="md-btn md-btn-primary" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet('<?php echo $emp_difin_id;?>')">View Your Declaration</span>
                                <?php } ?>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="uk-grid" data-uk-grid-margin ></div>
                    <div class="uk-accordion" data-uk-accordion="{ collapse: false }">
                        <h3 class="uk-accordion-title">Personal Information <font color="red" size="1"> (Note: Add/Edit Information, Go to Employee Definition)</font></h3>
                        <div class="uk-accordion-content">
                            <p>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">First Name </label>
                                        <?php
                                        echo $this->form->input('fname', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['first_name'], 'class' => "md-input"));
                                        ?>  
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Surname Name </label>
                                        <?php
                                        echo $this->form->input('surname', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['surname'], 'class' => "md-input"));
                                        ?>  
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Other Name </label>
                                        <?php
                                        echo $this->form->input('othername', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['othername'], 'class' => "md-input"));
                                        ?>  
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Date of Birth </label>
                                        <?php
                                        echo $this->form->input('dob', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => date("d/m/Y", strtotime($rec['CAEmployeeDefinition']['dob'])), 'class' => "md-input"));
                                        ?>  
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Place of Birth</label>
                                        <?php
                                        echo $this->form->input('pob', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['place_of_birth'], 'class' => "md-input"));
                                        ?>  
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-3">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Marital Status </label>
                                        <?php
                                        if ($rec['CAEmployeeDefinition']['marital_status'] == '1') {
                                            echo $this->form->input('m_status', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => 'Married', 'class' => "md-input"));
                                        } elseif ($rec['CAEmployeeDefinition']['marital_status'] == '2') {
                                            echo $this->form->input('m_status', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => 'Single', 'class' => "md-input"));
                                        }
                                        ?>  
                                    </div>
                                </div>

                            </div>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Postal Address </label>
<?php echo $this->form->textarea('post_add', array('label' => false, 'disabled' => 'disabled', 'value' => $rec['CAEmployeeDefinition']['postal_add'], 'class' => "md-input")); ?>                 
                                    </div>
                                </div>

                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Physical Address</label>
<?php echo $this->form->textarea('post_add', array('label' => false, 'disabled' => 'disabled', 'value' => $rec['CAEmployeeDefinition']['physical_add'], 'class' => "md-input")); ?>                 
                                    </div>
                                </div>
                            </div>

                            </p>
                        </div>
                        <h3 class="uk-accordion-title">Employment Information <font color="red" size="1"> (Note: Add/Edit Information, Go to Employee Definition)</font></h3>
                        <div class="uk-accordion-content">
                            <p>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-4">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Employment Number </label>
<?php
echo $this->form->input('empl_num', array('type' => 'text', 'disabled' => 'disabled', 'value' => $rec['CAEmployeeDefinition']['employment_number'], 'label' => false, 'class' => "md-input"));
?>  
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-4">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="desg" class="fixed">Designation </label>
<?php
echo $this->form->input('desg', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['designation_id'], 'class' => "md-input"));
?>  
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-4">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="name_employer" class="fixed">Name of Employer </label>
<?php
echo $this->form->input('name_employer', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CAEmployeeDefinition']['organisation_name'], 'class' => "md-input"));
?>  
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-4">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="n_employee" class="fixed">Nature of Employment </label>
                                        <?php
                                        if ($rec['CAEmployeeDefinition']['nature_of_employment'] == '1') {
                                            echo $this->form->input('name_employer', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => 'Permanent', 'class' => "md-input"));
                                        } elseif ($rec['CAEmployeeDefinition']['nature_of_employment'] == '2') {
                                            echo $this->form->input('name_employer', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => 'Contract', 'class' => "md-input"));
                                        } elseif ($rec['CAEmployeeDefinition']['nature_of_employment'] == '3') {
                                            echo $this->form->input('name_employer', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => 'Temporary', 'class' => "md-input"));
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            </p>
                        </div>
                        <h3 class="uk-accordion-title">Name of Spouse or Spouses </h3>
                        <div class="uk-accordion-content">
                            <p>

                                <?php
                                $total = count($rec['CADependentDetails']);
                                for ($i = 0; $i < $total; $i++) {
                                    if ($rec['CADependentDetails'][$i]['dependent_type'] == '1' && $rec['CADependentDetails'][$i]['depend_status'] == '1') {
                                        echo $this->form->input('wealth_dependent_type.', array('type' => 'hidden', 'label' => false, 'value' => '1', 'class' => "md-input"));
                                        echo $this->form->input('wealth_dependent_id.', array('type' => 'hidden', 'label' => false, 'value' => $rec['CADependentDetails'][$i]['id'], 'class' => "md-input"));
                                        ?>
                                    <div class="uk-grid" data-uk-grid-margin > 
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Surname </label>
        <?php
        echo $this->form->input('surname', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CADependentDetails'][$i]['surname'], 'class' => "md-input"));
        ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">First Name </label>
        <?php
        echo $this->form->input('fname', array('type' => 'text', 'disabled' => 'disabled', 'value' => $rec['CADependentDetails'][$i]['fname'], 'label' => false, 'class' => "md-input"));
        ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Other Name </label>
        <?php
        echo $this->form->input('othername', array('type' => 'text', 'disabled' => 'disabled', 'value' => $rec['CADependentDetails'][$i]['othername'], 'label' => false, 'class' => "md-input"));
        ?>  
                                            </div>
                                        </div>
                                    </div> 
    <?php }
} ?>
                            </p>
                        </div>
                        <h3 class="uk-accordion-title">Name of Dependent Children</h3>
                        <div class="uk-accordion-content">
                            <p>
                                <?php
                                $total = count($rec['CADependentDetails']);
                                for ($i = 0; $i < $total; $i++) {
                                    if ($rec['CADependentDetails'][$i]['dependent_type'] == '2'  && $rec['CADependentDetails'][$i]['depend_status'] == '1') {
                                        echo $this->form->input('wealth_dependent_type.', array('type' => 'hidden', 'label' => false, 'value' => '2', 'class' => "md-input")); 
                                        echo $this->form->input('wealth_dependent_id.', array('type' => 'hidden', 'label' => false, 'value' => $rec['CADependentDetails'][$i]['id'], 'class' => "md-input"));
                                        ?>
                                    <div class="uk-grid" data-uk-grid-margin > 
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Surname </label>
        <?php
        echo $this->form->input('surname', array('type' => 'text', 'disabled' => 'disabled', 'label' => false, 'value' => $rec['CADependentDetails'][$i]['surname'], 'class' => "md-input"));
        ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">First Name </label>
        <?php
        echo $this->form->input('fname', array('type' => 'text', 'disabled' => 'disabled', 'value' => $rec['CADependentDetails'][$i]['fname'], 'label' => false, 'class' => "md-input"));
        ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Other Name </label>
                                    <?php
                                    echo $this->form->input('othername', array('type' => 'text', 'disabled' => 'disabled', 'value' => $rec['CADependentDetails'][$i]['othername'], 'label' => false, 'class' => "md-input"));
                                    ?>  
                                            </div>
                                        </div>
                                    </div>
                                    <?php }
                                } ?>
                            </p>
                        </div>
                        <h3 class="uk-accordion-title">Financial Statement<font color="red" size="1"> (*)</font></h3>
                        <div class="uk-accordion-content" id="finan_stat">
                            <p>
                                <?php
                                if (!empty($EmpWealthDecla)) {
                                    foreach ($EmpWealthDecla as $welthrec)
                                        ;
                                    echo $this->form->input('wealthdecla_id', array('type' => 'hidden', 'required' => true, 'value' => $welthrec['CAWealthdeclaration']['id'], 'label' => false, 'class' => "md-input"));
                                }
                                ?>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Financial Statement For: <span class="req">*</span></label>
<?php
echo $this->form->input('financial_stmnt', array('type' => 'text', 'required' => true, 'value' => $rec['CAEmployeeDefinition']['first_name'] . " " . $rec['CAEmployeeDefinition']['surname'], 'label' => false, 'readonly' => true, 'class' => "md-input"));
?> 
                                        <span class="uk-form-help-block">(A separate statement is required for the officer, each spouse and dependent child under the age of 18 years.
                                            Additional sheets should be added as required)</span>
                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="dor">Statement Date<span class="req">*</span></label>
<?php
//                                        if($welthrec['CAWealthdeclaration']['satement_date']){
//                                        $satement_date = date("d/m/Y", strtotime($welthrec['CAWealthdeclaration']['satement_date']));
//                                        }
echo $this->form->input('stmnt_date', array('type' => "text", 'label' => false, 'required' => true, 'value' => $StatmentDate, 'readonly' => true, 'class' => "md-input"));
?>
                                        <span class="md-input-bar"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin > </div>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Income,including emoluments, for period </label>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">From </label>
                                        <?php
                                        if ($welthrec['CAWealthdeclaration']['period_from'] != "") {
                                            $p_from = date("d/m/Y", strtotime($welthrec['CAWealthdeclaration']['period_from']));
                                        }
                                        if ($welthrec['CAWealthdeclaration']['period_to'] != "") {
                                            $p_to = date("d/m/Y", strtotime($welthrec['CAWealthdeclaration']['period_to']));
                                        }

                                        echo $this->form->input('from_date', array('type' => "text", 'label' => false, 'value' => $p_from, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
                                        ?>  


                                    </div>
                                </div>
                                <div class="uk-width-medium-1-2">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">To </label>
<?php
echo $this->form->input('to_date', array('type' => "text", 'label' => false, 'value' => $p_to, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'class' => "md-input"));
?>  
                                    </div>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin >  </div>

                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-2">
                                    
                                        <label for="fname" class="fixed">Declaration For</label>
                                        <?php 
                                        if($rec['CAEmployeeDefinition']['marital_status']=='1'){
                                        $options = array('0' => 'Self', '1' => 'Spouse', '2' => 'Children');
                                        }elseif($rec['CAEmployeeDefinition']['marital_status']=='2'){
                                        $options = array('0' => 'Self');        
                                        }
                                
                                $attributes = array('legend' => false,'id'=>'declarFor','lable'=>false,'default'=>'0','onclick'=>'replaceFrom(this.value)');
                                echo $this->Form->radio('wealth_depnd_type', $options, $attributes);
                               
                           ?>
                                </div>
                            </div>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-1"><hr> </div>
                            </div>
                            <div id="allform">
                            </div>
                            <div class="uk-grid" data-uk-grid-margin ></div>
                         <div class="uk-grid" data-uk-grid-margin >
                             <div class="uk-width-medium-1-1">
                                 <input type="hidden" id="formid" name="tot_form" value="1">
                                 <input type='button' class="md-btn md-btn-primary" style="display: none"  value='Add More Statement' onclick="return addFrom();" id='addmoreform'>
                                 <input type='button' class="md-btn md-btn-danger" style="display: none" value='Remove' onclick="return remove();" id='removemoreform'>
                            </div>
                        </div>
                        </div>
                        
                        <h3 class="uk-accordion-title">Other information that may be useful or relevant</h3>
                        <div class="uk-accordion-content">
                            <p>
                            <div class="uk-width-medium-1-1">
                                <div class="md-input-wrapper md-input-filled">
                                    <label for="fname" class="fixed">Write Here </label>
                                    <?php echo $this->form->textarea('info', array('label' => false, 'value' => $welthrec['CAWealthdeclaration']['other_info'], 'class' => "md-input")); ?>                  
                                </div>
                            </div>
                            </p>
                        </div> 
                        <div class="uk-grid" data-uk-grid-margin > </div>
                        <div class="uk-grid" data-uk-grid-margin > 
                            <div class="uk-width-medium-1-2">
                                <div class="md-input-wrapper md-input-filled">
                                    <label for="dor">Declaration Date</label>
<?php
//if ($welthrec['CAWealthdeclaration']['declaration_date'] != "") {
//    $declaration_date = date("d-m-Y", strtotime($welthrec['CAWealthdeclaration']['declaration_date']));
//    echo $this->form->input('declar_date', array('type' => "text", 'label' => false, 'required' => true, 'data-uk-datepicker' => '{format:"DD-MM-YYYY"}', 'value' => $declaration_date, 'class' => "md-input"));
//} else {
    echo $this->form->input('declar_date', array('type' => "text", 'label' => false, 'required' => true, 'value'=>date('d-m-Y'),'readonly'=>true, 'class' => "md-input"));
//}
?>
                                    <span class="md-input-bar"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#" onclick="return confirm_Action();">Save</button>                    
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

<script  type="text/javascript">
function confirm_Action() {
    
    

        var cout = '0';
        $(".declar_depend_type").each(function (i,el1) {
        var current_val = $(el1).val();
        
        if (current_val != "") {
            $(".declar_depend_type").each(function (i,el2) {
                if ($(el2).val() == current_val && $(el1).attr("name") != $(el2).attr("name")) {
                    alert('Please select unique dependent name !');
                    cout = '1';
                    return false;
                }
            });
        }
        if(cout == '1'){
            return false;
        }
    }); 
        if(cout == '1'){
            return false;
        }
        
        
        $(".desc1").each(function () {
            var maxLength = 500;
            var text = $(this).val();
            var textLength = text.length;
            if (textLength > maxLength) {
                $(this).val(text.substring(0, (maxLength)));
                alert("Sorry, you only " + maxLength + " characters are allowed in description !");
                return false;
            }
            else {
                //alert("Required Min. 500 characters");
            }
        });

        $(".desc_2").each(function () {
            var maxLength = 500;
            var text = $(this).val();
            var textLength = text.length;
            if (textLength > maxLength) {
                $(this).val(text.substring(0, (maxLength)));
                alert("Sorry, you only " + maxLength + " characters are allowed in description !");
                return false;
            }
            else {
                //alert("Required Min. 500 characters");
            }
        });

        $(".desc_3").each(function () {
            var maxLength = 500;
            var text = $(this).val();
            var textLength = text.length;
            if (textLength > maxLength) {
                $(this).val(text.substring(0, (maxLength)));
                alert("Sorry, you only " + maxLength + " characters are allowed in description !");
                return false;
            }
            else {
                //alert("Required Min. 500 characters");
            }
        });

        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
        var errflag = 0;
        $(".aprox_amt1").each(function () {
            var aprox_amt = $(this).val();
            if (aprox_amt != '') {
                if (numberRegex.test(aprox_amt)) {
                    return true;
                } else {
                    errflag++;
                    alert("Please enter number only for amount !!");
                    return false;
                }
            }
        });



        $(".aprox_amt_2").each(function () {
            var aprox_amt_2 = $(this).val();
            if (aprox_amt_2 != '') {
                if (numberRegex.test(aprox_amt_2)) {
                    return true;
                } else {
                    errflag++;
                    alert("Please enter number only for amount!!");
                    return false;
                }
            }
        });
        $(".aprox_amt_3").each(function () {
            var aprox_amt_3 = $(this).val();
            if (aprox_amt_3 != '') {
                if (numberRegex.test(aprox_amt_3)) {
                    return true;
                } else {
                    errflag++;
                    alert("Please enter number only for amount!!");
                    return false;
                }
            }
        });

        if (errflag > 0) {
            return false;
        }

    } 
    
</script>