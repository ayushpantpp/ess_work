<!-- Header Ends -->
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card"> 
            <div class="md-card-toolbar">

                <div class="md-card-toolbar-actions">
                </div>
                <h3 class="md-card-toolbar-heading-text">
                    <b> Pending Timesheet List</b>
                </h3>
            </div>  

            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <form name="lveForm" action="<?php echo $this->webroot;?>timesheet/forward_timesheet" method="post" autocomplete="off">
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                            <thead>
                                <tr>                
                                    <th class="filter-false remove sorter-false"><input type="checkbox" name="" id="check_all"/>All </th>
                                    <th>S No</th>
                                    <th>Employee Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Submitted On</th>
                                    <th>Approved On</th>
                                    <th>Forms</th>
                                    <th>Reports</th>
                                    <th>Total Hours </th>
                                    <th>TS Type 	</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$i = 1;
                        foreach($rwEmpTs as $v) {
                            if ($v['MstTimesheet']["TS_TYPE"] == 'CO') {
                                $type = 'Consolidate';
                                $file = 'editauto';
                            } else {
                                $type = 'Normal';
                                $file = 'editauto';
                            }
                    ?>

                                <tr class="<?php
                if ($i % 2 == 0) {
                        echo "cont1";
                } else {
                        echo "cont";
                } ?>">	
                                    <?php $status = $v['MstTimesheet']["vc_status"]; ?>
                                    <td>
                                    <?php  if ($status == 'P') { ?>       
                                    <input type="checkbox" name="all[]" class="checkSingle" id="check_<?php echo $i;?>" value="<?php echo $v['MstTimesheet']["s_no"];?>"></input></td>								
                                    <?php } ?>
                                    <td align="center" nowrap="nowrap"><?php echo $i; ?></td>
                                    <td align="center" nowrap="nowrap"><?php echo $this->Common->getempnamebyid($v['MstTimesheet']["vc_emp_id"]); ?></td>
                                    <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_start_date"])); ?></td>
                                    <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_end_date"])); ?></td>
                                    <td align="center" nowrap="nowrap"><?php echo date('d-M-Y',strtotime($v['MstTimesheet']["dt_applied"])); ?></td>
                                    <td align="center" nowrap="nowrap"><?php echo $v['MstTimesheet']["dt_approved"]; ?></td>
                                    <td  align="right"><?php echo $v['MstTimesheet']["vc_tot_frms"]; ?></td>
                                    <td align="right" ><?php echo $v['MstTimesheet']["vc_tot_reps"]; ?></td>
                                    <td align="right"><?php echo $v['MstTimesheet']["vc_tot_hrs"]; ?></td>
                                    <td align="center"><?php echo $type; ?></td>
                    <td><?php
                        if ($status == 'P') {
                                echo "PENDING";
                        } else if ($status == 'R') {
                                echo "REJECTED";
                        } else if ($status == 'S') {
                                echo "APPROVED";
                        } else if ($status == 'I') {
                                echo "INTERMEDIATE";
                        } else {
                                echo '';
                        }
                                        ?>
                                    <td>
                                        <ul class="edit-delete-icon">
<?php
                                                        if ($status == 'P') { ?>
                                            <span> <a href="editauto/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>/2/S/custid" target="blank" title="Approved"> <i class="md-list-addon-icon material-icons md-icon dp24">done</i></a></span>


                                                        <?php } ?> 
                                            <span style="border:none;">
                                                <span> <a href="tsview_new/<?php echo $v['MstTimesheet']["s_no"] ?>/<?php echo $v['MstTimesheet']["vc_emp_id"]; ?>/<?php echo $v['MstTimesheet']["dt_start_date"]; ?>/<?php echo $v['MstTimesheet']["dt_end_date"] ?>/2/S/custid" target="blank" title="Approved"> <i class="md-list-addon-icon material-icons">remove_red_eye</i></a></span>

                                        </ul>
                                    </td>
                                </tr>
                        <?php $i++; } ?>
                            </tbody>
                        </table>
			<?php $emplist = $this->Common->getemplist();?>
                        <?php if(!empty($rwEmpTs)) {?>
                           
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-3" >
                                <div class="parsley-row" >
                                    <label for="req_cat">Forward to Manager <span class="req">*</span></label>
							<?php echo $this->form->input('forward_to', array('label'=>false, 'type' => 'text','required'=>true,'id'=>'search-box','class'=>'md-input')); ?>
							<?php echo $this->form->input('forward_to_code', array('label'=>false, 'type' => 'hidden','required'=>true,'id'=>'forward_emp_code','class'=>'md-input')); ?>

                                    <div id="suggesstion-box"></div>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="req_cat">Forward Remark<span class="req">*</span></label>
                                    <?php echo $this->form->input('forward_to_remark', array('label'=>false, 'type' => 'text','required'=>true,'class'=>'md-input')); ?>
				</div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <input name="sheet_status_save" type="submit" class="md-btn md-btn-primary" value="Forward" id="SaveChangehs" onClick="return get_sel();">
                                </div>
                            </div>
                        </div>
                           <?php } ?>
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
        </div>

        <script>
            $(document).ready(function () {
                $("#search-box").keyup(function () {
                    $.ajax({
                        type: "POST",
                        url: "getdtl",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function () {
                            $("#search-box").css("background", "#FFF url(ajax-loader.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#suggesstion-box").show();
                            $("#suggesstion-box").html(data);
                            $("#search-box").css("background", "#FFF");
                        }
                    });
                });
            });
            //To select country name
            function selectCountry(val, emp_code) {
                $("#search-box").val(val);
                $("#forward_emp_code").val(emp_code);
                $("#suggesstion-box").hide();
            }
        </script>		

        <div id="dialog" title="Remark/Comment" style="display:none">
            <div id="getrejectionresion"></div>
        </div>

        <script type="text/javascript">
            var selected = new Array();

            $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
                /* Get the checkboxes values based on the class attached to each check box */
                $("#buttonClass").click(function () {
                    get_sel();
                });

                $("#check_all").change(function () {
                    if (this.checked) {
                        $(".checkSingle").each(function () {
                            this.checked = true;


                        })
                    } else {
                        $(".checkSingle").each(function () {
                            this.checked = false;
                        })
                    }
                });

                $(".checkSingle").click(function () {
                    if ($(this).is(":checked")) {

                        var isAllChecked = 0;
                        $(".checkSingle").each(function () {
                            if (!this.checked)
                                isAllChecked = 1;
                        })
                        if (isAllChecked == 0) {
                            $("#check_all").prop("checked", true);
                        }
                    } else {
                        $("#check_all").prop("checked", false);
                    }
                });
            });

            function get_sel()
            {
                var chkArray = [];


                $(".checkSingle:checked").each(function () {
                    chkArray.push($(this).val());
                });


                var selected;
                selected = chkArray.join(',');

                if (selected.length > 0) {

                    $("#sel_list").val(selected);
                } else {
                    alert("Please at least one of the checkbox");
                    return false;
                }

                //var n=$("input[id=check_]",+ids).val()

            }
        </script>
        <script>
        function get_country(id){
            $.ajax({
                        type: "POST",
                        url: "getdtl",
                        data: 'keyword=' + $(this).val(),
                        beforeSend: function () {
                            $("#search-box").css("background", "#FFF url(ajax-loader.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#suggesstion-box").show();
                            $("#suggesstion-box").html(data);
                            $("#search-box").css("background", "#FFF");
                        }
                    });
        }
        </script>
