
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
            $action = "mstRequest";
        }?>
        
        <h3 class="heading_b uk-margin-bottom"><?=$heading?></h3>
        
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => 'mstRequest'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                    <div class="uk-grid" data-uk-grid-margin>                        
                        <div class="uk-width-medium-1-3">
                            <div class="parsley-row">
                                <?php echo $this->form->input('req_type_name.', array('label' => "Request Type Name", 'type' => "text", 'value' => $editTermsOfService['MstTermsOfService']['tos_name'] ,'class' => "md-input",'id' => 'tos_name', 'required' => true)); ?>                                
                            </div>
                        </div>
                    </div>   
                    
                    <a class="add md-btn md-btn-primary padding-left-lg" style="margin-top: 30px;">Add More</a>
                    <button type="submit" name="submit" class="md-btn md-btn-success" style="margin-top: 30px;" href="#">Submit</button>                    
                    <?php echo $this->Form->end();?>
            </div>
        </div>
        <div class="md-card">
                <div class="md-card-content">                    
                    <?php echo $this->Form->create('masters', array('url' =>array('controller' => 'masters', 'action' => 'mstRequest'),'id'=>'form_validation','class' => 'uk-form-stacked')); ?>
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>                          
                                    <th class="filter-false remove sorter-false"><input type="checkbox" class="ts_checkbox_all"></th>
                                    <th>Request Type Name</th>                                    
                                    <th>Type Status</th>                                    
                                    <th class="filter-false remove sorter-false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($MstRequest)){
                                    $p = 1;
                                    for($i=0;$i<count($MstRequest);$i++)
                                        {
                                            $ctr = (($this->params['paging']['MstRequest']['page']*$this->params['paging']['MstRequest']['limit'])-$this->params['paging']['MstRequest']['limit'])+$p;
                                            if($MstRequest[$i]['MstRequest']['status'] == 1){
                                            $Status = "Active";
                                            $termsOfServiceChacked = "checked = ''";
                                        }else{
                                            $Status = "Deactive"; 
                                            $termsOfServiceChacked = "";
                                        }
                        
                                ?>
                        <tr id = "<?php echo $MstRequest[$i]['MstRequest']['id'];?>">  
                            <td><input type="checkbox" data-md-icheck  <?php echo $termsOfServiceChacked;?> name="id[]" class="ts_checkbox" value="<?php echo $MstRequest[$i]['MstRequest']['id'];?>"></td>                        
                            <td id="req_td_<?php echo $MstRequest[$i]['MstRequest']['id'];?>"><?php echo ucfirst($MstRequest[$i]['MstRequest']['req_type_name']);?></td>
                            <td id="req_dip_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" style="display:none"><input type="text" name="req_type_name" id="req_type_name_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" value="<?php echo $MstRequest[$i]['MstRequest']['req_type_name'];?>" class="md-input"></td>
                            <td id="req_ip_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" style="display:none"><input type="text" name="req_id" id="req_id_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" value="<?php echo $MstRequest[$i]['MstRequest']['id'];?>"></td>
                            <td><?php echo $Status;?></td>
                            <td> 
                                <button type="button" class="edit uk-badge uk-badge-info" style="margin-top: 30px;" value="<?php echo $MstRequest[$i]['MstRequest']['id'];?>" id="edit_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" onClick="return edit_change(this.value);" href="#">Edit</button>                    
                                <button type="button" class="cancel uk-badge uk-badge-info" style="margin-top: 30px; display: none" value="<?php echo $MstRequest[$i]['MstRequest']['id'];?>" id="cancel_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" onClick="return cancel_change(this.value);" href="#">Cancel</button>                    
                                <button type="button" class="cancel uk-badge uk-badge-info" style="margin-top: 30px; display: none" value="<?php echo $MstRequest[$i]['MstRequest']['id'];?>" id="save_<?php echo $MstRequest[$i]['MstRequest']['id'];?>" onClick="return save_change(this.value);" href="#">Save</button>                    
                                <a href="<?php echo $this->webroot;?>masters/mstRequestDelete/<?php echo $MstRequest[$i]['MstRequest']['id'];?>" ><button type="button" class="uk-badge uk-badge-danger" style="margin-top: 30px;" >Delete</button> </a>                
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
                                <label for="hobbies" class="uk-form-label">Request Type Status (1 minimum):</label>
                                <span class="icheck-inline">
                                    <input type="radio" value="1" name="status" id="meeting_status" required="" data-md-icheck />
                                    <label for="val_check_ski" class="inline-label">Active</label>
                                </span>
                                <span class="icheck-inline">
                                    <input type="radio" value="0" name="status" id="meeting_status" data-md-icheck />
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
            $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-1-3"><div class="parsley-row"><?php echo $this->form->input('req_type_name.', array('label' => false, 'type' => "text",'class' => "md-input",'id' => 'tos_name', 'required' => true)); ?></div></div><br><br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });
    $(document).on('click','.remove',function() {
            $(this).parent('div').remove();
    });
    $(".edit").live('click',function(){
    alert($(this).closest('tr').attr('id'));
    });
    function edit_change(id){
            $('#save_'+id).show();
            $('#edit_'+id).hide()
            $('#req_dip_'+id).show();
            $('#req_td_'+id).hide();
            $('#cancel_'+id).show();
    }
    function cancel_change(id){
            $('#save_'+id).hide();
            $('#req_dip_'+id).hide();
            $('#req_td_'+id).show();
            $('#cancel_'+id).hide();
            $('#edit_'+id).show();
    }
    
    function save_change(id) {
        var id = $('#req_id_'+id).val();
        var name = $('#req_type_name_'+id).val();
        $.ajax({
                type: "POST",
                url: '<?php echo $this->webroot ?>masters/mstRequestEdit/'+id +'/' +name ,
                //data:'project_id='+val,
                success: function (data) {
                    location.reload();
                }
            });
    }
   
</script>   