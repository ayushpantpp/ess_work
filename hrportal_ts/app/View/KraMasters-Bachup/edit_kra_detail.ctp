<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

<?php
echo $this->Form->create('Kra', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'KraMasters', 'action' => 'editKraSaveInfo'), 'id' => 'editkra', 'name' => 'editkra'));
?>

<div role="main" class="right_col">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit KRA Detail</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Department : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getdepartmentbyid($dept_code);?>
                                <span style="display: none;"><?php echo $this->Form->input('department_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $department,'value'=>$dept_code, 'class' => 'form-control col-md-4 col-xs-12')); ?></span>
                                <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12">KRA Name :</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php foreach($kraNamelists as $k=>$val){ 
                                    foreach ($kralist as $va) { if($k==$va['KraMaster']['id']) echo $val;}
                                     } ?>
                                <select  class="form-control col-md-4 col-xs-12" name="kraName[]" style="display: none;">
                                    <?php foreach($kraNamelists as $k=>$val){ ?>
                                    <option value='<?php echo $k?>' <?php foreach ($kralist as $va) { if($k==$va['KraMaster']['id']) echo 'selected';}?>><?php echo $val ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Start Date(y-m-d)* : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('kr_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'startdate','readonly'=>true, 'value'=>date('Y-m-d',strtotime($kralist[0]['KraMapEmp']['from_date'])))); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">End Date(y-m-d)* :</label>

                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('kr_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 krDate",'type' => 'text', 'id' => 'enddate','readonly'=>true,'value'=>date('Y-m-d',strtotime($kralist[0]['KraMapEmp']['to_date'])))); ?>
                            </div>
                        </div>

                        <div id="empselect">
                    <?php $checllvl = $this->Common->getAllEmployeeListDepartment($dept_code,$comp_code);?>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name:<span class="required">*</span></label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php
                                    if(!empty($checllvl)){
                                        foreach ($checllvl as $key => $ve) {
                                            if($key==$employeeID) echo $ve;
                                        }
                                    }
                                    ?>
                                    <span style="display: none;">
                                       <?php echo $this->Form->input('employee_name', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' =>$checllvl,'value'=>$employeeID, 'class' => 'form-control s-form-item s-form-all')); ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" id="Park-Button">
                            <input type="hidden" value="<?php echo $employeeID;?>" name="emplyeeID">
                            <input type="hidden" value="<?php echo $kraMapEmp;?>" name="kraMapEmp">
                            <input type="hidden" value="<?php echo $kralist[0]['KraMapEmp']['kramasters_id'];?>" name="kraMaster">
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
