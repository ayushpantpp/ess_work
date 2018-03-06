<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>KRA for the year <?php echo (date("Y")-1)."-".date("Y")?></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="x_title">
                            <h2>Appraisee Information - <?php echo $myprofile['MyProfile']['emp_firstname']." ".$myprofile['MyProfile']['emp_lastname'];?> [<?php echo $myprofile['MyProfile']['emp_code'];?>]</h2>
                        </div>
                        <br>
                        <div class="form-group col-md-12 col-sm-12 col-xs-12">

                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Appraisee Name [Code]</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $myprofile['MyProfile']['emp_firstname']." ".$myprofile['MyProfile']['emp_lastname'];?> [<?php echo $myprofile['MyProfile']['emp_code'];?>]
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
                                    <?php echo $this->Form->input('assign_user_employee', array('type' => 'hidden', 'label' => false,'value'=>$myprofile['MyProfile']['emp_code'])); ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">OverAll Rating For KRA Competency Group</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php //echo $this->common->calculateAverageByEmployee($myprofile['MyProfile']['emp_code'],$emp_date); ?>
                                    <?php echo $kraScore; ?>
                                    <?php echo " (".$kraScorePos.")"; ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">OverAll Rating For Competency Competency Group</label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <?php echo $competencyScore; ?>
                                    <?php echo " (".$competencyScorePos.")"; ?>
                                </div>
                            </div>
                            <?php 
                                $checllvl = $this->Common->findcheckLevel1($appId);
                                if($emp_codes=='209'){
                                    $fwemplist = '';
                                }else{
                                    $fwemplist = $this->Common->findPreviousLevel($myprofile['MyProfile']['emp_code']);
                                }
                            ?>
                            <?php if(!empty($krlist)){?>
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
                                        <?php if(!empty($kraProcessCount)){
                                            foreach ($kraProcessCount as $key => $value) {
                                                if($key==0){
                                                    echo "<th>Self Rating</th>";
                                                    echo "<th>Self Remark</th>";
                                                }elseif($key==count($kraProcessCount)-1){
                                                    echo "<th>Final Rating</th>";
                                                    echo "<th>Final Remark</th>";
                                                }else{
                                                    echo "<th>Superior ".$key." Rating</th>";
                                                    echo "<th>Superior ".$key." Remark</th>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;foreach($krlist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                    <tr class="even pointer">
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <td><?php echo $kpiVal['kpi_masters']['weightage']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                        <?php 
                                        if(!empty($kraProcesslist)){
                                            foreach ($kraProcesslist as $value) {
                                                if($value['KraKpiProcess']['kpi_masters_id']==$kpiVal['kpi_masters']['id']){
                                                      echo "<td>".$value['KraKpiProcess']['units']."</td>";
                                                    echo "<td>".$value['KraKpiProcess']['comment']."</td>";
                                                }
                                                }
                                        }
                                        ?>
                                    </tr>
                                    <?php $i++;}?>
                                </tbody>
                            </table>
                            <?php }if(!empty($complist)){?>
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <h2>Competency Competency Group</h2>
                            </div>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">
                                        <th class="column-title">Sr.No </th>
                                        <th> Competency</th>
                                        <th> Priority</th>
                                        <?php if(!empty($kraProcessCount)){
                                            foreach ($kraProcessCount as $key => $value) {
                                                if($key==0){
                                                    echo "<th>Self Rating</th>";
                                                    echo "<th>Self Remark</th>";
                                                }elseif($key==count($kraProcessCount)-1){
                                                    echo "<th>Final Rating</th>";
                                                    echo "<th>Final Remark</th>";
                                                }else{
                                                    echo "<th>Superior ".$key." Rating</th>";
                                                    echo "<th>Superior ".$key." Remark</th>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;foreach($complist as $kraListValue)  {
                                        $kpiVal=$this->common->getKpiDetail($kraListValue['KpiMapEmps']['kpi_masters_id']);
                                    ?>
                                    <tr class="even pointer">
                                        <td><?php echo $i;?></td>
                                        <td><?php echo $this->common->getKraName($kpiVal['kpi_masters']['kra_id'])."<br/>".$kpiVal['kpi_masters']['kpi_name']; ?></td>
                                        <td><?php echo $this->common->getPriorityName($kpiVal['kpi_masters']['priority']); ?></td>
                                        <?php 
                                        if(!empty($kraProcesslist)){
                                            foreach ($kraProcesslist as $value) {
                                                if($value['KraKpiProcess']['kpi_masters_id']==$kpiVal['kpi_masters']['id']){
                                                      echo "<td>".$value['KraKpiProcess']['units']."</td>";
                                                    echo "<td>".$value['KraKpiProcess']['comment']."</td>";
                                                }
                                                }
                                        }
                                        ?>
                                    </tr>
                                    <?php $i++;}?>
                                </tbody>
                            </table>
                            <?php }?>
                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                    <?php
                                    if (!empty($kraProcessCount)) {
                                        foreach ($kraProcessCount as $key => $value) {
                                            if ($key == 0) {
                                                echo "<tr><th>Self Comment</th>";
                                                echo "<td>".$kraProcessComment[$key]['KraKpiProcess']['kra_comments']."</td></tr>";
                                            } else {
                                                echo "<tr><th>Superior " . $key . " Comment</th>";
                                                echo "<td>".$kraProcessComment[$key]['KraKpiProcess']['kra_comments']."</td></tr>";
                                            }
                                        }
                                    }
                                    ?>
                            </table>
                            <div class="ln_solid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>