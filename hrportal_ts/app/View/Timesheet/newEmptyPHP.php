<!-- Center Content Starts -->
<?php $read0nly = ($empdetail[4] == "milestone") ? 'readonly="readonly"' : ''; ?>
<form name="lveForm" action="<?php echo $this->webroot;?>timesheet/save_timesheet" method="post" autocomplete="off">
    <div id="page_content">
        <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
            <div id="alerts"></div>
            <div class="md-card">
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <div style="text-align:right;">* Under Pilot: not mandatory</div>

                    </div>
                    <h3 class="md-card-toolbar-heading-text">
                    <?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] != 'P')) { ?>
                        <b>Edit Consolidate Form </b><?php } else {?>
                        <b>Approve Consolidate Form</b><?php } ?>
                    </h3>
                </div>
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        <div class="input-boxs">
                            <input type="hidden" name ="tot_ctrl" value="<?php echo $numTsRec ?>" id="Control_Number">
                            <input type="hidden" name ="posted" value="1" id="posted">
                            <input type="hidden" name ="task" value="Update Consolidate" id="updateTS">
                            <input type="hidden" name ="customer" value="<?php // echo $rows['CUSTOMER'][0];   ?>">

                            <input type="hidden" name ="flag" value="<?php echo $flag; ?>">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan='11' align='center' nowrap="nowrap" id='error_div'></td>
                                </tr>
                                <tr>
                                    <th scope="row">Region :</th>
                                    <td><?php echo $rwTsRec[0]['MstTimesheet']['vc_region']; ?>
                                        <input type="hidden" name ="region" value="">
                                        <input type="hidden" name ="sno" id = "final_s_no" value="<?php echo $rwTsRec[0]['MstTimesheet']['s_no']; ?>">
                                        <input type="hidden" name ="is_manager" id="is_manager" value="0">
                                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>
                                        <input type="hidden" id="rej" name="rej" value=""/>
                                    </td>

                                    <th scope="row">Employee Name :</th>
                                    <td><?php echo $this->Common->getempnamebyid($rwTsRec[0]['MstTimesheet']['vc_emp_id']); ?>
                                        <input type="hidden" name ="employee" value="<?php echo $this->Common->getempnamebyid($rwTsRec[0]['MstTimesheet']['vc_emp_id']); ?>">
                                        <input type="hidden" name ="mst_timesheet_id" value="<?php echo $rwTsRec[0]['MstTimesheet']['id']; ?>">
                                    
                                    </td>
                                    <th scope="row">Employee ID :</th>
                                    <td><?php echo $rwTsRec[0]['MstTimesheet']['vc_emp_id']; ?><input name="empid" type="hidden" id="empid" value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_emp_id']; ?>"size="4"></td>
                                    <th scope="row" >Week Start Date :</th>
                                    <td id="YearWeeks"><?php echo date('d-M-Y', strtotime($rwTsRec[0]['MstTimesheet']['dt_start_date'])); ?><input name="sDate" type="hidden" id="sDate"  value="<?php echo $rwTsRec[0]['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly>
                                    </td>
                                    <th scope="row">Week End Date :</th>
                                    <td> <?php echo date('d-M-Y', strtotime($rwTsRec[0]['MstTimesheet']['dt_end_date'])); ?><input name="wstDate" type="hidden" id="wstDate"  value="<?php echo $rwTsRec[0]['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly>&nbsp;
                                        <input name="wedDate" type="hidden" id="wedDate"   value="<?php echo $rwTsRec[0]['MstTimesheet']['dt_end_date']; ?>" size="10" maxlength="20"  readonly></td>
                                    <th scope="row"></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md-card"> 
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom" >
                        <table border="1" class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup">
                            <thead class = "uk-text-contrast">
                                <tr >
						 <?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] == 'P')) { ?>

                                    <th class="filter-false remove sorter-false"><input type="checkbox" name="all[]" id="check_all"/>All </th>
						 <?php } else { ?>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Check*</th>
                                                 <?php } ?>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">TMS ID*</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Customer</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Activity/Milestone</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Primary Milestone</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Timesheet Date</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Leave</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Start Time</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">End Time</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Hours</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Module</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">TMS Type</th>

                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Remarks</th>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Forms/Reports</th>
                                    <?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] != 'P')) { ?>
                                    <th class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Action</th>
                                    <?php } ?>
                                </tr>
                            </thead>
				<?php for($i = 0; $i<=6;$i++){
					$n_date = date('Y-m-d',strtotime($rwTsRec[0]['MstTimesheet']['dt_start_date'] . '+'.$i.'day'));
					$data_dt[$n_date]	= date('d-M-Y', strtotime($n_date));	
					$listing .= '<option value='.$n_date.'>'.date('d-M-Y', strtotime($n_date)).'</option>';
				}?>

			<?php $x = 0; foreach($rwTsRec[0]['DtTimesheet'] as $rw) { ?>
                            <tr>
                             <?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] == 'P')) { ?>
                                <td><input type="checkbox" name="all[]" class="checkSingle" id="check_<?php echo $x;?>" value = <?php echo $rw['id'];?> <?php echo $rw['vc_cm_code'];?>></input></td><?php } else {?><td></td>
                                <?php } if($rw['vc_cm_code'] == 'Checked'){$value = "disabled";} else {$value = "";} if($rw['tms_id'] == '0'){$tms_id_di = "Others";} else {$tms_id_di = $rw['tms_id'];} ?>
                                <?php $read0nly = ($rw['tms_id'] != "Others") ? 'readonly="readonly"' : ''; ?>
                
                                <td><?php echo $this->Form->input("record_id.", array("class" => "uk-width-medium-1-1 tags", "style"=>"width:80px !important", "maxlength" => "6", "label" => "", "type" => "hidden", "required" => True,"autocomplete"=> "off",'value'=>$rw['id'],$value)); ?>
                                    <?php echo $this->Form->input("tms_id.", array("class" => "uk-width-medium-1-1 tags", "style"=>"width:80px !important", "maxlength" => "6", "label" => "", "type" => "text","id"=>"tms_id_$x", "required" => True,"extra_ele"=>"$x" ,"autocomplete"=> "off",'value'=>$tms_id_di,$value)); ?>
                                </td>
                                <td><?php echo $this->Form->input("customer_name.", array("class" => "uk-width-medium-1-1 cust_name", "id" => "cust_name$x","maxlength" => "300","type" => "text", "required" => True,"onKeyup"=>"return get_country($x)",'value'=>$rw['tms_customer'],$value,$read0nly)); ?>
                                <?php echo $this->Form->input("customer_code.", array("class" => "uk-width-medium-1-1", "id" => "customer_code$x", "style"=>"width:45px !important", "maxlength" => "3","type" => "hidden", "required" => True,"readOnly",'value'=>$rw['customer_code'],$value)); ?>
                                <div id="suggesstion-box<?php echo $x;?>"></div></td>
                                <td><?php echo $this->Form->input("milestone_id.", array("id" => "milestone_id_$x","type" => "select","options"=>$s,'default'=>$rw['tms_customer'],$value)); ?></td>
                                <td><?php echo $this->Form->input("primary_milestone_id.", array("id" => "primary_milestone_id$x","type" => "select","options"=>$s,'default'=>$rw['tms_customer'],$value)); ?></td>
                                <td><?php echo $this->Form->input("dt_week_dt.", array("id" => "dt_week_dt_$x","type" => "select","options"=>$data_dt,'default'=>$rw['dt_wk_date'],$value)); ?></td>
                                <td><input type="checkbox" name="leave[]" id="leave_<?php echo $x ?>" value="Y" <?php if(!empty($rw['vc_leave'])){ echo "CHECKED";} ?> onClick="CheckLeave(this.value,<?php echo $x;?>)" ></td>
                                <td><?php echo $this->Form->input("start_time.", array("class" => "uk-width-medium-1-1 weightage", "id" => "stTime$x", "style"=>"width:45px !important", "maxlength" => "5",'onBlur'=>"IsValidTime(this.value , this.id);",'value'=>$rw['vc_strt_time'],$value)); ?></td>
                                <td><?php echo $this->Form->input("end_time.", array("class" => "uk-width-medium-1-1 weightage", "id" => "edTime$x", "style"=>"width:45px !important", "maxlength" => "5",'value'=>$rw['vc_end_time'],'onBlur'=>"CheckTime(this.value , '$x' ,this.id)",$value)); ?></td>
                                <td><?php echo $this->Form->input("total_hrs.", array("class" => "uk-width-medium-1-1 weightage", "id" => "hrs$x", "style"=>"width:45px !important", "maxlength" => "5",'value'=>$rw['vc_hrs'],$value)); ?></td>
                                <td><?php echo $this->Form->input("module.", array("class" => "uk-width-medium-1-1", "id" => "module_$x", "style"=>"width:45px !important", "maxlength" => "50",'value'=>$rw['vc_module'],$value)); ?></td>
                                <td><?php echo $this->Form->input("bug_type.", array("class" => "uk-width-medium-1-1", "id" => "bug_type_$x", "style"=>"width:45px !important", "maxlength" => "50",'value'=>$rw['bt_type'],$value)); ?></td>
                                <td><?php echo $this->Form->input("remark.", array("class" => "uk-width-medium-1-1 textarea_expand","type" => "textarea", "id" => "remark_$x", "maxlength" => "50",'value'=>$rw['vc_remarks'],$value)); ?></td>
                                <td><?php echo $this->Form->input("frms_report.", array("class" => "uk-width-medium-1-1 textarea_expand","type" => "textarea","id" => "frms_report_$x", "maxlength" => "500",'value'=>$rw['vc_f_r'],$value)); ?></td>
                                <?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] != 'P')) { ?>
                                <td><a href="javascript:void(0);" onClick="javascript: if (confirm('Do you really want to delete this record?\nClick \'OK\' to continue and \'Cancel\' to stop.'))
                                            window.location.href = 'http://<?php echo $_SERVER['SERVER_NAME']; ?>/hrportal_ts/timesheet/delweektimesheetdtl/Delete/<?php echo $rw['id'] ?>/<?php echo $rw["s_no"]; ?>/<?php echo $rw['vc_emp_id']; ?>';
                                        return false;" title="Delete"><i class="material-icons md-24"></i></a></span>
                                </td>
                                <?php } ?>
                            </tr>
			<?php  $x++; }?>
                            <tr>
                            <input type="hidden" name ="addtimesheetrow" id="addtimesheetrow" value="<?php echo $x+1; ?>">
                            <td colspan="13" style="padding:0px;">
                                <div id="add_ctrl"></div>
                            </td>
                            </tr>
                        </table>
                    </div>

                    <div class="submit">
				<?php if (($rwTsRec[0]['MstTimesheet']['vc_status'] != 'P')) { ?>
                        <input name="sheet_status_save" type="submit" class="md-btn md-btn-primary" value="Save Changes" id="SaveChangehs" >
                        <input name="sheet_status_manager" type="submit" id="manager" class="md-btn md-btn-primary" value="Submit To Manager"  onClick="return checkcon1(this.form, this.name, '1');">
                        <input type='button' class="md-btn md-btn-primary plusbtn"  value='Add More' id='addButton'>
                        <input type='button' class="md-btn md-btn-danger minusbtn" value='Delete Row' id='removeButton'>

                <?php } else { ?>
                        <input name="sheet_status_manager" type="submit" class="md-btn md-btn-primary" value="Approve" id="Approved"  onClick="return get_sel();">
                        <input name="Reject" id="reject" type="button" class="md-btn md-btn-primary" value="Reject"  onclick="return reject1('<?php echo $sno;?>', '<?php echo $empdetail[1]?>')"/>
				<?php } ?>
                        <input type="button" value="Back"  id="back_button" class="md-btn md-btn-primary" onClick="javascript:history.back(-1);" style="margin-right:5px;"/>
                    </div>
                </div>		
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <table width="100%" cellspacing="5" cellpadding="5" border="1" class="uk-table uk-tab-responsive main tbl" id="TextBoxesGroup">
                        <tbody>
                            <tr class="uk-text-center md-bg-blue-100 uk-te uk-text-small">Weekly Summary :</tr>
                            <tr>
                                <th scope="row"><strong>Total Hours:</strong>  :</th>
                                <td><input class='md-input' name="tothr" type="text" id="tothr"  value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_tot_hrs']; ?>" size="8" readonly></td>
                                <th scope="row"><strong>Total Forms</strong>  :</th>
                                <td><td colspan="9"><input class='md-input' name="totfr" type="text" id="totfr" value="<?php echo$rwTsRec[0]['MstTimesheet']['vc_tot_frms']; ?>" size="8"></td>
                                <th scope="row"><strong>Total Reports</strong>  :</th>
                                <td><input class='md-input'  name="totrep" type="text" id="totrep" value="<?php echo $rwTsRec[0]['MstTimesheet']['vc_tot_reps']; ?>" size="8"></td>
                            </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</form>
<style>
    /* min Jquery CSS elements for autocomplete */
    .ui-autocomplete { position: absolute; cursor: default; }    
    .ui-menu { list-style:none; padding: 2px; margin: 0; display:block; float: left; background-color:#f9f9f9; border: 1px solid #efefef; border-radius: 3px 3px 3px 3px; }

    .ui-menu .ui-menu {
        margin-top: -3px;
    }
    .ui-menu .ui-menu-item {
        margin:0;
        padding: 0;
        zoom: 1;
        float: left;
        clear: left;
        width: 100%;
        font-family:arial;
    }
    .ui-menu .ui-menu-item a {
        text-decoration:none;
        display:block;
        padding:.1em .3em;
        line-height:1.5;
        zoom:1;
    }
    .ui-menu .ui-menu-item a.ui-state-hover, .ui-menu .ui-menu-item a.ui-state-active {
        font-weight: bold;
    }
</style>	

<!-- Center Content Ends -->
<script type="text/javascript">
    var counter = $('#addtimesheetrow').val();
    var valu = '<?php echo $listing;?>';
    $('.plusbtn').click(function () {
        $("#TextBoxesGroup").append('<tr>' +
                '<td class="uk-text-center uk-width-small-1-10"><input type="checkbox" name="record"></td>' +
                '<td><input name="data[tms_id][]" class="uk-width-medium-1-1 tags" style="width:80px !important" maxlength="6" id="tms_id_' + counter + '" required="required" autocomplete="off" type="text"/></td>' +
                '<td><input name="data[customer_name][]" class="uk-width-medium-1-1 cust_name" id="cust_name'+counter+'" maxlength="300" required="required" onKeyup="return get_country('+counter+')" type="text"/></div>                                \n\
                <input type="hidden" name="data[customer_code][]" class="uk-width-medium-1-1" id="customer_code'+counter+'" style="width:45px !important" maxlength="3" required="required" readOnly="readOnly"/><div id="suggesstion-box'+counter+'"></div></td>' +
                '<td><select name="data[milestone_id][]" class="uk-width-medium-1-1" id="milestone_id_' + counter + '">' + '</select></td>' +
                '<td><select name="data[primary_milestone_id][]" class="uk-width-medium-1-1" id="primary_milestone_id_' + counter + '">' + '</select></td>' +
                '<td><select name="data[dt_week_dt][]" class="uk-width-medium-1-1" required="true" id="dt_week_dt_' + counter + '">' + valu + '</select></td>' +
                '<td class="kra_upload"><input type="checkbox" name="leave[]" id="leave<?php echo $x ?>" value="Y" onClick="CheckLeave(this.value,<?php echo $x;?>)" ></td>' +
                '<td class="qualifying"><input name="data[start_time][]" class="uk-width-medium-1-1 weightage" id="stTime' + counter + '" style="width:45px !important" maxlength="5" onBlur="IsValidTime(this.value , this.id);" value="09:30" type="text"/></td>' +
                '<td class="target"><input name="data[end_time][]" class="uk-width-medium-1-1 weightage" id="edTime' + counter + '" style="width:45px !important" maxlength="5" value="17:30" onBlur="CheckTime(this.value ,' + counter + ' ,this.id)" type="text"/></td>' +
                '<td class="stretched"><input name="data[total_hrs][]" class="uk-width-medium-1-1 weightage" id="hrs'+counter+'" style="width:45px !important" maxlength="5" value="08:00" type="text"/></td>' +
                '<td class="mid_target"><input name="data[module][]" class="uk-width-medium-1-1" id="module_'+counter+'" style="width:45px !important" maxlength="50" type="text"/></td>' +
                '<td class="mid_target"><input name="data[bug_type][]" class="uk-width-medium-1-1" id="bug_type_'+counter+'" style="width:45px !important" maxlength="50" type="text"/></td>' +
                '<td class="mid_target"><textarea name="data[remark][]" class="uk-width-medium-1-1 textarea_expand" id="remark_'+counter+'" maxlength="50" cols="30" rows="6"></textarea></td>' +
                '<td><textarea name="data[frms_report][]" class="uk-width-medium-1-1 textarea_expand" id="frms_report_'+counter+'" maxlength="500" cols="30" rows="6"></textarea></td>'+
                '</tr>');
        counter++;
        var aTags = <?php echo $tms_id; ?>

        $(".tags").autocomplete({
            source: aTags,
            change: function (event, ui) {
                get_id = (this.id);
                if (!ui.item) {
                    this.value = '';
                }
                getCustomer(ui.item.value, get_id);
            }
        });
    });

    $(".minusbtn").click(function () {
        var cnt = 0;
        var delArr = [];
        var r = confirm("Are you sure want to delete ?");
        if (r == true) {
            $("table#TextBoxesGroup.main tbody").find('input[name="record"]').each(function (i) {
                if ($(this).is(":checked")) {
                    if ($("table#TextBoxesGroup.main tr").length != 3) {
                        if (!isNaN(parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val())))) {
                            delArr[i] = parseInt($.trim($(this).closest("tr").find("input#updateEmpKraTargetId").val()));
                        }
                        $(this).parents("tr").remove();
                        cnt++;
                    } else {
                        alert("There must be atleast one record to submit.");
                        cnt++;
                    }
                }

            });
        }
        if (cnt == 0) {
            alert("Please select records to delete.");
            return false;
        }
    });


    $(document).on('change', '#weightage', function () {
        if (Number($(this).val()) === 0) {
            $(this).val('');
            alert('Number must be greater than 0');
        } else if (Number($(this).val()) > 100000) {
            $(this).val('');
            alert('Number must be less than 100000');
        }
        ;
    });


    function isNumberKey(evt, obj) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        var value = obj.value;
        var dotcontains = value.indexOf(".") != -1;
        if (dotcontains)
            if (charCode == 46)
                return false;
        if (charCode == 46)
            return true;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }


    $(function () {
        $("textarea").keyup(function (e) {
            $(this).val($(this).val().replace(/^\s/g, ""));
        });
    });


</script>
<script>
    $(document).ready(function () {
       var aTags = <?php echo $tms_id; ?>
        $(".tags").autocomplete({
            source: aTags,
            change: function (event, ui) {
                get_id = (this.id);
                if(!ui.item) {
                    this.value = '';
                }
                getCustomer(ui.item.value, get_id);
            }
        });

    });

    function getCustomer(tms_id, get_id) {
        var row_id = get_id.split('_');
        jQuery.ajax({
            url: 'http://<?php echo $_SERVER["SERVER_NAME"] ?>/hrportal_ts/timesheet/get_cust_dtl/' + tms_id,
            success: function (data) {
                var obj = jQuery.parseJSON(data);
                jQuery('#cust_name' + row_id[2]).val(obj.Customer);
                jQuery('#customer_code' + row_id[2]).val(obj.Customer_ID);
                jQuery('#remark_' + row_id[2]).val(obj.description);
                jQuery('#module_' + row_id[2]).val(obj.Module);
                jQuery('#bug_type_' + row_id[2]).val(obj.nature_of_bug);
                jQuery('#milestone' + row_id[2]).html(obj.milestonelist);
            }
        })

    }
</script>		
<script type="text/javascript">
    function CheckTime(val, counter, id) {

        if (IsValidTime(val, id)) {
            timecalculation(counter);
            return true;
        } else {
            document.getElementById('stTime' + counter).focus;
            return false;
        }
    }

    function IsValidTime(timeStr, id) {
        var timePat = /^(\d{1,2}):(\d{2})(:(\d{2}))?(\s?(AM|am|PM|pm))?$/;

        var matchArray = timeStr.match(timePat);
        if (matchArray == null) {
            alert("Time is not in a valid format.");
            return false;
            document.getElementById(id).focus();
            exit;

        }
        hour = matchArray[1];
        minute = matchArray[2];
        second = matchArray[4];
        ampm = matchArray[6];

        if (second == "") {
            second = null;
        }
        if (ampm == "") {
            ampm = null
        }

        if (hour < 0 || hour > 23) {
            alert("Hour must be between 0 and 23 for military time)");
            return false;
            document.getElementById(id).focus();
            exit;

        }
        if (hour > 12 && ampm != null) {
            alert("You can't specify AM or PM for military time.");
            return false;
            document.getElementById(id).focus();
            exit;
        }
        if (minute < 0 || minute > 59) {
            alert("Minute must be between 0 and 59.");
            return false;
            document.getElementById(id).focus();
            exit;
        }
        if (second != null && (second < 0 || second > 59)) {
            alert("Second must be between 0 and 59.");
            return false;
            document.getElementById(id).focus();
            exit;
        }
        return true;
    }
    function timecalculation(p) {

        var start_time = Convert(document.getElementById('stTime' + p).value, false);

        var end_time = Convert(document.getElementById('edTime' + p).value, false);

        var diff = parseFloat(end_time - start_time);

        if (diff < 0) {
            alert("Start time should be less then end time.\n So please enter valid time.");
            document.getElementById('stTime' + p).focus;
            return false;
        }

        totHour = Convert(diff, true);
        document.getElementById('hrs' + p).value = totHour;
        TotalTimeCalulate();
    }

    function TotalTimeCalulate() {
        var TotSec = 0;
        var tottime = '';
        var ControlVal = parseInt($('#addtimesheetrow').val());
        for (j = 0; j < ControlVal - 1; j++) {
            TotSec = parseFloat(TotSec + Convert(document.getElementById('hrs' + j).value, false));
        }
        tottime = Convert(TotSec, true);
        $('#tothr').val(tottime)
    }

    function Convert(val, ReverseTime) {
        if (ReverseTime == false) {
            sp = val.split(':');
            var totSec = parseFloat(sp[0] * 3600) + parseFloat(sp[1] * 60);
            return totSec;
        } else {
            var TotHr = parseInt(val / 3600);
            TotHr = (TotHr < 10) ? '0' + TotHr : TotHr;

            var TotMin = parseInt((val % 3600) / 60);
            TotMin = (TotMin < 10) ? '0' + TotMin : TotMin;
            return (TotHr + ':' + TotMin);
        }
    }


</script>
<script type="text/javascript">
        var selected = new Array();

    $(document).ready(function () {
    /* Get the checkboxes values based on the class attached to each check box */
    $("#buttonClass").click(function() {
        get_sel();
    });
    
  $("#check_all").change(function(){
        if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;

    
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){

      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)

           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#check_all").prop("checked", true); }     
    }else {
      $("#check_all").prop("checked", false);
    }
  });
});

function get_sel()
{
   var chkArray = [];
    $(".checkSingle:checked").each(function() {
        chkArray.push($(this).val());
    });
    
        var selected;
    selected = chkArray.join(',') ;
    
    if(selected.length > 0){
     
          $("#sel_list").val(selected);
    }else{
        alert("Please at least one of the checkbox"); 
        return false;
    }

}
</script>


<script>
        function get_country(id){
            $.ajax({
                        type: "POST",
                        url: "http://localhost/hrportal_ts/timesheet/getcustomer/"+id,
                        data: 'keyword=' + $('#cust_name'+id).val(),
                        beforeSend: function () {
                            $("#search-box").css("background", "#FFF url(ajax-loader.gif) no-repeat 165px");
                        },
                        success: function (data) {
                            $("#suggesstion-box"+id).show();
                            $("#suggesstion-box"+id).html(data);
                            $("#search-box"+id).css("background", "#FFF");
                        }
                    });
        }
        
        function selectCountry(val, emp_code, id) {
                $("#cust_name"+id).val(val);
                $("#customer_code"+id).val(emp_code);
                $("#suggesstion-box"+id).hide();
            }
</script>