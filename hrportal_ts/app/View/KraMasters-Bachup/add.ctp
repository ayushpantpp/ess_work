<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <?php if(!empty($krafrmchk)){?>
                    <div class="x_title">
                        <h2>No Appraisal Form</h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php }elseif(!empty($kraList)){?>
                    <div class="x_title">
                        <h2>KRA for the year <?php echo (date("Y")-1)."-".date("Y")?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php   echo $this->Form->create('Kra', array('inputDefaults' => array('label' => false,'div' => false,'error' => array('wrap' => 'span','class' => 'my-error-class')), 'url' => array('controller' => 'KraMasters', 'action' => 'kraKpiSaveInfo'), 'id' => 'addkra', 'name' => 'addkra'));?>
                    <div class="x_content">
                        <div class="x_title">
                            <h2>Appraisee Information - <?php echo $name;?> [<?php echo $emp_code;?>]</h2>
                        </div>
                        <br>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Appraisee Name [Code]</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $name;?> [<?php echo $emp_code;?>]
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Designation</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->common->findDesignationName($myprofile['MyProfile']['desg_code'],$myprofile['MyProfile']['comp_code']); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Branch</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Department</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->common->getdepartmentbyid($myprofile['MyProfile']['dept_code']); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Joining Date</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $myprofile['MyProfile']['join_date']; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Appraisal Date</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Last Date Of Submission</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $kraList[0]['KpiMapEmps']['to_date']; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Qualification</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo ""; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Forward To</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php $checllvl = $this->Common->findcheckLevel1($appId);
                                    $fwemplist = $this->Common->findPreviousLevel($emp_code);
                                    $l=0;
                                    foreach ($fwemplist as $key => $value) {
                                            if($l==0){
                                            $forward_emp_code=$key;
                                            $forward_emp_name=$value;
                                            $l++;
                                            }
                                        } 
                                        echo $forward_emp_name;
                                    ?>
                                    <?php  echo $this->Form->input('employee_name', array('type' => 'hidden', 'label' => false, 'class' => 'form-control s-form-item s-form-all','value'=>$forward_emp_code)); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Comment</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $this->Form->input('kra_comments.'.$i, array('class'=>'form-control','type' => 'textarea')); ?>
                                </div>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <tr>
                                    <td>1:- Unsatisfactory (0.00-2.50)</td>
                                    <td>2:- Satisfactory (2.51-3.00)</td>
                                </tr>
                                <tr>
                                    <td>3:- Above Average (3.01-3.74)</td>
                                    <td>4:- Good (3.75-4.50)</td>
                                </tr>
                                <tr>
                                    <td>5:- Very Good (4.51-5.00)</td>
                                    <td></td>
                                </tr>
                            </table>
                            <?php $i=1; if(!empty($krlist)){?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <h2>KRA Competency Group</h2>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Sr.No </th>
                                        <th> Competency</th>
                                        <th> Weightage(%)</th>
                                        <th> Priority</th>
                                        <th> Rating</th>
                                        <th> Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($krlist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                    <tr class="even pointer">
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td></td>
                                        <td><?php echo $kpiVal['kpi_masters']['weightage']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                        <td><?php echo $this->Form->input('kpiUnit.'.$i, array('class'=>'form-control','type' => 'text','value' => $units,'maxlength'=>'100')); ?></td>
                                        <td><?php echo $this->Form->input('kpiComment.'.$i, array('class'=>'form-control','type' => 'textarea','value' => $comment)); ?>
                                            <?php echo $this->Form->input('kpiCommentIds.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['id'], 'maxlength'=>'100')); ?>
                                            <?php echo $this->Form->input('kra_masters_id.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['kra_masters_id'], 'maxlength'=>'100')); ?>
                                            <?php echo $this->Form->input('kpi_masters_id.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['kpi_masters_id'], 'maxlength'=>'100')); ?>
                                        </td>
                                    </tr>
                                    <?php $i++; } ?>
                                </tbody>
                            </table>
                            <?php }?>
                            <?php if(!empty($complist)){?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <h2>Competency Competency Group</h2>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Sr.No </th>
                                        <th> Competency</th>
                                        <th> Priority</th>
                                        <th> Rating</th>
                                        <th> Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $j=1;foreach($complist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                    <tr class="even pointer">
                                        <td><?php echo $j;?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                        <td><?php echo $this->Form->input('kpiUnit.'.$i, array('class'=>'form-control','type' => 'text','value' => $units,'maxlength'=>'100')); ?></td>
                                        <td><?php echo $this->Form->input('kpiComment.'.$i, array('class'=>'form-control','type' => 'textarea','value' => $comment)); ?>
                                            <?php echo $this->Form->input('kpiCommentIds.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['id'], 'maxlength'=>'100')); ?>
                                            <?php echo $this->Form->input('kra_masters_id.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['kra_masters_id'], 'maxlength'=>'100')); ?>
                                            <?php echo $this->Form->input('kpi_masters_id.'.$i, array('class'=>'form-control','type' => 'hidden','value' => $kraListValue['KpiMapEmps']['kpi_masters_id'], 'maxlength'=>'100')); ?>
                                        </td>
                                    </tr>
                                    <?php $i++;$j++; } ?>
                                </tbody>
                            </table>
                            <?php }?>
                            <div class="ln_solid"></div>
                            <div class="form-group col-md-1 col-sm-6 col-xs-6">
                                <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                                    <input type="submit" class="btn btn-success" value="Submit">
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php }else{ ?>
                    <div class="x_title">
                        <h2>No Appraisal Form</h2>
                        <div class="clearfix"></div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>