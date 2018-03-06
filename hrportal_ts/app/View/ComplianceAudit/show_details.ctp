<?php
foreach ($showDet as $rec)
    ;
//echo "<pre>";
//print_r($rec);
?>

<h3 class="heading_a uk-margin-small-bottom"><u>Compliant Details</u> </h3>
<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Compliant Category :</b> 
                <?php
                if ($rec['CAInvestigation']['compliant_category'] == '1') {
                    echo "Anonymous Whistle blower";
                } elseif ($rec['CAInvestigation']['compliant_category'] == '2') {
                    echo "Public Servant";
                } elseif ($rec['CAInvestigation']['compliant_category'] == '3') {
                    echo "Others";
                }
                ?>
            </label>

        </div>
    </div>

    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Applicable policies, procedures and practices/Guidelines
:</b></label>
            <span><?php
                $str = $rec['CAInvestigation']['compliant_description'];
                echo wordwrap($str, 29, "<br>\n");
                ?></span>
        </div>
    </div>

    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Date of Compliant(On Complain letter)
:</b></label>
            <span><?php 
            if($rec['CAInvestigation']['date_of_compliant'] != '' && $rec['CAInvestigation']['date_of_compliant'] != "1970-01-01"){
                echo date("d/m/Y", strtotime($rec['CAInvestigation']['date_of_compliant']));
            }
             ?></span>
        </div>
    </div>


</div>


<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Date of Compliant Receive(Received at the commission)
:</b></label>
            <span><?php 
            if($rec['CAInvestigation']['date_of_compliant_received'] != '' && $rec['CAInvestigation']['date_of_compliant_received'] != "1970-01-01"){
                echo date("d/m/Y", strtotime($rec['CAInvestigation']['date_of_compliant_received']));
            }
             ?></span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Type of ID Details:</b></label>
            <span><?php
                if ($rec['CAInvestigation']['id_details_type'] == '1') {
                    echo "Personal Number";
                } elseif ($rec['CAInvestigation']['id_details_type'] == '2') {
                    echo "ID Number";
                } elseif ($rec['CAInvestigation']['id_details_type'] == '3') {
                    echo "Passport Number";
                }
                ?></span>

        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>ID Details:</b></label>
            <span><?php echo $rec['CAInvestigation']['id_details']; ?></span>

        </div>
    </div>
</div>


<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Mode of Compliant Received:</b></label>
            <span><?php
                if ($rec['CAInvestigation']['mode_of_compliant_received'] == '1') {
                    echo "Email";
                } elseif ($rec['CAInvestigation']['mode_of_compliant_received'] == '2') {
                    echo "Physical Mail";
                }
                ?></span>

        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Entity complained against:</b></label>
            <span><?php echo $rec['CAInvestigation']['compliant_entity'];
            //echo $this->Common->getdepartmentbyid($rec['CAInvestigation']['department']); ?></span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Email:</b></label>
            <span>
<?php echo $rec['CAInvestigation']['email'];
?></span>

        </div>
    </div>
</div>

<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Postal Address :</b></label>
            <span>
<?php echo $rec['CAInvestigation']['postal_add']; ?>

            </span>

        </div>
    </div>

    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Mobile number of the complainant
 :</b></label>
            <span>
<?php echo $rec['CAInvestigation']['phone_number']; ?>
            </span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Compliant Type :</b></label>
            <span>
<?php
                                $complain_type = array(
                                    '1'=>'Terms and Service',
                                    '2'=>'Corrupt/Ethical Conduct',
                                    '3'=>'Favoritism/Unfairness',
                                    '4'=>'Workplace Discrimination',
                                    '5'=>'Work Place Bullying',
                                    '6'=>'Occupational Health and Safety',
                                    '7'=>'Workloads',
                                    '8'=>'Occupational Health and Safety',
                                    '9'=>'Others',
                                        );
                                foreach ($complain_type as $key => $rt) {
                                    $value = $key;
                                    $option = $rt;
                                    if($rec['CAInvestigation']['compliant_type'] == $value){
                                        echo  $option;
                                    }
                                }
                                 
                                ?>
            </span>
        </div>
    </div>
</div>
<hr>
<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Contact Person Name:</b></label>
            <span>
<?php echo $rec['CAInvestigation']['info_name']; ?>

            </span>

        </div>
    </div>

    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Mobile
 :</b></label>
            <span>
<?php echo $rec['CAInvestigation']['info_mobile']; ?>
            </span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Official E-mail ID:</b></label>
            <span>
<?php echo $rec['CAInvestigation']['info_email']; ?>
            </span>
        </div>
    </div>
</div>
<div  class="uk-grid" data-uk-grid-margin>
<?php if(!empty($rec['CAComplianDoc'])){
    for($i = 0 ; $i<count($rec['CAComplianDoc']); $i++){
        if($rec['CAComplianDoc'][$i]['doc_status']=='1'){
    ?>
    <h3 class="heading_a uk-margin-small-bottom"><u>Related Documents</u> </h3>
<div class="uk-width-medium-1-1">
        <div class="parsley-row">
            <label for="subject"><b>Compliant Document :</b></label>
            <span>
            <a href="<?php echo $this->Html->url('investigation_file_download/' . $rec['CAComplianDoc'][$i]['id']); ?>" >View</a>
            </span>
        </div>
    </div>
    <?php } }}?>
</div>
<?php if(($response == 'ceo_resp' || $response =='complance_res' || $rec['CAInvestigation']['created_by']==$rec['CAInvestigation']['forward_to']) && ($rec['CAInvestigation']['current_status']=='1' || $rec['CAInvestigation']['current_status']=='2')){?>
<hr>
<h3 class="heading_a uk-margin-small-bottom"><u>CEO Response</u> </h3>
<div  class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Action :</b></label>
            <span><?php 
            if($rec['CAInvestigation']['ceo_action'] == '1'){
                echo "Forward to External";
            }elseif($rec['CAInvestigation']['ceo_action'] == '2'){
                echo "Forward to Compliance";
            }elseif($rec['CAInvestigation']['ceo_action'] == '3'){
               echo "Direct Response";  
            }
            ?></span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <?php 
            if($rec['CAInvestigation']['ceo_action'] != '1'){
                ?>
        <div class="parsley-row">
            <label for="subject"><b>Forward To:</b></label>
            <span>
            <?php
                echo $this->Common->finddepEmpName($rec['CAInvestigation']['forward_to']);
            
             ?>
            </span>
        </div>
            <?php } ?>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Date of Response:</b></label>
            <span>
                
            <?php 
            echo date("d/m/Y", strtotime($rec['CAInvestigation']['date_of_response'])) ?>
            </span>
        </div>
    </div>
</div>
<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-1">
        <div class="parsley-row">
            <label for="subject"><b>CEO Remark:</b></label>
            <span>
           <?php echo $rec['CAInvestigation']['ceo_remark']; ?>
            </span>
        </div>
    </div>
</div>
<?php } ?>
<?php if($response == 'complance_res' && $rec['CAInvestigation']['current_status']=='2'){
    
    ?>
<hr>
<h3 class="heading_a uk-margin-small-bottom"><u>Compliance Response</u> </h3>
<div  class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Significance of Compliant :</b></label>
            <span><?php echo $rec['CAInvestigation']['significance_of_compliat'];?></span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Symantec Problem:</b></label>
            <span>
            <?php
                if ($rec['CAInvestigation']['symantec_problem'] == '0') {
                    echo "Yes";
                } elseif ($rec['CAInvestigation']['symantec_problem'] == '1') {
                    echo "No";
                } 
                ?>
            
            </span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Scope of Problem:</b></label>
            <span>
            <?php echo $rec['CAInvestigation']['scope_problem']; ?>
            </span>
        </div>
    </div>
</div>
<div  class="uk-grid" data-uk-grid-margin>
<div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Resource Requirement :</b></label>
            <span><?php echo $rec['CAInvestigation']['resource_requirement'];?></span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Description:</b></label>
            <span>
           <?php echo $rec['CAInvestigation']['compliance_description']; ?>
            </span>
        </div>
    </div>
    <div class="uk-width-medium-1-3">
        <div class="parsley-row">
            <label for="subject"><b>Nature of Outcome:</b></label>
            <span>
            <?php echo $rec['CAInvestigation']['nature_outcome']; ?>
            </span>
        </div>
    </div>
</div>

<div  class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-1">
        <div class="parsley-row">
            <label for="subject"><b>Is any authorization required to start investigation:</b></label>
            <span>
                <?php
                if ($rec['CAInvestigation']['authrization_required'] == '0') {
                    echo "Yes";
                } elseif ($rec['CAInvestigation']['authrization_required'] == '1') {
                    echo "No";
                } 
                ?>
            </span>
        </div>
        
    </div>
</div>
<div  class="uk-grid" data-uk-grid-margin>
    <?php if($rec['CAComplianDoc'][0]['doc_status']=='2'){
        ?>
    <h3 class="heading_a uk-margin-small-bottom"><u>Investigated Documents</u> </h3>
    <?php }?>
    
<?php if(!empty($rec['CAComplianDoc'])){
    
    for($i = 0 ; $i<count($rec['CAComplianDoc']); $i++){
        if($rec['CAComplianDoc'][$i]['doc_status']=='2'){
    ?>
    
           
<div class="uk-width-medium-1-1">
        <div class="parsley-row">
            <label for="subject"><b>Complaint Document :</b></label>
            <span>
            <a href="<?php echo $this->Html->url('investigation_file_download/' . $rec['CAComplianDoc'][$i]['id']); ?>" >View</a>
            </span>
        </div>
    </div>
    <?php } }}?>
</div>
<?php } ?>



