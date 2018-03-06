<div id="popup1" class="HRoverlay">
    <div class="HRpopup">
        <a class="HRclose" href="#">×</a>
        <div class="HRcontent"> </div>
    </div>
</div>
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Assign KRA</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div></div>
                    <div class="x_content"> <br />
                        <table class="table table-striped responsive-utilities jambo_table bulk_action">
                            <thead>
                                <tr class="headings">
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Employee Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                                <?php if(empty($kralist)){
                                    echo "<tr class='even pointer'><td>No Record</td></tr>";
                                }else{
                                    foreach ($kralist as $value) {
                                    ?>
                            <tr class="even pointer">
                                <td><?php echo $value['KraMaster']['kra_name']?></td>
                                <td><?php echo strtoupper($value['KraMaster']['groups'])?></td>
                                <td><?php echo $value['MyProfile']['emp_firstname']." ".$value['MyProfile']['emp_lastname'];?></td>
                                <td><?php echo $value['KraMapEmp']['from_date']?></td>
                                <td><?php echo $value['KraMapEmp']['to_date']?></td>
                                <td>     <a href="<?php echo $this->webroot;?>kraMasters/editKraDetail/<?php echo base64_encode($value['KraMapEmp']['id']);?>/" class ="btn btn-primary btn-xs"   title="Click to Edit.">Edit</a>
                                    <span class ="btn btn-primary btn-xs" title="Click to Delete." onClick="kraDelete('<?php echo base64_encode($value['KraMapEmp']['kramasters_id']).",".$value['KraMapEmp']['myprofile_id'];?>')">Delete</span></td>
                            </tr>
                                <?php
                                    }
                                }
                                ?>
                        </table>
                    </div>
                </div>
                <script>
                    function kraDelete(id, cd)
                    {
                        var txt;
                        var r = confirm("Are you sure want to delete this record");
                        if (r == true) {
                            jQuery.ajax({
                                url: '<?php echo $this->webroot ?>kraMasters/kraDelete/' + id,
                                success: function (data) {
                                    if (data == 'success') {
                                        alert('Data Remove Suceesfully.');
                                        window.location.reload();
                                    } else {
                                        alert('Data Not Remove Suceesfully.');
                                    }
                                }
                            });
                        } else {

                        }

                    }
                </script>