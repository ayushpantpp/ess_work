<script>
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('parameter_type/'); ?>");
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }


</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Survey Parameter Master</h1>
    </div>
    <div id="page_content_inner" >
        <?php echo $flash = $this->Session->flash();
        
        if($CTid==''){
            $display="display: none;";
        }else{
            $display="display: block;";
        }
        ?> 
        <div class="md-card uk-width-medium-1-1"  id="addform"  style="<?php echo $display;?>">  
            <div class="md-card-content">

                <?php echo $this->Form->create('SurveyMaster', array('url' => array('controller' => 'Surveys', 'action' => 'create_survey'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Create Survey Parameter</h3>
                <?php 
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <?php
                            echo $this->form->input('date', array('type' => "text", 'label' => "Survey Date", 'required' => true,'id'=>'date', 'class' => "md-input"));
                            echo $this->form->input('id', array('type' => "hidden", 'label' => false, 'value'=>$CTid, 'class' => "md-input"));
                            ?>
                        </div>
                    </div>                  
                    <div class="uk-width-medium-1-2" >
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    
                      
                        <?php if($CTid == ""){ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('')">Cancel</a> 
                            <?php }else{ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('<?php echo $create;?>')">Cancel</a> 
                        <?php }?>                       
                    </div>
                </div> 
                

                <div class="uk-grid">
                    
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Surveys 
                    <?php if($CTid == ""){ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Create Survey</a></h3>
                <?php }else{ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Cancel</a></h3>
                <?php }?>
                
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Survey ID</th>
                                <th>Created On</th>
                                <th>Survey Link</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            $i=1;
                            foreach($data as $rec){ ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['SurveyMaster']['id'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d-M-Y", strtotime($rec['SurveyMaster']['date']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php echo $this->form->input('', array('type' => "text", 'label' => false, 'value'=> 'http://'.$_SERVER[HTTP_HOST].$this->webroot.'Surveys/index/'.$rec['SurveyMaster']['id'] ,'class' => "md-input"));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                      <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('survey_detail/'.$rec['SurveyMaster']['id']); ?>" target="blank">Download Survey Result</a>
                                </span></td>
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                    <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery("#date").datepicker({
            inline: true,
            changeMonth: true,
            autoclose: true,
            //changeYear: true,
            Format: 'dd-mm-yy'

        });
</script>
