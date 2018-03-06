<script type="text/javascript">
			$(function(){

			       // Dialog
				$('#dialog').dialog({
					autoOpen: false,
					width: 600,
                                        modal:true,
					buttons: {
						"Ok": function() {
							 var cmnt=$('#cmnt').val();

                                                        if(cmnt==' ')
                                                       {
                                                             $('#errdis').show('medium', function() {
                                                               // Animation complete.
                                                              });
                                                            return false;
				                    }else{
         		                          	     $(this).dialog("close");
                                                            document.trvoucher.submit();
                                                          }
                                                  },
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});


			});
		</script>
<script>

function reject(compcode,vno,sdate,edate)
{

      var compcode=document.getElementById("ccode").value=compcode;
      var voucherno=document.getElementById("vouchno").value=vno;
      var stdate=document.getElementById("stdate").value=sdate;
      edate=document.getElementById("eddate").value=edate;
      	$('#dialog').dialog('open');
	return false;
}

function getcmtval()
{
      var voucherno=document.getElementById("cmnt").value;
      var rjres=document.getElementById("rejectres").value=voucherno;

}


</script>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>

            <li><?php echo $html->link('Self Services', $html->url('/travels/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Travel Voucher', $html->url('/travels/trvoucher', true)); ?> </li>
              <li>Travel Expense Report :</li>



        </ul>
    </div>
</div>

<h2 class="demoheaders">Approve</h2>


<div class="travel-voucher1">
<div class="input-boxs">
<div class="travel-voucher1">
<?php echo $form->create('Account_Voucher', array('url' => array('controller' => 'travels', 'action' => 'rejectvoucher'), 'id' => 'trvoucher','name'=>'trvoucher')); ?>
<input type="hidden" value="2" name="varfy">
    <table  frame="void" width="100%" align="center" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">
  
 <?php 
 
 if(!empty($pending_voucher_employee)) {
?>
  <thead class="vrTableHeader">
  <tr class="head">
   <th>Voucher No</th>
   <th align="center">Name</th>
   <th align="center">Department Name</th>
   <th>Voucher Date</th>
   <th>Start Date</th>
   <th>End Date</th>
   <th align="center">Balance Amount<br> (in Rs.)</th>
   <th align="center">Amount to be<br> Returned (in Rs.)</th>
   <th>Update Status</th>
  </tr>
  </thead><tbody>

<?php // pr($pending_voucher_employee); die;?>
<?php $i=1;foreach($pending_voucher_employee as $pending_detail) { ?>

<tr <?php if($i%2==0){?>class="cont1" <?php } else {?>class="cont" <?php } ?>>
   <td><?php echo $pending_detail[0]['vc_voucher_no'];?></td>
   <td><?php echo $pending_detail[0]['vc_emp_name'];?></td>
   <td><?php echo $pending_detail[0]['vc_dept_name'];?> </td>
    <td>
   <?php echo $pending_detail[0]['dt_app_date'];?>
   </td><td>
   <?php echo $pending_detail[0]['dt_start_date'];?>
   </td>
   <td>
   <?php echo $pending_detail[0]['dt_end_date'];?>
   </td>
   <td><?php echo $pending_detail[0]['nu_balance_amount'];?></td>
   <td><?php echo $pending_detail[0]['nu_return_amount'];?></td>

   <td>
   <ul class="edit-delete-icon">
        <li>
   <a href="<?php echo $this->webroot.'travels/editaccountvoucher/'.base64_encode($pending_detail[0]['vc_comp_code'])
                                                          .'/'.base64_encode($pending_detail[0]['vc_voucher_no'])
                                                          .'/'.base64_encode($pending_detail[0]['vc_emp_code']).'/'
                                                          .base64_encode($pending_detail[0]['vc_emp_name']).'/'
                                                          .base64_encode($pending_detail[0]['Mgr']).'/'
                                                          .base64_encode($pending_detail[0]['dt_start_date']).'/'
                                                          .base64_encode($pending_detail[0]['dt_end_date']);?>"
                                                          class="approved vtip" Title="Sanction">> </a>
       </li>
       <li style="border:none;"> <span class=""><a href="#" id="dialog_link" class="reject vtip" Title="Reject" onclick="return reject('<?php echo $pending_detail[0]['vc_comp_code']?>','<?php echo $pending_detail[0]['vc_voucher_no']?>','<?php echo $pending_detail[0]['dt_start_date'];?>','<?php echo $pending_detail[0]['dt_end_date'];?>')"><span class=""></span> Reject</a></span>
       </li>
   </ul>
   </td>
  </tr>
<?php $i++; } } else {?>

	<h2 class="demoHeaders" style="color:red;" ></h2>
		<div class="ui-widget">
			<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0pt 20em; margin-left: 0px;">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
				No Record For Approval </p>
			</div>
		</div>
<div style="margin-top: 90px;"></div>

<?php } ?>
<input type="hidden" id="vouchno" name="voucher_no" value=""/>
<input type="hidden" id="ccode" name="comp_code" value=""/>
<input type="hidden" id="stdate" name="start_date" value=""/>
<input type="hidden" id="eddate" name="end_date" value=""/>
<input type="hidden" id="rejectres" name="rejectreson" value=""/>


</tbody></table>
	<div id="dialog" title="Remark/Comment">
			<div ><textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 550px; height:200px;" onKeypress="getcmtval()" > </textarea></div>
		
<div class="ui-widget" id="errdis" style="display:none">
			<div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
				<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
				Please write rejection reason.</p>
			</div>
</div>
		</div>
</div>

</div>

</div>

<?php $form->end(); ?>