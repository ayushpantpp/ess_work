<?php $i = 0; ?>
<div id="page_content">
    <div id="page_content_inner">

        <?php echo $flash = $this->Session->flash(); ?>

        <div class="md-card">  
            <div class="md-card-toolbar">


                <div class="md-card-toolbar-actions">
                    <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a = array(10 => '10', 20 => '20', 30 => '30');
        //echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); 
        ?>
                    </div>

                </div>
                <h3 class="md-card-toolbar-heading-text">
                    <b> Attendance List</b>
                </h3>




            </div>
            <div class="md-card-content" >

                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>                
                                <th>Sr.No</th>
                                <th>Employee Name</th>
                                <th>Reason</th>
                                <th>Attendance Date</th>
                                <th>Applied Date</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Outstation Duty</th>
                                <th>PGP</th>
                                <th>OD Minutes</th>
                                <th>PGP Minutes</th>
                                <th>Location Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody >

<?php if (empty($pen_attendances)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php
                            # code...prin




                            foreach ($pen_attendances as $srcdet) {
                                if ($srcdet['AttendanceDetail']['status'] == 1) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                } elseif ($srcdet['AttendanceDetail']['status'] == 2) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                } elseif ($srcdet['AttendanceDetail']['status'] == 6) {
                                    $btnClass = "uk-badge uk-badge-warning";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                } elseif ($srcdet['AttendanceDetail']['status'] == 4) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                } elseif ($srcdet['AttendanceDetail']['status'] == 5) {
                                    $btnClass = "uk-badge uk-badge-success";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                } else {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus = $this->Common->findSatus($srcdet['AttendanceDetail']['status']);
                                }

                                if ($i % 2 == 0)
                                    $class = 'even pointer';
                                else
                                    $class = 'odd pointer';
                                ?>
                                <tr class="even pointer">
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo $this->Common->findEmpNameDocID($srcdet['AttendanceDetail']['emp_doc_id']); ?></td>
                                    <td> <?php echo $srcdet['AttendanceDetail']['description'] ?></td>
                                    <td> <?php echo date('d-m-Y', strtotime($srcdet['AttendanceDetail']['atten_dt'])); ?></td>
                                    <td> <?php echo date('d-m-Y', strtotime($srcdet['AttendanceDetail']['usr_id_create_dt'])); ?></td>
                                    <td> <?php echo date('H:i', strtotime($srcdet['AttendanceDetail']['in_time'])); ?></td>
                                    <td> <?php echo date('H:i', strtotime($srcdet['AttendanceDetail']['out_time'])); ?></td>
                                    <td> <?php echo $srcdet['AttendanceDetail']['is_od'] ? 'Yes':'No'; ?></td>
                                    <td><?php echo $srcdet['AttendanceDetail']['is_pgp'] ? 'Yes':'No'; ?></td>
                                    <td><?php echo $srcdet['AttendanceDetail']['od_minutes'] ? $srcdet['AttendanceDetail']['od_minutes']:'--NA--'; ?></td>
                                    <td><?php echo $srcdet['AttendanceDetail']['pgp_minutes'] ? $srcdet['AttendanceDetail']['pgp_minutes']:'--NA--'; ?></td>
                                    <td> <?php echo $srcdet['AttendanceDetail']['address']; ?></td>
                                    <td><a class="<?php echo $btnClass; ?>"> <?php echo $btnStatus; ?></a></td>

                                    <?php
                                    $getlevel = $this->Common->findAppLevel('17');


                                    if ($srcdet['AttendanceDetail']['status'] == 2 && ($getlevel == 2)) {
                                        ?>


                                        <td  > 




                                            <?php echo $this->Html->link('Proceed', 'forward_attendance/' . $srcdet['AttendanceDetail']['id'], array('class' => 'uk-badge uk-badge-success')); ?>
                                            <a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-danger"
                                               onclick="Get_Details('<?php echo $srcdet['AttendanceDetail']['id']; ?>')" class="view vtip" title="Click to Reject.">Reject</a></td><?php
                                } else if ($srcdet['AttendanceDetail']['status'] != 5&&$srcdet['AttendanceDetail']['status'] != 4&&$srcdet['AttendanceDetail']['status'] != 6) {
                                    ?>
                                        <td > <?php echo $this->Html->link('Approve', 'approve_attendance/' . $srcdet['AttendanceDetail']['id'], array('class' => 'uk-badge uk-badge-sucess')); ?>/
                                            <a href="#popup1" data-uk-modal="{ center:true }" class="uk-badge uk-badge-danger"
                                               onclick="Get_Details('<?php echo $srcdet['AttendanceDetail']['id']; ?>')" class="view vtip" title="Click to Reject.">Reject</a></td>

                                <?php } ?>


                                </tr>
    <?php $i++;
} ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">

                        <ul class="uk-pagination uk-pagination-right">

                            <?php
                            echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                            echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                            ?>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="container" ></div>
        </div>

        <div class="uk-modal" id="popup1">
            <div class="uk-modal-dialog">
                <div class= "HRcontent"></div>
                <div class="uk-modal-footer uk-text-right">
                    <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
                </div>
            </div>
        </div>







        <script>

            function Get_Details(id)
            {
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>users/rejectId/' + id,
                    success: function (data) {
                        //alert(data);
                        jQuery('.HRcontent').html(data);
                    }
                });
            }

            function get_paginate(val)
            {
                window.location.href = "<?php echo $this->webroot; ?>users/attendance_approve/" + val;

            }



        </script>	
