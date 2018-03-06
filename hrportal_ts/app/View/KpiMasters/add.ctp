<?php

echo $this->Form->create('Kpi', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KpiMasters', 'action' => 'kpiSaveInfo'), 'id' => 'addkpi', 'name' => 'addkpi'));
 ?>

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add KPI</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>

                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table table-striped responsive-utilities jambo_table bulk_action" id = "myTable">
                            <thead>
                                <tr>  
                                    <th>KPI Name</th>
                                    <th>KRA</th>
                                    <th>Department</th>
                                    <th>Employee Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Weightage</th>
                                    <th>Assessment Period (Every)</th>
                                </tr>
                            </thead>
                            <tbody>
               <?php for ($i = 0; $i <= 0; $i++) {?>
                                <tr class="even pointer" id="row_1">
                                    <td>
                                        <?php echo $this->Form->input('kpi_name.1', array('class'=>'form-control','type' => 'text', 'maxlength'=>'100')); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('kpi_kra_id.1', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $kraLists, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('kpi_department_id.1', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $departments, 'id'=>'kra_kpi_department_id_1','onChange'=>'getDepartmentEmployee(this)', 'class' => 'kra_kpi_department form-control col-md-4 col-xs-12')); ?>
                                    </td>
                                    <td id="empselect_1"></td>
                                    <td>
                                        <?php echo $this->Form->input('kpi_start_date.1', array('id'=>'kpi_start_1','label' => false, 'type' => 'text', 'class' => 'form-control required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('kpi_end_date.1', array('id'=>'kpi_end_1','label' => false, 'type' => 'text', 'class' => 'form-control required expenseTest', 'MAXLENGTH' => '20', 'autocomplete' => 'off')); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->form->input('kpi_weightage.1', array('label'=>false,'class'=>"form-control",'type' => 'text', 'readonly'=>false)); ?>
                                    </td>
                                    <td>
                                        <?php echo $this->Form->input('kpi_target.1', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $targets, 'id'=>'kra_target_1','class' => 'form-control col-md-4 col-xs-12')); ?>
                                    </td>
                                </tr>
               <?php } ?>
                            </tbody>
                        </table>     
                    </div>
                </div>
                <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                <input type="submit" value="Submit to Manager" onClick="return checkSubmit()"/>
                <input type="button" value="Add New" onClick="return addmore()"/>
                <input type="button" value="Remove" onClick="return removeRow()" id="removeButton"/>
            </div>
        </div>
    </div>


</div>    
<?php $this->Form->end(); ?>   


<script>
    function getconveyence() {
        jQuery('#dialog').dialog('open');
    }
    jQuery(document).ready(function () {
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
            url: "<?php echo $this->webroot ?>kpiMasters/addnew/",
            data: {"rowCount": rowCount},
            success: function (data_var)
            {
                $('#myTable tr:last').after(data_var);
                jQuery("#removeButton").show();
                jQuery('.expenseTest').datepicker({inline: true, changeMonth: true, changeYear: true, autoclose: true, format: 'yyyy-mm-dd', orientation: "right"});
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
        return true;
    }
</script>

<script type="text/javascript">
    $(function () {
        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            height: 'auto',
            modal: true,
            buttons: {
                "OK": function () {
                    $(this).dialog("close");
                }
            }
        });
    });
</script>

<script>
    function getDepartmentEmployee(idd) {
        depId = $(idd).attr("id").match(/\d+/);
        var dept = $("#kra_kpi_department_id_" + depId + " option:selected").val();
        var app = $('#appid').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>kpiMasters/levelEmp/' + dept + '/' + app,
            data: {"rowCount": depId},
            success: function (data) {
                jQuery('#empselect_' + depId).html(data);
            }
        });
    }

</script>

<script type="text/javascript">
    jQuery(function () {
        jQuery('.expenseTest').datepicker({inline: true, changeMonth: true, changeYear: true, autoclose: true, format: 'yyyy-mm-dd', orientation: "right"});
    });
</script>
