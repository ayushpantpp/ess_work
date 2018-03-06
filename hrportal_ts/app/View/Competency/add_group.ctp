<div id="page_content" role="main">
    <div id="page_content_inner">
        <?php        
        if ($groupEditId != "") {
            $heading = "Update Group";
            $buttonName = "Update";
            $action = "addGroup/groupEdit/" . $groupEditId;
        } else {
            $heading = "Add Group";
            $buttonName = "Submit";
            $action = "addGroup";
        }
        ?>
     
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">   <h3><?= $heading; ?></h3>
                <?php echo $this->Form->create('Competency', array('url' =>array('controller' => 'Competency', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                
                <?php if ($groupEditId != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $groupEditId, 'type' => 'hidden', 'id' => 'id'));
                } ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('groupName', array('class' => 'md-input', 'type' => 'text', 'value' => $editGroup['HcmGroupMaster']['group_name'], 'label' => 'Group Name', 'required' => TRUE)); ?>
                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            if ($editGroup['HcmGroupMaster']['status'] == 1) {
                                $ActiveStatus = "checked='checked'";
                                $DeactiveStatus = "";
                            } else if ($editGroup['HcmGroupMaster']['status'] == 2) {
                                $DeactiveStatus = "checked='checked'";
                                $ActiveStatus = "";
                            }
                            ?>
                            <label for="hobbies" class="uk-form-label">Status (1 minimum):</label>
                            <span class="icheck-inline">
                                <input type="radio" name="data[Competency][status]" <?= $ActiveStatus; ?> id="val_check_ski"  value="1" data-md-icheck data-parsley-mincheck="1" required />
                                <label for="val_check_ski" class="inline-label">Active</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="data[Competency][status]" <?= $DeactiveStatus; ?> id="val_check_ski" value="2" data-md-icheck />
                                <label for="val_check_ski" class="inline-label">Deactive</label>
                            </span>
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
            <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addGroup'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Group Name</th>
                                <th>Status</th>                                    
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //echo "<pre>";
                            //print_r($groupList);
                            //die;
                            if (isset($groupList)) {
                                $p = 1;
                                for ($i = 0; $i < count($groupList); $i++) {

                                    $ctr = (($this->params['paging']['HcmGroupMaster']['page'] * $this->params['paging']['HcmGroupMaster']['limit']) - $this->params['paging']['HcmGroupMaster']['limit']) + $p;
                                    
                                    if ($groupList[$i]['HcmGroupMaster']['status'] == 1) {
                                        $groupStatus = "Active";
                                    } else{
                                       $groupStatus = "Deactive";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo ucfirst($groupList[$i]['HcmGroupMaster']['group_name']); ?></td>                                        
                                        <td><?php echo $groupStatus; ?></td>
                                        <td>                            
                                            <a data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" href="<?php echo $this->webroot; ?>Competency/addGroup/groupEdit/<?php echo $groupList[$i]['HcmGroupMaster']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                            <!-- <a href="<?php echo $this->webroot; ?>Competency/groupDelete/<?php echo $groupList[$i]['HcmGroupMaster']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a> -->
                                        </td>                          
                                    </tr> 

        <?php $p++;
    }
} ?>

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
