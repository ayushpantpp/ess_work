<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Leave Form</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content"> <br />

                <?php
               
                echo $this->form->create('Leave', array('url' => '','name'=>'Form1','action'=>'add','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>

      <?php $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);?>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee Name<span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'text', 'value' =>$options[$auth['MyProfile']['emp_nm_ttl']].$auth['MyProfile']['emp_full_name'].'-'.$auth['MyProfile']['emp_id'],'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <?php $department=$this->Common->getdepartmentbyid($auth['MyProfile']['dept_code']);?>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee Department<span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'text', 'readonly' => 'readonly', 'value' =>$department,'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <?php $desgName =$this->Common->findDesignationName($auth['MyProfile']['desg_code'],$auth['MyProfile']['comp_code']);?>
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Employee Designation<span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php echo $this->form->input('user_name', array('label'=>false, 'type' => 'text', 'readonly' => 'readonly', 'value' => $desgName,'class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'first_name')); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Leave Type : <span class="required">*</span> </label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
					<?php 
					$v = $this->Common->option_attribute_name($gender);
					$leave_name['PAR0000011']='LWP LEAVE';
					if($v[$gender] == 'FEMALE'){
					$leave_name['PAR0000006']='MATERNITY LEAVE';
					}
					asort($leave_name);?>
                      <?php echo $this->form->input('leave_code', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select' ,'options' => array_map('strtoupper', $leave_name), 'default' => 'C', 'id' =>'leave')); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Start Date<span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->form->input('dt_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'id' => 'startdate','readonly'=>true)); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Start Duration<span class="required">*</span></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div style="float:left; "><input type="radio" class="iCheck-helper" name="ch_st_daylength" id="ch_st_daylengthf" value="F" checked="checked" > Full Day</div>
                                <div style="float:left; margin-left: 8px;"><input type="radio" class="flat" name="ch_st_daylength" id="ch_st_daylengthh" style="display:block !important" value="H"> Half Day</div>
                            </div>

                            <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_st_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'st_half_type_div','style'=>'display:none;')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">End Date<span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('dt_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12",'type' => 'text', 'id' => 'enddate','readonly'=>true, 'default' => $_POST['Leave']['dt_end_date'])); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">End Duration<span class="required">*</span></label>
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div style="float:left; ">
                                    <input type="radio" class="flat" name="ch_ed_daylength" id="ch_ed_daylengthf" value="F" checked="checked"> Full Day
                                </div>
                                <div style="float:left; margin-left: 8px;">
                                    <input type="radio" class="flat" name="ch_ed_daylength" id="ch_ed_daylengthh" value="H"> Half Day
                                </div>

                            </div>
                            <div class="col-md-3 col-sm-3 row col-xs-12">
                    <?php echo $this->form->input('ch_ed_dayhalf', array('class' => "form-control s-form-item s-form-all", 'label'=>false,'type' => 'select', 'options' => array('F'=>"FIRST HALF",'S'=>"SECOND HALF"), 'default' => 'F', 'id' =>'ed_half_type_div','style'=>'display:none;')); ?>

                            </div>


                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Total Leaves/Week off<span class="required">*</span></label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->form->input('nu_tot_leaves', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12",
'type' => 'text', 'readonly' => 'readonly', 'id' => 'total_leave')); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Reason<span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">

                      <?php echo $this->form->textarea('vc_leave_reason', array('label'=>false,'class'=>"form-control", 'maxlength' => "145",'style'=>"width: 274px; height: 63px;")); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message" id="image" style = "display:none">Medical Certificate <span class="required">*</span> </label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="file" name="leave_image" id="leave_image" style = "display:none" />
                            </div>
                        </div>
                        <div class="x_content">


                            <table class="table table-striped responsive-utilities jambo_table bulk_action">
                                <thead>
                                    <tr class="headings">

                                        <th class="column-title">Leave Type </th>
                                        <th class="column-title">1st January Opening Balance</th>
                                        <th class="column-title">Balance Leave</th>
                                        <th class="column-title">Applied Leaves</th>
                                        <th class="column-title">Pending Leaves for approval</th>
                                    </tr>
                                </thead>
                                <tbody>
                  <?php
    $i = 0;
  
    foreach($leaveType as $type){ ?>  
      <?php
      if($i%2 == 0) 
        $class = "cont1";
      else
        $class = "cont";
      $bal = $type['MstEmpLeaveAllot']['leave_bal'];
      $total = $type['MstEmpLeaveAllot']['leave_op'];
      $applied = $this->Common->countAppliedLeave($type['MstEmpLeaveAllot']['emp_code'] , $type['type']['id']);
      ?>
                                    <tr class="<?php echo $class; ?>">
                                        <th ><?php echo $type['type']['name']; ?></th>
                                        <th><?php echo $total; ?></th>
                                        <td id="bal_leave_<?php echo $type['type']['id'] ?>"><?php echo  $bal ; ?></td>
                                        <td><?php echo $applied;?></td>
                                        <td id="pending_leave_<?php echo $type['type']['id'] ?>">
      <?php echo $this->Common->countPendingLeave($type['MstEmpLeaveAllot']['emp_code'] , $type['type']['id']);?> </td></tr>
      <?php $i++;
       }  ?>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="ln_solid"></div>

                        <div class="form-group col-md-12 col-sm-6 col-xs-6">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="submit" class="btn btn-success" value="Save As Draft" onclick="return CheckLeaveCount();">  
                                <input type="submit" class="btn btn-danger" value="Apply" name='post_leave' onclick="return post();">
                                <a class="btn btn-primary" href="<?php echo $this->Html->url('/users/dashboard') ?>">Cancel</a>
                            </div>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" >
            function post()
            {
                var tot = $('#total_leave').val();
                var leave_code = jQuery('#leave').val();
                var leave_image = jQuery('#leave_image').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>leaves/getCode/',
                    success: function (data) {

                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function (key, value) {

                            if ((leave_code === value.LeaveConfiguration.leave_code || leave_code === value.LeaveConfiguration.leave_code) && tot > 2) {

                                if (leave_image === '') {
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Upload Medical Certificate").show();
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    return false;
                                }
                            }

                        });
                    }

                });


                document.Form1.action = "postLeaves";
                return CheckLeaveCount();
            }


            jQuery(document).keydown(function (e) {
                if (e.keyCode == 90 && e.altKey) {
                    history.go(-1);
                }

            });
            jQuery(document).ready(function () {



                // $('#ch_st_daylengthh').hide();
                //$('#ch_ed_daylengthh').hide();
                jQuery("#startdate").datepicker({
                    //inline: true,
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true,
                    format: 'dd-mm-yyyy',
                    onSelect: function (selected) {
                        jQuery("#enddate").datepicker("option", "minDate", selected);
                        var diff = dateDiff(jQuery('#startdate').datepicker("getDate"));
                        jQuery('#enddate').datepicker("getDate");
                        if (jQuery('#enddate').val() != "") {
                            var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                                    jQuery('#enddate').datepicker("getDate"));
                            //custome starts
                            var medical = jQuery('#leave').val();
                            var tot = $('#total_leave').val();

                            if (medical === 'PAR0000003' && tot > 3) {
                                jQuery('#leave_image,#image').show();

                            } else {
                                jQuery('#leave_image,#image').hide();
                            }
                            //custome ends
                        }
                    }

                });
                jQuery("#enddate").datepicker({
                    inline: true,
                    changeMonth: true,
                    changeYear: true,
                    autoclose: true,
                    orientation: "right bottom",
                    format: 'dd-mm-yyyy',
                    onSelect: function (selected) {
                        jQuery("#startdate").datepicker("option", "maxDate", selected);
                        var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
                        //custome starts
                        var medical = jQuery('#leave').val();
                        var tot = $('#total_leave').val();

                        if (medical === 'PAR0000003' && tot > 3) {
                            jQuery('#leave_image,#image').show();

                        } else {
                            jQuery('#leave_image,#image').hide();
                        }
                        //custome ends
                    }
                });

                jQuery('#enddate').change(function () {

                    var diff = dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
                    var medical = jQuery('#leave').val();
                    var tot = $('#total_leave').val();
                    jQuery.ajax({
                        url: '<?php echo $this->webroot ?>leaves/getCode/',
                        success: function (data) {

                            var obj = jQuery.parseJSON(data);
                            $.each(obj, function (key, value) {

                                if (medical === value.LeaveConfiguration.leave_code && tot > value.LeaveConfiguration.file_upload_no) {
                                    $('#leave_image,#image').show();
                                    if (leave_image === '') {
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                        $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Upload Medical Certificate").show();
                                        $("html, body").animate({scrollTop: 0}, "fast");
                                        return false;
                                    }
                                }
                            });
                            //custome starts
                            var medical = jQuery('#leave').val();
                            var tot = $('#total_leave').val();

                            if (medical === 'PAR0000003' && tot > 3) {
                                jQuery('#leave_image,#image').show();

                            } else {
                                jQuery('#leave_image,#image').hide();
                            }
                            //custome ends
                        }

                    });

                });

                jQuery('#startdate').change(function () {
                    if (jQuery('#enddate') != "") {
                        var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                                jQuery('#enddate').datepicker("getDate"));
                        //custome starts
                        var medical = jQuery('#leave').val();
                        var tot = $('#total_leave').val();

                        if (medical === 'PAR0000003' && tot > 3) {
                            jQuery('#leave_image,#image').show();

                        } else {
                            jQuery('#leave_image,#image').hide();
                        }
                        //custome ends
                    }

                });

                jQuery('input[name=ch_st_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });
                jQuery('input[name=ch_ed_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });

                /* function calculateDate() {
                 dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"));
                 if (jQuery("#startdate").val() != '' && jQuery("#enddate").val() != '') {
                 var ed_date = jQuery('input[name=ch_ed_daylength]:checked').val();
                 var st_date = jQuery('input[name=ch_st_daylength]:checked').val();
                 if (ed_date == 'H' && st_date != 'H') {
                 jQuery('#total_leave').val(jQuery('#total_leave').val() - 0.5);
                 }
                 if (st_date == 'H' && ed_date != 'H') {
                 jQuery('#total_leave').val(jQuery('#total_leave').val() - 0.5);
                 }
                 if (st_date == 'H' && ed_date == 'H') {
                 jQuery('#total_leave').val(jQuery('#total_leave').val() - 1.0);
                 }
                 }
                 }*/

            });
        </script>
        <script>
            function dateDiff(startDate, endDate) {

                var difdate = 0;
                var difdate1 = 0;
                if (jQuery("#startdate").val() == '' && jQuery("#enddate").val() == '') {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please select start date and end date").show();
                    jQuery('#total_leave').val('');
                    return false;
                }
                if (jQuery("#startdate").val() == '') {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please select Start Date").show();
                    jQuery('#total_leave').val('');
                    return false;
                }
                if (endDate && startDate) //make sure we don't call .getTime() on a null
                    difdate = (endDate.getTime() - startDate.getTime()) / (1000 * 60 * 60 * 24);


                if (jQuery('#enddate').val() != "") {
                    difdate1 = difdate + 1;
                }

                var ed_date = jQuery("input[name='ch_ed_daylength']:checked").val();
                var st_date = jQuery("input[name='ch_st_daylength']:checked").val();
                if (ed_date == 'H' && st_date != 'H') {
                    difdate1 = difdate1 - 0.5;
                }
                if (st_date == 'H' && ed_date != 'H') {
                    difdate1 = difdate1 - 0.5;
                }
                if (st_date == 'H' && ed_date == 'H') {
                    difdate1 = difdate1 - 1.0;
                    if (difdate1 == 0) {
                        $("html, body").animate({scrollTop: 0}, "slow");
                        $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>You cannot claim Two half day for Same Date").show();
                        $('#ed_half_type_div').hide();
                        jQuery("input[name='ch_ed_daylength']").val(unchecked);


                    }
                }
                jQuery('#vc_date_diff').val(difdate1);
                //alert(difdate1);
                if (difdate < 0) {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Total Days cannot be less than 0! Please Enter Proper Dates").show();
                    jQuery('#total_leave').val('');
                    return false;
                } else {
                    jQuery('#total_leave').val(difdate1);

                }
                var leavetyp = $("#leave").val();


                //	jQuery.ajax({
                //        url: '<?php echo $this->webroot ?>leaves/getleaveConfi/',
                //        
                //        success: function(data){
                var w = <?php echo json_encode($week_off);?>;
                var listweek = Object.keys(w).map(function (k) {
                    return w[k]
                });

                //alert(leavetyp);


                var all_dates = getDates(startDate, endDate);
                jQuery(all_dates).each(function (e, v) {
                    //check holidays
                    var holidays = <?php echo json_encode($holidays);?>;
                    var dt = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                    var hol = Object.keys(holidays).map(function (k) {
                        return holidays[k]
                    });
                    console.log(hol);
                    if (jQuery.inArray(dt, hol) !== -1) {
                        jQuery('#total_leave').val(jQuery('#total_leave').val() - 1);
                    }
                    //check week holidays
                    var week_holidays = <?php echo json_encode($week_holidays);?>;
                    var dtw = v.getFullYear() + '-' + ("0" + (v.getMonth() + 1)).slice(-2) + '-' + ("0" + v.getDate()).slice(-2);
                    var holw = Object.keys(week_holidays).map(function (k) {
                        return week_holidays[k]
                    });
                    console.log(holw);
                    if (jQuery.inArray(dtw, holw) !== -1) {
                        jQuery('#total_leave').val(jQuery('#total_leave').val() - 1);

                    }
                });

            }

            //});

            // }
            $(window).load(function () {

                var type = $('#leave').val();

                var tot = $('#total_leave').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>leaves/getleaveConfi/',
                    success: function (data) {

                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function (key, value) {

                            if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 0) {
                                $('#leave_image,#image').hide();
                                $('#ch_st_daylengthh').parent().show();
                                $('#ch_ed_daylengthh').parent().show();
                            } else if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 1) {
                                if (value.LeaveConfiguration.file_upload == 1)
                                {
                                    if (tot > value.LeaveConfiguration.file_upload_no) {
                                        $('#leave_image,#image').show();
                                    } else {
                                        $('#leave_image,#image').hide();
                                    }

                                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_st_daylengthh').parent().parent().hide();
                                    $('#ch_ed_daylengthh').parent().parent().hide();
                                } else
                                {
                                    $('#leave_image,#image').hide();
                                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_st_daylengthh').parent().parent().hide();
                                    $('#ch_ed_daylengthh').parent().parent().hide();

                                }
                            }
                        });
                    }

                });


            });

            $('#leave').change(function () {

                var stdate = jQuery('#startdate').val();
                var endate = jQuery('#enddate').val();
                //alert(stdate);alert(endate);
                if (stdate !== '' && endate !== '') {

                    var diff = dateDiff(jQuery('#startdate').datepicker("getDate"),
                            jQuery('#enddate').datepicker("getDate"));
                }


                jQuery('input[name=ch_st_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });
                jQuery('input[name=ch_ed_daylength]').change(function () {
                    dateDiff(jQuery('#startdate').datepicker("getDate"), jQuery('#enddate').datepicker("getDate"))
                });
                var type = $('#leave').val();

                var tot = $('#total_leave').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>leaves/getleaveConfi',
                    success: function (data) {

                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function (key, value) {

                            if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 0) {
                                if (value.LeaveConfiguration.leave_type === 'EL' && value.LeaveConfiguration.leave_code === type) {
                                    $("#startdate").datepicker("option", "maxDate", '0');
                                } else {
                                    $("#startdate").datepicker("option", "maxDate", null);
                                }
                                $('#leave_image,#image').hide();
                                $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                $('#ch_st_daylengthh').parent().parent().show();
                                $('#ch_ed_daylengthh').parent().parent().show();
                            } else if (value.LeaveConfiguration.leave_code == type && value.LeaveConfiguration.half_day_chk == 1) {
                                if (value.LeaveConfiguration.leave_type === 'EL' && value.LeaveConfiguration.leave_code === type) {
                                    $("#startdate").datepicker("option", "maxDate", '0');
                                } else {
                                    $("#startdate").datepicker("option", "maxDate", null);
                                }
                                if (value.LeaveConfiguration.file_upload == 1)
                                {
                                    if (tot > value.LeaveConfiguration.file_upload_no) {
                                        $('#leave_image,#image').show();
                                    } else {
                                        $('#leave_image,#image').hide();
                                    }

                                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_st_daylengthh').parent().parent().hide();
                                    $('#ch_ed_daylengthh').parent().parent().hide();
                                } else
                                {
                                    $('#leave_image,#image').hide();
                                    $('#ch_st_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_ed_daylengthf').parent().find('.iCheck-helper').trigger('click');
                                    $('#ch_st_daylengthh').parent().parent().hide();
                                    $('#ch_ed_daylengthh').parent().parent().hide();

                                }
                            }

                            if (value.LeaveConfiguration.leave_type === 'SL' && value.LeaveConfiguration.leave_code === type) {
                                $("#startdate").datepicker("option", "maxDate", '0');
                            } else
                            {

                            }

                        });
                    }
                });

            });
            function CheckLeaveCount()
            {

                var tot = $('#total_leave').val();
                var leave_code = jQuery('#leave').val();
                var leave_image = jQuery('#leave_image').val();
                jQuery.ajax({
                    url: '<?php echo $this->webroot ?>leaves/getCode/',
                    success: function (data) {

                        var obj = jQuery.parseJSON(data);
                        $.each(obj, function (key, value) {

                            if ((leave_code === value.LeaveConfiguration.leave_code || leave_code === value.LeaveConfiguration.leave_code) && tot > 2) {

                                if (leave_image === '') {
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Upload Medical Certificate").show();
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    return false;
                                }
                            }

                        });
                    }

                });

                var leave_id = jQuery('#leave').val();

                jQuery("#bal_leave_" + leave_id).text().trim();
                jQuery('#total_leave').val();
                var doc = $('#leave_image').val();
                var medical = jQuery('#leave').val();
                var tot = $('#total_leave').val();
                if (jQuery('#total_leave').val() === '') {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Enter Leave Date.!").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else if (jQuery('#total_leave').val() == 0) {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Total Days cannot be less than 0! Please Enter Proper Dates").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;

                } else if (jQuery('#total_leave').val() < 0) {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Total Days cannot be less than 0! Please Enter Proper Dates").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;

                } else if (parseInt(jQuery('#total_leave').val().trim()) > (parseInt(jQuery("#bal_leave_" + leave_id).text().trim()) - parseInt(jQuery("#pending_leave_" + leave_id).text().trim()))) {

                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>You can't apply " + jQuery('#total_leave').val() + " leaves in " + jQuery('#bal_leave_' + leave_id).text().trim() + " Balance Leaves and " + jQuery('#pending_leave_' + leave_id).text().trim() + " Pending Leaves.").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else if (jQuery('#total_leave').val() == 'NaN') {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Enter Start Date.!").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else if ($('#LeaveVcLeaveReason').val() == "") {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Enter Leave Reason").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else if (medical === value.LeaveConfiguration.leave_code && tot > 2 && doc == "") {
                    $("html, body").animate({scrollTop: 0}, "slow");
                    $("#alerts").html("<span class='closebtn' onclick='$(this).parent().fadeOut()'>X</span>Please Upload Medical Certificate").show();
                    $("html, body").animate({scrollTop: 0}, "slow");
                    return false;
                } else
                {
                    return true;
                }
            }
        </script>
    </div>



    <div id="popup1" class="HRoverlay">
        <div class="HRpopup">
            <a class="HRclose" href="#">×</a>
            <div class="HRcontent"> 
                <div id="container" style="width: 600px; height: 400px; margin: 0 auto"></div>
            </div>    
        </div>
    </div>

    <script type="text/javascript">

    </script>