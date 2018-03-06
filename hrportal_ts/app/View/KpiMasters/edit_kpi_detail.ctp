<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

<?php
echo $this->Form->create('Kpi', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KpiMasters', 'action' => 'editKpiSaveInfo'), 'id' => 'editkpi', 'name' => 'editkpi'));
?>

<div role="main" class="right_col">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit KPI Detail</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Department : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('department_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -','value'=>$dept_code, 'options' => $departmentList, 'class' => 'form-control col-md-4 col-xs-12'));?>
                                <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">KPI Name :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('kpiName', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value'=>$kpiName, 'maxlength'=>'100')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Start Date(y-m-d)* : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('kpi_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'startdate','readonly'=>true, 'value'=>date('Y-m-d',strtotime($kpi_start_date)))); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">End Date(y-m-d)* :</label>

                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('kpi_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'enddate','readonly'=>true,'value'=>date('Y-m-d',strtotime($kpi_end_date)))); ?>
                                <input type="hidden" name="kraId" value="<?php echo $kraId; ?>" >
                                <input type="hidden" name="kpiId" value="<?php echo $kpiId; ?>" >
                                <input type="hidden" name="kpiMapId" value="<?php echo $kpiMapEmpId; ?>" >
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">Weightage : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('weightage', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'id' => 'weightage','readonly'=>false,'value'=>$weightage)); ?>
                            </div>
                        </div>

                        <div id="empselect">
                    <?php
                    $checllvl = $this->Common->findcheckLevel1($appId);
                    $fwemplist = $this->Common->findLevel1($checllvl,'Apply');
                    ?>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name:<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                       <?php echo $this->Form->input('employee_name', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' =>$fwemplist, 'id'=>'employee_name' ,'class' => 'form-control s-form-item s-form-all')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Target : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('target', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -','value'=>$dept_code, 'options' => $targets,'value'=>$target, 'class' => 'form-control col-md-4 col-xs-12'));?>
                                <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                            </div>
                        </div>

                        <div class=" col-md-2 col-sm-8" id="Park-Button">
                            <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                        </div>
                  <?php $this->Form->end(); ?>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            jQuery(function () {
                jQuery('.krDate').datepicker({inline: true, changeMonth: true, changeYear: true, autoclose: true, format: 'yyyy-mm-dd'});
            });
        </script>
        <script>
            $('#KraDepartmentId').change(function () {
                var dept = $("#KraDepartmentId option:selected").val();
                var app = $('#appid').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>kraMasters/levelEmp/' + dept + '/' + app,
                    success: function (data) {

                        jQuery('#empselect').html(data);
                    }
                });
            });
            $('#employee_name').val(<?php echo $employeeID;?>);
        </script>