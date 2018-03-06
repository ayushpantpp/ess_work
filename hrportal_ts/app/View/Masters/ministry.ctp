


<div id="page_content" role="main">
    <div id="page_content_inner">        
        <?php        
        if($meetingEditId != ""){
            $heading = "Update Ministry";
            $buttonName = "Update";
            $action = "ministry/ministryEdit/".$meetingEditId;
        }else{
            $heading = "Add Ministry";
            $buttonName = "Submit";
            $action = "ministry";
        }?>
        
        <h3 class="heading_b uk-margin-bottom"><?=$heading?></h3>
        
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                <?php if($meetingEditId != ""){ echo $this->form->input('id', array('class' => "md-input",'label' => false, 'value' => $meetingEditId, 'type' => 'hidden', 'id' => 'id'));}?>
                
                    <div class="uk-grid" data-uk-grid-margin>                        
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <?php echo $this->form->input('ministry_name.', array('label' => "Ministry Name", 'type' => "text", 'value' => $editMinistry['Ministry']['ministry_name'] ,'class' => "md-input",'id' => 'ministry_name', 'required' => true)); ?>                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('ministry_code.', array('label' => "Ministry Code",'class' => "md-input",'type' => 'text', 'value' => $editMinistry['Ministry']['ministry_code'],'id' => 'ministry_code', 'required' => true)); ?>                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('email_id.', array('label' => "Email Id",'class' => "md-input",'type' => 'email', 'value' => $editMinistry['Ministry']['email_id'],'id' => 'email_id', 'required' => true)); ?>                                
                            </div>
                        </div>
                    </div>   
                    
                    <?php if($meetingEditId == ""){?><a class="add md-btn md-btn-primary padding-left-lg" style="margin-top: 30px;">Add More</a><?php }?>
                    <button type="submit" name="submit" class="md-btn md-btn-success" style="margin-top: 30px;" href="#"><?=$buttonName;?></button>                    
                    <?php echo $this->Form->end();?>
            </div>
        </div>
        <div class="md-card">
                <div class="md-card-content">                    
                    <?php echo $this->Form->create('masters', array('url' =>array('controller' => 'masters', 'action' => 'ministry'),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                          
                                    <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                    <th>Ministry Name</th>
                                    <th>Ministry Code</th>
                                    <th>Email ID</th>
                                    <th>Ministry Status</th>                                    
                                    <th class="filter-false remove sorter-false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //echo "<pre>";
                                //print_r($ministryList);
                                //die;
                                
                      if(isset($ministryList)){
                          $p = 1;
                      for($i=0;$i<count($ministryList);$i++)
                      {
                        
                        $ctr = (($this->params['paging']['Ministry']['page']*$this->params['paging']['Ministry']['limit'])-$this->params['paging']['Ministry']['limit'])+$p;
                        
                        if($ministryList[$i]['Ministry']['ministry_status'] == 1){
                            $ministryStatus = "Active";
                            $ministryChacked = "checked = ''";
                            
                        }else{
                            $ministryStatus = "Deactive"; 
                            $ministryChacked = "";
                        }
                        
                        ?>
                    <tr>               
                        <td><input type="checkbox" data-md-icheck  <?php echo $ministryChacked;?> name="id[]" class="ts_checkbox" value="<?php echo $ministryList[$i]['Ministry']['id'];?>"></td>                        
                        <td><?php echo $ministryList[$i]['Ministry']['ministry_name'];?></td>
                        <td><?php echo $ministryList[$i]['Ministry']['ministry_code'];?></td>
                        <td><?php echo $ministryList[$i]['Ministry']['email_id'];?></td>
                        
                        <td><?php echo $ministryStatus;?></td>
                        
                        <td>                            
                            <a href="<?php echo $this->webroot;?>masters/ministry/ministryEdit/<?php echo $ministryList[$i]['Ministry']['id'];?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                            <a href="<?php echo $this->webroot;?>masters/ministryDelete/<?php echo $ministryList[$i]['Ministry']['id'];?>"  title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
                        </td>                          
                    </tr> 
                        
                     <?php $p++; } }  ?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                    <div class="uk-grid" data-uk-grid-margin>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <label for="hobbies" class="uk-form-label">Ministry Status (1 minimum):</label>
                                <span class="icheck-inline">
                                    <input type="radio" value="1" name="ministry_status" id="meeting_status" required="" data-md-icheck />
                                    <label for="val_check_ski" class="inline-label">Active</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" value="0" name="ministry_status" id="meeting_status" data-md-icheck />
                                    <label for="val_check_run" class="inline-label">De-Active</label>
                                </span>                              
                            </div>
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Status Update</button>
                            <button type="reset" name="reset" class="md-btn md-btn-primary">Reset</button>
                                
                        </div>
                        <div class="uk-width-medium-1-2">
                            <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                </div>
            </div>

    </div>
</div>

<script type="text/javascript">   
    
    $('.add').click(function() {
            $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-1-4"><div class="parsley-row"><?php echo $this->form->input('ministry_name.', array('label' => false, 'type' => "text",'class' => "md-input",'id' => 'ministry_name', 'required' => true)); ?></div></div><div class="uk-width-medium-1-4"><div class="parsley-row"><?php echo $this->form->input('ministry_code.', array('label' => false,'class' => "md-input",'type' => 'text', 'id' => 'ministry_code', 'required' => true)); ?></div></div><div class="uk-width-medium-1-4"><div class="parsley-row"><?php echo $this->form->input('email_id.', array('label' => false,'class' => "md-input",'type' => 'email', 'id' => 'email_id', 'required' => true)); ?></div></div><br><br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });

    $(document).on('click','.remove',function() {
            $(this).parent('div').remove();
    });
    
</script>   
