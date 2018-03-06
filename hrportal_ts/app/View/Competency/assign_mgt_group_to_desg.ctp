<?php

$groupList = $this->Common->findGroupMasterList($hoOrgId,$orgId);

$heading = "Assign Management Group to Designation";
$buttonName = "Submit";
$action = "AssignMgtGroupToDesg";
?>
<div id="page_content" role="main">
    <div id="page_content_inner">
    
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">    <h3><?= $heading ?></h3>
                <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => $action), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Group List</label>
                        <div class="parsley-row">
                            <select name="data[mgt_group]" id="group_comp_id" class="md-input" data-placeholder="Select Group" required="">
                                <option value=''> -- Select Group -- </option>
                                <?php foreach ($groupList as $k => $val) { ?>
                                    <option value='<?php echo $k ?>'> <?php echo ucfirst($val); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Department List</label>
                        <div class="parsley-row">
                            <select name="dept_id" required="" data-md-selectize onChange = 'return getEmployee(this.value)' id="department_list">
                                <?php 
                                echo $list = "<option value=''> - Select Department - </option><option value='0'>All</option>";
                                foreach($department_list as $key => $value){
                                    echo $list ="<option value='$key'>$value</option>";
                                }
                                //echo $list;
                                ?>
                            </select>
                            <?php //echo $this->form->input('dept_id', array('label' => "Department List", 'type' => "select", 'empty' => ' -- Select Department--', 'options' => $department_list, 'class' => "md-input", 'id' => 'department_list', 'required' => true, 'data-md-selectize', 'onChange' => 'return getEmployee(this.value)')); ?>
                            <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">                            
                        </div>
                    </div>                    
                </div>

                <span id="empList"></span>  


                <br><div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-1 uk-margin-top">                    
                        <button type="submit" name="submit" class="md-btn md-btn-success"><?= $buttonName ?></button>
                    </div>
                </div>  
                <?php echo $this->Form->end(); ?>

            </div>
        </div> 
        
        <h3 class="heading_b uk-margin-bottom uk-margin-top">Assign Management Group to Designation List</h3>
        <div class="md-card">
            <div class="md-card-content">                    
            <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => 'addCompetency'), 'id' => 'form_validation', 'class' => 'uk-form-stacked')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Group Name</th>
                                <th>Designation</th>
								<th>Department</th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            
                            if (isset($assignMgtGroupToDesgList)) {
                                $p = 1;
                                for ($i = 0; $i < count($assignMgtGroupToDesgList); $i++) {

                                    $ctr = (($this->params['paging']['MgtGroupDesg']['page'] * $this->params['paging']['MgtGroupDesg']['limit']) - $this->params['paging']['MgtGroupDesg']['limit']) + $p;

                                    ?>
                                    <tr>
                                        <td><?php echo $ctr; ?></td>
                                        <td><?php echo $this->Common->findGroupMasterName($assignMgtGroupToDesgList[$i]['MgtGroupDesg']['mgt_group']); ?></td>
                                        <td><?php echo $this->Common->findDesignationName($assignMgtGroupToDesgList[$i]['MgtGroupDesg']['desg_code'],"01"); ?></td>
										<td><?php $dept_name=$this->Common->findAllDepartmentsNameByDesgCode($assignMgtGroupToDesgList[$i]['MgtGroupDesg']['desg_code']); 
											$str='';
											$j=0;
											foreach($dept_name as $name){
												$j++;
													$str .= $name['Departments']['dept_name'].' , ';
													if(($j%5)==0)
													$str .= '<br/>';
											}
											echo $str;
										?></td>
                                        <td>
                                            <a href="<?php echo $this->webroot; ?>Competency/AssignMgtGroupToDesgDelete/<?php echo $assignMgtGroupToDesgList[$i]['MgtGroupDesg']['id']; ?>" onClick="return confirm('are you sure you want to delete??');" title="Click to Delete" class="uk-badge uk-badge-danger">Delete</a>
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

    function getEmployee(dept) {
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Competency/DesgList/' + dept,
            //data:'project_id='+val,
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
</script>