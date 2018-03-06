<php
    /*Alias				 :Diwakar Upadhyay
    Date of creation		 :13-june-2001
    Developed by(alias)		 :mb
    Description of code unit	 :to display Conveyence Claim Form
    Last Date of Modification	 :27-Jun-2001
    Modification Done By		 :diwakar
    Last Modification Done		 :max length of description field is 500 */
    ?>


<script type="text/javascript">
    $(function(){

        // Accordion
      // alert($( "#accordion" ).accordion({ disabled: false }));
      //$( "#accordion" ).accordion({ header: false });
       $("#accordion").accordion({
           header: "h3",
           collapsible: true,
           active: false
   });


        //$("#accordion").accordion({ header: "h3" });

    });

    </script>

    <!-- Accordion -->
    <div class="left">
        <h2 class="demoheaders">Employee Self Services</h2>
        <div id="accordion">
            <div>
                <h3><a href="#">Travel Voucher</a></h3>
                <ul class="employ-self-service-ul">
                
                <li><?php echo $html->link('Travel Expense Claim Form', $html->url('/travels/trvoucher', true)); ?></li>
                    <li><?php echo $html->link(' Travel Expense Claim Summary', $html->url('/travels/summary', true)); ?> </li>
                    <?php if (!empty($check_project_mgr)) {
                    ?>
                        <li><?php echo $html->link(' Travel Expense Claim Approve By Manager', $html->url('/travels/approval', true)); ?> </li>
                    <?php } ?>
                    <?php if ($designation_code[0][0]['vc_desg_code'] == "G108") {
                    ?>
                        <li><?php echo $html->link(' Travel Expense Claim Approve By CEO', $html->url('/travels/ceoapproval', true)); ?> </li>
                    <?php } ?>

                    <?php if ($emp_department[0][0]['Vc_Description'] == "ACCOUNTS") {
 ?>

                        <li><?php echo $html->link(' Travel Expense Claim', $html->url('/travels/accountsearch', true)); ?> </li>

<?php } ?>

                </ul>

            </div>
            <div><div>
                    <h3><a href="#">Expense Voucher</a></h3>
                    <ul class="employ-self-service-ul"><li><?php echo $html->link('Cinveyance Claim Form', $html->url('/Expense/Conclaim', true)); ?> </li>
                        <li><?php echo $html->link('Claim Summary', $html->url('/Expense/Empsearch', true)); ?></li>
                        <li><?php echo $html->link('Conveyance Claim Sanction', $html->url('/Expense/Pncnvcsn', true)); ?></li>
                        <li><?php echo $html->link('Employee Wise Claim', $html->url('/Expense/Exrpenter/Emprept', true)); ?></li>
                        <li><?php echo $html->link('Department Wise Claim', $html->url('/Expense/Exrpenter/Deptrept', true)); ?></li>
                      <div><?php // echo $html->link('Weekly Claim', $html->url('/Expense/Wkrpentr', true)); ?></div>



                    </ul>
                </div>
            </div>
            <div>
                <h3><a href="#">TimeSheet</a></h3>
                <ul class="employ-self-service-ul"><li><?php echo $html->link('Normal Form', $html->url('/Timesheet/timesheet', true)); ?> </li>
                    <li><?php echo $html->link('Consolidate Form', $html->url('/Timesheet/tsauto', true)); ?></li>
                    <li><?php echo $html->link('Summary', $html->url('/Timesheet/tslist', true)); ?></li>
                    <li><?php echo $html->link('Submission Rules', $html->url('/Timesheet/tsrules', true));  ?></li>
                    <li><?php echo $html->link('Sanction', $html->url('/Timesheet/sanctionedlist', true)); ?></li>
                    <li><?php echo $html->link('Employee Records', $html->url('/Timesheet/tsreport', true)); ?></li>
                    <li><?php echo $html->link('Employee Reminder', $html->url('/Timesheet/tslistunfilled', true)); ?></li>
                    <li><?php echo $html->link('Employee Regionwise', $html->url('/Timesheet/emplist', true)); ?></li>
                    <li><?php echo $html->link('Billing Master', $html->url('/Timesheet/billingmaster', true)); ?></li>
                    <li><?php echo $html->link('Billing Master Summary', $html->url('/Timesheet/billinglist', true)); ?></li>
                    <li><?php echo $html->link('Billing Report', $html->url('/Timesheet/billingreport', true)); ?></li>
                    <li><?php echo $html->link('Costing Sheet', $html->url('/costing/costingreport', true)); ?></li>
                </ul>
           <div>
                <div>
                    <h3><a href="#">Online QSD</a></h3>
                     <ul class="employ-self-service-ul">
                             <li><?php echo $html->link('QSD Change Request Form', $html->url('/Qsd/qsdfrm?reqno=0', true)); ?> </li>
                             <li><?php echo $html->link('QSD Change Request Summary', $html->url('/Qsd/qcrfmsm/default/normal', true)); ?></li>
                             <li><?php echo $html->link('QSD  Entry Form', $html->url('/Qsd/qsdmstfm/default', true)); ?></li>
                             <li><?php echo $html->link('QSD  Summary', $html->url('/Qsd/qsdmstsm/default', true)); ?></li>
                             <li><?php echo $html->link('QSD Change Request Sanction', $html->url('/Qsd/qcrfmsm/default/edit', true)); ?></li>
                     </ul>
                </div>
            </div>
                <div>
                    <h3><a href="#">Leave Application</a></h3>
                    <ul class="employ-self-service-ul">
                    <li><a href="#">Nam dui erat, auctor a, dignissim quis.</a></li>
                    </ul>
                </div>
                <div>
                    <h3><a href="#">Salary Details</a></h3>
                    <ul class="employ-self-service-ul">
                    <li><a href="#">Nam dui erat, auctor a, dignissim quis.</a></li>
                    </ul>
                </div>
            </div><!-- main tab close -->
        </div>
    </div>

