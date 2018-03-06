
<div id="page_content" role="main">
    <div id="page_content_inner">        
        <?php        
        if($termsOfServiceEditId != ""){
            $heading = "Update Signatory Setup";
            $buttonName = "Update";
            $action = "termsOfService/termsOfServiceEdit/".$termsOfServiceEditId;
        }else{
            $heading = "Add Signatory Setup";
            $buttonName = "Submit";
            $action = "mstRequest";
        }?>

        <h3 class="heading_b uk-margin-bottom"><?=$heading?></h3>

        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php echo $this->Form->create('master', array('url' =>array('controller' => 'masters', 'action' => 'SignatoryMaster'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                <div class="uk-grid" data-uk-grid-margin>                        
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                
                            <?php echo $this->form->input('department_id', array('label' => "Department List", 'type' => "select",'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input",'id' => 'department_list', 'required' => true,'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id="empList">                                

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
                                <th>Department Name</th>                                    
                                <th>Signatory Name</th>                                    
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
                                            $ctr = (($this->params['paging']['MstSignatory']['page']*$this->params['paging']['MstSignatory']['limit'])-$this->params['paging']['MstSignatory']['limit'])+$p;
                                            if($MstRequest[$i]['MstSignatory']['status'] == 1){
                                            $Status = "Active";
                                            $termsOfServiceChacked = "checked = ''";
                                        }else{
                                            $Status = "Deactive"; 
                                            $termsOfServiceChacked = "";
                                        }
                        
                                ?>
                            <tr id = "<?php echo $MstRequest[$i]['MstSignatory']['id'];?>">  
                                <td><input type="checkbox" data-md-icheck  <?php echo $termsOfServiceChacked;?> name="id[]" class="ts_checkbox" value="<?php echo $MstRequest[$i]['MstSignatory']['id'];?>"></td>                        
                                <td id="req_td_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>"><?php echo ucfirst($this->Common->getdepartmentbyid($MstRequest[$i]['MstSignatory']['department_id']));?></td>
                                <td id="req_td_emp<?php echo $MstRequest[$i]['MstSignatory']['id'];?>"><?php echo ucfirst($this->Common->getempname($MstRequest[$i]['MstSignatory']['signatory_id']));?></td>
                                <td id="req_dip_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" style="display:none"><input type="text" name="req_type_name" id="req_type_name_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" value="<?php echo $MstRequest[$i]['MstSignatory']['req_type_name'];?>" class="md-input"></td>
                                <td id="req_ip_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" style="display:none"><?php echo $this->form->input('department_id', array('label' => "Employee List", 'type' => "select",'empty' => 'Select Employee', 'options' => $this->Common->getemplistbyDept($MstRequest[$i]['MstSignatory']['department_id']) , 'class' => "md-input",'id' => "signatory_list_".$MstRequest[$i]['MstSignatory']['id'], 'required' => true,'data-md-selectize')); ?></td>
                                <td id="req_ik_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" style="display:none"><input type="text" name="req_id" id="req_id_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" value="<?php echo $MstRequest[$i]['MstSignatory']['id'];?>"></td>

                                <td><?php echo $Status;?></td>
                                <td> 
                                    <button type="button" class="edit uk-badge uk-badge-info" style="margin-top: 30px;" value="<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" id="edit_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" onClick="return edit_change(this.value);" href="#">Edit</button>                    
                                    <button type="button" class="cancel uk-badge uk-badge-info" style="margin-top: 30px; display: none" value="<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" id="cancel_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" onClick="return cancel_change(this.value);" href="#">Cancel</button>                    
                                    <button type="button" class="cancel uk-badge uk-badge-info" style="margin-top: 30px; display: none" value="<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" id="save_<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" onClick="return save_change(this.value);" href="#">Save</button>                    
                                    <a href="<?php echo $this->webroot;?>masters/SignatoryMasterDelete/<?php echo $MstRequest[$i]['MstSignatory']['id'];?>" ><button type="button" class="uk-badge uk-badge-danger" style="margin-top: 30px;" >Delete</button> </a>                
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
    $('.add').click(function () {
        $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-1-3"><div class="parsley-row"><?php echo $this->form->input('req_type_name.', array('label' => false, 'type' => "text",'class' => "md-input",'id' => 'tos_name', 'required' => true)); ?></div></div><br><br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });
    $(document).on('click', '.remove', function () {
        $(this).parent('div').remove();
    });
    $(".edit").live('click', function () {
        alert($(this).closest('tr').attr('id'));
    });
    function edit_change(id) {
        $('#save_' + id).show();
        $('#edit_' + id).hide()
        $('#req_dip' + id).show();
        $('#req_td_emp' + id).hide();
        $('#cancel_' + id).show();
        $('#req_ip_' + id).show();
    }
    function cancel_change(id) {
        $('#save_' + id).hide();
        $('#req_dip_' + id).hide();
        $('#req_td_emp' + id).show();
        $('#cancel_' + id).hide();
        $('#edit_' + id).show();
        $('#req_ip_' + id).hide();
    }

    function save_change(id) {
        var id = $('#req_id_' + id).val();
        var name = $('#signatory_list_' + id).val();
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>masters/SignatoryMasterEdit/' + id + '/' + name,
            //data:'project_id='+val,
            success: function (data) {
                location.reload();
            }
        });
    }

</script>   
<script type="text/javascript">
    function getEmployee(val) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>masters/employeelist/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script> 