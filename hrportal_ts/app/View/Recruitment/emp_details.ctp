<?php $auth = $this->Session->read('Auth'); ?>
<table class="uk-table uk-table-no-border">
   <?php
  
    
   
    $i = 1;
    foreach ($EmpDetail as $edt) {



?>
        
  <div class="uk-width-medium-1-3" id="emp_group" >
                        <div class="parsley-row">
                            <label for="department"> Employee group <span class="req">*</span></label>
                             <?php 
                               $empname1=$this->Common->findEmpGroupNameByCode($edt['emp_grp_id']);
                                echo $this->form->input('emp_group', array('label'=>false, 'type' => 'select', 'readonly' => true, 'options' =>$empname1,'class' => "md-input",'id'=>'employeegrp',"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                        

                    </div>

                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   $department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);
                                ?>

                                <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Department','options' =>$department,'class' => "md-input",'required'=>true,'id'=>'first_name','value'=>$edt['dept_code'],"data-md-selectize" => "data-md-selectize")); ?>
                                  
                        </div>

                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                             <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationList();
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'empty'=>'Select Designation','readonly' => true, 'options' => $desgName,'class' => "md-input",'required'=>true,'id'=>'d_name','value'=>$edt['desg_code'], 'data-md-selectize' =>'data-md-selectize')); 
                            ?>         
                        </div>
                    </div>
                   
              
       
             
                    <?php 
                   $i++;

               }?>

</table>


