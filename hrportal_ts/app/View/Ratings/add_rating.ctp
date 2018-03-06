<div id="page_content" role="main">
    <div id="page_content_inner">
        <?php        
        if (isset($ratingEditId) != "") {
            $heading = "Update Overall Rating (KRA + Competency)";
            $buttonName = "Update";
            $action = "addRating/ratingEdit/" . $ratingEditId;
        } else {
            $heading = "Overall Rating (KRA + Competency)";
            $buttonName = "Submit";
            $action = "addRating";
        }
        ?>
        <h3 class="heading_b uk-margin-bottom"><?= $heading; ?></h3>
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('Rating', array('url' =>array('controller' => 'Ratings', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                
                <?php if (isset($ratingEditId) != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $ratingEditId, 'type' => 'hidden', 'id' => 'id'));
                } ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('ratingName', array('class' => 'md-input', 'type' => 'text', 'value' => $editRating['Rating']['rating_name'], 'label' => 'Rating Title', 'required' => TRUE)); ?>
                        </div>
                    </div>
                </div>
         
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('ratingScalefrom', array('class' => 'md-input', 'type' => 'text', 'value' => $editRating['Rating']['rating_scale_from'], 'label' => 'Rating Scale From', 'required' => TRUE)); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('ratingScaleto', array('class' => 'md-input', 'type' => 'text', 'value' => $editRating['Rating']['rating_scale_to'], 'label' => 'Rating Scale To')); ?>
                        </div>
                    </div>
                </div>
                
                


                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="parsley-row">
                            <label for="message">Description (20 chars min, 2000 max)</label>
                            <?php 
                            $description = str_replace("&#39","'",$editRating['Rating']['description']);
                            
                            echo $this->Form->input('comment', array('class' => 'md-input', 'type' => 'textarea', 'label' => false ,'value' => $description, "data-parsley-trigger" => "keyup", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "2000", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..")); ?>

                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            if ($editRating['Rating']['status'] == 1) {
                                $ActiveStatus = "checked='checked'";
                                $DeactiveStatus = "";
                            } else if ($editRating['Rating']['status'] == 2) {
                                $DeactiveStatus = "checked='checked'";
                                $ActiveStatus = "";
                            }
                            ?>
                            <label for="hobbies" class="uk-form-label">Status (1 minimum):</label>
                            <span class="icheck-inline">
                                <input type="radio" name="data[Rating][status]" <?= $ActiveStatus; ?> id="val_check_ski"  value="1" data-md-icheck data-parsley-mincheck="1" required />
                                <label for="val_check_ski" class="inline-label">Active</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="data[Rating][status]" <?= $DeactiveStatus; ?> id="val_check_ski" value="2" data-md-icheck />
                                <label for="val_check_ski" class="inline-label">De Active</label>
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
        <h3 class="heading_b uk-margin-bottom uk-margin-top">Overall Rating (KRA + Competency) Scale</h3>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('Rating', array('url' => array('controller' => 'Rating', 'action' => 'addRating'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                                
                                <th class="uk-width-small-1-10">Rating</th>
                                <th class="uk-width-small-1-10">Score</th>
                                <th class="uk-width-small-1-10">Overall Description Of Performance</th>
                                <th class="uk-width-small-1-10">Status</th>                                    
                                <?php /* <th class="filter-false remove sorter-false">Action</th> */?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($ratingList)) {
                                $p = 1;
                                for ($i = 0; $i < count($ratingList); $i++) {

                                    $ctr = (($this->params['paging']['Rating']['page'] * $this->params['paging']['Rating']['limit']) - $this->params['paging']['Rating']['limit']) + $p;

                                    if ($ratingList[$i]['Rating']['status'] == 1) {
                                        $ratingStatus = "Active";
                                    } else {
                                        $ratingStatus = "Deactive";
                                    }
                                    
                                    if($ratingList[$i]['Rating']['rating_scale_from'] != "" && $ratingList[$i]['Rating']['rating_scale_to'] == ""){
                                       $ratingScale = "Below ".$ratingList[$i]['Rating']['rating_scale_from'];
                                    }else{
                                        $ratingScale = $ratingList[$i]['Rating']['rating_scale_from']." - ".$ratingList[$i]['Rating']['rating_scale_to'];
                                    }
                                    ?>
                                    <tr>
                                        
                                        <td><?php echo ucfirst($ratingList[$i]['Rating']['rating_name']); ?></td>
                                        <td><?php echo $ratingScale; ?></td>                                        
                                        <td><?php echo wordwrap(ucfirst($ratingList[$i]['Rating']['description']), 80, "<br />\n"); ?></td>
                                        <td><?php echo $ratingStatus; ?></td>
                                        <?php /*<td>                            
                                            <a href="<?php echo $this->webroot; ?>Ratings/addRating/ratingEdit/<?php echo $ratingList[$i]['Rating']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                            <a href="<?php echo $this->webroot; ?>Ratings/ratingDelete/<?php echo $ratingList[$i]['Rating']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>  
                                        </td>  */?>                        
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
