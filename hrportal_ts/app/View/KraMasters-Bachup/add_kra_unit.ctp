<?php

$cot=$this->common->getKraQuarterCount($kraId,$kraMapEmpId);
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
                                <?php if($this->common->getKraQuarters($kraId,$kraMapEmpId,$n)!==true) {?>
                                <form accept-charset="utf-8" method="post" name="addkra" id="addkra" action="/hrlatest_new/KraMasters/addKraUnitSave">
                                    <input type="hidden" value="POST" name="_method">
                                    <h3>Quarter 1</h3>
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
                                            <input type="hidden" name="process_quarter" value="<?php echo $n; ?>" id="process_quarter">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reporting To : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($assign_emp_code);?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Target Employee By : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php echo $KraScore=$this->common->getKraKpiQuarterDetail($kraId,$n,$kraVal['KraMapEmp']['weightage']);
                                            if($KraScore!='NA'){
                                                echo "  (".($KraScore/$kraVal['KraMapEmp']['weightage'])*100 ."%)";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                               <?php //echo $this->Form->input('kraComment', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $comment, 'maxlength'=>'100')); ?>
                                            <input type="text" id="kraComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kra[kraComment]">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //echo $this->Form->input('kraUnit', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $units,'maxlength'=>'100')); ?>
                                            <input type="text" id="kraUnit" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kra[kraUnit]">
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-sm-8" id="Park-Button">
                                        <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                                    </div>
                                </form>
                                <?php }else{ ?>
                                <h3>Quarter 1</h3>
                                <?php $kraDetail=$this->common->getKraQuarterDetail($kraId,$kraMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Repoting To : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($kraDetail['KraMapEmp']['kra_user_emp_code']);?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Target Employee By : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php echo $KraScore=$this->common->getKraKpiQuarterDetail($kraId,$n,$kraVal['KraMapEmp']['weightage']);
                                            if($KraScore!='NA'){
                                                echo "  (".($KraScore/$kraVal['KraMapEmp']['weightage'])*100 ."%)";
                                            }
                                            ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php }else{?>
                            <div id="menu<?php echo $n;?>" class="tab-pane fade">
                                <?php if($this->common->getKraQuarters($kraId,$kraMapEmpId,$n)!==true) {?>
                                <form accept-charset="utf-8" method="post" name="addkra<?php echo $n;?>" id="addkra<?php echo $n;?>" action="/hrlatest_new/KraMasters/addKraUnitSave">
                                    <input type="hidden" value="POST" name="_method">
                                    <h3>Quarter <?php echo $n;?></h3>
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
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Kra Name : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraName;?>
                                            <input type="hidden" name="process_quarter" value="<?php echo $n; ?>" id="process_quarter">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Reporting To : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($assign_emp_code);?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Target Employee By : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php echo $KraScore=$this->common->getKraKpiQuarterDetail($kraId,$n,$kraVal['KraMapEmp']['weightage']);
                                            if($KraScore!='NA'){
                                                echo "  (".($KraScore/$kraVal['KraMapEmp']['weightage'])*100 ."%)";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                               <?php //echo $this->Form->input('kraComment', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $comment, 'maxlength'=>'100')); ?>
                                            <input type="text" id="kraComment" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kra[kraComment]">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : <span class="required">*</span> </label>
                                        <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php //echo $this->Form->input('kraUnit', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text','value' => $units,'maxlength'=>'100')); ?>
                                            <input type="text" id="kraUnit" maxlength="100" class="form-control col-md-7 col-xs-12" name="Kra[kraUnit]">
                                        </div>
                                    </div>
                                    <div class=" col-md-2 col-sm-8" id="Park-Button">
                                        <input type="submit" value="Post" class="btn btn-success" onclick ="checkSubmit();">
                                    </div>
                                </form>
                                <?php }else{ ?>
                                <h3>Quarter <?php echo $n;?></h3>
                                <?php $kraDetail=$this->common->getKraQuarterDetail($kraId,$kraMapEmpId,$n);?>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">KRA Name : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['KraMaster']['kra_name'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Comment : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['kra_kpi_process']['comment'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Units : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $kraDetail['kra_kpi_process']['units'];?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Repoting To : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                <?php echo $this->common->getempinfo($kraDetail['KraMapEmp']['kra_user_emp_code']);?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Target Employee By : <span class="required">*</span> </label>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                            <?php echo $KraScore=$this->common->getKraKpiQuarterDetail($kraId,$n,$kraVal['KraMapEmp']['weightage']);
                                            if($KraScore!='NA'){
                                                echo "  (".($KraScore/$kraVal['KraMapEmp']['weightage'])*100 ."%)";
                                            }
                                            ?>
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