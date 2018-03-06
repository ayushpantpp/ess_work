<?php

$auth=$this->Session->read('Auth');
$travelmode = $this->Common->findAllWheelerMode(); ?>
?>
<style>
.uk-dropdown, .uk-dropdown-blank {
    width: auto !important;
}
</style>
<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Temporary Component Add Form</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
<?php echo $this->Form->create('tempcomp', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'TemporaryComponents', 'action' => 'add'), 'id' => 'tempcompid', 'name' => 'tempcomp', 'enctype' => 'multipart/form-data'));
        ?>

                <div class="md-card-content" data-uk-grid-margin>
                    <div class="uk-overflow-container" role="main">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="x_content">
					<div data-uk-grid-margin="" class="uk-grid">
						<div class="uk-width-medium-1-2 uk-row-first">
						    <div class="parsley-row">
						        <label for="req_cat">Employee Name :</label>
<?php $auth = $this->Session->read('Auth'); ?>
						       <div class="input text"><div class="md-input-wrapper md-input-filled"><input type="text" id="first_name" required="required" readonly="readonly" class="md-input" value="<?php echo ucwords(strtolower($auth['MyProfile']['emp_firstname']))." ".ucwords(strtolower($auth['MyProfile']['emp_lastname'])); ?>" data-parsley-id="4"><span class="md-input-bar"></span></div></div>                                  
						     </div>
					       </div>
					       <div class="uk-width-medium-1-2">
						    <div class="parsley-row">
						        <label for="department">Employee ID : </label>
						                                        <div class="input text"><div class="md-input-wrapper md-input-filled"><input type="text" id="first_name" required="required" class="md-input" value="<?php echo $auth['MyProfile']['emp_id']; ?>" readonly="readonly" data-parsley-id="6"><span class="md-input-bar"></span></div></div>                        </div>
					       </div>
					</div>


					<div data-uk-grid-margin="" class="uk-grid">
						<div class="uk-width-medium-1-2 uk-row-first">
						    <div class="parsley-row">
<?php $dept_name = $this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);?>
						        <label for="req_cat">Department :</label>
<?php echo $this->Form->input('Emp_department', array('type' => 'hidden', 'value'=>$_SESSION['Auth']['MyProfile']['dept_code'])); ?>
                                    
						       <div class="input text"><div class="md-input-wrapper md-input-filled"><input type="text" id="first_name" required="required" readonly="readonly" class="md-input" value="<?php echo $this->common->getdepartmentbyid($_SESSION['Auth']['MyProfile']['dept_code']);?>" data-parsley-id="4"><span class="md-input-bar"></span></div></div>                                  
						     </div>
					       </div>
					       <div class="uk-width-medium-1-2">
						    <div class="parsley-row">
						        <label for="department">Claim Date *: </label>
						                                        <div class="input text"><div class="md-input-wrapper md-input-filled"> <div class="input text"><div class="md-input-wrapper md-input-filled"><input type="text" id="claimdate_1" required="required" readonly="readonly" maxlength="20" class="md-input required expenseTest form-control" value="" name="data[tempcomp][Claimdate]" data-parsley-id="4"><span class="md-input-bar"></span></div></div>  </div></div>                        </div>
					       </div>


					</div>


<div data-uk-grid-margin="" class="uk-grid">
						<div class="uk-width-medium-1-2 uk-row-first">
						    <div class="parsley-row">
<?php $dept_name = $this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);?>
						        <label for="req_cat">Salary Type *:</label>
<?php echo $this->Form->input('Emp_department', array('type' => 'hidden', 'value'=>$_SESSION['Auth']['MyProfile']['dept_code'])); ?>
  <?php $sal_type = $this->Common->findAllSalaryType();
  //print_r($sal_type);
  ?> 
<div class="input select">
<select class="md-input required form-control" id="sal_type" name="data[sal_type]">
<option value="0"> -- Select --</option>
<?php 
foreach ($sal_type as $key => $value) {
    echo "<option value='".$value['Options']['id']."'>".$value['Options']['name']."</option>";     
}
?>
</select>
</div>

						     </div>
					       </div>
					       

					</div>



                       
                        <table class="uk-table uk-text-nowrap table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
				<thead>
					<tr style="background: rgb(51, 153, 255) none repeat scroll 0px 0px;">  
		                            <th style="color: #fff">Temporary Component</th>
		                            <th style="color: #fff">Claim-Amount</th>
					    <th style="color: #fff">File</th>
		                            
		                        </tr>
		                   
		                    </thead>
                            
                            <tbody> 
                                <tr>
                                    <td colspan="2"><p id="p1" style="color:#00a65a; font-weight: 400;">* Click Add Button for Add Temporary Component</p></td>
                                </tr>
                               <?php for ($i = 1; $i <= 0; $i++) {?>
                                
                               <?php } ?>
                            </tbody>
                        </table> 
                        <div class='form-group'> 
                   
                            <input type="submit" class="md-btn md-btn-primary" id="apply" value="Apply" name='post_travel' onClick="return checkSubmit()">

                            <input type="button" class = "md-btn md-btn-success" id="add_more" value="Add" onClick="return addmore(), this.value='Add More'"/>
                            <input type="button" class = "md-btn md-btn-danger" value="Remove" onClick="return removeRow()" id="removeButton"/>
                        </div>
                    
<?php $this->Form->end(); ?>   

    
                                    </div>
                                    <div class="ln_solid"></div>   
                                    
            </div>
        </div>
    </div>
</div>


<script>
var rowCount = 0;
    jQuery(document).ready(function () {
         
        $("#apply").hide();
        
        $("#add_more").click(function(){
             $("#p1").hide();             
             $("#apply").show();
        });
        
       $("#sal_type").change(function(){
             rowCount = 0;
                 $("#removeButton").hide();
                $('#myTable tr.cont1').remove();
                return false;
            
        });
        
        jQuery(".expenseTest").datepicker({
            inline: false,
            changeMonth: true,
            autoclose: true,
            orientation: "right top",
            endDate:'today',
             dateFormat: 'dd-mm-yy',
             minDate:0,
             maxDate:0

        });

// You can use the locally-scoped $ in here as an alias to jQuery.
        jQuery("#removeButton").hide();
        $('#').change(function () {

        });

    });
    /*====function to add a row====*/
   
    function addmore() {
        var sal_typ = $("#sal_type").val();
        
        if(sal_typ!=0){
        rowCount++;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot ?>temporary_components/addnew/",
            data: {"rowCount": rowCount,"sal_typ":sal_typ},
            success: function (data_var)
            {
                $('#myTable tr:last').after(data_var);
                $("#myTable").find(".expenseTest").each(function () {
                    jQuery(this).datepicker({
                        inline: false,
                        changeMonth: true,
                        autoclose: true,
                        orientation: "right bottom",
                        endDate:'today',
                        format: 'dd-mm-yyyy',
                        minDate: 0,
                        maxDate: 0

                    });
                });
                jQuery("#removeButton").show();

            }
        });
        }else{
               $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Select Salary Type</div>").show();
        return false;
        
        }
    }
    /*====function to remove a row====*/
    function removeRow()
    {

        var id = $('#myTable tr:last').attr('id');
        var oldRowCount = document.getElementById("myTable").rows.length;
        var newRowCount = parseInt(oldRowCount) - 1;
        if (newRowCount == 2)
        {
            $("#removeButton").hide();
            $('#myTable tr:last').remove();
        } else
        {
            $('#myTable tr:last').remove();
        }
    }
    function checkSubmit()
    {

        var oldRowCount = document.getElementById("myTable").rows.length;
        var newRowCount = parseInt(oldRowCount) - 1;
        var typeval = $("#sal_type").val();
        //alert(newRowCount);
        if(typeval==0){
            $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Select Salary Type</div>").show();
               return false;
        }
        if(oldRowCount == 2)
            {
               $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Select a Temporary Component</div>").show();
               //temp_code.focus();
               return false;
            } 
      
        var i=1;
        for (i = 1; i <= newRowCount; i++)
        {
           //alert(i);
            var claim = jQuery('#amount_' + i).val();
            var temp_code = jQuery('#temp_code_' + i);
            var date = jQuery('#claimdate_' + i);

	    
           //alert(temp_code.val());
            if (date.val() == '')
            {
               $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Enter claim date</div>").show();
               date.focus();
                return false;
            }else if (temp_code.val() == '')
            {
               $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Select a Temporary Component</div>").show();
               temp_code.focus();
               return false;
            } 
            else if (claim == "")
            {
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#alerts").html("<div class='uk-alert uk-alert-danger' data-uk-alert=''><a href='#' class='uk-alert-close uk-close'></a>Claim amount is required to be filled</div>").show();
                
                return false;
            } 

        }

        return true;

    }
    



</script>

