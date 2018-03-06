<?php

$cot=$this->common->getKpiQuarterCount($kpiId,$kraId,$kpiMapEmpId);
?>
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

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
                        <ul class="nav nav-tabs">
                            <?php
                            for($n=1;$n<=$tab;$n++){
                                if($n==1){?>
                            <li class="active"><a data-toggle="tab" href="#home">Quarter <?php echo $n;?></a></li>
                            <?php }else{?>
                            <li><a data-toggle="tab" href="#menu<?php echo $n;?>">Quarter <?php echo $n;?></a></li>
                            <?php }} ?>
                        </ul>
                        <div class="tab-content">
                            <?php
                            for($n=1;$n<=$tab;$n++){
                                if($n==1){?>
                            <div id="home" class="tab-pane fade in active">
                                <?php if($this->common->getKpiQuarters($kpiId,$kraId,$kpiMapEmpId,$n)!==true) {?>
                                <form accept-charset="utf-8" method="post" name="addkpi" id="addkpi" action="/hrlatest_new/KpiMasters/addKpiUnitSave">
                                    <input type="hidden" value="POST" name="_method">
                                    <h3>Quarter 1</h3>
                                    <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                                    <input type="hidden" name="kraId" value="<?php echo $kraId; ?>" id="kraId">
                                    <input type="hidden" name="kpiId" value="<?php echo $kpiId; ?>" id="kpiId">
                                    <input type="hidden" name="kpiMapEmpId" value="<?php echo $kpiMapEmpId; ?>" id="kpiMapEmpId">
                                    <input type="hidden" name="assign_emp_code" value="<?php echo $assign_emp_code; ?>" id="assign_emp_code">
                                    <input type="hidden" name="myprofile_id" value="<?php echo $myprofile_id; ?>" id="myprofile_id">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $name;?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraName;?>
                                            <input type="hidden" name="process_quarter" value="<?php echo $n; ?>" id="process_quarter">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KPI Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiName;?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reporting To : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($assign_emp_code);?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                               <?php //echo $this->Form->input('kpiComment', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $comment, 'maxlength'=>'100')); ?>
                                            <input type="text" id="kpiComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kpi[kpiComment]">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //echo $this->Form->input('kpiUnit', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $units,'maxlength'=>'100')); ?>
                                            <input type="text" id="kpiComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kpi[kpiUnit]">
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-sm-8" id="Park-Button">
                                        <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                                    </div>
                                </form>
                                <?php }else{ ?>
                                <h3>Quarter 1</h3>
                                <?php $kpiDetail=$this->common->getKpiQuarterDetail($kpiId,$kraId,$kpiMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KPI Name : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KpiMaster']['kpi_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Repoting To : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($kpiDetail['KpiMapEmps']['kpi_user_emp_code']);?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php }else{?>
                            <div id="menu<?php echo $n;?>" class="tab-pane fade">
                                <?php if($this->common->getKpiQuarters($kpiId,$kraId,$kpiMapEmpId,$n)!==true) {?>
                                <form accept-charset="utf-8" method="post" name="addkpi<?php echo $n;?>" id="addkpi<?php echo $n;?>" action="/hrlatest_new/KpiMasters/addKpiUnitSave">
                                    <input type="hidden" value="POST" name="_method">
                                    <h3>Quarter <?php echo $n;?></h3>
                                    <input type="hidden" name="appid" value="<?php echo $appId; ?>" id="appid">
                                    <input type="hidden" name="kraId" value="<?php echo $kraId; ?>" id="kraId">
                                    <input type="hidden" name="kpiId" value="<?php echo $kpiId; ?>" id="kpiId">
                                    <input type="hidden" name="kpiMapEmpId" value="<?php echo $kpiMapEmpId; ?>" id="kpiMapEmpId">
                                    <input type="hidden" name="assign_emp_code" value="<?php echo $assign_emp_code; ?>" id="assign_emp_code">
                                    <input type="hidden" name="myprofile_id" value="<?php echo $myprofile_id; ?>" id="myprofile_id">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $name;?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Kra Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraName;?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Kpi Name : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiName;?>
                                            <input type="hidden" name="process_quarter" value="<?php echo $n; ?>" id="process_quarter">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reporting To : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($assign_emp_code);?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                               <?php //echo $this->Form->input('kpiComment', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $comment, 'maxlength'=>'100')); ?>
                                            <input type="text" id="kpiComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kpi[kpiComment]">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //echo $this->Form->input('kpiUnit', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $units,'maxlength'=>'100')); ?>
                                            <input type="text" id="kpiComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kpi[kpiUnit]">
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-sm-8" id="Park-Button">
                                        <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                                    </div>
                                </form>
                                <?php }else{ ?>
                                <h3>Quarter <?php echo $n;?></h3>
                                <?php $kpiDetail=$this->common->getKpiQuarterDetail($kpiId,$kraId,$kpiMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KPI Name : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KpiMaster']['kpi_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Repoting To : </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($kpiDetail['KpiMapEmps']['kpi_user_emp_code']);?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php }} ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>