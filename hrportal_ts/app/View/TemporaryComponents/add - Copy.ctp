
<?php

$travelmode = $this->Common->findAllWheelerMode(); ?>
<!-- Center Content Starts -->
<?php echo $this->Form->create('tempcomp', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'TemporaryComponents', 'action' => 'add'), 'id' => 'tempcompid', 'name' => 'tempcomp'));
        ?>
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent big-table"> </div>
    </div>
</div>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            <h3>Temporary Component Add Form</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table class="table table-striped responsive-utilities jambo_table bulk_action">

                            <tr>
                                <th scope="row" width="35%">Employee Name :</th>
                                <td valign="middle"><?php $auth = $this->Session->read('Auth');
                                 echo ucwords(strtolower($auth['MyProfile']['emp_firstname']))." ".ucwords(strtolower($auth['MyProfile']['emp_lastname'])); ?></td>
                                <th scope="row">Employee ID :</th>
                                <td valign="middle"><?php echo $auth['MyProfile']['emp_id']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Department :</th>
                                <?php $dept_name = $this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);?>

                                <td valign="middle"><?php echo $this->Form->input('Emp_department', array('type' => 'hidden', 'value'=>$_SESSION['Auth']['MyProfile']['dept_code'])); ?>
                                    <?php echo $this->common->getdepartmentbyid($_SESSION['Auth']['MyProfile']['dept_code']);?>
                                </td>
                                <td></td>   
                                <td></td>
                               
                            </tr>
                        </table>
                        <table class="table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
                            <thead>
                                <tr>  
                                    <th scope="row">Claim Date</th>
                                    <th>Temporary Component</th>
                                    <th>Claim-Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php for ($i = 0; $i <= 0; $i++) {?>
                                <tr class="even pointer" id="row_1">
                                    <td><?php echo $this->Form->input('Claimdate', array('id'=>'claimdate_1','label' => false, 'type' => 'text', 'class' => 'required expenseTest form-control', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>
                                    </td>
                                    <td><?php echo $this->Form->input('temp_code.1', array('id'=>'temp_code_1','type' => 'select', 'empty' => ' -- select -- ' , 'label' => false, 'options' => $temp, 'class' => 'required form-control')); ?></td>                                    
                                    <td><?php echo $this->Form->input('amount.1', array('id'=>'amount_1','label' => false, 'type' => 'text', 'class' => 'required form-control','value'=>'', 'autocomplete' => 'off')); ?></td>

                                </tr>
                               <?php } ?>
                            </tbody>
                        </table>     
                    </div>
                </div>
                <div class='form-group'> 
                   
                    <input type="submit" class="btn btn-danger" value="Apply" name='post_travel' onClick="return checkSubmit()">

                    <input type="button" class = 'btn btn-success' value="Add New" onClick="return addmore()"/>
                    <input type="button" class = 'btn btn-success' value="Remove" onClick="return removeRow()" id="removeButton"/>
                </div>
            </div>
        </div>
    </div>


</div>    
<?php $this->Form->end(); ?>   


<script>

    jQuery(document).ready(function () {

        jQuery(".expenseTest").datepicker({
            inline: false,
            changeMonth: true,
            autoclose: true,
            orientation: "right bottom",
            endDate:'today',
             format: 'dd-mm-yyyy'

        });

// You can use the locally-scoped $ in here as an alias to jQuery.
        jQuery("#removeButton").hide();
        $('#').change(function () {

        });

    });
    /*====function to add a row====*/
    var rowCount = 1;
    function addmore() {

        rowCount++;
        $.ajax({
            type: "POST",
            url: "<?php echo $this->webroot ?>temporary_components/addnew/",
            data: {"rowCount": rowCount},
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
                        format: 'dd-mm-yyyy'

                    });
                });
                jQuery("#removeButton").show();

            }
        });
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
       
        var i;
        for (i = 1; i <= newRowCount; i++)
        {
           
            var claim = jQuery('#amount_' + i).val();
           var date = jQuery('#claimdate_' + i);
           
            if (date.val() == '')
            {
               $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a Date").show();
               date.focus();
                return false;
            }    
            else if (claim == "")
            {
                $("html, body").animate({ scrollTop: 0 }, "slow");
               $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>claim amount is required to be filled").show();
               
                return false;
            } else if (isNaN(claim))
            {
                $("html, body").animate({ scrollTop: 0 }, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter a Numeric Claim Value ").show();
                jQuery('#claim_amt_' + i).focus();
                
                return false;
            }

        }

        return true;

    }



</script>

