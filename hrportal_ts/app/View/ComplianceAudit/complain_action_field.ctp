    <?php 
        if($actionID == '1'){
    ?>
           <!-- <div class="parsley-row">
                <label for="department">Department <span class="req">*</span></label>
                <?php
//                $dept = $this->Common->getdepartmentlist();
//                echo $this->form->input('dept_id', array('label' => false, 'type' => "select", 'options'=>$dept,'empty'=>'--Select--','required'=>true, 'class' => "md-input data-md-selectize "));
                ?>
            </div>-->
    
     <?php }elseif($actionID == '3'){
         ?>
            <div class="parsley-row">
                <label for="department">Direct Response <span class="req">*</span></label>
                <?php
                echo $this->form->input('direct_response', array('label' => false, 'type' => "text", 'required'=>true, 'class' => "md-input"));
                ?>
            </div>
    
     <?php
     }elseif($actionID == '2'){
        ?>
            <div class="parsley-row">
                <label for="department">Compliance Director <span class="req">*</span></label>
                <?php
                $emplist = $this->Common->getemplistbyDeptDesig('DEPT00006','PAR0000061');
                echo $this->form->input('compliance_dierector', array('label' => false, 'type' => "select", 'options'=>$emplist,'empty'=>'--Select--','required'=>true, 'class' => "md-input"));
                ?>
            </div>
    
     <?php 
         
     } ?>

   