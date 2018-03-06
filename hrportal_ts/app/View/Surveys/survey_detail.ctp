
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Survey Parameter Master</h1>
    </div>
    <div id="page_content_inner" >
        <?php echo $flash = $this->Session->flash();
        ?> 
        <div class="md-card uk-width-medium-1-1"  id="addform"  style="<?php echo $display;?>">  
            <div class="md-card-content">

                <?php echo $this->Form->create('SurveyRecord', array('url' => array('controller' => 'Surveys', 'action' => 'save_record'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a uk-margin-small-bottom">Internal Survey Details </h3>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <?php echo "Date : ".date('d-M-Y');?>
                        </div>
                    </div> 
                    
                    <div class="uk-width-medium-1-1" >
                        <div class="parsley-row">
                            <label for="qsn_desc">Question Description</label>
                            <?php
                            echo $this->form->input('Detail.emp_name', array('type' => "text", 'label' => "Employee Name", 'required' => true,'class' => "md-input"));
                            
                            ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <?php
                            $dept_list = $this->Common->getdepartmentlist();
                            echo $this->form->input('Detail.dept_id', array('type' => "select", 'label' => "Departments", 'required' => false,'options'=>$dept_list,'class' => "md-input"));
                            ?>
                        </div>
                    </div>   
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="qsn_desc">Survey No</label>
                            <?php 
                            echo $this->form->input('Detail.survey_id', array('type' => "text", 'label' => false, 'required' => false,'value'=>$survey_id,'class' => "md-input"));
                            
                            ?>
                        </div>
                    </div>
                </div>
                
                <h3 class="heading_a uk-margin-small-bottom">Internal Survey Details</h3>
                <?php foreach($qsn_ans as $cnt){?>
                <div class="uk-accordion" data-uk-accordion="{ collapse: false }">
                    <h3 class="uk-accordion-title"><?php echo $cnt['SurveyParameter']['name'] ?></h3>
                    <div class="uk-accordion-content">
                        <?php $sr = 1;?>
                        <?php foreach($cnt['SurveyQuestion'] as $qsn){?>
                        <?php echo $this->form->input('Question.'.$qsn['id'].'.parameter_id', array('type' => "hidden", 'label' => false, 'required' => false,'value'=>$cnt['SurveyParameter']['id'],'class' => "md-input"));?>
                    
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1" >
                                <div class="parsley-row">
                                    <?php echo $this->form->input('Question.'.$qsn['id'].'.qsn_id', array('type' => "hidden", 'label' => false, 'value'=>$qsn['id'], 'class' => "md-input"));?>
                                    <div class="uk-accordion">
                                        <h3 class="uk-accordion-title">Qsn: <?php echo $sr." "; ?><?php echo $qsn['qsn_desc']?></h3>
                                    </div>
                                </div>
                            </div> 
                            <?php $sr++; ?>
                            <div class="uk-width-medium-1-1" >
                                <div class="parsley-row">
                                    <?php $options = $this->Common->get_qsn_options(1);?>
                                    <?php foreach($options as $opt){?>
                                        <input type="radio" name="data[Question][<?php echo $qsn['id']; ?>][option_id]" value="<?php echo $opt['SurveyOption']['id']; ?>" required="required" id="radio_demo_1" data-md-icheck />
                                        <label for="radio_demo_1" class="inline-label"><?php echo $opt['SurveyOption']['option_desc'];?></label>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                <?php }?>
                    </div>
                </div>
                
                <?php }?>
                 <div class="uk-width-medium-1-2" >
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    
                        <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('')">Cancel</a> 
                    </div>

                <div class="uk-grid">
                    
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        
    </div>
</div>
