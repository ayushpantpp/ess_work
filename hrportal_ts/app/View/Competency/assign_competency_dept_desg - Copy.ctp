<?php

$competencyList = $this->Common->findCompetencyList();
    if ($assignCompetencyDeptDesgEditId != "") {
        $heading = "Update Assign Competency to Employee";
        $buttonName = "Update";
        $action = "AssignCompetencyDeptDesg/assignCompetencyDeptDesgEdit/" . $assignCompetencyDeptDesgEditId;
    } else {
        $heading = "Assign Competency to Employee";
        $buttonName = "Submit";
        $action = "AssignCompetencyDeptDesg";
    }
?>

<div id="page_content" role="main">
    <div id="page_content_inner">
       
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding"> <h3><?=$heading?></h3>
                <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => $action), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>

                <?php
                if ($assignCompetencyDeptDesgEditId != "") {
                    echo $this->form->input('id', array('class' => "md-input", 'label' => false, 'value' => $assignCompetencyDeptDesgEditId, 'type' => 'hidden', 'id' => 'id'));
                }
                ?>
                <div class="uk-grid" data-uk-grid-margin>                                  
                    <div class="uk-width-medium-1-2">
                        <label>Department List</label>
                        <div class="parsley-row">
                            <?php if($editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id'] == ""){?>
                                <?php echo $this->form->input('dept_id', array('label' => "", 'type' => "select",'empty' => ' -- Select Department--', 'default' => $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id'], 'options' => $department_list, 'class' => "md-input",'id' => 'department_list', 'required' => true,'data-md-selectize','onChange' => 'return getEmployee(this.value)')); ?>
                            <?php }else{?>

                            <select name="data[desg_id]" required="" id="employee_id" class="md-input" data-placeholder="Select Designation..." data-md-selectize = "data-md-selectize" onChange = 'return getEmployeebyDesg(this.value)'>
                                <option value='<?php echo $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id']; ?>'> <?php echo $this->Common->getdepartmentbyid($editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id']);?></option>                        
                            </select>
                            <?php }?>
                        </div>
                    </div>           
                    <div class="uk-width-medium-1-2">
                        <label>Financial Year</label>
                        <div class="parsley-row">                                
                            <?php 
                            $financialYear = $this->Common->findfyDesc($currentFinancialYear);
                            echo $this->form->input('financial_year', array('label' => "", 'type' => "text", 'value' => "$financialYear",'class' => "md-input",'id' => 'financial_year', 'required' => true,'readonly' => 'readonly')); ?>
                        </div>
                    </div>
                </div>

                <?php if($editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['desg_id']){?>
                <div class="uk-grid" data-uk-grid-margin id="empList">     
                    <div class="uk-width-medium-1-2">
                        <label>Designation List</label>
                        <div class="parsley-row">  
                            <?php 
                            $departmentCode = $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id'];
                            $desgCode = $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['desg_id'];
                            $desgList = $this->Common->getAllDesignationByDept($departmentCode);
                            
                            
                            ?>
                            <select name="data[desg_id]" required="" id="employee_id" class="md-input" data-placeholder="Select Designation..." data-md-selectize = "data-md-selectize" onChange = 'return getEmployeebyDesg(this.value)'>

                                <?php 
                                $p = "01";
                                ///foreach ($desgList as $k) {  ?>
                                <option value='<?php echo $desgCode ?>'> <?php echo $this->Common->findDesignationName($desgCode, $p);?></option>
                                <?php //} ?>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <label>Employee List</label>
                        <div class="parsley-row">  
                            <?php  
                                $empList = $this->Common->findEmpListByDesgCode($desgCode,$departmentCode);
                                echo $this->form->input('emp_id', array('label' => "", 'type' => "select",'empty' => ' -- Select Employee --', 'default' => $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['emp_id'], 'options' => $empList, 'class' => "md-input",'id' => 'employee_list', 'required' => true,'data-md-selectize'));  
                            ?>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="uk-grid" data-uk-grid-margin id="empList">

                </div>
                <?php }?>





                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <div class="parsley-row">
                            <label for="kUI_multiselect_basic" class="uk-form-label">Select Competency</label>
                            <?php 
                                
                                if($editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['competency_id']){
                                    echo $this->form->input('competency_id.', array('label' => "", 'type' => "select", 'empty' => ' -- Select Competency --', 'default' => $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['competency_id'], 'options' => $competencyList, 'class' => "md-input", 'id' => 'task_id', 'data-md-selectize'));
                                }else{
                            ?>


                            <select id="kUI_multiselect_basic" name="competency_id[]" required="" id="employee_id" multiple="multiple" data-placeholder="Select Competency...">
                                <?php 
                                        foreach ($competencyList as $k => $val) {
                                            if($k == $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['competency_id']){
                                                $selected = "selected = 'selected'";                                                
                                            }else{
                                                $selected = "";
                                            }
                                    ?>
                                <option value='<?php echo $k ?>' <?=$selected?>> <?php echo ucfirst($val);?></option>
                            <?php } ?>
                            </select>
                                <?php }?>
                        </div>
                    </div>
                </div>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success" href="#"><?= $buttonName ?></button>
                        <?php if($buttonName == "Update"){?>
                        <a href="<?php echo $this->webroot;?>Competency/AssignCompetencyDeptDesg" class="md-btn md-btn-primary">Cancel</a>   
                        <?php }?>
                    </div>
                </div>                           

            </div>
        </div>
        <div class="md-card">
            <div class="md-card-content">                    
<?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addCompetency'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table id="dt_individual_search" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Financial Year</th>
                                <th>Employee Name</th>
                                <th>Department Name</th>
                                <th class="uk-width-3-10">Designation Name</th>                                
                                <th class="uk-width-3-10">Competency Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Financial Year</th>
                                <th>Employee Name</th>
                                <th>Department Name</th>
                                <th class="uk-width-3-10">Designation Name</th>                                
                                <th class="uk-width-3-10">Competency Name</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            //echo "<pre>";
                            //print_r($assignCompetencyDeptDesgList);
                            //die;
                            if (isset($assignCompetencyDeptDesgList)) {
                                $p = 1;
                                for ($i = 0; $i < count($assignCompetencyDeptDesgList); $i++) {

                                    $ctr = (($this->params['paging']['AssignCompetencyDeptDesg']['page'] * $this->params['paging']['AssignCompetencyDeptDesg']['limit']) - $this->params['paging']['AssignCompetencyDeptDesg']['limit']) + $p;
                                    $deptName = $this->Common->getdepartmentbyid($assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['dept_id']);
                                    $designationName = $this->Common->findDesignationName($assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['desg_id'],"01");
                                    $competencyName = $this->Common->findCompetencyName($assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['competency_id']);
                                    
                                    ?>
                            <tr>                                        
                                <td><?php echo $ctr; ?></td>
                                <td class="uk-text-small"><?php echo $this->Common->findfyDesc($assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['financial_year']); ?></td>
                                <td><?php echo $this->Common->findEmpName($assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['emp_id']); ?></td>
                                <td><?php echo ucfirst($deptName); ?></td>
                                <td><?=$designationName;?></td>
                                <td class="uk-width-3-10"><?php echo ucfirst($competencyName); ?></td>                                        
                                <td>                            
                                    <a href="<?php echo $this->webroot; ?>Competency/AssignCompetencyDeptDesg/assignCompetencyDeptDesgEdit/<?php echo $assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['id']; ?>"  title="Click to Edit" class="uk-badge uk-badge-info">Edit</a>
                                    <a href="<?php echo $this->webroot; ?>Competency/assignCompetencyDeptDesgDelete/<?php echo $assignCompetencyDeptDesgList[$i]['AssignCompetencyDeptDesg']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
                                </td>                          
                            </tr> 

                                    <?php
                                    $p++;
                                }
                            }
                            ?>

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

<script type="text/javascript">

    function getEmployee(dept) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Competency/DesgListSecond/' + dept,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>
<?php 
$deptCode = $editAssignCompetencyDeptDesg['AssignCompetencyDeptDesg']['dept_id'];

?>

<script type="text/javascript">

    function getEmployeebyDesg(desgCode) {

        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Competency/EmpListSecond/' + desgCode + "/<?php echo $deptCode;?>",
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList1").html(data);
            }
        });
    }
</script>
