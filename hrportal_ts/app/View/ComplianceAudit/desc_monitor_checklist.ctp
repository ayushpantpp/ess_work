<script>
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('desc_audit_checklist/'); ?>");
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }


</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Audit Checklist</h1>
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
                <?php echo $this->Form->create('ComplianceAudit', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'desc_monitor_checklist'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Audit Checklist Parameter</h3>
                <?php 
              
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            
                            <?php
                            echo $this->form->input('vp_type', array('type' => "select", 'label' => "Audit Checklist Type",'empty'=>'--Select--', 'options'=>$VPtype, 'default'=>$eData['CADescAuditChecklist']['checklist_type'],'required' => true, 'class' => "md-input label-fixed"));
                            echo $this->form->input('parameterid', array('type' => "hidden", 'label' => false, 'value'=>$Typeid, 'class' => "md-input"));
                            ?>
                        </div>
                    </div> 
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin > 
                                <div class="uk-width-1-3"> 
                            <div class="uk-overflow-container">
                            <table border="1" class="uk-table uk-tab-responsive"  id="TextBoxesGroup1">
                                <tr>
                                    <th  class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Sr.No.</th>
                                    <th  class="uk-text-center md-bg-blue-100 uk-text-small">Description</th>
                                </tr>

                                <tr>
                                    <td class="uk-text-center uk-width-small-1-10">1<?php echo $this->Form->input("rowCount", array("type" => "hidden", "id" => "rowCount", "value" => "1")); ?></td>                            
                                    <td class="uk-width-small-1-1"><?php echo $this->Form->input("desc.", array("class" => "uk-width-medium-1-1 desc ", "label" => "", "value"=>$eData['CADescAuditChecklist']['description'],"required"=>true, "type" => "text", "id" => "desc_1")); ?></td>
                                </tr>
                            </table>

                            </div>
                                </div>
                            <div class="uk-width-1-3"> 
                                <?php if($Typeid == ''){?>
                                <!--<input type="submit" class="md-btn md-btn-success" onclick="return confirmAction();" name="submit" value="Submit">-->
                                <input type='button' class="md-btn md-btn-primary plusbtn1"  value='Add More' id='addButton1'>
                                <input type='button' class="md-btn md-btn-danger minusbtn1" value='Remove' id='removeButton1'>
                                <?php }?>
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
                                <th>Monitor Checklist Type</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            
                            $p=1;
//                            echo "<pre>";
//                            print_r($allrecord);
                            for($i=0;$i<count($allrecord);$i++)
                      {
                                $ctr = (($this->params['paging']['CADescAuditChecklist']['page']*$this->params['paging']['CADescAuditChecklist']['limit'])-$this->params['paging']['CADescAuditChecklist']['limit'])+$p;
                                
                                ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $ctr;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $allrecord[$i]['CASetChecklistTypeAuditMonitoring']['checklist_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $allrecord[$i]['CADescAuditChecklist']['description'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($allrecord[$i]['CADescAuditChecklist']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('desc_monitor_checklist/'.$allrecord[$i]['CADescAuditChecklist']['id']); ?>">Edit</a>
                                         |
                                         <?php if($allrecord[$i]['CADescAuditChecklist']['status'] == '0'){ ?><a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('desc_monitor_checklist/'.$allrecord[$i]['CADescAuditChecklist']['id'].'/1');  ?>" onclick="return confirm('Are you sure?');">Inactive</a></span>
                                         <?php }else{ ?><a class="uk-badge uk-badge-info" id="form_open" href="<?php echo $this->Html->url('desc_monitor_checklist/'.$allrecord[$i]['CADescAuditChecklist']['id'].'/0');  ?>" onclick="return confirm('Are you sure?');">Active</a></span>
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
<script type="text/javascript">


    var counter = 2;
<?php $count = 2; ?>
    $('.plusbtn1').click(function () {
        
        if (counter > 10) {
                alert("Only 10 label can create at a time");
                return false;
            }

        $("#TextBoxesGroup1").append('<tr><?php echo $this->Form->create("ComplianceAudit"); ?>' +
                '<td class="uk-text-center uk-width-small-1-10">' + counter + '</td>' +
                '<td class="uk-text-center uk-width-small-1-1"><?php echo $this->Form->input("desc.", array("class" => "uk-width-medium-1-1 desc ", "label" => "", "type" => "text", "id" => "desc_" . $count, "required" => True)); ?></td>' +
                '</tr>');
<?php $count++; ?>
        $('#rowCount').val(counter);
        
        counter++;
    });
    $('.minusbtn1').click(function () {
        if ($("#TextBoxesGroup1 tr").length != 2) {
            $("#TextBoxesGroup1 tr:last-child").remove();
            
            counter--;
            $('#rowCount').val(counter-1);
        }
        else {
            alert("You cannot delete first row");
        }
    });
    
    </script>