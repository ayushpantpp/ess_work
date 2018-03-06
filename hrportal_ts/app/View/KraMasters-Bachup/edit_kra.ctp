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
        ), 'url' => array('controller' => 'KraMasters', 'action' => 'editKraSave'), 'id' => 'editkra', 'name' => 'editkra'));
?>

<div role="main" class="right_col">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>History</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                        <input type="hidden" name="kraId" value="<?php echo $kraId; ?>" id="kraId">
                        <input type="hidden" name="kraMapEmpId" value="<?php echo $kraMapEmpId; ?>" id="kpiMapEmpId">
                        <input type="hidden" name="assign_emp_code" value="<?php echo $assign_emp_code; ?>" id="assign_emp_code">
                        <input type="hidden" name="myprofile_id" value="<?php echo $myprofile_id; ?>" id="myprofile_id">
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Name : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $name;?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraName;?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reporting To : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($assign_emp_code);?>
                                <input type="hidden" name="kraKpiProcess" value="<?php echo $kraKpiProcess; ?>" id="kraKpiProcess">
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                               <?php echo $this->Form->input('kpiComment', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $comment, 'maxlength'=>'100')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->Form->input('kpiUnit', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $units,'maxlength'=>'100')); ?>
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