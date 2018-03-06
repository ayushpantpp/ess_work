<?php $auth = $this->Session->read('Auth');
$ecode = $auth['MyProfile']['emp_code']; 
?>
<script>
    $('#startdate').kendoDatePicker({
        start: "year",
        depth: "year",
        format: "MMMM yyyy"
    });
    $('#kUI_multiselect_basic').kendoMultiSelect();
    
    
    
    function getmodule(val) {

        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>tasks/module/' + val,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#mname").html(data);
            }
        });
    }
    
    function getMomDetails(momId) {        
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/momdetails/' + momId,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#momDetails").html(data);
            }
        });
    }
      function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>tasks/emptask/"+val; 

 }
</script>
    
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash();?>
            <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Task List</b>
                            </h3>
                            
                          

                        
                            </div>
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <td>Task Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Complete</th>
                                    <th>Details</th>
                                    <th class="filter-false remove sorter-false uk-text-center">Related Meeting</th>
                                    <th>Task Forward</th>
                                    <th>Notification</th>
                              </tr>      
                            </thead>
                       
                <tbody aria-live="polite" aria-relevant="all">
                <?php $status=array(0=>'Very High',1=>'High',2=>'Medium',3=>'Low');?>
                <?php $statusnew=array(0=>'Pending',1=>'Pending',2=>'Pending',3=>'Pending',4=>'Pending',5=>'Pending',6=>'Complete');?>
                      
                <?php $j=1; ?>
                  <?php foreach($assignedTask as $data) {?>
                            <tr>

                                <td class="uk-text-center"><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $j;?></span></td>
                                <td><?php echo $data['TaskAssign']['tname']?></td>

                                <td class="uk-text-small"><?php echo $data['TaskAssign']['starttime']?></td>
                                <td class="uk-text-small"><?php echo $data['TaskAssign']['endtime']?></td>
                       
                                    <?php if($data['TaskAssign']['tpriority'] == '0'){$per = 'uk-badge uk-badge-danger';}
                                     if($data['TaskAssign']['tpriority'] == '1'){$per = 'uk-badge uk-badge-warning';}
                                     if($data['TaskAssign']['tpriority'] == '2'){$per = 'uk-badge uk-badge-info';}
                                     if($data['TaskAssign']['tpriority'] == '3'){$per = 'uk-badge uk-badge-success';}
                                    ?> 
                                <td ><a href="" class="<?php echo $per;?>" ><?php $new= $data['TaskAssign']['tpriority']; echo $status[$new];?></a></td>
                            <?php if($data['Assigned']['cstatus'] == '0'){$per = 0;}
                                       
                                    if($data['Assigned']['cstatus'] == '1'){$per = 0;}
                                    if($data['Assigned']['cstatus'] == '2'){$per = 10;}
                                    if($data['Assigned']['cstatus'] == '3'){$per = 30;}
                                    if($data['Assigned']['cstatus'] == '4'){$per = 50;}
                                    if($data['Assigned']['cstatus'] == '5'){$per = 80;}
                                    if($data['Assigned']['cstatus'] == '6'){$per = 100;}
                                    if($data['Assigned']['cstatus'] == '7'){$per = 100;}
                                ?>          
                                <td> <?php if($data['TaskAssign']['status'] == 7){ echo "Approved";}else{?>
                                    <select id = "workstatus" onchange="return updatestatus(this.value,'<?php echo $data['TaskAssign']['tid']; ?>','<?php echo $ecode; ?>');" <?php if($data['Assigned']['cstatus'] == '6'){
                                     echo 'disabled';
                                } ?> >
                                       <option value = "0" <?php if($data['Assigned']['cstatus'] == '0'){
                                        $per = 0;
                                        echo "selected = 'selected'";
                                }?> >New</option>
                                        <option value = "1" <?php if($data['Assigned']['cstatus'] == '1'){
                                        $per = 0;
                                        echo "selected = 'selected'";
                                }?>>Start</option>
                                        <option value = "2" <?php if($data['Assigned']['cstatus'] == '2'){
                                        $per = 10;
                                        echo "selected = 'selected'";
                                }?>>complete 10-20%</option>
                                        <option value = "3" <?php if($data['Assigned']['cstatus'] == '3'){
                                        $per = 30;
                                        echo "selected = 'selected'";
                                }?>>complete 30-40%</option>
                                        <option value = "4" <?php if($data['Assigned']['cstatus'] == '4'){
                                        $per = 50;
                                        echo "selected = 'selected'";
                                }?>>complete 50-60%</option>
                                        <option value = "5" <?php if($data['Assigned']['cstatus'] == '5'){
                                        $per = 80;
                                        echo "selected = 'selected'";
                                }?>>complete 70-80%</option>
                                        <option value = "6" <?php if($data['Assigned']['cstatus'] == '6'){
                                        $per = 100;
                                        echo "selected = 'selected'";echo ' '; echo "disabled = 'disabled'";
                                } ?>>Complete</option>
                                    </select></td>
                                 <?php } ?>  
                               
                                <td><a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-success"
                                       onclick="Get_Details('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="Click to View.">Click To View</a></td>
                                <td><?php echo $data['TaskAssign']['remark']; ?></td>
                                <td>
                                    <a data-uk-modal="{target:'#modal_overflow'}" onclick="return getMomDetails(<?php echo $data['TaskAssign']['mom_id'];?>)" alt="View Full Details" title="View Full Details" class="uk-badge uk-badge-success">View Meeting</a>
                                </td>
                                <td>
                                 <?php if($data['TaskAssign']['status'] == '7'){ echo "--N/A--"; } else {?>
                                 <?php if($auth['MyProfile']['desg_code']== 'PAR0000019'){ ?>
                                    <a href="taskforward/<?php echo $data['TaskAssign']['tid']?>" class="uk-badge uk-badge-success" class="view vtip" title="Click to Task Forward">Task Forward</a>
                                <?php } else {?>
                                    <!--<a href="forwardemp/<?php //echo $data['TaskAssign']['tid']?>" class="btn btn-info btn-xs" class="view vtip" title="Click to Remark.">Task Forward..</a>-->
                                    <a href="taskforward/<?php echo $data['TaskAssign']['tid']?>" class="uk-badge uk-badge-success" class="view vtip" title="Click to Task Forward">Task Forward</a>
                                 <?php } }?>
                                </td>     
                                <td><?php if($data['Assigned']['statusid'] != 8){echo "--No Alert--";}
                                     else{  ?>
                                    <a href="#popup5" data-uk-modal="{center:true }" class="uk-badge uk-badge-warning"
                                       onclick="Get_Details5('<?php echo $data['TaskAssign']['tid']; ?>')" class="view vtip" title="New Alert">View Alert</a>
                                       <?php } ?>
                                </td>
                                
                               <?php $j++;?>
                            </tr>
                           <?php }?>

                          
                           </tbody>
                        </table>
                    <div>
                    <ul class="uk-pagination uk-pagination-right">
  
                    <?php
                      echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                      echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                      echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                    ?>
                    </ul>
                    </div>
            </div>
        </div>

    </div>

<div id="new_issue" class="uk-modal" aria-hidden="true" style="display: none; overflow-y: scroll;">
        <div class="uk-modal-dialog" style="top: -29px;">
                    <?php echo $this->Form->create('task', array('url' =>array('controller' => 'tasks', 'action' =>'taskassign'),'id'=>'form_validation','class' => 'uk-form-stacked' , 'Onsubmit'=>'return passwordCompaire();')); ?>
                         <h3 class="heading_a">Please fill to assign tasks.</h3>

                <div class="uk-grid data-uk-grid-margin">
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tid">Task ID: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tid" name="tid" maxlength="25">                            

                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="tname">Task Name: <span class="req">*</span></label>
                            <input type="text" class="md-input" id="tname" name="tname" maxlength="25" required>                            
                        </div>
                    </div>
                </div>
                         
               

                <div class="uk-grid" data-uk-grid-margin>
                    
                    <div class="uk-width-medium-1-2">
                            <label for="tpriority" class="uk-form-label">Task Priority</label>
                                <select class="uk-form-width-medium" name="tpriority" id="tpriority" data-md-selectize-inline>
                                    <option value="0">Very High</option>
                                    <option value="1">High</option>
                                    <option value="2">Medium</option>
                                    <option value="3">Low</option>
                                </select>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="pid">Project Name <span class="req">*</span></label>
                            <?php //echo "<pre>"; print_r($ar);?>
                             <select class="uk-form-width-medium" name="pid" id="pid" onChange="getmodule(this.value)" data-md-selectize-inline>
                                 <?php foreach($ar as $k) { ?>
                                 <option value="<?php echo $k['Tasksproject']['pid']; ?>"><?php echo $k['Tasksproject']['pname']; ?></option>
                                  <?php } ?>
                             </select>
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="startdate">Start Date(d/m/y): <span class="req">*</span></label>
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="startdate" name="startdate" maxlength="25" value ="" required ="required">                            
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row" id = 'mname'>
                            
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="enddate">End Date(d/m/y): <span class="req">*</span></label>
                            <input type="text" class="md-input" data-uk-datepicker='{format:"DD-MM-YYYY"}' id="enddate" name="enddate" maxlength="25" value ="" required>                            
                        </div>
                        <div class="parsley-row">
                            <label for="remark">Remark <span class="req">*</span></label>
                            <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"md-input",'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')")); ?>                
                        </div>
                        <div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">Select Employees</label>
                            <select id="kUI_multiselect_basic" multiple="multiple" name = 'ticker[]' id  = "ticker" data-placeholder="Select attendees...">
                                     <?php foreach($employee_name as $k=>$val){ ?>
                                <option  value='<?php echo $k ?>'> <?php foreach($employee_name as $t=>$value){if($value == $k ) echo 'selected';} ?> <?php echo $val ?></option>
                                    <?php } ?>  
                            </select>
                        </div>
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>

                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Submit</button>                    
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>
        
        </div>
    </div>
    </div>
</div>

<div class="uk-modal" id="popup1">
    <div class="uk-modal-dialog">
        <div class= "HRcontent"></div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>
<div class="uk-modal" id="popup2">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>

<div class="uk-modal" id="popup5">
    <div class="uk-modal-dialog">
        <div><p><h3> Task Remark:    </h3></p> </div>
        <div class="HRcontent5">
            <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
        </div> 
    </div>
</div>
<div class="uk-width-medium-1-1">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <span id="momDetails" class="verflow container"></span>            
            <div class="uk-overflow-container"></div>           
        </div>
    </div>
</div>




<script type="text/javascript">

    function updatestatus(status,id,ecode){
      jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/updatestatus/'+status+'/'+id+'/'+ecode,
        success: function(data){
            //alert(data);
           window.location.reload();
        }
    });
       

    }

    function Get_Details(id)
    {
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/view2/'+id,
        success: function(data){
            jQuery('.HRcontent').html(data);
        }
    });
    }
  
    function Get_Details2(id)
    {
    //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/remark/'+id,
        success: function(data){
            jQuery('.HRcontent1').html(data);
        }
    });
    }

   function Get_Details5(id)
    {
    //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>tasks/alert/'+id,
        success: function(data){
            //alert(data);
            jQuery('.HRcontent5').html(data);
        }
    });
    }   

    function tooltip(id){
         $.get('<?php echo $this->webroot;?>tasks/tooltip/'+id, function(data){
        $('#dialog_'+id).html(data);
         //$('[data-toggle="dialog"]').tooltip();           
        });

    }
    function tooltip_left(id){
        $('#dialog_'+id).html('');

    }


</script>
