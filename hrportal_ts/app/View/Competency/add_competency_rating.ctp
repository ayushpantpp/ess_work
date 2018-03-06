<div id="page_content" role="main">
    <div id="page_content_inner">
        
       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3>Add Competency Rating</h3>
                <?php echo $this->Form->create('CompetencyRating', array('url' =>array('controller' => 'Competency', 'action' => "addCompetencyRating"),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>                
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('ratingScale', array('class' => 'md-input', 'type' => 'text', 'label' => 'Rating Scale', 'required' => TRUE, 'maxlength' => "2","onkeypress" => "return isNumberKey(event)")); ?>
                        </div>
                    </div>
                </div>
                
                <!--  <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('achievement_from', array('class' => 'md-input', 'type' => 'text', 'label' => 'Achievement From', 'required' => TRUE, 'maxlength' => "4", "onkeypress" => "return isNumberKey(event)")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('achievement_to', array('class' => 'md-input', 'type' => 'text', 'label' => 'Achievement To', 'maxlength' => "4", "onkeypress" => "return isNumberKey(event)")); ?>
                        </div>
                    </div>
                </div> -->

                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <div class="parsley-row">
                            <label for="message">Comment (20 chars min, 500 max)</label>
                            <?php echo $this->Form->input('comment', array('class' => 'md-input', 'type' => 'textarea', 'label' => false , "data-parsley-trigger" => "keyup", "data-parsley-maxlength" => "500", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Please enter at least a 20 characters long comment..")); ?>

                        </div>
                    </div>
                </div>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                            
                            <label for="hobbies" class="uk-form-label">Status (1 minimum):</label>
                            <span class="icheck-inline">
                                <input type="radio" name="data[CompetencyRating][status]" id="val_check_ski"  value="1" data-md-icheck checked="" />
                                <label for="val_check_ski" class="inline-label">Active</label>
                            </span>
                            <span class="icheck-inline">
                                <input type="radio" name="data[CompetencyRating][status]" id="val_check_ski" value="2" data-md-icheck />
                                <label for="val_check_ski" class="inline-label">De Active</label>
                            </span>
                        </div>
                    </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success">Submit</button>
                        <button type="reset" name="submit" class="md-btn md-btn-primary">Cancel</button>
                    </div>
                </div>                            

            </div>

        </div>
        
        <h3 class="heading_b uk-margin-bottom uk-margin-top">Competency Rating Scale</h3>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('CompetencyRating', array('url' => array('controller' => 'CompetencyRating', 'action' => 'addCompetencyRating'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="">
                        <thead>
                            <tr>
                                
                                <th>Rating</th>
                                <!-- <th class="uk-width-small-1-10">Overall Achievement</th> -->
                                <th>Description of Rating</th>
                                <th>Status</th>                                    
                                <?php /* <th class="filter-false remove sorter-false">Action</th> */?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($kraRatingList)) {
                                $p = 1;
                                for ($i = 0; $i < count($kraRatingList); $i++) {

                                    $ctr = (($this->params['paging']['CompetencyRating']['page'] * $this->params['paging']['CompetencyRating']['limit']) - $this->params['paging']['CompetencyRating']['limit']) + $p;

                                    if ($kraRatingList[$i]['CompetencyRating']['status'] == 1) {
                                        $kraRatingStatus = "Active";
                                    } else {
                                        $kraRatingStatus = "Deactive";
                                    }
                                    
                                    if ($kraRatingList[$i]['CompetencyRating']['rating_scale'] == 1 && $kraRatingList[$i]['CompetencyRating']['achievement_from'] == 60) {
                                        $overAllAchievement = "<".$kraRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                    }else if ($kraRatingList[$i]['CompetencyRating']['rating_scale'] == 5 && $kraRatingList[$i]['CompetencyRating']['achievement_from'] >= 120) {
                                        $overAllAchievement = ">=".$kraRatingList[$i]['CompetencyRating']['achievement_from']."%";
                                    }else{
                                        $overAllAchievement = $kraRatingList[$i]['CompetencyRating']['achievement_from']."% - ".$kraRatingList[$i]['CompetencyRating']['achievement_to']."%";
                                    }
                                    ?>
                                    <tr>
                                        
                                        <td><?php echo ucfirst($kraRatingList[$i]['CompetencyRating']['rating_scale']); ?></td>
                                        <!--  <td><?php echo $overAllAchievement; ?></td>   -->                                     
                                        <td><?php echo wordwrap(ucfirst($kraRatingList[$i]['CompetencyRating']['comment']), 80, "<br />\n"); ?></td>
                                        <td><?php echo $kraRatingStatus; ?></td>
                                        <td>
                                            <?php /*<a href="#" data-uk-tooltip="{cls:'uk-tooltip-small',pos:'left'}" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
                                            <a href="<?php echo $this->webroot; ?>Competency/competencyRatingDelete/<?php echo base64_encode($kraRatingList[$i]['CompetencyRating']['id']); ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a> */ ?>
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
function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }

        if (charCode == 46) {
            return false;
        }
        return true;
    }


</script>
