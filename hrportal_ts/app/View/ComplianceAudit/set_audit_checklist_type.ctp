<script type="text/javascript">
    function formOpen(create = null) {
        if (create != '') {
            location.replace("<?php echo $this->Html->url('set_audit_checklist_type/'); ?>");
        } else {
            jQuery("#addform").slideToggle('medium');
        }

    }


</script>
<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <h1>Set of Checklist Type</h1>
    </div>
    <div id="page_content_inner" >
        <?php
        echo $flash = $this->Session->flash();

        if ($Typeid == '') {
            $display = "display: none;";
        } else {
            $display = "display: block;";
        }
        ?> 
        <div class="md-card uk-width-medium-1-1"  id="addform"  style="<?php echo $display; ?>">  
            <div class="md-card-content">

                <?php echo $this->Form->create('frm', array('url' => array('controller' => 'ComplianceAudit', 'action' => 'set_audit_checklist_type'), 'type' => 'file', 'id' => 'form_validation', 'class' => 'uk-form-stacked padding-left-lg')); ?>
                <h3 class="heading_a">Checklist Type</h3>
                <?php if (!empty($EditData)) {
                    foreach ($EditData as $eData)
                        ;
                } ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <?php
                            echo $this->form->input('vpType', array('type' => "text", 'label' => "Checklist Name", 'required' => true, 'value' => $eData['CASetChecklistTypeAuditMonitoring']['checklist_name'], 'class' => "md-input"));
                            echo $this->form->input('vpTypeID', array('type' => "hidden", 'label' => "Set Name", 'required' => true, 'value' => $eData['CASetChecklistTypeAuditMonitoring']['id'], 'class' => "md-input"));
                            ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <?php
                            if ($eData['CASetChecklistTypeAuditMonitoring']['status_for_monitoring'] == '1') {
                                $checked = true;
                            } else {
                                $checked = false;
                            }
                            echo $this->form->input('for_monitoring', array('type' => "checkbox", 'checked' => $checked, 'label' => false, 'id' => 'checkbox_demo_1', 'class' => "data-md-icheck"));
                            ?>
                            <label for="checkbox_demo_1" class="inline-label">Populate to Monitoring and Evaluation</label>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3" >
                        <button type="submit" name="submit"  class="md-btn md-btn-success" value="submit">Save</button>                    

                        <?php if ($Typeid == "") { ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('')">Cancel</a> 
<?php } else { ?>
                            <a class="md-btn md-btn-primary" id="form_open" onclick="return formOpen('<?php echo $create; ?>')">Cancel</a> 
<?php } ?>                       
                    </div>
                </div> 


                <div class="uk-grid">

                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="md-card" >
            <div class="md-card-content ">
                <h3 class="heading_a uk-margin-small-bottom">List of Checklist Type
                    <?php if ($Typeid == "") { ?>
                        <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create; ?>')">Create Checklist Type</a>
<?php } else { ?>
                        <a  class="md-btn md-btn-primary uk-float-right" onclick="return formOpen('<?php echo $create; ?>')">Cancel</a>
<?php } ?>
                </h3>
                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Set Name</th>
                                <th>In Monitoring</th>
                                <th>Created On</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $p = 1;
//                            echo "<pre>";
//                            print_r($setType);
                            for ($i = 0; $i < count($setType); $i++) {
                                $ctr = (($this->params['paging']['CASetChecklistTypeAuditMonitoring']['page'] * $this->params['paging']['CASetChecklistTypeAuditMonitoring']['limit']) - $this->params['paging']['CASetChecklistTypeAuditMonitoring']['limit']) + $p;
                                ?>
                                <tr>
                                    <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $p; ?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $setType[$i]['CASetChecklistTypeAuditMonitoring']['checklist_name']; ?></span></td>
                                    <td ><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                            <?php
                                            if ($setType[$i]['CASetChecklistTypeAuditMonitoring']['status_for_monitoring'] == '1') {
                                                echo "Yes";
                                            } else {
                                                echo "No";
                                            }
                                            ?>
                                        </span>
                                    </td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo date("d/m/Y", strtotime($setType[$i]['CASetChecklistTypeAuditMonitoring']['created_on'])); ?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-nowrap">
                                            <a class="uk-badge uk-badge-success" id="form_open" href="<?php echo $this->Html->url('set_audit_checklist_type/' . $setType[$i]['CASetChecklistTypeAuditMonitoring']['id']); ?>">Edit</a>
                                            | 
                                            <?php if($setType[$i]['CASetChecklistTypeAuditMonitoring']['status'] == '0'){ ?><a class="uk-badge uk-badge-danger" id="form_open" href="<?php echo $this->Html->url('set_audit_checklist_type/'.$setType[$i]['CASetChecklistTypeAuditMonitoring']['id'].'/1');  ?>" onclick="return confirm('Are you sure?');">Inactive</a></span>
                                         <?php }else{ ?><a class="uk-badge uk-badge-info" id="form_open" href="<?php echo $this->Html->url('set_audit_checklist_type/'.$setType[$i]['CASetChecklistTypeAuditMonitoring']['id'].'/0');  ?>" onclick="return confirm('Are you sure?');">Active</a></span>
                                         <?php }?>
                                         </td>
                                </tr>
    <?php $p++;
} ?>
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
