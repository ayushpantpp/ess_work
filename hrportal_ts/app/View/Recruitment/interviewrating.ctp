<style>
    .check{
        margin-left: 100px;
    }
    </style>
        
<?php
$emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code, $comp_code);
?>
<div id="page_content">
<div id="page_content_inner">
<?php echo $flash = $this->Session->flash(); ?>
<div id="alerts"></div>
<div class="md-card">  
            <div class="md-card-toolbar">
                <b  ><p class="uk-text-center md-bg-white-300 uk-te uk-text-large" ><?php
                        foreach ($competency_lvl as $val) {


                            $form_name = $this->Common->getmgtname($val['management_code']);
                        }

                        echo $form_name . "&nbsp;&nbsp;" . "Form";
                        ?></p></b>

            </div>
        
            <div class="md-card">   
                 <div class="md-card-content">

      

                       
                                     <?php
                    foreach ($candidate_details as $candidatedetails) {

                        echo $this->Form->create('doc', array('url' => array('controller' => 'Recruitment', 'action' => 'interviewerratingDetails'), 'type' => 'file', 'name' => 'Form1', 'id' => 'form_validation', 'class' => 'uk-form-stacked'));
                        $auth = $this->Session->read('Auth');
                        $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                        echo $this->form->input('id', array('value' => $candidatedetails['CandidateDetail']['id'], 'type' => 'hidden'));
                          echo $this->form->input('selectvalue', array('id'=>'checkbox', 'type' => 'hidden'));
                        echo $this->form->input('managementcode', array('value' =>$val['management_code'],'type' => 'hidden'));
                        ?>
                                <div class="uk-accordion" data-uk-accordion>
                                            <h3 class="uk-accordion-title uk-accordion-title-primary"><p class="uk-text-center md-bg-white-300 uk-te uk-text-medium"> 
                                                <?php echo $pageheading; ?></p></h3>
                    <div class="uk-accordion-content">
                <div class="md-card-content large-padding">
                        <div class="uk-grid" data-uk-grid-margin>
                        <?php
                        if ($block[0]['LabelBlock']['block_status'] == 1) {

                            $candidate_labels = $this->Common->block_labels($block[0]['LabelBlock']['id']);

                            if ($candidate_labels['0']['Labels']['label_status'] == 1) {
                                ?>
                                    <div class="uk-width-medium-1-3" >
                                        <div class="parsley-row">
                                            <label for="req_cat"><?php
                                    Configure::write('I18n.preferApp', true);
                                    echo __d('debug_kit', $candidate_labels['0']['Labels']['name']);
                                    ?> <span class="req">*</span></label>
            <?php
            $candidate_name = $this->common->getcandidatenamebyid($candidatedetails['CandidateDetail']['id']);
            echo $this->form->input('Candidate Name', array('label' => false, 'type' => 'text', 'class' => "md-input",  'readonly' => true, 'id' => 'p_name', 'value' => $candidate_name));
            ?>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="parsley-row">

                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php
                                                Configure::write('I18n.preferApp', true);
                                                echo __d('debug_kit', $candidate_labels[1]['Labels']['name']);
                                                ?></label>

            <?php
            echo $this->form->input('Position Applied', array('label' => false, 'type' => 'text', 'class' => "md-input", 'readonly'=>true, 'id' => 'pos_name',
                'value'=>$candidatedetails['CandidateDetail']['position_name']));
            ?>

                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="parsley-row">
                                            <label for="department"><?php
                                            //Configure::write('I18n.preferApp', true);
                                            echo __d('debug_kit', $candidate_labels[2]['Labels']['name']);
                                            ?><span class="req">*</span></label>


            <?php echo $this->form->input('Date of Interview', array('label' => false, 'class' => "k-input", 'type' => 'text','readonly'=>true,
                'id' =>"kUI_datepicker_a",'value'=>$InterviewerDetails[0]['InterviewerDetails']['int_date'])); ?>
                                        </div>
                                    </div>

                                
                                
                                    <div class="uk-width-medium-1-3">
                                        <div class="parsley-row">
                                            <label for="department"><?php
                                            //Configure::write('I18n.preferApp', true);
                                            echo __d('debug_kit', $candidate_labels[3]['Labels']['name']);
                                            ?><span class="req">*</span></label>


            <?php echo $this->form->input('Total Experience', array('label' => false, 'class' => "md-input ", 'type' => 'text', 'readonly' => true,
                'value'=>$candidatedetails['CandidateDetail']['cndt_exp'])); ?>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="parsley-row">
                                            <label for="resp" class="fixed"><?php
                                                echo __d('debug_kit', $candidate_labels[4]['Labels']['name']);
                                                ?><span class="req fixed">*</span></label>
            <?php 
            $interviewername=$this->Common->getEmpDetails($InterviewerDetails[0]['InterviewerDetails']['interviewer_code']);
           
            echo $this->form->input('Name of Interviewer', array('label' => false, 'class' => "md-input ", 'type' => 'text', 
                'readonly' => true,'value'=>$interviewername['MyProfile']['emp_full_name'])); ?>
                                        </div>
                                    </div>
                                    <div class="uk-width-medium-1-3">
                                        <div class="parsley-row">
                                            <label for="resp" class="fixed"><?php
            echo __d('debug_kit', $candidate_labels[5]['Labels']['name']);
            ?><span class="req fixed">*</span></label>
                                                <?php 
                                                $source=array('1'=>'Consultant','2'=>'Individual','3'=>'Internal');
                                                echo $this->form->input('Source of CV', array('label' => false, 'class' => "md-input ", 'type' => 'select', 'required' => true,'options'=>$source,
                                                    "data-md-selectize" => "data-md-selectize")); ?>
                                        </div>
                                    </div>


                                </div>
                                    </div>
                </div>
                 </div>
                     
              
                                <hr>
                                <div class="md-card">  

                                    <!--      <div class="md-card-toolbar">
                                                 <div class="md-card"> -->
                                    <div class="md-card-content">

                                        <div class="uk-accordion" data-uk-accordion>
                                            <h3 class="uk-accordion-title uk-accordion-title-primary"><?php
                                                echo __d('debug_kit', $candidate_labels[6]['Labels']['css_name']);
                                                ?></h3>




                                            </h3>


                                            <div class="uk-accordion-content">
                                                <div class="uk-grid" data-uk-grid-margin > 
                                                    <div class="uk-width-medium-1-1">

                                                        <div class="uk-overflow-container">


                                                            <table border="1" class="uk-table uk-tab-responsive" >
                                                                <tr>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small"><?php
                                                echo __d('debug_kit', $candidate_labels[7]['Labels']['name']);
                                                ?><br>
            <?php echo __d('debug_kit', $candidate_labels[7]['Labels']['css_name']); ?></th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
            echo __d('debug_kit', $candidate_labels[8]['Labels']['name']);
            ?><br>
            <?php
            echo __d('debug_kit', $candidate_labels[8]['Labels']['css_name']);
            ?> </th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
            echo __d('debug_kit', $candidate_labels[9]['Labels']['name']);
            ?><br>
            <?php
            echo __d('debug_kit', $candidate_labels[9]['Labels']['css_name']);
            ?></th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                                                        echo __d('debug_kit', $candidate_labels[10]['Labels']['name']);
                                                                        ?><br>
                                                                        <?php
                                                                        echo __d('debug_kit', $candidate_labels[10]['Labels']['css_name']);
                                                                        ?></th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                                            echo __d('debug_kit', $candidate_labels[11]['Labels']['name']);
                                                                        ?><br>
                                                                        <?php
                                                                        echo __d('debug_kit', $candidate_labels[11]['Labels']['css_name']);
                                                                        ?></th>

                                                                </tr>



                                                            </table>
                                                        </div>
                                                    </div>


                                                </div> 
                                            </div>
                                        </div>    
                                    </div>
                                </div>


                                <hr>
                                <div class="md-card" >   



                                    <div class="md-card-toolbar" >

                                        <b  ><p class="uk-text-center md-bg-white-300 uk-te uk-text-small" ><?php
                                                                        echo __d('debug_kit', $candidate_labels[12]['Labels']['name']);
                                                                        ?></b>
                                        </p>
                                        </b>
                                    </div>
                                    <div class="md-card-toolbar">

                                        <p class="uk-text-center md-bg-white-300 uk-te uk-text-large" ><?php
                                                            echo __d('debug_kit', $candidate_labels[12]['Labels']['css_name']);
                                                            ?></b>
                                        </p>

                                    </div>
                                </div>


                                <div class="uk-grid" data-uk-grid-margin > 
                                    <div class="uk-width-medium-1-1">

                                        <div class="uk-overflow-container">


                                            <table border="1" class="uk-table uk-tab-responsive" >
                                                <tr>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small"><?php
                                                            echo __d('debug_kit', $candidate_labels[13]['Labels']['name']);
                                                            ?></th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                                echo __d('debug_kit', $candidate_labels[14]['Labels']['name']);
                                                ?> </th>
                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                    echo __d('debug_kit', $candidate_labels[15]['Labels']['name']);
                                    ?></th>


                                                </tr>
                                                <tr>
                                                    <td class="uk-text-center uk-width-small-3-10" ><b><?php
                                            echo __d('debug_kit', $candidate_labels[16]['Labels']['name']);
                                            ?></b><br><?php
                                            echo __d('debug_kit', $candidate_labels[16]['Labels']['css_name']);
                                            ?></td> 
                                                    <td> <?php $Rating = array('0', '1', '2', '3', '4', '5');
                                            ?>

            <?php echo $this->form->input('Rating1', array('label' => false, 'class' => "md-input ", 'type' => 'select', 'required' => true, 'options' => $Rating, "data-md-selectize" => "data-md-selectize")); ?></td>
                                                    <td><?php
            echo $this->form->input('rating remark1', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
            ?></td>                                                  
                                                </tr>
                                                <tr>
                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
            echo __d('debug_kit', $candidate_labels[17]['Labels']['name']);
            ?></b><br><?php
                                                        echo __d('debug_kit', $candidate_labels[17]['Labels']['css_name']);
                                                        ?></td>
                                                    <td> <?php $Rating = array('0', '1', '2', '3', '4', '5');
                                            ?>

                                                        <?php echo $this->form->input('Rating2', array('label' => false, 'class' => "md-input ", 'type' => 'select', 'required' => true, 'options' => $Rating,"data-md-selectize" => "data-md-selectize")); ?></td>
                                                    <td><?php
                                            echo $this->form->input('rating remark2', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                        ?></td>                                                   
                                                </tr>
                                                <tr>
                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                            echo __d('debug_kit', $candidate_labels[18]['Labels']['name']);
                                            ?></b><br><?php
                                            echo __d('debug_kit', $candidate_labels[18]['Labels']['css_name']);
                                            ?></td>     
                                                    <td> <?php $Rating = array('0', '1', '2', '3', '4', '5');
                                                        ?>

                                                        <?php echo $this->form->input('Rating3', array('label' => false, 'class' => "md-input ", 'type' => 'select', 'required' => true, 'options' => $Rating,"data-md-selectize" => "data-md-selectize")); ?></td>
                                                    <td><?php
                                                            echo $this->form->input('rating remark3', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                            ?></td>                       
                                                </tr>

                                            </table>




                                        </div>
                                        <hr>
                                        <br>
                                                            <?php
                                                            if ($block[1]['LabelBlock']['block_status'] == 1) {

                                                                $candidate_labels1 = $this->Common->getcompetenciesbymgtcode($val['management_code']);

                                                                if (!empty($candidate_labels1)) {
                                                                    ?>
                                                <div class="md-card" >   



                                                    <div class="md-card-toolbar" >

                                                        <b  ><p class="uk-text-center md-bg-white-300 uk-te uk-text-small" ><?php
                                                                echo __d('debug_kit', $candidate_labels[34]['Labels']['css_name']);
                                                                echo __d('debug_kit', $block[1]['LabelBlock']['name']);
                                                                ?></b>
                                                        </p>
                                                        </b>
                                                    </div>

                                                </div>


                                                <div class="uk-grid" data-uk-grid-margin > 
                                                    <div class="uk-width-medium-1-1">

                                                        <div class="uk-overflow-container">


                                                            <table border="1" class="uk-table uk-tab-responsive" >
                                                                <tr>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small"><?php
                                                                echo __d('debug_kit', $candidate_labels[34]['Labels']['name']);
                                                                ?></th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                                                echo __d('debug_kit', $candidate_labels[35]['Labels']['name']);
                                                                ?> </th>
                                                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small"><?php
                                                                echo __d('debug_kit', $candidate_labels[36]['Labels']['name']);
                                                                ?></th>


                                                                </tr>

                                                <?php
                                                $i = 0;
                                                $count = ($competency_lvl['Competencylvlmaster']['competency_lvl']);

                                                while ($i < $count) {
                                                    if (!empty($candidate_labels1[$i]['ComptencyTypeMaster']['comepetency_types'])) {
                                                        ?>
                                                                        <tr>
                                                                            <td class="uk-text-center uk-width-small-3-10" ><?php
                            echo $candidate_labels1[$i]['ComptencyTypeMaster']['comepetency_types'];
                            ?><br></td> 
                                                                            <td> <?php $Rating = array('0', '1', '2', '3', '4', '5');
                            ?>

                                                                        <?php echo $this->form->input('ComptencyTypeMaster.Ratings.', array('label' => false, 'class' => "md-input ", 'type' => 'select', 'required' => true, 'options' => $Rating, "data-md-selectize" => "data-md-selectize")); ?></td>
                                                                            <td><?php
                                                                        echo $this->form->input('ComptencyTypeMaster.observation.', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                                        ?></td>                                                  
                                                                        </tr>
                            <?php
                        }
                        $i++;
                    }
                    ?>

                                                            </table>




                                                        </div>
                <?php }
            } ?>
                                                <hr>
                                                <br>
                                                <div class="uk-grid" data-uk-grid-margin > 
                                                    <div class="uk-width-medium-1-1">

                                                        <div class="uk-overflow-container">


                                                            <table border="1" class="uk-table uk-tab-responsive" >

                                                                <tr>
                                                                    <th colspan="3"><p class="uk-text-center md-bg-blue-100 uk-te uk-text-full"> <?php
            echo __d('debug_kit', $candidate_labels[19]['Labels']['name']);
            ?></p></th>



                                                                </tr>
                                                                <tr>
                                                                    <td class="uk-text-center uk-width-small-3-10" ><b><?php
                                                        echo __d('debug_kit', $candidate_labels[20]['Labels']['name']);
                                                        ?></b><br></td> 

                                                                    <td><?php
                                                        echo $this->form->input('com skills', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                        ?></td>                                                  
                                                                </tr>
                                                                <tr>
                                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                                                echo __d('debug_kit', $candidate_labels[21]['Labels']['name']);
                                                                ?></b><br></td>

                                                                    <td><?php
                                                                echo $this->form->input('strength', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                                ?></td>                                                   
                                                                </tr>
                                                                <tr>
                                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                                                echo __d('debug_kit', $candidate_labels[22]['Labels']['name']);
                                                                ?></b><br></td>     

                                                                    <td><?php
                                                                echo $this->form->input('imp area', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'catt_name',));
                                                                ?></td>                       
                                                                </tr>
                                                                </tr>

                                                            </table>




                                                        </div>
                                                        <hr>
                                                        <div class="uk-grid" data-uk-grid-margin > 
                                                            <div class="uk-width-medium-1-1">

                                                                <div class="uk-overflow-container">


                                                                    <table border="1" class="uk-table uk-tab-responsive" >

                                                                        <tr>
                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                            echo __d('debug_kit', $candidate_labels[23]['Labels']['name']);
                                            
                                            ?></p></th>
                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                            echo __d('debug_kit', $candidate_labels[24]['Labels']['name']);
                                             echo $this->form->input('interview.select', array('label' => false, 'type' => 'checkbox',  'class' => "check", 'id' => 'selected','value'=>'1'));
                                            ?></p></th>
                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                                                            echo __d('debug_kit', $candidate_labels[25]['Labels']['name']);
                                                                            echo $this->form->input('interview.select', array('label' => false, 'type' => 'checkbox', 'class' => "check", 'id' => 'Reject','value'=>'0'));
                                                                            ?></p></th>
                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                                                echo __d('debug_kit', $candidate_labels[26]['Labels']['name']);
                                                                  echo $this->form->input('interview.select', array('label' => false, 'type' => 'checkbox', 'class' => "check",  'id' => 'hold','value'=>'2'));
                                                                
                                                                ?></p></th>


                                                                        </tr>


                                                                    </table>




                                                                </div>
                                                                <div class="uk-grid" data-uk-grid-margin > 
                                                                    <div class="uk-width-medium-1-1">

                                                                        <div class="uk-overflow-container">


                                                                            <table border="1" class="uk-table uk-tab-responsive" >

                                                                                <tr>
                                                                                    <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                                                        echo __d('debug_kit', $candidate_labels[27]['Labels']['name']);
                                                                        ?></p></th>
                                                                                    <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php echo $this->form->input('CCTC', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'cur_ctc'));?></p></th>


                                                                                </tr>


                                                                                <br>
                                                                                <br>

                                                                            </table>




                                                                        </div>
                                                                        <div class="uk-grid" data-uk-grid-margin > 
                                                                            <div class="uk-width-medium-1-1">

                                                                                <div class="uk-overflow-container">


                                                                                    <table border="1" class="uk-table uk-tab-responsive" >

                                                                                        <tr>
                                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"> <?php
                                                                        echo __d('debug_kit', $candidate_labels[28]['Labels']['name']);
                                                                        ?></p></th>
                                                                                            <th ><p class="uk-text-center md-bg-white-100 uk-te uk-text-full"><?php  echo $this->form->input('reasonofrecommend', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'recommend',)); ?></p></th>

                                                                                        </tr>


                                                                                    </table>




                                                                                </div>

                                                                                <div class="uk-grid" data-uk-grid-margin > 
                                                                                    <div class="uk-width-medium-1-1">

                                                                                        <div class="uk-overflow-container">


                                                                                            <table border="1" class="uk-table uk-tab-responsive" >

                                                                                                <tr>
                                                                                                    <th colspan="3"><p class="uk-text-center md-bg-blue-100 uk-te uk-text-full"> <?php
                                                                        echo __d('debug_kit', $candidate_labels[29]['Labels']['name']);
                                                                        ?></p></th>



                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="uk-text-center uk-width-small-3-10" ><b><?php
                                                                        echo __d('debug_kit', $candidate_labels[30]['Labels']['name']);
                                                                        ?></b><br></td> 

                                                                                                    <td><?php
                                                                        echo $this->form->input('CCTC', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'cur_ctc'));
                                                                        ?></td>                                                  
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                                                                            echo __d('debug_kit', $candidate_labels[31]['Labels']['name']);
                                                                                            ?></b><br></td>

                                                                                                    <td><?php
                                                                                echo $this->form->input('ECTC', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'Ex_ctc',));
                                                                                ?></td>                                                   
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                                                                echo __d('debug_kit', $candidate_labels[32]['Labels']['name']);
                                                                                ?></b><br></td>     

                                                                                                    <td><?php
                                                                                echo $this->form->input('Expected Date', array('label' => false, 'type' => 'text',  'class' => "md-input", 'required' => true,'readonly' => true, 'id' => 'Ex_date','data-uk-datepicker'=>"{format:'DD-MM-YYYY'}"));
                                                                                ?></td>                       
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td class="uk-text-center uk-width-small-1-10" ><b><?php
                                                                                echo __d('debug_kit', $candidate_labels[33]['Labels']['name']);
                                                                                ?></b><br></td>     

                                                                                                    <td><?php
                                                                                echo $this->form->input('final remark', array('label' => false, 'type' => 'text', 'class' => "md-input", 'required' => true, 'id' => 'remark',));
                                                                                ?></td>                       
                                                                                                </tr>
                                                                                                </tr>

                                                                                            </table>




                                                                                        </div>

                                                                                      <?php } ?>


                                                                                    <div class="uk-grid">

                                                                                        <div class=" uk-margin-top">                            
                                                                                            <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Submit</button>                    
                                                                                        </div>
                                                                                        <div class="uk-margin-top">                            
                                                                                            <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/Recruitment/view') ?>">Cancel</a>                       
                                                                                        </div>
                                                                                        </div>
      
                                                                                        </div>
                                                                                        </div>
                                                                                         </div>
                                                                                        </div>
                                                                                         </div>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                        </div>
                                                                                         </div>
                                                                                         </div>
                                                                                          </div>
                                                                                           </div>
                                                                                            </div>
                                 
           
            
  <?php echo $this->Form->end(); ?>

 </div>
                    </div><?php }} ?> </div>
  </div>
</div>

                                                        <script type="text/javascript">
                                                            
                                                            $(function () {
                                                                $("#datepicker").datepicker({dateFormat: 'dd-mm-yy',

                                                                    minDate: '+1D'});
                                                                
                                                                $("input:checkbox").on('click', function() {
  // in the handler, 'this' refers to the box clicked on $(
  var value=$(this).val();
 
  if(value==1) 
  {
      $("#checkbox").val(1);
      
  }
  else if(value==2) {
       $("#checkbox").val(2);
      
  }
  else{
       $("#checkbox").val(0);
  }
 
  
  var $box = $(this);
  if ($box.is(":checked")) {
      
    // the name of the box is retrieved using the .attr() method
    // as it is assumed and expected to be immutable
    var group = "input:checkbox[name='" + $box.attr("name") + "']";
    // the checked state of the group/box on the other hand will change
    // and the current value is retrieved using .prop() method
    $(group).prop("checked", false);
    $box.prop("checked", true);
  } else {
    $box.prop("checked", false);
  }
});
                                                            });
                                                            function check() {

                                                                var final = $("#skills1").val();
                                                                if (final == '')
                                                                {
                                                                    alert("Please Fill Required Skills");
                                                                    $("#skills").focus();
                                                                }
                                                            }



                                                            function pos_type(val)
                                                            {
                                                                $("#emp_group").hide();
                                                                var ptype = $("#position_type").val();
                                                                if (ptype == 2)
                                                                {

                                                                    $("#emp_group").show();
                                                                } else {
                                                                    $("#emp_group").hide();

                                                                }
                                                            }
                                                            function get_details(emp_code)
                                                            {
                                                                jQuery.ajax({

                                                                    url: '<?php echo $this->webroot ?>Recruitment/emp_details/' + emp_code,

                                                                    success: function (data) {



                                                                        $id = jQuery('#empResponse').html(data);



                                                                    }
                                                                });
                                                            }
                                                            function isNumberKey(evt)
                                                            {
                                                                
                                                                var charCode = (evt.which) ? evt.which : event.keyCode
                                                                if (charCode != 46 && charCode > 31
                                                                        && (charCode < 48 || charCode > 57))
                                                                    return false;

                                                         
                                                            }

                                                            /** Days to be disabled as an array */
                                                            $(function () {
                                                                var counter = 2;
                                                                $("#addmore").click(function () {
                                                                    $("#container").append('<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="department"><?php echo __d('debug_kit', $candidate_labels[4]['Labels']['name']); ?><span class="req">*</span></label><select name="int_type' + counter + '" id="interview_type_' + counter + '" type="select" class="md-input" data-md-selectize><option value="1">Skype</option><option value="2">Telephonic</option><option value="3">F2F</option></select> </div></div>' + '<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="department"><?php echo __d('debug_kit', $candidate_labels[5]['Labels']['name']); ?><span class="req">*</span></label><?php echo $this->form->input("interview_date'+counter+'", array('label' => false, "data-uk-datepicker" => "{format:'DD-MM-YYYY',minDate:'" . date('d-m-Y' + 1) . "'}", 'class' => "md-input", 'type' => 'text', 'required' => true)); ?></div></div>' + '<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="resp" class="fixed"><?php
                                                                                                echo __d('debug_kit', $candidate_labels[6]['Labels']['name']);
                                                                                                ?><span class="req fixed">*</span></label><?php echo $this->form->input("in_time'+counter+'", array('label' => false, 'class' => "md-input", "data-uk-timepicker" => "", 'id' => 'in_time')); ?></div></div>' + ' <div class="uk-width-medium-1-4"><div class="parsley-row"> <label for="resp" class="fixed"><?php echo __d('debug_kit', $candidate_labels[7]['Labels']['name']); ?><span class="req fixed">*</span></label> <select name="interviewer_' + counter + '" id="interviewercode_' + counter + '" class="selecters"  ><option value="0">Select Interviewer</opton><?php $hrList = $this->Common->getemplist();
                                                                            foreach ($hrList as $hr => $value) {
                                                                                ?><option value="<?php echo $hr ?>"><?php echo $value; ?></option><?php } ?></select></div></div></div>');

                                                                    $('#form_validation').val(counter);

                                                                    counter++;
                                                                    var rowcount = $('#form_validation').val();
                                                                    $('#rowcount').val(rowcount);


                                                                    $('.selecters').change(function () {

                                                                        self = $(this);
                                                                        choosen = $(this).val();
                                                                        var intval = $("#interviewercode").val();
                                                                        if (choosen == intval)
                                                                        {
                                                                            alert('Interviewer is already selected for this Candidate');
                                                                            $(self).val($(this).find("option:first").val());
                                                                        }

                                                                        $('.selecters').not(self).each(function () {


                                                                            if ($(this).val() == choosen) {

                                                                                // $(this).prop('disabled', true);
                                                                                alert('Interviewer is already selected for this Candidate');

                                                                                $(self).val($(this).find("option:first").val());


                                                                            }


                                                                        });

                                                                    });


                                                                });
                                                                $("#emp_group").hide();





                                                            });

                                                        </script>


                                                        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

                                                        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
                                                        <script src="jquery.tag-editor.js"></script>

                                                        <link rel="stylesheet" href="jquery.tag-editor.css">
