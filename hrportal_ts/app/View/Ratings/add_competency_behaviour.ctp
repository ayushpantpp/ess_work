<div id="page_content" role="main">
    <div id="page_content_inner">
        <?php        
        if (isset($behaviourEditId) != "") {
            $heading = "Update Behavioural Indicators";
            $buttonName = "Update";
            $action = "addCompetencyBehaviour/ratingEdit/" . $behaviourEditId;
        } else {
            $heading = "Add Behavioural Indicators";
            $buttonName = "Submit";
            $action = "addCompetencyBehaviour";
        }?>
        <h3 class="heading_b uk-margin-bottom"><?= $heading; ?></h3>
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('CompetencyBehaviour', array('url' =>array('controller' => 'Ratings', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                
                <?php if (isset($behaviourEditId) != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $behaviourEditId, 'type' => 'hidden', 'id' => 'id'));
                } ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label>Select Competency</label>
                            
                            <select name="data[CompetencyBehaviour][CompetencyName]" id="val_select" required data-md-selectize>
                                <option value=""> - Select Competency - </option>
                                <?php foreach ($Competency as $key => $value){
                                    if($key == $editCompetencyBehaviour['CompetencyBehaviour']['compitency_id']){
                                       $selected = "selected='selected'"; 
                                    }else{
                                        $selected = "";
                                    }?>
                                <option value="<?=$key?>" <?=$selected?>><?=ucfirst($value)?></option>
                                <?php } ?>
                            </select>
                            <?php //echo $this->Form->input('CompetencyName', array('class' => 'md-input', 'type' => 'select', 'options' => $Competency, 'value'=> $editCompetencyBehaviour['CompetencyBehaviour']['compitency_id'],'label' => 'Select Competency', 'required' => TRUE, "data-md-selectize")); ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-medium-8-10">
                        <div class="parsley-row">
                            <label for="message">Description (20 chars min, 2000 max)</label>
                            <?php 
                            $description = str_replace("&#39","'",$editCompetencyBehaviour['CompetencyBehaviour']['behaviour_desc']);
                            
                            echo $this->Form->input('comment.', array('class' => 'md-input', 'type' => 'text', 'label' => false ,'required' => TRUE, 'value' => $description,"data-parsley-trigger" => "keyup", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "2000", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..")); ?>

                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top"> 
                        <?php if($behaviourEditId == ""){?><a class="add md-btn md-btn-primary padding-left-lg" style="margin-top: 30px;">Add More</a><?php }?>
                        </div>
                </div>  

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            if ($editCompetencyBehaviour['CompetencyBehaviour']['status'] == 1) {
                                $ActiveStatus = "checked='checked'";
                                $DeactiveStatus = "";
                            } else if ($editCompetencyBehaviour['CompetencyBehaviour']['status'] == 2) {
                                $DeactiveStatus = "checked='checked'";
                                $ActiveStatus = "";
                            }
                            ?>
                            <label for="hobbies" class="uk-form-label">Status (1 minimum):</label>
                            <span class="icheck-inline">
                                <input type="radio" name="data[CompetencyBehaviour][status]" <?= $ActiveStatus; ?> id="val_check_ski"  value="1" data-md-icheck data-parsley-mincheck="1" required />
                                <label for="val_check_ski" class="inline-label">Active</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="data[CompetencyBehaviour][status]" <?= $DeactiveStatus; ?> id="val_check_ski" value="2" data-md-icheck />
                                <label for="val_check_ski" class="inline-label">De Active</label>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top"> 
                        <button type="submit" name="submit" class="md-btn md-btn-success" ><?= $buttonName ?></button>
                        <input type="reset" name="reset" class="md-btn md-btn-primary" value="Cancel">
                    </div>
                </div>                            

            </div>

        </div>
        <h3 class="heading_b uk-margin-bottom uk-margin-top">Competency Behaviour List</h3>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('CompetencyBehaviour', array('url' => array('controller' => 'CompetencyBehaviour', 'action' => 'addCompetencyBehaviour'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th class="uk-width-small-1-10">Competency Title</th>
                                <th class="uk-width-small-1-10">Behaviour Description</th>
                                <th class="uk-width-small-1-10">Status</th>                                    
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($behaviourList)) {
                                $p = 1;
                                for ($i = 0; $i < count($behaviourList); $i++) {

                                    $ctr = (($this->params['paging']['CompetencyBehaviour']['page'] * $this->params['paging']['CompetencyBehaviour']['limit']) - $this->params['paging']['CompetencyBehaviour']['limit']) + $p;

                                    if ($behaviourList[$i]['CompetencyBehaviour']['status'] == 1) {
                                        $ratingStatus = "Active";
                                    } else {
                                        $ratingStatus = "Deactive";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo $this->Common->findCompetencyNameByID($behaviourList[$i]['CompetencyBehaviour']['compitency_id']); ?></td>
                                        <td><?php echo wordwrap(ucfirst($behaviourList[$i]['CompetencyBehaviour']['behaviour_desc']), 80, "<br />\n"); ?></td>
                                        <td><?php echo $ratingStatus; ?></td>
                                        <td>                            
                                            <a href="<?php echo $this->webroot; ?>Ratings/addCompetencyBehaviour/ratingEdit/<?php echo $behaviourList[$i]['CompetencyBehaviour']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                            <a href="<?php echo $this->webroot; ?>Ratings/competencyBehaviourDelete/<?php echo $behaviourList[$i]['CompetencyBehaviour']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a> 
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


<script type="text/javascript">   
    
    $('.add').click(function() {
            $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-8-10">\n\
                            <div class="parsley-row"><?php echo $this->form->input('CompetencyBehaviour.comment.', array('label' => false, 'type' => "text",'class' => "md-input",'id' => 'ministry_name', 'required' => true,'label' => false ,"data-parsley-trigger" => "keyup", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "2000", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..")); ?></div>\n\
                            </div>\n\
                            <br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });

    $(document).on('click','.remove',function() {
            $(this).parent('div').remove();
    });
    
</script> 