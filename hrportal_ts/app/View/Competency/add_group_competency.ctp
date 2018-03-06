<?php

    $groupMasterList = $this->Common->findGroupMasterList($hoOrgId,$orgId);
    $competencyList = $this->Common->findCompetencyList();
    if ($competencyGroupEditId != "") {
        $heading = "Update Group Competency";
        $buttonName = "Update";
        $action = "addGroupCompetency/competencyGroupEdit/" . $competencyGroupEditId;
    } else {
        $heading = "Add Group Competency";
        $buttonName = "Submit";
        $action = "addGroupCompetency";
    }
?>
<div id="page_content" role="main">
    <div id="page_content_inner">
       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3><?=$heading?></h3>
                <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => $action), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>

                <?php
                if ($competencyGroupEditId != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $competencyGroupEditId, 'type' => 'hidden', 'id' => 'id'));
                }
                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Group List</label>
                        <div class="parsley-row">
                        <?php
                            echo $this->form->input('group_id', array('label' => "", 'type' => "select", 'empty' => ' -- Select Group --', 'default' => $editGroupCompetency['GroupCompetency']['group_id'], 'options' => $groupMasterList, 'class' => "md-input", 'id' => 'task_id', 'required' => TRUE));
                        ?>                                                            
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">Select Competency</label>
                            <?php 
                                
                                if($editGroupCompetency['GroupCompetency']['competency_id']){
                                    echo $this->form->input('competency_id.', array('label' => "", 'type' => "select", 'empty' => ' -- Select Competency --', 'default' => $editGroupCompetency['GroupCompetency']['competency_id'], 'options' => $competencyList, 'class' => "md-input", 'id' => 'task_id', 'data-md-selectize'));
                                }else{
                            ?>
                            
                            
                            <select id="kUI_multiselect_basic" name="competency_id[]" required="" id="employee_id" multiple="multiple" data-placeholder="Select Competency...">
                                <?php 
                                        foreach ($competencyList as $k => $val) {
                                            if($k == $editGroupCompetency['GroupCompetency']['competency_id']){
                                                $selected = "selected = 'selected'";                                                
                                            }else{
                                                $selected = "";
                                            }
                                    ?>
                                    <option value='<?php echo $k ?>' <?=$selected?>> <?php echo ucfirst($val);?></option>
                            <?php } ?>
                            </select>
                                <?php }?>
                        </div>
                    </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#"><?= $buttonName ?></button>
                    </div>
                </div>                           

            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">                    
                <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addCompetency'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Group Name</th>
                                <th>Competency Name</th>                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //echo count($competencyGroupList);
                            if (isset($competencyGroupList)) {
                                $p = 1;
                                for ($i = 0; $i < count($competencyGroupList); $i++) {

                                    $ctr = (($this->params['paging']['GroupCompetency']['page'] * $this->params['paging']['GroupCompetency']['limit']) - $this->params['paging']['GroupCompetency']['limit']) + $p;
                                    $groupName = $this->Common->findGroupMasterName($competencyGroupList[$i]['GroupCompetency']['group_id']);
                                    $competencyName = $this->Common->findCompetencyName($competencyGroupList[$i]['GroupCompetency']['competency_id']);
                                    
                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo ucfirst($groupName); ?></td>
                                        <td><?php echo ucfirst($competencyName); ?></td>                                        
                                        <td>                            
                                            <a data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="<?php echo $this->webroot; ?>Competency/addGroupCompetency/competencyGroupEdit/<?php echo $competencyGroupList[$i]['GroupCompetency']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                            <!-- <a href="<?php echo $this->webroot; ?>Competency/groupCompetencyDelete/<?php echo $competencyGroupList[$i]['GroupCompetency']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a> -->
                                        </td>                          
                                    </tr> 

                                    <?php
                                    $p++;
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
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
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
