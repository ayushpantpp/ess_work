<div id="page_content">
    
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
       <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               Add Travel-Master
                            </h3>
                        </div>
            <div class="md-card-content large-padding">
                 
                <?php //echo $this->Form->create('doc', array('url' =>array('controller' => 'TravelMaster','action'=>'add'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                 echo $this->Form->create('TravelMaster',array('type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked'));
                        
                ?>
                <h3 class="heading_a">Enter Travel-Master</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_cat">Department <span class="req">*</span></label>
                                <?php
                                echo $this->form->input('department_id', array('label'=>false,'type' => "select",'empty'=>'-- Select --','required'=>true,'options' => $deptList,'class' => "md-input",'data-md-selectize')); 
                                  ?>
                             </div>
                       </div>
                
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_ref">Designation  <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('designation_id', array('label'=>false,'type' => "select",'empty' => '-- Select --','required'=>true, 'options' => $this->Common->findDesignationList(), 'class' => "md-input",'data-md-selectize')); 
                                ?>
                                
                        </div>
                       </div>
                    </div>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">City Group<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('city_type', array('type'=>'select','label'=>false,'required'=>true,'class'=>"md-input",'empty' => '-- Select --','options'=>$city_grp_list));
                                  ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">Cash Allowance Daily <span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('amount', array('type'=>'text','label'=>false,'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">Hotel Entitlement<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('hotel_amount', array('type'=>'text','label'=>false,'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
                       </div>
                </div>
                    
                
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" value="submit" class="md-btn md-btn-success" href="#">Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/TravelMasters/') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
            </div>
           </div>
   </div>
</div>


























<script type="text/javascript">
    $(document).ready(function () {
        $("#amount").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                (e.keyCode >= 35 && e.keyCode <= 40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
    });
</script>
