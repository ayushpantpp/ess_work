<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>


<div class="input-boxs">
    <form method="post" action="tslistunfilled">
<div class="travel-voucher1">

<?php    
        $EmailStr='';
         for($i=0;$i<$numEmpTs;$i++){
               $EmailStr .=$rwEmp['VC_LOGIN_NAME'][$i].'@essindia.co.in'.',';
       } ?>

<table width="700" cellspacing="1" cellpadding="5" border="0" class="">

<tr class="cont1">
      <th>To : </th>
      <td><textarea name="MailTo" cols="30" rows="3" ><?php echo $EmailStr?></textarea> </td>
</tr>
<tr class="cont1"> 
      <th>Subject: </th>
      <td><input type="text" size="60" autocomplete="off" name="MailSubject" value="Timesheet Pending for the period of <?php echo trim($stdate); ?> - <?php echo trim($eddate);?>"></td>
</tr>
<tr class="cont1">
     <th>Message : </th>
      <td><textarea rows="10" cols="50" name="MailText"></textarea>
      <input type="hidden" name="stdate" value="<?php echo trim($stdate); ?>" />
      <input type="hidden" name="eddate" value="<?php echo  trim($eddate);?>" />
      <input type="hidden" name="empids" value="<?php echo $empids;?>" />
      </td>
</tr>
</table>
    </div>
          <div class="submit-form"><input type="submit" value="Send Reminder" name="trExpRpAp" /></div>
</form>

</div>






