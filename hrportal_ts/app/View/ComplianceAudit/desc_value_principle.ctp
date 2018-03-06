<script>
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('desc_value_principle/'); ?>");
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }


</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Parameter Setup For Value and Principle</h1>
    </div>
    <div id="page_content_inner" >
        <?php echo $flash = $this->Session->flash();
        
        if($Typeid==''){
            $display="display: none;";
        }else{
            $display="display: block;";
        }
        ?> 
        <div class="md-card uk-width-medium-1-1"  id="addform"  style="<?php echo $display;?>">  
            <div class="md-card-content">

                <?php echo $this->Form->create('frm', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'desc_value_principle'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Parameter Setup</h3>
                <?php 
                
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            
                            <?php
                            echo $this->form->input('vp_type', array('type' => "select", 'label' => "Source *",'empty'=>'--Select--', 'options'=>$VPtype,'required' => true,'default'=>$eData['CADescValuePrinciple']['set_type_id'], 'class' => "md-input label-fixed"));
                            echo $this->form->input('parameterid', array('type' => "hidden", 'label' => false, 'value'=>$Typeid, 'class' => "md-input"));
                            ?>
                        </div>
                    </div> 
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            
                            <?php
                           echo $this->form->input('desc', array('type' => "text", 'label' => "Value and Principle *", 'required' => true,'value'=>$eData['CADescValuePrinciple']['description'], 'class' => "md-input label-fixed"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            
                            <?php
                             echo $this->form->input('belongs_to', array('type' => "select", 'label' => "Thematic Area *",'empty'=>'--Select--', 'options'=>$themAreaMaster,'required' => true,'default'=>$eData['CADescValuePrinciple']['thematic_area_id'], 'class' => "md-input label-fixed"));
                            
                            
                            ?>
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            
                            <?php
                             echo $this->form->input('app_legislation', array('type' => "text", 'label' => "application legislation *",'required' => true, 'value'=>$eData['CADescValuePrinciple']['app_legislation'], 'class' => "md-input label-fixed"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <?php
                             echo $this->form->input('applicable', array('type' => "text", 'label' => "Applicable policy/regulation/Legislation *",'required' => true,'value'=>$eData['CADescValuePrinciple']['applicable'], 'class' => "md-input label-fixed"));
                            ?>
                        </div>
                    </div>
                </div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2" >
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    
                      
                        <?php if($Typeid == ""){ ?>
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
                <h3 class="heading_a uk-margin-small-bottom">List of Parameters
                    <?php if($Typeid == ""){ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Create Parameters</a>
                <?php }else{ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Cancel</a>
                <?php }?>
                </h3>
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Value and Principle</th>
                                <th>Description</th>
                                <th>Thematic Area</th>
                                <th>Application Legislation</th>
                                <th>Applicable policy/regulation/Legislation</th>
                                <th>Created On</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($setType);
                            for($i=0;$i<count($setType);$i++)
                      {
                                $ctr = (($this->params['paging']['CADescValuePrinciple']['page']*$this->params['paging']['CADescValuePrinciple']['limit'])-$this->params['paging']['CADescValuePrinciple']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $p;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CASetType']['set_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CADescValuePrinciple']['description'];?></span></td>
                                <td>
                                    <span class="uk-text-small uk-text-muted uk-text-nowrap">
                                    <?php  echo $this->Common->findThematicAreaById($setType[$i]['CADescValuePrinciple']['thematic_area_id']);?>
                                    </span>
                                </td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CADescValuePrinciple']['app_legislation'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CADescValuePrinciple']['applicable'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($setType[$i]['CADescValuePrinciple']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('desc_value_principle/'.$setType[$i]['CADescValuePrinciple']['id']); ?>">Edit</a>
                                         | <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('desc_value_principle/'.$setType[$i]['CADescValuePrinciple']['id'].'/del');  ?>" onclick="return confirm('Are you sure?');">Delete</a></span></td>
                            </tr>
                            <?php  $p++; }?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                    <div  class="uk-width-medium-1-1">           
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
