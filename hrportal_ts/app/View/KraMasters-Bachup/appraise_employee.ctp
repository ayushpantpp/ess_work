<?php

$i=0; ?>

<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
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
                        <h2>KRA Detail </h2>
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
                                    <th class="column-title">Employee Name </th>
                                    <th class="column-title">Department Name </th>
                                    <th class="column-title">Designation</th>
                                    <th class="column-title"> From Date  </th>
                                    <th class="column-title"> To Date   </th>
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
              <?php } ?>

             <?php foreach($kraValues as $kraValue)  {?>
                                <tr class="even pointer">
                                    <td><?php echo $i+1;?></td> 
                                    <td><?php echo $kraValue['MyProfile']['emp_firstname']." ".$kraValue['MyProfile']['emp_lastname']; ?></td>
                                    <td><?php echo $this->common->findDepartmentName($kraValue['MyProfile']['dept_code'],$kraValue['MyProfile']['comp_code']); ?></td>
                                    <td><?php echo $this->common->findDesignationName($kraValue['MyProfile']['desg_code'],$kraValue['MyProfile']['comp_code']); ?></td>
                                    <td><?php echo $kraValue['KraMapEmp']['from_date']; ?></td>
                                    <td><?php echo $kraValue['KraMapEmp']['to_date']; ?></td>
                                    <td>
                                        <a href="<?php echo $this->webroot;?>kraMasters/appraiseEmployeeDetail/<?php echo base64_encode($kraValue['KraMapEmp']['myprofile_id'])."&".strtotime($kraValue['KraMapEmp']['from_date']); ?>/" class ="btn btn-primary btn-xs"  title="Click to View.">View</a>
                                    </td>
                                </tr>
             <?php $i++ ;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <script>
                function get_Details(id)
                {
                    jQuery.ajax({
                        url: '<?php echo $this->webroot ?>kraMasters/kradetail/' + id,
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