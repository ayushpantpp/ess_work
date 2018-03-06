<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>Add Travel-Master</h1>
            
    </div>
    
    
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
       <div class="md-card">  
            <div class="md-card-content large-padding">
                 
                <?php //echo $this->Form->create('doc', array('url' =>array('controller' => 'TravelMaster', 'action' =>'i'),'type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked' )); 
                 echo $this->Form->create('TravelMaster',array('type' => 'file','id'=>'form_validation','class' => 'uk-form-stacked'));
                
                    foreach($trdata as $rec);
                ?>
                <h3 class="heading_a">Enter Travel-Master</h3>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_cat">Department Id</label>
                                <?php
                                echo $this->Form->input('departmentID', array('value'=>$this->Common->getdepartmentbyid($rec['department_id']),'label'=>false,'class'=>'md-input','type' => 'text','required'=>true,'readonly'=>'readonly'));
                                echo $this->Form->input('department_id', array('value'=>$rec['department_id'],'label'=>false,'class'=>'md-input','type' => 'hidden','required'=>true,'readonly'=>'readonly'));
                                //echo $this->form->input('department_id', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'select','required','options'=>$deptList));
                                  ?>
                             </div>
                       </div>
                
                    <div class="uk-width-medium-1-2" >
                            <div class="parsley-row">
                                <label for="req_ref">Designation Id <span class="req">*</span></label>
                                <?php 
                                //echo $this->form->input('designation_id', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'select','required','options'=>$this->Common->findDesignationList()));
                                echo $this->Form->input('designationID', array('value'=>$this->Common->getDesignationNameByID($rec['designation_id'],'01'),'label'=>false,'class'=>'md-input','type' => 'text','required','readonly'=>'readonly'));
                                echo $this->Form->input('designation_id', array('value'=>$rec['designation_id'],'label'=>false,'class'=>'md-input','type' => 'hidden','required','readonly'=>'readonly'));
                                ?>
                                
                        </div>
                       </div>
                    </div>
                <div  class="uk-grid" data-uk-grid-margin>
                    <div  class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">City Group<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('city_type', array('type'=>'select','label'=>false,'required'=>true,'class'=>"md-input",'empty' => '-- Select --','options'=>$city_grp_list,'default'=>$rec['city_type']));
                                  ?>
                             </div>
                       </div>
                
                    <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">Cash Allowance Daily  <span class="req">*</span></label>
                                <?php 
                                echo $this->Form->input('amount', array('value'=>$rec['amount'],'label'=>false,'class'=>'md-input','required'));
                                  ?>
                             </div>
                       </div>
                        <div class="uk-width-medium-1-3" >
                            <div class="parsley-row">
                                <label for="id_no">Hotel Entitlement<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('hotel_amount', array('value'=>$rec['hotel_amount'],'type'=>'text','label'=>false,'required'=>true,'class'=>"md-input"));
                                  ?>
                             </div>
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

