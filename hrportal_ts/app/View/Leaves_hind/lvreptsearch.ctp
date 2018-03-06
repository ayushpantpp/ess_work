<script type="text/javascript">
    function check()
    {
        if (document.getElementById("Leave_ReportFromDate").value == "")
        {
            alert("From Date Required !");
            return false;
        }
        if (document.getElementById("Leave_ReportToDate").value == "")
        {
            alert("To Date Required !");
            return false;
        }
        else
            document.login.submit();
    }


</script>
<?php echo $form->create('Leave_Report', array('url' => array('controller' => 'leaves', 'action' => 'leavereport'), 'id' => 'empsearch')); ?>
<div class="wrpper">
    <!-- Center Content Starts -->



    <div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
            <ul>
                <li> <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a></li>
                <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
                <li><?php echo $html->link(' Leave Report', $html->url('/selfservices/#leave', true)); ?> </li>
            </ul>
        </div>
    </div>

    <h2 class="demoheaders">Leave Records Query Form </h2>

    <div class="travel-voucher">
        <div class="input-boxs">
            <table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr></tr>
                <tr>
                    <th scope="row">From Date :</th>
                    <td><?php echo $form->input('Leave_Report.from_date', array('label' => false, 'type' => 'text', 'class' => 'required')); ?>
                        <script type="text/javascript"> jQuery(function() {
                                jQuery('#Leave_ReportFromDate').datepicker({inline: true, changeMonth: true, changeYear: true, dateFormat: 'dd-mm-yy'});
                            });</script></td>
                </tr>
                <tr>
                    <th scope="row">Tour End Date :</th>
                    <td><?php echo $form->input('Leave_Report.to_date', array('label' => false, 'type' => 'text', 'class' => 'required')); ?>
                        <script type="text/javascript"> jQuery(function() {
                                jQuery('#Leave_ReportToDate').datepicker({inline: true, changeMonth: true, changeYear: true, dateFormat: 'dd-mm-yy'});
                            });</script></td>

                </tr>
                
                <tr>
                    <th scope="row">Employee Name :</th>
                      <td> 
                          <?php echo $form->input('Leave_Report.vc_emp_code', array('type' => 'select', 'label' => false, 'options' => $emplist, 'default' => '', 'class' => 'round_select','style'=>'width:148px;')); ?>
                      </td>
                </tr>
                
                <tr>
                    <td align="right"><b>Sort Records By&nbsp;:</b></td>
                    <td><select name="sort">
                            <option value="VcEmpName" selected>Employee Name</option>
                            <option value="Mgr">Manager's Name</option>
                            <option value="ChLveStatus">Leave Status</option>
                            <option value="VcLeaveCode">Leave Code</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Status :</b></td>
                    <td>
                        <select name="status[]" id="lvsrt" multiple>
                            <option value="elr" selected>All Leave</option>
                            <option value="lwp">Leave without pay</option>
                            <option value="el">Earned Leaves</option>
                            <option value="cl">Casual Leaves</option>
                            <option value="ml">Medical Leaves</option>
                            <option value="pl">Pending Leaves</option>
                            <option value="rl">Rejected Leaves</option>
                            <option value="eclr" >Employee Consolidated Leave Record</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="submit-form" colspan="1"  style="width:0% ; float:right;">
                        <input type="submit" class="taskbutton" id="exceldownload" value="Download Excel" name="data[Leave_Report][submit]" onClick="return check()">
                    </td>
                    <td class="submit-form" colspan="1"  style="width:0% ; float:none;">
                        <input type="submit" class="taskbutton" id="pdfdownload" value="Download PDF" name="data[Leave_Report][submit]" onClick="return check()">
                    </td>
                </tr>
            </table>
        </div>
    </div>





    <div class="submit-form"><?php echo $form->submit('Display', array('Display', 'onClick' => "return check()")); ?></div>


    <!-- Center Content Ends -->

</div>


<?php $form->end(); ?>