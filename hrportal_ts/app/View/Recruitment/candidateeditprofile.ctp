
<?php 
$emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code,$comp_code);
?>
        <?php echo $flash = $this->Session->flash(); 
         ?>
                             
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Candidate Details Form</b>
                            </h3>
                            
                         
<?php 
if(!empty($CandidatessDetail))
{

  foreach ($CandidatessDetail as $profile ) {
  }

     ?>
     
<!-- [cndt_dept_id] => DEPT00002 [cndt_desg_id] => PAR0000051 [cndt_loc_id] => PAR0000063 [cndt_gen] => 1 [cndt_perm_add] => B329 New ashok nagar [cndt_curr_add] => B328 New ashok Nagar delhi [cndt_email] => guptarishabh056@gmail.com [cndt_phone1] => 9971500429 [cndt_phone2] => [cndt_pan_no] => 797987414826 [cndt_guard_nm] => [cndt_rel] => Hindu [cndt_mrtl_stat] => 1 [cndt_nation] => INDIAN [cndt_bld_grp] => [cndt_notice_prd] => 12 [cndt_accomodation] => [cndt_intrv_status] => [intrv_times] => [cndt_exp] => 12 [cndt_ind_exp] => [cndt_expect_sal] => 1212 [cndt_sal_amt] => [cndt_leav_reason] => Booked [usr_id_create] => 303 [usr_id_create_dt] => 2018-01-29 [usr_id_mod] => [usr_id_mod_dt] => [c -->
                        
                            </div>
            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'Candidateprofile'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked','enctype'=>'multipart/form-data')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?><div id="empResponse">
                <div class="uk-grid"   data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Position Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name','readonly' => true,'value'=>$profile['CandidateDetail']['position_name']));
                               
                               ?>
                        </div>

                    </div>
                    
                        <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   $department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);
                                $depat=$this->Common->findDepartmentNameByCode($profile['CandidateDetail']['cndt_dept_id']);
                                print_r($depat);
                                ?>

                                <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Department','options' =>$department,'required'=>true,'value'=>$profile['CandidateDetail']['cndt_dept_id'],'class' => "md-input",'id'=>'first_name',"data-md-selectize" => "data-md-selectize")); ?>
                                  
                        </div>

                    </div>
                   
                        

                    </div>
                    
                  
                  
                

                  
            <div class="uk-grid" data-uk-grid-margin > 

                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationList();
                            $desg=$this->Common->findDesignationNameByCode($profile['cndt_desg_id']);
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'empty'=>'Select Designation','readonly' => true, 'options' => $desgName,'required'=>true,'value'=>$profile['CandidateDetail']['cndt_desg_id'],'class' => "md-input",'id'=>'d_name',"data-md-selectize" => "data-md-selectize")); 
                            ?>         
                        </div>

                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Location <span class="req fixed">*</span></label>
                            <?php 
                            $locName =$this->Common->findLocationName();
                           $locationName =$this->Common->findLocationNameByCode($profile['CandidateDetail']['cndt_loc_id']);
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select', 'empty'=>'Select Location','readonly' => true, 'options' => $locName,'required'=>true,'value'=>$profile['CandidateDetail']['cndt_loc_id'],'class' => "md-input",'id'=>'l_name',"data-md-selectize" => "data-md-selectize")); 
                            ?>                
                        </div>
                    </div>
                   </div>
               
                <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Candidate Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_name','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_nm']));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Gender <span class="req">*</span></label>
                               <?php 
                               $gender=array('1'=>'Male','2'=>'Female');
                               echo $this->form->input('Gender', array('label'=>false, 'type' => 'select','options'=>$gender ,'class' => "md-input",'required'=>true,'id'=>'Candidate_gender',"data-md-selectize" => "data-md-selectize",'readonly' => true,'value'=>$gender['CandidateDetail']['cndt_gen']));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
             
                 <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Current Address <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('current Address', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_address','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_curr_add']));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Permanent Address <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Permanent Address', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_paddress','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_perm_add']));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Mobile <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('mobileno', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_number','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_phone1']));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Marital Status <span class="req">*</span></label>
                               <?php 
                               $Marital_status = array('1' =>'Single' ,'2'=>'Married' );
                               echo $this->form->input('marital', array('label'=>false, 'type' => 'select','options'=>$Marital_status,'class' => "md-input",'required'=>true,'id'=>'Cog',"data-md-selectize" => "data-md-selectize",'value'=>$profile['cndt_mrtl_stat'],'disable' =>'disabled'));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin > 
                       <div class="uk-width-medium-1-2" id="enddate_div">
                          <label class="subject" >Candidate Email <span class="req">*</span></label>
                        <div class="parsley-row" >
                          
                             
                                <?php echo $this->form->input('email', array('label' =>false, 'class'=>"md-input autosize_init",'required'=>true, "id" => "email",'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_email'])); ?> 

                        </div>
                    </div>
                        
                    

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label class="subject" >Candidate Adhar<span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('Candidate Adhar', array('label' =>false,'type'=>'text', 'class'=>"md-input autosize_init",'required'=>true, "id" => "adhar",'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_pan_no'])); ?> 

                           
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
              </div>
                <div class="uk-grid" data-uk-grid-margin > 
                     <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Current Organization <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Current orgname', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Cog','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_current_org']));
                               
                               ?>    
                            
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="enddate_div">
                          <label for="req_cat">Candidate Notice Period <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Candidate NoticePeriod', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'CNP','readonly' => true,'value'=>$profile['CandidateDetail']['cndt_notice_prd']));
                               
                               ?>    
                        </div>
                    </div>
                        
                  
                     <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2" id="enddate_div">
                           <label class="subject" >Candidate Current CTC per annum <span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('Candidate CTC', array('label' =>false,'type'=>'text', 'class'=>"md-input autosize_init",'required'=>true, "id" => "ctc",'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_crnt_sal'])); ?> 
                                      

                        </div>
                        </div>
                         <div class="uk-width-medium-1-2" id="enddate_div">
                            
                          <label for="dor">Expected CTC per annum<span class="req">*</span></label>
                           <div class="parsley-row">
                                <?php 
                                echo $this->form->input('Expected CTC', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' =>'CTC','required'=>true,'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_expect_sal']));
                                ?>
                              </div>
                             </div>
                             </div>
                            
        
                  
     <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2">
                      
                               <label class="subject" >Candidate Experience</label>
                            
                     <div class="parsley-row">
                                <?php echo $this->form->input('Experience', array('label' =>false, 'type'=>'text','class'=>"md-input autosize_init",'required'=>true, "id" => "C_exp",'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_exp'])); ?> 
                            
                            <span class="md-input-bar"></span>
                    
                    </div>
                  </div>
                    <!-- <div class="uk-width-medium-1-2">
                        
                        <label for="dor">Preffered Interview Date<span class="req">*</span></label>
                        <div class="parsley-row">
                               <?php 
                               $date=date("d-m-y",strtotime($profile['CandidateDetail']['cndt_join_date']));
                                //echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' =>'text', 'id' =>'datepicker','required'=>true,'readonly' => true,'value'=>$date));?>
                        </div>
                    </div> -->
                   
                </div> 
              

                    <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                           <label class="subject" >Reason for Leaving</label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->textarea('Leave Reason', array('label' =>false, 'class'=>"md-input autosize_init",'required'=>true, "id" => "Reason",'readonly' => true,'value'=>$profile['CandidateDetail']['cndt_leav_reason'])); ?> 
                        </div>
                    </div>
                  </div>
                    <div class="uk-width-medium-1-2">
                       
                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            <label class="subject" >Why Our Company?</label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->textarea('why OCompany', array('label' =>false, 'type'=>'text','class'=>"md-input autosize_init",'required'=>true, "id" => "woc",'readonly' => true)); ?> 
                        </div>
                    </div>
                   
                </div>



 <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2">
                     <div class="parsley-row">
                          <label for="kUI_multiselect_basic" class="uk-form-label">Required Skills</label>
                             <?php
                             
                                
                             
                             foreach($profile['Candidateskills'] as $value)
                             {
                        
                          $skilllist[]=$this->Common->getskilllistbyskillcode($value['skil_id']);
                      

                             }
                         
                        
                    

                            echo $this->form->input('Skill List', array('label' => false,'type' =>'text','class'=>"md-input autosize_init",'readonly' => true,'value'=>$skilllist)); 

                            ?>
                          </div>

                        </div>
              
              
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label class="subject" >Download Resume</label>

                            <div class="parsley-row">
                   
                             <a class="uk-badge uk-Primary-Primary" href="<?php echo $this->Html->url('download/'.base64_encode($profile['CandidateDetail']['id'])); ?>" >Download</a>          
                                
                        </div>
                    </div>
                   
                </div>
              </div>
                  <?php }?>
<?php echo $this->Form->end();?>

</div>
</div>
</div>
</div>
</div>

<script>

            function fileDownload(fileid) {

        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>recruitment/download/' + fileid,
            success: function (data) {
            }
        });

    }

</script>