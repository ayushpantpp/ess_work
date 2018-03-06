<?php
App::import('Model', 'General');
$General = new General;
App::import('Component', 'Functions');
// We need to load the class
$Function = new FunctionsComponent();
?>
<script type="text/javascript">

  function InvlidEmployee1(id){
  
	if(document.getElementById("Timesheet_Reportemp_id").value!="" && document.getElementById("Timesheet_Reportemp_name").value==""){
		document.getElementById("Timesheet_Reportemp_id").value="";
		document.getElementById("Timesheet_Reportemp_name").focus();
	}else if(document.getElementById("Timesheet_Reportemp_name").value!="" && document.getElementById("emp_id").value==""){
		document.getElementById("Timesheet_Reportemp_name").focus();
	}
}
function InvlidCustomer1(ID , Name){
		if(document.getElementById(ID).value!="" && document.getElementById(Name).value==""){
			document.getElementById(ID).value="";
			document.getElementById(Name).focus();
		}else if(document.getElementById(Name).value!="" && document.getElementById(ID).value==""){
			document.getElementById(Name).focus();
		}
}

    function SetCustomer(cust_id,row_id){

         if(cust_id !=''){
            //var Control_Number = document.lveForm.tot_ctrl.value;
            var url='task=SetCust&cust_id='+cust_id+'&Control_Number='+row_id;
            jQuery.ajax({
                url: '<?php echo $this->webroot . "Timesheet/functions" ?>',
                data: url,
                success: function(data){
                                        data = "<option value=''>All</option>" + data;
                                        jQuery('#M'+row_id+" select[name^=milestone]").html(data);
                }
            });
        }
    }

</script>







<script type="text/javascript">
    function check(){
	  if (document.getElementById("Timesheet_ReportFromDate").value=="")
	  {
		alert("From Date Required !");
		document.getElementById("Timesheet_ReportFromDate").focus() ;
		return false;
	  }
	  if (document.getElementById("Timesheet_ReportToDate").value=="")
	  {
		alert("To Date Required !");
		document.getElementById("Timesheet_ReportToDate").focus() ;
		return false;
	  }
	 if (document.getElementById("Timesheet_Reportcust_name").value=="")
	  {
		alert("Customer Name is Required !");
		document.getElementById("Timesheet_Reportcust_name").focus() ;
		return false;
	  }
	  
  }
</script>

<?php echo $form->create('Timesheet_Report', array('url' => array('controller' => 'Timesheet', 'action' => 'tsreportviewnew'), 'id' => 'tsreport','name'=>'reportForm')); ?>
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

<h2 class="demoheaders">Customer wise Time Sheet Report Query Form</h2>
        <div class="travel-voucher">

            <div class="input-boxs">
                <table width="100%" border="0" cellspacing="5" cellpadding="5">

                    <tr>
                        <th scope="row">From Date :</th>
                                <td><?php echo $form->input('Timesheet_Report.from_date', array('label' => false, 'type' => 'text', 'class' => 'required round')); ?>
                                        <script type="text/javascript"> jQuery(function(){jQuery('#Timesheet_ReportFromDate').datepicker({ inline: true,changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy' });});</script></td>
                    </tr>
                    <tr>
                        <th scope="row">To Date :</th>
                                <td><?php echo $form->input('Timesheet_Report.to_date', array('label' => false, 'type' => 'text', 'class' => 'required round')); ?>
                                        <script type="text/javascript"> jQuery(function(){jQuery('#Timesheet_ReportToDate').datepicker({ inline: true,changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy' });});</script></td>
                    </tr>

                    <?php $report = array('Vc_Emp_Name' => 'Employee Name', 'Dt_Sanction_Date' => 'Sanction Date', 'Dt_Voucher_Date' => 'Voucher Date', 'Vc_Status' => 'Voucher Status'); ?>
                        <tr>
                            <th scope="row">Customer Name :</th>
                            <td valign="top" id='customer1'>
                                    <input type="hidden" id="cust_id0" name="cust_id0" value="<?php //echo $rwTsRec['NU_CUSTOMER_NO'][$x]  ?>" style="font-size: 10px; width: 20px;"  readonly/>
                           
                                        <input type="text" class="round" id="Timesheet_Reportcust_name" name="Timesheet_Reportcust_name"  onselectstart='javascript:return false;' value="" onKeyDown="Show1('0','<?php echo $this->webroot . 'Timesheet' ?>');" onBlur="SetCustomer(document.getElementById('cust_id0').value,'<?php echo (1) ?>');"/>
                                <input type="hidden" id="Timesheet_Reportcust_id" name="Timesheet_Reportcust_id" value="<?php //echo $rwTsRec['NU_CUSTOMER_NO'][$x]   ?>" style="font-size: 10px; width: 20px;"  readonly/>
                            </td>
                        </tr>
                       
                    </table>

                </div>

            </div>
    
            <div class="submit-form">
            <?php echo $form->submit('Display', array('Display', 'onClick' => "return check()")); ?>
            </div>

   
        

          
<?php $form->end(); ?>

<script type="text/javascript">
    function Showemployee(id, url) {
    }
    jQuery(document).ready(function(){
            jQuery( "#Timesheet_Reportemp_name").autocomplete({
                source: '<?php echo $this->webroot; ?>'+'Timesheet/autosuggestionbyemp/'+jQuery('#Timesheet_ReportRegion').val(),
                minLength: 1,
                select: function( event, ui ) {
                    jQuery('#Timesheet_Reportemp_id').attr('value', ui.item.id);
                },
                open: function() {
                    //jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    //jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            jQuery('#Timesheet_Reportemp_name').change(function(){
                if(jQuery('#Timesheet_Reportemp_name').val().length == 0 )
                    jQuery('#Timesheet_Reportemp_id').attr('value','');
            });
 
        });

</script>

<script type="text/javascript">
    function Show1(id, url) {  
       }
      jQuery(document).ready(function(){
            jQuery( "#Timesheet_Reportcust_name").autocomplete({
                source:'<?php echo $this->webroot; ?>'+'Timesheet/autosuggestion',
                minLength: 2,
                select: function( event, ui ) {
                    jQuery('#Timesheet_Reportcust_id').attr('value', ui.item.id);
                     jQuery('#cust_id0').attr('value', ui.item.id);
                },
                open: function() {
                    //jQuery( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
                },
                close: function() {
                    //jQuery( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
                }
            });
            jQuery('#Timesheet_Reportcust_name').change(function(){
                if(jQuery('#Timesheet_Reportcust_name').val().length == 0 )
                    jQuery('#Timesheet_Reportcust_id').attr('value','');
            });

        });
</script>