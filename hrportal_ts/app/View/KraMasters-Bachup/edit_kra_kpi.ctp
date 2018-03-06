<?php

$i=0; ?>

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
                        <h2>Key Result Area Group</h2>
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
                                    <th class="column-title">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                  <?php if(empty($kraLists)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
              <?php } ?>

             <?php foreach($kraLists as $kraList)  {?>
                                <tr class="even pointer">
                                    <td><?php echo $i+1;?></td> 
                                    <td><?php echo $kraList['KraMasters']['kra_name'];?></td>
                                    <td>
                                        <a href="<?php echo $this->webroot;?>kraMasters/Kra/<?php echo base64_encode($kraList['KraMasters']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Edit.">Edit</a>
                                    </td>
                                </tr>
             <?php $i++ ;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Key Result Area Group Detail </h2>
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
                                    <th> KRA Detail</th>
                                    <th> Weightage</th>
                                    <th> Priority</th>
                                    <th class="column-title">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                  <?php unset($i);if(empty($kpiLists)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
              <?php } ?>

             <?php foreach($kpiLists as $kpiList)  {?>
                                <tr class="even pointer">
                                    <td><?php echo $i+1;?></td> 
                                    <td><?php echo $this->common->getKraName($kpiList['KpiMasters']['kra_id']);?></td>
                                    <td><?php echo $kpiList['KpiMasters']['kpi_name'];?></td>
                                    <td><?php echo $kpiList['KpiMasters']['weightage'];?></td>
                                    <td><?php echo $this->common->getPriorityName($kpiList['KpiMasters']['priority']);?></td>
                                    <td>
                                        <a href="<?php echo $this->webroot;?>kraMasters/Kpi/<?php echo base64_encode($kpiList['KpiMasters']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Edit.">Edit</a>
                                    </td>
                                </tr>
             <?php $i++ ;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>