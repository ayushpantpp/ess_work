<script>
    function req_field(val) {
        if (val == '1') {
            $('#mend').show(); //to show
            $('#feedback').attr('required', true); //to hide


        } else {
            $('#mend').hide(); //to show
            $('#feedback').attr('required', false);

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
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">

        <h1>Employee Wealth Declaration</h1>

    </div>


    <div id="page_content_inner">
        <div class="uk-modal" id="modal_large">
                                <div class="uk-modal-dialog uk-modal-dialog-large" >
                                    <button type="button" class="uk-modal-close uk-close"></button>
                                    <div id="showdata"></div>
                                </div>
                            </div>
        <div class="md-card">
<?php
//echo "<pre>";
//print_r($EmpWealthDecla);
if(!empty($EmpWealthDecla)){
foreach ($EmpWealthDecla as $rec){
        //$heding = '';
    if($rec['CAWealthdeclaration']['declaration_type'] == '1'){
        $declType = '1';
        $heding = "Initial Declaration";
    }elseif($rec['CAWealthdeclaration']['declaration_type'] == '2'){
        $declType = '2';
        $heding = "Benial Declaration";
    }if($rec['CAWealthdeclaration']['declaration_type'] == '3'){
        $declType = '3';
        $heding = "Final Declaration";
    }
    
    
?>
            <div class="md-card-content large-padding">
             
                <div class="md-card-content uk-margin-bottom">
                    <div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-4">
                            <div class="md-input-wrapper md-input-filled">
                                <h2><u><?php echo $heding; ?></u></h2>
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3"></div>
                        <div class="uk-width-medium-1-4">
                            <div class="md-input-wrapper md-input-filled">
                                <?php
                                if (!empty($EmpWealthDecla)) { ?>
                                <span class="md-btn md-btn-primary" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet('<?php echo $emp_difin_id;?>')">View All Declaration</span>
                                <?php } ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="uk-grid" data-uk-grid-margin ></div>
                    <div class="uk-accordion" >
                        <h3 class="uk-accordion-title">Name of Spouse or Spouses </h3>
                        <div class="uk-accordion-content">
                            
                            <?php
                            if($rec['CAWealthdeclaration']['declaration_type'] == $declType){
                                 $total = count($rec['CAWealthdeclarationDependents']);
                              
                                for ($i = 0; $i < $total; $i++) {
                                    if ($rec['CAWealthdeclarationDependents'][$i]['wealth_dependent_type'] == '1') {
                                        $depe_name = $this->Common->getCAgetdependentsByID($rec['CAWealthdeclarationDependents'][$i]['dependents_id']);
                                        ?>
                                    <div class="uk-grid" data-uk-grid-margin > 
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Surname </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['surname'];
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">First Name </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['fname'];
                                            ?> 
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Other Name </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['othername'];
                                            ?> 
                                            </div>
                                        </div>
                                    </div> 
                            <div class="uk-grid" data-uk-grid-margin ></div>
                            <?php }} } ?>
                            
                        </div>
                        <h3 class="uk-accordion-title">Name of Dependent Children</h3>
                        <div class="uk-accordion-content">
                             <?php
                            if($rec['CAWealthdeclaration']['declaration_type'] == $declType){
                                 $total = count($rec['CAWealthdeclarationDependents']);
                              
                                for ($i = 0; $i < $total; $i++) {
                                    if ($rec['CAWealthdeclarationDependents'][$i]['wealth_dependent_type'] == '2') {
                                        $depe_name = $this->Common->getCAgetdependentsByID($rec['CAWealthdeclarationDependents'][$i]['dependents_id']);
                                        ?>
                                    <div class="uk-grid" data-uk-grid-margin > 
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Surname </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['surname'];
                                            ?>  
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">First Name </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['fname'];
                                            ?> 
                                            </div>
                                        </div>
                                        <div class="uk-width-medium-1-3">
                                            <div class="md-input-wrapper md-input-filled">
                                                <label for="fname" class="fixed">Other Name </label>
                                                <br>
                                            <?php
                                             echo $depe_name['CADependentDetails']['othername'];
                                            ?> 
                                            </div>
                                        </div>
                                    </div> 
                            <div class="uk-grid" data-uk-grid-margin ></div>
                            <?php }} } ?>
                        </div>
                        <?php if(!empty($rec['CAWealthAssets'])){?>
                        <hr>
                        <h3 class="heading_a uk-margin-bottom">Declaration of Income,Assets & Liabilities</h3>
                        <?php 
                        
                        $selfname = '1';
                        $spousename = '1';
                        $childrenname = '1';
                   
                        
                        $assets_spouse = '1';
                        $libilit_spouse = '1';
                        $emulments_self = '1';
                        $assets_self = '1';
                        $libilit_self = '1';
                        
                        $assets_child = '1';
                        $libilit_child = '1';

                        foreach($rec['CAWealthAssets'] as $AssestRec){
                            $emulments_spouse = '1';
                            $emulments_child = '1';
                        if($AssestRec['wealth_dependent_type']=='0'){
                            
                            if($selfname == '1'){
                                unset($selfname);
                            ?>
                        <h3 class="uk-accordion-title">Declaration For SELF</h3>
                        <?php }?>
                        <div class="uk-accordion-content">
                            <?php 
                            
                            if($AssestRec['assets_for'] == '1'){ 
                                
                                if($emulments_self == '1'){
                                    unset($emulments_self);
                                ?>
                            
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">(including, but not limited to, salary and emoluments and income from investment.
                                        The period is from the previous statement date to the current statement date. For an initial declaration, 
                                        the period is the year ending on the statement date.)</span>
                                </div>
                            </div>
                                <?php } ?>
                            <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                </div>
                            </div>
                                    <?php 
                                
                                }elseif($AssestRec['assets_for'] == '2'){ 
                                    if($assets_self == '1'){
                                        unset($assets_self);
                                    ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Assets(as of the statement date)</label>
                                        <span class="uk-form-help-block">(Including, but not limited to, land, buildings, vehicles, investment and financial obligations
                                            owed to the person for whom the statement is made)</span>
                                    </div>
                                </div>
                            </div>
                            
                                <?php } ?>
                            <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                              <?php }elseif($AssestRec['assets_for'] == '3'){ 
                                  if($libilit_self == '1'){
                                    unset($libilit_self);
                                  ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Liabilities(as of the statement date)</label>
                                    </div>
                                </div>
                            </div>
                                  <?php  } ?>
                                      <br>
                                      <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                                      <?php } ?>
                            
                            

                        </div>
                        <?php }elseif($AssestRec['wealth_dependent_type']=='1'){ 
                            
                            if($spousename == '1'){
                                unset($spousename);
                            ?>
                        <br>
                        <h3 class="uk-accordion-title">Declaration For SPOUSES</h3>
                        <?php }
                        
                        if($AssestRec['declare_dependent_type']%2!=0){
                            $class = "style='background-color: #FAFAFA; border: 10px solid #FAFAFA'";
                        }else{
                            $class = "style='background-color: white; border: 10px solid white'";
                        }
                        ?>
                        <div class="uk-accordion-content" <?= $class;?> >
                                
                                       <?php 
                                       if($spousedependname != $AssestRec['declare_dependent_type']){
                                           $spousedependname = $AssestRec['declare_dependent_type'];
                                                   
                                        $emulments_spouse1 = '';
                                        $assets_spouse1 = '';
                                        $libilit_spouse1 = '';
                                                   
                                       
                                       ?>
                                    <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">Spouse Name : 
                                       <?php 
                                       $spouse_name = $this->Common->getCAgetdependentsByID($spousedependname);
                                      echo  $spouse_name['CADependentDetails']['fname']." ".$spouse_name['CADependentDetails']['surname']." ".$spouse_name['CADependentDetails']['othername'];;
                                       ?></span>
                                </div>
                            </div>
                                    
                                  
                            
                            <?php 
                                       }
                            
                            if($AssestRec['assets_for'] == '1'){ 
                                
                                if($spousedependname == $AssestRec['declare_dependent_type']){
                            
                            if($emulments_spouse == '1' && $emulments_spouse1 == '' ){
                                    $emulments_spouse1++;
                                ?>
                            
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">(including, but not limited to, salary and emoluments and income from investment.
                                        The period is from the previous statement date to the current statement date. For an initial declaration, 
                                        the period is the year ending on the statement date.)</span>
                                </div>
                            </div>
                            <?php } }else{
                                    unset($emulments_spouse1);
                                    unset($emulments_spouse);
                                } ?>
                            <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                </div>
                            </div>
                                    <?php 
                                
                                }elseif($AssestRec['assets_for'] == '2'){ 
                                       
                                  if($spousedependname == $AssestRec['declare_dependent_type']){
                           
                            if($assets_spouse == '1' && $assets_spouse1 == '' ){  
                                    $assets_spouse1++;
                                ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Assets(as of the statement date)</label>
                                        <span class="uk-form-help-block">(Including, but not limited to, land, buildings, vehicles, investment and financial obligations
                                            owed to the person for whom the statement is made)</span>
                                    </div>
                                </div>
                            </div>
                            
                                <?php } }else{
                                    unset($assets_spouse1);
                                    unset($assets_spouse);
                                } ?>
                            <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                              <?php }elseif($AssestRec['assets_for'] == '3'){ 
                                  if($spousedependname == $AssestRec['declare_dependent_type']){
                            
                            if($libilit_spouse == '1' && $libilit_spouse1 == '' ){
                                    $libilit_spouse1++;
                                ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Liabilities(as of the statement date)</label>
                                    </div>
                                </div>
                            </div>
                                  <?php  } }else{
                                    unset($libilit_spouse1);
                                    unset($libilit_spouse);
                                } ?>
                                      <br>
                                      <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr >
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                                      <?php } ?>
                            
                            

                        </div>
                      <?php  }elseif($AssestRec['wealth_dependent_type']=='2'){
                            
                            if($childrenname == '1'){
                                unset($childrenname);
                            ?>
                        <br>
                        <h3 class="uk-accordion-title">Declaration For CHILDREN</h3>
                        <?php }  
                        if($AssestRec['declare_dependent_type']%2!=0){
                            $class = "style='background-color: #FAFAFA; border: 10px solid #FAFAFA'";
                        }else{
                            $class = "style='background-color: white; border: 10px solid white'";
                        }
                        ?>
                        <div class="uk-accordion-content" <?= $class;?> >
                            <?php 
                               if($childname != $AssestRec['declare_dependent_type']){
                               $childname = $AssestRec['declare_dependent_type'];
                               $emulments_child1 = '';
                               $assets_child1 = '';
                               $libilit_child1 = '';
                            ?>
                        <hr>
                        
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">Child Name : 
                                       <?php 
                                       $child_name = $this->Common->getCAgetdependentsByID($childname);
                                      echo  $child_name['CADependentDetails']['fname']." ".$child_name['CADependentDetails']['surname']." ".$child_name['CADependentDetails']['othername'];;
                                       ?></span>
                                </div>
                            </div>
                            <?php 
                                     }
                            if($AssestRec['assets_for'] == '1'){ 
                              
                                if($childname == $AssestRec['declare_dependent_type']){
                                     
                                if($emulments_child == '1' && $emulments_child1 == '' ){
                                    $emulments_child1++;
                                ?>
                            <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-2"> 
                                    <span class="uk-form-help-block">(including, but not limited to, salary and emoluments and income from investment.
                                        The period is from the previous statement date to the current statement date. For an initial declaration, 
                                        the period is the year ending on the statement date.)</span>
                                </div>
                            </div>
                                <?php  } }else{
                                    unset($emulments_child1);
                                    unset($emulments_child);
                                } ?>
                        <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr style="background-color: white;">
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                </div>
                            </div>
                                    <?php 
                                
                                }elseif($AssestRec['assets_for'] == '2'){ 
                                    
                                 if($childname == $AssestRec['declare_dependent_type']){
                                if($assets_child == '1' && $assets_child1 == '' ){
                                    $assets_child1++;
                                ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Assets(as of the statement date)</label>
                                        <span class="uk-form-help-block">(Including, but not limited to, land, buildings, vehicles, investment and financial obligations
                                            owed to the person for whom the statement is made)</span>
                                    </div>
                                </div>
                            </div>
                            
                                    <?php } }else{
                                    unset($assets_child1);
                                    unset($assets_child);
                                }?>
                            <br>
                                <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr style="background-color: white;">
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                              <?php }elseif($AssestRec['assets_for'] == '3'){ 
                                    
                                    if($childname == $AssestRec['declare_dependent_type']){
                                if($libilit_child == '1' && $libilit_child1 == '' ){
                                    $libilit_child1++;
                                  ?>
                            <hr>
                                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-medium-1-1">
                                    <div class="md-input-wrapper md-input-filled">
                                        <label for="fname" class="fixed">Liabilities(as of the statement date)</label>
                                    </div>
                                </div>
                            </div>
                                  <?php  } }else{
                                    unset($libilit_child1);
                                    unset($libilit_child);
                                } ?>
                                      <br>
                                      <div class="uk-overflow-container">
                                <div class="uk-width-medium-1-2">
                                            <table border="1" class="uk-table uk-tab-responsive"  >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Approximate Amount</th>
                                                </tr>
                                               
                                                <tr style="background-color: white;">
                                                    <td><?php echo $AssestRec['description']; ?></td>
                                                    <td class="uk-text-center"><?php echo $AssestRec['approx_amount']; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                            </div>
                                      <?php } ?>
                        </div>
                       <?php }
                        }
                    }
                       ?>
                    </div>
                </div>
            </div>
<?php } ?>
    <hr>
            <div class="md-card-content large-padding">
                <h3 class="uk-accordion-title">Feedback Against Wealth declaration</h3>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <?php echo $this->Form->create('doc', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'comment_emp_wealthdeclaration'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                echo $this->form->input('wealthdeclaration_id', array('type' => 'hidden','id'=>'emplmnt_number', 'value'=>$EmpWealthDecla[0]['CAWealthdeclaration']['id'],'label' => false,  'class' => "md-input"));
                ?>
                <div class="uk-grid" data-uk-grid-margin > </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="nature_employment">Declaration Status</label>
                            <select name="declaration_status" required="required" onchange="return req_field(this.value);" class="md-input data-md-selectize label-fixed">
                                <option value="0">Accepted</option>
                                <option value="1">Rejected</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > </div>
                 <div class="uk-grid" data-uk-grid-margin >
                
                    <div class="uk-width-medium-1-2">
                        <div class="md-input-wrapper">
                            <label for="t_o_org">Feedback <span class="req fixed" id="mend" style="display: none">*</span></label>
<?php echo $this->form->textarea('feedback', array('label' => false, 'id'=>'feedback','class' => "md-input")); ?>                
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Send</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/emp_all_wealth_declaration') ?>">Cancel</a>                       
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
    
    <?php 
}else{ ?>
    <div class="md-card-content uk-margin-bottom">
<div class="uk-grid" data-uk-grid-margin > 
                        <div class="uk-width-medium-1-2">
                            <div class="md-input-wrapper md-input-filled">
                               <h2> Your feedback already sent for 
                                   <?php if($wealthdeclar_Type == '1'){
                                    echo "Initial Declaration";
                                }elseif($wealthdeclar_Type == '2'){
                                    echo "Benial Declaration";
                                }elseif($wealthdeclar_Type == '3'){
                                    echo "Final Declaration";
                                } ?> !</h2>
                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="md-input-wrapper md-input-filled">
                               
                                <span class="md-btn md-btn-primary" data-uk-modal="{target:'#modal_large'}" onclick="ShowDet('<?php echo $emp_difin_id;?>')">View All Declaration</span>
                                
                            </div>
                        </div>
                        
                    </div>
    </div>
    <div class="uk-grid" data-uk-grid-margin ></div>
    <div class="uk-grid" data-uk-grid-margin ></div>
    <div class="uk-grid" data-uk-grid-margin ></div>
 <?php } ?>

            
        </div>
    </div>
</div>