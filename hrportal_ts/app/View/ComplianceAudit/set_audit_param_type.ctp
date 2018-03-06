<script type="text/javascript">
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('set_audit_param_type/'); ?>");
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }

function calling(){
alert('adsfasdfasdf');
}

</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Audit Parameter Set Type</h1>
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

                <?php echo $this->Form->create('frm', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'set_audit_param_type'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Audit Parameter Type</h3>
                <?php 
                
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <?php
                            echo $this->form->input('vpType', array('type' => "text", 'label' => "Set Name", 'required' => true,'value'=>$eData['CASetTypeAuditMonitoring']['set_name'], 'class' => "md-input"));
                            echo $this->form->input('vpTypeID', array('type' => "hidden", 'label' => "Set Name", 'required' => true,'value'=>$eData['CASetTypeAuditMonitoring']['id'], 'class' => "md-input"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                                        <?php  
                                        if($eData['CASetTypeAuditMonitoring']['status_for_monitoring'] == '1'){
                                            $checked = true;   
                                        }else{
                                            $checked = false;
                                        }
                                        echo $this->form->input('for_monitoring', array('type' => "checkbox",'checked'=>$checked, 'label' => false,'id'=>'checkbox_demo_1', 'onclick'=>'calling()', 'class' => "data-md-icheck"));?>
                                        <label for="checkbox_demo_1" class="inline-label">Populate to Monitoring and Evaluation</label>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
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
                <h3 class="heading_a uk-margin-small-bottom">List of Audit Parameter Type
                    <?php if($Typeid == ""){ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Create Audit Parameter Type</a>
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
                                <th>Set Name</th>
                                <th>Monitoring and Evaluation</th>
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
                                $ctr = (($this->params['paging']['CASetTypeAuditMonitoring']['page']*$this->params['paging']['CASetTypeAuditMonitoring']['limit'])-$this->params['paging']['CASetTypeAuditMonitoring']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $p;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CASetTypeAuditMonitoring']['set_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php if($setType[$i]['CASetTypeAuditMonitoring']['status_for_monitoring'] == "1"){echo "YES";}else{echo "NO";}?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($setType[$i]['CASetTypeAuditMonitoring']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('set_audit_param_type/'.$setType[$i]['CASetTypeAuditMonitoring']['id']); ?>">Edit</a>
                                         | 
                                         <?php if($setType[$i]['CASetTypeAuditMonitoring']['status'] == '0'){ ?>
                                         <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('set_audit_param_type/'.$setType[$i]['CASetTypeAuditMonitoring']['id'].'/1');  ?>" onclick="return confirm('Are you sure?');">Inactive</a></span>
                                         <?php }else{ ?><a class="uk-badge uk-badge-info" id="form_open" href="<?php echo $this->Html->url('set_audit_param_type/'.$setType[$i]['CASetTypeAuditMonitoring']['id'].'/0');  ?>" onclick="return confirm('Are you sure?');">Active</a></span>
                                         <?php }?>
                                    </td>
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
