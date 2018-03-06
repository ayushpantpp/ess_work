<?php
$competencyList = $this->Common->findCompetencyList();
$groupList = $this->Common->findGroupMasterList($hoOrgId,$orgId);

$heading = "Assign Competency Group to Designation";
$buttonName = "Submit";
$action = "AssignGroupToDesg";
?>
<div id="page_content" role="main">
    <div id="page_content_inner">
     
        <?php echo $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content large-padding">   <h3><?= $heading ?></h3>
			<?php
			$mgtgroupList = $this->Common->findAllGroupDesg();//print_r($mgtgroupList);
			if(count($mgtgroupList)==0){
				?>
				<div class="uk-overflow-container">
                        <h3 class="uk-text-primary">Please declare management groups for desginations. Please click here <a href="<?php echo $this->webroot ?>Competency/AssignMgtGroupToDesg" title="Designation Management Group" style="text-decoration:underline">Assign Group to Management Designation</a></h3>
                </div>
				<?php
			}else{
			
			?>
                <?php echo $this->Form->create('Competency', array('url' => array('controller' => 'Competency', 'action' => $action), 'id' => 'form_validation', 'enctype' => 'multipart/form-data', 'class' => 'uk-form-stacked')); ?>


                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <label>Group Name</label>
                        <div class="parsley-row">                            
                            <select name="data[group_comp_id]" id="group_comp_id" class="md-input" data-placeholder="Select Group" data-md-selectize = "data-md-selectize" required="required">
                                <option value='-1'> -- Select Group -- </option>
                                <?php foreach ($groupList as $k => $val) { ?>
                                    <option value='<?php echo $k ?>'> <?php echo ucfirst($val); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div> 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                
                            <?php                            
                            $financialYear = $this->Common->findfyDesc($currentFinancialYear);
                            echo $this->form->input('financial_year', array('label' => "Financial Year", 'type' => "text", 'value' => "$financialYear",'class' => "md-input",'id' => 'financial_year', 'required' => true,'readonly' => 'readonly')); ?>
                        </div>
                    </div>
                </div>
                
				<div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">                                    
                            <?php echo $this->Form->input('j_date_from', array('class' => 'md-input SDate', 'type' => 'text', 'label' => 'Joining Date From', 'required' => TRUE, 'id' => 'StartDate', 'data-uk-datepicker' => "{format:'DD-MM-YYYY'}")); ?>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <?php echo $this->Form->input('j_date_to', array('class' => 'md-input EndDate', 'type' => 'text', 'label' => 'Joining Date To', 'required' => TRUE, 'id' => 'EndDate', 'format' => 'd-MM-yyyy','data-uk-datepicker' => "{format:'DD-MM-YYYY'}")); ?>
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
                <?php echo $this->Form->end(); 
				
			}
				?>

            </div>
        </div>        
    </div>
</div>

<script type="text/javascript">
        
    $(".EndDate").change(function () {
        //alert("sdnmbsdjms")
        var startDate = document.getElementById("StartDate").value;
        var endDate = document.getElementById("EndDate").value;

        if ((Date.parse(startDate) >= Date.parse(endDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("EndDate").value = "";
        }
    });
    
    function getEmpListByJoiningDate(enddate)
    {
        var startdate = document.getElementById("StartDate").value;
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>KraMasters/getEmpListByJoiningDate/' + startdate + '/' + enddate,
            success: function (data) {
                //alert(data);
                jQuery('#empList').html(data);
            }
        });
    }
    
    function getEmpListByJoiningDateByStartDate(startdate)
    {
        var enddate = document.getElementById("EndDate").value;
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>KraMasters/getEmpListByJoiningDate/' + startdate + '/' + enddate,
            success: function (data) {
                //alert(data);
                jQuery('#empList').html(data);
            }
        });
    }

	
    $(document).ready(function () {
        $('#type_id').change(function () {
            if ($('#type_id').val() == '1') {
                $('#compId').show();                
                $('#compGroupId').hide();
                //$('#group_comp_id').removeAttr('required');​​​​​
            }
            else if ($('#type_id').val() == '2') {
                $('#compGroupId').show();                
                $('#compId').hide();
                //$('#competency_id').removeAttr('required');​​​​​
            }
            else{
                $('#compGroupId').hide();
                $('#compId').hide();
            }
        });
    });


    

    function getEmployee(dept) {
		var grp_id= $('#group_comp_id').val();
		//alert(grp_id);
        $.ajax({
            type: "POST",
            url: '<?php echo $this->webroot ?>Competency/DesgList/' + dept,
            //data:{ 'dept_id' : dept, 'grp_id' : grp_id },
            success: function (data) {
                //alert(data);
                $("#empList").html(data);
            }
        });
    }
	
	
</script>