
<div id="page_content" role="main">
    <div id="page_content_inner">        
        <?php        
        if($termsOfServiceEditId != ""){
            $heading = "Update Terms of Service Type";
            $buttonName = "Update";
            $action = "termsOfService/termsOfServiceEdit/".$termsOfServiceEditId;
        }else{
            $heading = "Add Terms of Service Type";
            $buttonName = "Submit";
            $action = "termsOfService";
        }?>
        
        <h3 class="heading_b uk-margin-bottom"><?=$heading?></h3>
        
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => $action),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                <?php if($termsOfServiceEditId != ""){ echo $this->form->input('id', array('class' => "md-input",'label' => false, 'value' => $termsOfServiceEditId, 'type' => 'hidden', 'id' => 'id'));}?>
                
                    <div class="uk-grid" data-uk-grid-margin>                        
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <?php echo $this->form->input('tos_name.', array('label' => "Terms of Service Name", 'type' => "text", 'value' => $editTermsOfService['MstTermsOfService']['tos_name'] ,'class' => "md-input",'id' => 'tos_name', 'required' => true)); ?>                                
                            </div>
                        </div>
                    </div>   
                    
                    <?php if($termsOfServiceEditId == ""){?><a class="add md-btn md-btn-primary padding-left-lg" style="margin-top: 30px;">Add More</a><?php }?>
                    <button type="submit" name="submit" class="md-btn md-btn-success" style="margin-top: 30px;" href="#"><?=$buttonName;?></button>                    
                    <?php echo $this->Form->end();?>
            </div>
        </div>
        <div class="md-card">
                <div class="md-card-content">                    
                    <?php echo $this->Form->create('masters', array('url' =>array('controller' => 'masters', 'action' => 'termsOfService'),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                          
                                    <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                    <th>Terms of Service Name</th>                                    
                                    <th>Terms of Service Status</th>                                    
                                    <th class="filter-false remove sorter-false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //echo "<pre>";
                                //print_r($termsOfServiceList);
                                //die;
                                
                      if(isset($termsOfServiceList)){
                          $p = 1;
                      for($i=0;$i<count($termsOfServiceList);$i++)
                      {
                        
                        $ctr = (($this->params['paging']['MstTermsOfService']['page']*$this->params['paging']['MstTermsOfService']['limit'])-$this->params['paging']['MstTermsOfService']['limit'])+$p;
                        
                        if($termsOfServiceList[$i]['MstTermsOfService']['tos_status'] == 1){
                            $termsOfServiceStatus = "Active";
                            $termsOfServiceChacked = "checked = ''";
                            
                        }else{
                            $termsOfServiceStatus = "Deactive"; 
                            $termsOfServiceChacked = "";
                        }
                        
                        ?>
                    <tr>               
                        <td><input type="checkbox" data-md-icheck  <?php echo $termsOfServiceChacked;?> name="id[]" class="ts_checkbox" value="<?php echo $termsOfServiceList[$i]['MstTermsOfService']['id'];?>"></td>                        
                        <td><?php echo $termsOfServiceList[$i]['MstTermsOfService']['tos_name'];?></td>                       
                        <td><?php echo $termsOfServiceStatus;?></td>
                        <td>                            
                            <a href="<?php echo $this->webroot;?>masters/termsOfService/termsOfServiceEdit/<?php echo $termsOfServiceList[$i]['MstTermsOfService']['id'];?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                            <a href="<?php echo $this->webroot;?>masters/termsOfServiceDelete/<?php echo $termsOfServiceList[$i]['MstTermsOfService']['id'];?>"  title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
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
                                <label for="hobbies" class="uk-form-label">Terms of services status (1 minimum):</label>
                                <span class="icheck-inline">
                                    <input type="radio" value="1" name="tos_status" id="meeting_status" required="" data-md-icheck />
                                    <label for="val_check_ski" class="inline-label">Active</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" value="0" name="tos_status" id="meeting_status" data-md-icheck />
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
            $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-1-3"><div class="parsley-row"><?php echo $this->form->input('tos_name.', array('label' => false, 'type' => "text",'class' => "md-input",'id' => 'tos_name', 'required' => true)); ?></div></div><br><br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });

    $(document).on('click','.remove',function() {
            $(this).parent('div').remove();
    });
    
</script>   