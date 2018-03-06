
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>

<div role="main" class="">
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
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee Name :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiValues['MyProfile']['emp_firstname'].$kralist['MyProfile']['emp_lastname'];?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Date From :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiValues['KpiMapEmps']['from_date'];?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Date To :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiValues['KpiMapEmps']['to_date'];?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Weightage :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiValues['KpiMapEmps']['weightage'];?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Assessment Period (Every) :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->findTargetNameById($kpiValues['KpiMapEmps']['target']);?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-6">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Overall Kra Score :  </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getKpiQuarterAllCalculation($kpiId,$kraId,$kpiMapEmpId);?>
                            </div>
                        </div>
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
                                <h3>Quarter 1</h3>
                                <?php $kpiDetail=$this->common->getKpiQuarterDetail($kpiId,$kraId,$kpiMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KPI Name :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KpiMaster']['kpi_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Score :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->kpiCalculation($kpiDetail['kra_kpi_process']['units'],'100',$kpiDetail['KpiMapEmps']['weightage']);?>
                                    </div>
                                </div>
                            </div>
                            <?php }else{?>
                            <div id="menu<?php echo $n;?>" class="tab-pane fade">
                                <h3>Quarter <?php echo $n;?></h3>
                                <?php $kpiDetail=$this->common->getKpiQuarterDetail($kpiId,$kraId,$kpiMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KPI Name :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['KpiMaster']['kpi_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kpiDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Score :  </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->kpiCalculation($kpiDetail['kra_kpi_process']['units'],'100',$kpiDetail['KpiMapEmps']['weightage']);?>
                                    </div>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>