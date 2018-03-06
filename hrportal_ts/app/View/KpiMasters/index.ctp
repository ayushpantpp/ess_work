<?php

$i=0;$j=0; ?>
<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">

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
                        <h2>KPI Detail </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class="headings">

                                    <th class="column-title">Sr.No </th>
                                    <th> KRA Name</th>
                                    <th> KPI</th>
                                    <th class="column-title"> Applied Date  </th>
                                    <th class="column-title"> End Date  </th>
                                    <th class="column-title"> Weightage  </th>
                                    <th class="column-title">Target </th>
                                    <th class="column-title">Action </th>

                                </tr>
                            </thead>
                            <tbody>
                  <?php if(empty($kraValues)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
              <?php }?>

             <?php foreach($kraValues as $kraValue)  {
                if($this->common->getKpiQuarterCheck($kraValue['KpiMapEmps']['kpi_masters_id'],$kraValue['KpiMapEmps']['kra_masters_id'],$kraValue['KpiMapEmps']['id'])){
                 ?>
                                <tr class="even pointer">
                                    <td><?php echo $i+1;?></td> 
                                    <td><?php echo $kraValue['KraMaster']['kra_name'];?></td>
                                    <td><?php echo $kraValue['KpiMaster']['kpi_name'];?></td>
                                    <td><?php echo $kraValue['KpiMapEmps']['from_date']; ?></td>
                                    <td><?php echo $kraValue['KpiMapEmps']['to_date']; ?></td>
                                    <td><?php echo $kraValue['KpiMapEmps']['weightage']; ?></td>
                                    <td><?php echo $this->common->findTargetNameById($kraValue['KpiMapEmps']['target']) ?></td>
                                    <td><a href="<?php echo $this->webroot;?>kpiMasters/addKpiUnit/<?php echo base64_encode($kraValue['KpiMapEmps']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Add Comment and Unit.">Add</a>
                                    </td>
                                </tr>
                 <?php }$i++ ;} ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="x_title">
                        <h2>Submit Kpi Detail </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class="headings">

                                    <th class="column-title">Sr.No </th>
                                    <th> KRA Name</th>
                                    <th> KPI Name</th>
                                    <th class="column-title"> Applied Date  </th>
                                    <th class="column-title"> End Date  </th>
                                    <th class="column-title"> Weightage  </th>
                                    <th class="column-title">Target </th>
                                    <th class="column-title">Units </th>
                                    <th class="column-title">Quarter </th>
                                    <th class="column-title">Action </th>

                                </tr>
                            </thead>
                            <tbody>
                  <?php if(empty($kpiProcessList)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
              <?php } ?>

             <?php foreach($kpiProcessList as $kpiProcessListValue)  {?>
                                <tr class="even pointer">
                                    <td><?php echo $j+1;?></td> 
                                    <td><?php echo $kpiProcessListValue['KraMaster']['kra_name'];?></td>
                                    <td><?php echo $kpiProcessListValue['KpiMaster']['kpi_name'];?></td>
                                    <td><?php echo $kpiProcessListValue['KpiMapEmps']['from_date']; ?></td>
                                    <td><?php echo $kpiProcessListValue['KpiMapEmps']['to_date']; ?></td>
                                    <td><?php echo $kpiProcessListValue['KpiMapEmps']['weightage']; ?></td>
                                    <td><?php echo $this->common->findTargetNameById($kpiProcessListValue['KpiMapEmps']['target']) ?></td>
                                    <td><?php echo $kpiProcessListValue['KraKpiProcess']['units']; ?></td>
                                    <td><?php echo "Quarter ".$kpiProcessListValue['KraKpiProcess']['process_quarter']; ?></td>
                                    <td><a href="<?php echo $this->webroot;?>kpiMasters/editKpi/<?php echo base64_encode($kpiProcessListValue['KraKpiProcess']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Edit.">Edit</a>
                                    </td>
                                </tr>
             <?php $j++ ;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>