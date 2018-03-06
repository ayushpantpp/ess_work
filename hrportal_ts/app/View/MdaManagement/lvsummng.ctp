<script type="text/javascript">
function change()
{
document.frm.selc.focus();
document.forms["frm"].submit();

}


    jQuery(document).ready(function(){
        jQuery('#viewdetails_l').dialog({ 
            autoOpen: false,
            modal: true,
	    width: 600,
		height: 350
             });
        
        
    });
        
    
function empleave(empcode)
{   
    jQuery('#viewdetails_l').dialog("open");
    var data='Loading....'; 
    jQuery('#viewdetails_l').html(data);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>leaves/empwiselvedt?ecode='+empcode,
        success: function(data){
            jQuery('#viewdetails_l').html(data);
        }
    });
  
  
 
   }

  </script>


<div class="breadCrumbHolder module">
<div id="breadCrumb0" class="breadCrumb	module">
<ul>
<li>
<a href="#" class="vtip" title="Home">Home</a>
</li>
<li><?php echo $html->link('Self Services', $html->url('/selfservices',	true));	?> </li>
<li>Leave List  </li>
</ul>
</div>
</div>
<h2 class="demoheaders">Leave List <?php echo date('Y'); ?></h2>
<div class="travel-voucher1">

<div class="input-boxs">

  <form name="frm" method="post">
   </form>
<?php $SumVouch=$rs;
      if(!empty($SumVouch)==0){ ?>
<br>
<br>
<center>

  <h3>There is no record to view ! <br>
  </h3>
 
  <br>
  <p><a href="#" class="linkStyle" onClick="history.back()"><b>Click here to go back....</b></a></p>
</center>
<?php } else { ?>
<table width="100%" align="center"   cellpadding="1" cellspacing="1" class="exp-voucher">
  <colgroup>
  <col width="20%" align="center" />
  <col width="20%" align="center" />
  <col width="10%" align="center" />
  <col width="13%" align="center" />
  <col width="10%" align="center" />
  <col width="10%" align="center" />
  <col width="10%" align="center" />
  <col width="10%" align="center" />
  </colgroup>
  <thead>
    <tr class="head">

        <th width="59%">Employee Name</th>
      <th width="26%">Total Leaves</th>
      
      <th width="14%">Action</th>
     </tr>
  <tbody>
  
<?php 

$i=0; foreach($rs as $result)
           {  if($i%2==0){
                    $cls="cont";
              }else {
                    $cls="cont1"; } ?>

    
    <tr class="<?php echo $cls;?>">
      <td> <?php echo $result[0]["VC_EMP_NAME"]; ?></td>
      <td><?php  echo $result[0]["TOTAL_LEAVES"]; ?></td>
     
      <td>
       <ul class="edit-delete-icon">
                         <li style="border-right:none;"><a href="javascript:void(0);" onclick='empleave(<?php echo $result[0]["VC_EMP_CODE"]; ?>);' class="view vtip" title="View">View</a></li>
                       </ul>
      </td>
    </tr>
<?php } } ?>
    
</table>

</div>

</div>



<div id="viewdetails_l" title="Leave Details" style="width:1190px;">
    <span id="display_details">Loding....</span>   
</div>
