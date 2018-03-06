<?php echo $flash = $this->Session->flash();?>
<!-- page content -->
<div id="page_content" role="main">
    <div id="page_content_inner">
        
        <h3 class="heading_b uk-margin-bottom">Add Meeting</h3>
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card">          
                        
            <div class="md-card-content large-padding">  
                
                <?php echo $this->Form->create('mom', array('url' =>array('controller' => 'moms', 'action' =>'momupdate'),'id'=>'form_validation','enctype' => 'multipart/form-data','class' => 'uk-form-stacked')); ?>
                <?php echo $this->form->input('mid', array('class' => "md-input",'label' => false, 'value' => $a['MomAssign']['mid'], 'type' => 'hidden', 'id' => 'mid'));?>
                    <div class="uk-grid" data-uk-grid-margin>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                 <?php $taskList = $this->Common->findTaskList();
                                echo $this->form->input('task_id', array('label' => "Task List", 'type' => "select",'default' => $a['MomAssign']['task_id'],'empty' => ' -- Select Task --', 'options' => $taskList, 'class' => "md-input",'id' => 'task_id','data-md-selectize')); ?>                          
                                
                            </div>
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('subject', array('label' => "Subject",'value' => $a['MomAssign']['subject'],'class' => "md-input",'type' => 'text', 'id' => 'date', 'required' => true,)); ?>                                
                            </div>
                        </div>                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('meeting_date', array('label' => "Meeting Date *", 'value' => date("d-m-Y",  strtotime($a['MomAssign']['meeting_date'])),'data-uk-datepicker' => "{format:'DD-MM-YYYY',minDate : 0}",'class' => "md-input",'type' => 'text', 'id' => 'date', 'required' => true,)); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row"> 
                                <?php echo $this->form->input('meeting_time', array('label' => "Meeting Time *&nbsp;&nbsp;&nbsp;", 'value' => $a['MomAssign']['meeting_time'],'class' => "uk-form-width-medium",'type' => 'number', 'id' => 'kUI_timepicker', 'required' => true)); ?>                                
                            </div>
                        </div>                        
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('res', array('label' => "Responsibility", 'value' => $a['MomAssign']['responsibility'],'class' => "md-input", 'type' => "text", 'id' => 'responsibility','required' => true)); ?>                        
                            </div>
                        </div>                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <?php echo $this->form->input('meeting_remark', array('label' => "Minutes Remarks",'value' => $a['MomAssign']['mremark'], 'type' => "text", 'class' => "md-input",'id' => 'mr')); ?>                                
                            </div>
                        </div>                       
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">
                                <?php echo $this->form->input('remark', array('label' => "Remark", 'type' => "text",'value' => $a['MomAssign']['remark'], 'class' => "md-input",'id' => 'remark', 'required' => true)); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">                                                        
                            <div class="parsley-row">                                                            
                                <div class="uk-form-file md-btn md-btn-primary">
                                    Select
                                    <input id="doc_file" name="doc_file" type="file">
                                </div>
                                Upload Document <span class="req"></span>
                                <?php echo $this->form->input('upload_file', array('class' => "md-input",'label' => false, 'value' => $a['MomAssign']['uploaded_file'], 'type' => 'hidden', 'id' => 'mid'));
                        ?>
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('des', array('class' => "md-input",'value' => $a['MomAssign']['description'],'type' => "text", 'label' => "Description *", 'id' => 'des', 'required' => true)); ?>                                
                            </div>
                        </div>
                        
                        <div class="uk-width-medium-1-2">
                            <div class="parsley-row">                                
                                <?php echo $this->form->input('department_id', array('label' => "Department List", 'type' => "select",'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input",'id' => 'department_list', 'required' => true,'default'=> $a['MomAssign']['department_id'],'data-md-selectize','onChange' =>'return getEmployee(this.value)')); ?>                                
                            </div>
                        </div>                 
                    </div>
                    
                    <div class="uk-grid">
                        <div class="uk-width-medium-1-1">
                            <div class="parsley-row">                              
                                
                                
                                <span id="empList">
                                    <?php 
//                                    echo $a['MomAssignEmp']['emp_code'];
//                                    echo "<pre>";
//                                    print_r($listing);
                                   
                                    ?>
                                    <label for="kUI_multiselect_basic" class="uk-form-label">Select Employee</label>
                                    <select id="kUI_multiselect_basic" name="employee_id[]" required="" multiple="multiple" data-placeholder="Select Employee...">
                                   
                                 <?php  foreach ($listing as $k => $val)
                                    { 
                                        if($k == $a['MomAssignEmp']['emp_code'])
                                        { ?>
                                        <option value='<?php echo $k; ?>' selected="selected"> <?php echo $val; ?></option>
                                        <?php //$select = "selected=''";
                                        }else{ ?>
                                          <option value='<?php echo $k; ?>' > <?php echo $val; ?></option>  
                                        <?php
                                        }                                    
                                    ?>
                                    
                                    <?php } ?>
                                    </select>                                    
                                </span>
                            </div>
                        </div> 
                    </div>
                
                                       
                    <div class="uk-grid">
                        <div class="uk-width-1-3 uk-margin-top">                            
                            <button type="submit" name="submit" class="md-btn md-btn-success" href="#">Update</button>                            
                            <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/moms/viewMeeting') ?>">Cancel</a>                       
                        </div>
                    </div>
                <?php echo $this->Form->end();?>
            </div>
        </div>        
    </div>
</div>

<script type="text/javascript">    

    function getEmployee(val) {
        //alert("--PROJECT ID--"+val);
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>moms/employeelist/' + val,
            //data:'project_id='+val,
            success: function (data) {       
                $("#empList").html(data); 
                $("#selectedEmpList").hide();
            }
            
        });
    }


    function post1()
    {
        alert("hiiii");
        document.getElementById("h1").value = 1;
        document.getElementById("mom").action = "/assign";
        document.forms["mom"].submit();
    }
</script>