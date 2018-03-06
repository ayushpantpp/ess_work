<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>

<script type="text/javascript">
    $(function(){

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 800,
            height:400,
            modal:true,
            buttons: {

                "Cancel": function() {
                    $(this).dialog("close");


                }
            }
        });


    });
</script>

<script type="text/javascript">
    function sendemlsep(empid,ver){


        var cmp_code='01';
        var formaval=<?php echo json_encode($formval); ?>;
        var stdate=formaval.wstDate;
       
        var eddate=formaval.wedDate;
        $("#getexpdetail").empty().html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');

        jQuery.get('<?php echo $this->webroot; ?>Timesheet/sendreminder/'+empid+'/'+stdate+'/'+eddate,{}, function(data){
            jQuery('#getexpdetail').html(data);

        });


        jQuery('#dialog').dialog('open');

    }

    function sendreminder()
    {
        var empid=document.getElementById('emp_ids').value;
   
        var formaval=<?php echo json_encode($formval); ?>;
        
        var stdate=formaval.wstDate;
        var eddate=formaval.wedDate;

        $("#getexpdetail").empty().html('<div style="position:absolute; top:50%; left:500%;"><span style="display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');

        jQuery.get('<?php echo $this->webroot; ?>Timesheet/sendreminder/'+empid+'/'+stdate+'/'+eddate,{}, function(data){
            jQuery('#getexpdetail').html(data);

        });

       if(empid!=''){
        jQuery('#dialog').dialog('open');
    }else{
        alert("Please chose atleast on check box");
    }

    }
</script>



<script type='text/javascript'>
    function SetDate(url){
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
            data: url,
            success: function(data){
                var DateSetter=data.split(';;');
                
                jQuery('#wstDate').val(DateSetter[0]);
                jQuery('#wedDate').val(DateSetter[1]);
                var arrDateSetter =DateSetter[2].split('||');
                for(i=1;i<=document.lveForm.tot_ctrl.value;i++){
                    jQuery('#weekCombo'+i).html(arrDateSetter[i-1]);
                }
            }
        });
    }
    function SetYearDate(url){
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
            data: url,
            success: function(data){
                
                var DateSetter=data.split(';;');
               
                jQuery('#YearWeeks').html(DateSetter[0]);
                jQuery('#wstDate').val(DateSetter[1]);
                
                jQuery('#wedDate').val(DateSetter[2]);
                for(i=1;i<=document.lveForm.tot_ctrl.value;i++){
                    jQuery('#weekCombo'+i).html(DateSetter[3]);
                }
            }
        });
    }

    function getTimesheetForm(div){
        var totaldirector=document.getElementById("addtimesheetrow").value;

        var totalrowfound=parseInt(totaldirector)+parseInt(1);
        document.getElementById("addnewrow").value=totaldirector;
        var url = '<?php echo $this->webroot; ?>Timesheet/timesheetrow/'+totalrowfound;
        jQuery.get(url, function(data) {
            jQuery("#"+div).append(data);

        });

    }






</script>


<!-- Center Content Starts -->
<?php //echo $customer_code;  ?>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>

            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
    
        </ul>
    </div>
</div>

<h2 class="demoheaders">Non Submitted Employee List</h2>

<form name="lveForm" method="post" autocomplete="off">

        <div class="travel-voucher">
            <div class="input-boxs">

                <table width="100%" border="0" cellspacing="5" cellpadding="5">
                    <tr>
                        <td colspan='10' align='center' nowrap="nowrap" id='error_div'></td>
                    </tr>

                    <?php
                    $con = $Function->connRet();
                    $arrWeek = $Function->SQLYearWeek($con);
                   $currentWeekStart = $arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY'];
                    $currentWeekEnd = $arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY'];
                    ?>
                    <!-- hidden for start date -->
                    <tr>
                        <th scope="row">Year :</th>
                        <td><input type="hidden" name ="tot_ctrl" value="1" id="Control_Number">
                            <?php $sel_year = $Function->YearSelectList();
                            $sel_year ?></td>
                        <th scope="row" >Week Start Date :</th>
                        <td id="YearWeeks">
                        <?php echo $Function->YearWeeksCombo($arrWeek['YEAR_FIRST_WK_START_DATE_RRRR'], $arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']); ?></td>
                        <td>  <input name="wstDate" type="hidden" id="wstDate"  value="<?php echo $currentWeekStart;?>" size="10" maxlength="20"  readonly>

                        </td>
                        <th scope="row">Week End Date :</th>
                        <td><input class='textBox' name="wedDate" type="text" id="wedDate" value="<?php echo $currentWeekEnd ?>" size="10" maxlength="20"  readonly>

                        </td>
                        <td><div class="submit-form"> <input type="submit" name="trExpRpAp" value="Show List" /></div></td>

                    </tr>

                   
                </table>
            </div>
            <?php if(!empty($start_date) and !empty($weekend_date)) { ?>
            <table align="center" style=" text-align:center;" width="100%">
               <tr>
                   <td><strong>Week Start Date</strong> <span style="color:#5078C1"><?php echo $start_date;?></span>  <strong> and Week End Date </strong> <span style="color:#5078C1"><?php echo $weekend_date;?></span> 
                        </td>
                    </tr>
          </table>
            <?php } ?>
        </div>

        <?php if (empty($numEmpTs)) {
                                echo $numEmpTs = '';
                            }
                            ?>
                                <div class="travel-voucher1">

                                    <div class="input-boxs-timesheet">
                                        <div>
                                            <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                                                <tr class="head">
                                                    <td align="center" width="5%"><b>
                                                  <input  type="checkbox" name="chk_top" value="1" class="comments" onClick="javascript:sel_inc_r_des_rem_all_ids(this.form)" /></b></td>
                                                    <th scope="row" width="21%">Employee Name</th>
                                                    <th width="12%">	Current Status</th>
                                                    <th>Total Reminder</th>
                                                    <th>Action
                                                    </th>
                                                </tr>

                    <?php 
 if (empty($numEmpTs)) {  
?>

    <tr class="cont">
    <td style="text-align:center;" colspan="11">
    <em>--No Records Found--</em>
    </td>
    </tr>

<?php } ?>
 <?php  //pr($rwEmpTs); die;
                                for ($i = 0; $i < $numEmpTs; $i++) {

                                    $con = $Function->connRet();
                                    $SQLReminder = "SELECT COUNT(*) total_reminder FROM hrpay . mst_ts_reminder MR, hrpay . dt_ts_reminder DR WHERE
                                                   MR . NU_REMINDER_NO= DR . NU_REMINDER_NO and MR.WK_START_DATE =to_date('" . $start_date . "' ,'dd-mm-rrrr')
                                                   And MR.WK_END_DATE = to_date('" . $weekend_date . "' ,'dd-mm-rrrr')
                                                   AND DR.VC_EMP_CODE='" . $rwEmpTs["VC_EMP_ID"][$i] . "'";
                          

                                    $rsReminder = ociparse($con, $SQLReminder);
                                    ociexecute($rsReminder);
                                    ocifetch($rsReminder);
                                    $total_reminder = ociresult($rsReminder, 'TOTAL_REMINDER');
                        ?>
                                    <tr <?php if ($i % 2 == 0) { ?>class="cont1" <?php } else { ?>class="cont" <?php } ?> id="">
                                        <td><input class="sel" id="chk_<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>" type="checkbox" name="chk_id" value="<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>"   onClick="javascript:des_top_n_inc_r_rem_id(this ,'tr_<?php echo $rwEmpTs["VC_EMP_ID"][$i]; ?>');"/></td>
                                        <td><?php echo $rwEmpTs["VC_EMP_NAME"][$i]; ?></td>
                                        <td><?php echo ($rwEmpTs["STATUS"][$i] == "I") ? 'Intermediate' : (($rwEmpTs["STATUS"][$i] == "R") ? 'Rejected' : $rwEmpTs["STATUS"][$i]) ?></td>
                                        <td><?php echo $total_reminder; ?></td>
                                        <td>
                                              <ul class="edit-delete-icon">
        <li>
        <li style="border:none;"> <a  href="#" title="Send Reminder" class="mail vtip"  onClick="sendemlsep('<?php echo $rwEmpTs["VC_EMP_ID"][$i] ?>','oneemp')">
                                                </a> </li></ul>
                                    </tr>
<?php } ?>
                               </table>

                        </div>
                                        </div>
                                     </div>
                               <div class="submit-form">
                                            <input type="button" name="trExpRpAp" value="Send Reminder" onClick="sendreminder();" />
                               </div>
                                               <input type="hidden" name="chk_ids" id="emp_ids" value="">




                <div id="dialog" title="Timesheet Reminder" style="display:none; overflow: visible;">
                    <div id="getexpdetail"></div>
                </div>

<?php //}  ?>

  

</form>

<!-- Center Content Ends -->
