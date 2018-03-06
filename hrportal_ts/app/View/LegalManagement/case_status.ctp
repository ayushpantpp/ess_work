<script>
    function formOpen(create=null) {
        if(create!=''){
            location.replace("<?php echo $this->Html->url('case_type/'); ?>");
            $('#addform').show();
        }else{
            jQuery("#addform").slideToggle('medium');
        }
        
    }



</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Case Status Setup</h1>
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

                <?php echo $this->Form->create('frm', array('url' => array('controller' => 'LegalManagement', 'action' => 'case_status'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <h3 class="heading_a">Create Case Status</h3>
                <?php 
                if(!empty($EditData)){ foreach($EditData as $eData);}?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="case_status">Case Status<span class="req">*</span></label>
                            <?php
                            echo $this->form->input('case_status', array('type' => "text", 'label' => false, 'required' => true,'value'=>$eData['CaseStatus']['case_status'], 'class' => "md-input"));
                            echo $this->form->input('ctid', array('type' => "hidden", 'label' => false, 'value'=>$CTid, 'class' => "md-input"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-1-2 ">                            
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    
                    
                        <?php if($CTid == ""){ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('')">Cancel</a> 
                            <?php }else{ ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('<?php echo $create;?>')">Cancel</a> 
                        <?php }?>
                                              
                    </div>

                </div> 
                
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Case Status 
                <?php if($CTid == ""){ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Create Case Status</a></h3>
                <?php }else{ ?>
                <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create;?>')">Cancel</a></h3>
                <?php }?>
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Case Status</th>
                                <th>Created On</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            
                            foreach($data as $rec){ ?>
                            <tr>
                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $i;?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $rec['CaseStatus']['case_status'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($rec['CaseStatus']['created_on']));?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                        <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('case_status/'.$rec['CaseStatus']['id']); ?>">Edit</a>
                                        <!-- | <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('case_status/'.$rec['CaseStatus']['id'].'/del'); ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                        -->
                                         |
                                         <?php if($rec['CaseStatus']['status'] == '0'){?>
                                         <a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('case_status/'.$rec['CaseStatus']['id'].'/1'); ?>" onclick="return confirm('Do you want to inactive this record ?');">Inactive</a>
                                         <?php }elseif($rec['CaseStatus']['status']=='1'){?>
                                         <a class="uk-badge uk-badge-primery" id="form_open" href="<?php echo $this->Html->url('case_status/'.$rec['CaseStatus']['id'].'/0'); ?>" onclick="return confirm('Do you want to activate this record ?');">Active</a>
                                         <?php } ?>
                                        </span></td>
                            </tr>
                            <?php  $i++; }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
