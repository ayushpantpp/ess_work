    <?php 
//    echo "<pre>";
//    print_r($AuditFormType);
    
   // $fields = explode(",",$form['CADescAuditChecklist']['label']);
    ?><br>
    <hr>
    <h3 class="heading_a" style="text-align: center"><?php echo $AuditFormType[0]['CASetChecklistTypeAuditMonitoring']['checklist_name'];?></h3>
    <hr>
   
     <div class="uk-grid" data-uk-grid-margin></div>
    <?php foreach($AuditFormType as $form){?>
    <div class="uk-grid" data-uk-grid-margin  ></div>
        <div class="uk-grid" data-uk-grid-margin  >
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Description <span class="req">*</span></label>
                <?php
                echo $this->form->input('desc.', array('label' => false, 'type' => "text",'value'=>  ucfirst($form['CADescAuditChecklist']['description']),'readonly'=>true, 'required'=>true, 'class' => "md-input"));
                echo $this->form->input('param_id.', array('label' => false, 'type' => "hidden",'value'=>$form['CADescAuditChecklist']['id'], 'required'=>true, 'class' => "md-input"));
                ?>
            </div>
        </div> 
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="result" >Result <span class="req">*</span></label>
                <?php 
                $opt = array('1'=>'Yes','2'=>'No');
                echo $this->form->input('result.', array('type' => "select", 'label' => false,'empty'=>'--Select--', 'options'=>$opt, 'default'=>$form['CADescAuditChecklist']['result'],'required' => true, 'class' => "md-input label-fixed"));
               /* ?>
               <select name="result[]" required="required" class="md-input data-md-selectize label-fixed">
                                <option value=" ">-- Select --</option>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                <?php */ ?>
                
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="parsley-row">
                <label for="department">Remark</label>
                <?php
                echo $this->form->input('remark.', array('label' => false, 'type' => "text", 'value'=>$form['CADescAuditChecklist']['remark'],'class' => "md-input"));
                
                ?>
            </div>
        </div>
    </div>
     <?php } ?>
<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit"  class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                   <!-- <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('audit_checklist_save') ?>">Cancel</a>                       
                    </div>-->
                </div>
        

   