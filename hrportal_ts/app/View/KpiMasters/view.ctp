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
                                    <th class="column-title">Sr.No. </th>
                                    <th> KPI Name</th>
                                    <th> KRA</th>
                                    <th class="column-title">Employee Name </th>
                                    <th class="column-title"> Applied Date </th>
                                    <th class="column-title"> Weightage </th>
                                    <th class="column-title">Status </th>
                                    <th class="column-title">Action </th>
                                </tr>
                            </thead>
                            <tbody>
                  <?php if(empty($kpiValues)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
              <?php }?>

             <?php foreach($kpiValues as $kpiValue)  {?>
                                <tr class="even pointer">
                                    <td><?php echo $i+1;?></td> 
                                    <td><?php echo $kpiValue['KpiMaster']['kpi_name'];?></td>
                                    <td><?php echo $kpiValue['KraMaster']['kra_name'];?></td>
                                    <td><?php echo $kpiValue['MyProfile']['emp_firstname']." ".$kpiValue['MyProfile']['emp_lastname']; ?></td>
                                    <td><?php echo $kpiValue['KpiMapEmps']['from_date']; ?></td>
                                    <td><?php echo $kpiValue['KpiMapEmps']['weightage'];?></td>
                                    <td><?php echo 'Status' ?></td>
                                    <td>
                                        <a href="#popup1" class ="btn btn-primary btn-xs" onclick="get_Details('//<?php echo $kpiValue['KpiMapEmps']['id']; ?>')"  title="Click to View.">View</a>
                                        <a href="<?php echo $this->webroot;?>kpiMasters/editKpiDetail/<?php echo base64_encode($kpiValue['KpiMapEmps']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Edit.">Edit</a>
                                    </td>
                                </tr>
             <?php $i++ ;}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                function get_Details(id)
                {
                    jQuery.ajax({
                        url: '<?php echo $this->webroot ?>kpiMasters/kpidetail/' + id,
                        success: function (data) {
                            //alert(data);
                            jQuery('.HRcontent').html(data);
                        }
                    });
                }
            </script>
        </div>
    </div>
</div>