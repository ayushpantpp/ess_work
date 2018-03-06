<div id="page_content" role="main">
    <div id="page_content_inner">
        <?php        
        if (isset($competencyEditId) != "") {
            $heading = "Update Competency";
            $buttonName = "Update";
            $action = "addCompetency/competencyEdit/" . $competencyEditId;
        } else {
            $heading = "Add Competency";
            $buttonName = "Submit";
            $action = "addCompetency";
        }
        ?>
       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3><?= $heading; ?></h3>
                <?php echo $this->Form->create('Competency', array('url' =>array('controller' => 'Competency', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                
                <?php if (isset($competencyEditId) != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $competencyEditId, 'type' => 'hidden', 'id' => 'id'));
                } ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('competencyName', array('class' => 'md-input', 'type' => 'text', 'value' => $editCompetency['Competency']['competency_name'], 'label' => 'Competency Name', 'required' => TRUE)); ?>
                        </div>
                    </div>
                </div>


                <div class="uk-grid">
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="message">Description (20 chars min, 2000 max)</label>
                            <?php 
                            $description = str_replace("&#39","'",$editCompetency['Competency']['description']);
                            
                            echo $this->Form->input('comment', array('class' => 'md-input', 'type' => 'textarea', 'label' => false ,'value' => $description, "data-parsley-trigger" => "keyup", "data-parsley-minlength" => "20", "data-parsley-maxlength" => "2000", "data-parsley-validation-threshold" => "10", "data-parsley-minlength-message" => "Come on! You need to enter at least a 20 caracters long comment..")); ?>

                        </div>
                    </div>
                </div>
				<?php
				$totalScore=1;
				if($totalScore==1){
				?>
				  <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="message">Competency Group Type</label>
                            <?php
								if($editCompetency['Competency']['comp_type']==1){
									$selected="1";
								}elseif($editCompetency['Competency']['comp_type']==2){
									$selected="2";
								}elseif($editCompetency['Competency']['comp_type']==3){
									$selected="3";
								}else{
									$selected="0";
								}							
                            echo $this->Form->input('', array('name' => 'data[Competency][comp_type]','class' => 'md-input', 'type' => 'select', 'options' => array('Please select','Individual','Managerial','360 degree'),'default'=>$selected)); ?>

                        </div>
                    </div>
                </div>
				<?php
				}
				
				?>

                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php
                            if ($editCompetency['Competency']['status'] == 1) {
                                $ActiveStatus = "checked='checked'";
                                $DeactiveStatus = "";
                            } else if ($editCompetency['Competency']['status'] == 2) {
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
        <h3 class="heading_b uk-margin-bottom uk-margin-top">Competency List</h3>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addCompetency'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th class="uk-width-small-1-10">Competency Name</th>
                                <th class="uk-width-small-1-10">Description</th>
								<th class="uk-width-small-1-10">Competency Group Type</th>
                                <th class="uk-width-small-1-10">Status</th>                                    
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th class="uk-width-small-1-10">Competency Name</th>
                                <th class="uk-width-small-1-10">Description</th>
								<th class="uk-width-small-1-10">Competency Group Type</th>
                                <th class="uk-width-small-1-10">Status</th>  
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (isset($competencyList)) {
                                $p = 1;
                                for ($i = 0; $i < count($competencyList); $i++) {

                                    $ctr = (($this->params['paging']['Competency']['page'] * $this->params['paging']['Competency']['limit']) - $this->params['paging']['Competency']['limit']) + $p;

                                    if ($competencyList[$i]['Competency']['status'] == 1) {
                                        $competencyStatus = "Active";
                                    } else {
                                        $competencyStatus = "Deactive";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo ucfirst($competencyList[$i]['Competency']['competency_name']); ?></td>
                                        <td><?php echo wordwrap(ucfirst($competencyList[$i]['Competency']['description']),60, "<br />\n"); ?></td>
										<td><?php if($competencyList[$i]['Competency']['comp_type']==1){
												echo 'Individual';
											}elseif($competencyList[$i]['Competency']['comp_type']==2){
												echo 'Managerial';
											}elseif($competencyList[$i]['Competency']['comp_type']==3){
												echo '360 degree';
											}else{
												echo '-';
											} ?></td>
										<td><?php echo $competencyStatus; ?></td>
                                        <td>                            
                                            <a href="<?php echo $this->webroot; ?>Competency/addCompetency/competencyEdit/<?php echo $competencyList[$i]['Competency']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                            <!-- <a href="<?php echo $this->webroot; ?>Competency/competencyDelete/<?php echo $competencyList[$i]['Competency']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a> -->
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
                            //echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            //echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            //echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>
                </div>
            <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
