<?php $auth=$this->Session->read('Auth');?>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Forward Temporary Component </h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <div class="uk-overflow-container">
<?php 
echo $this->Form->create('fwtemp', array('inputDefaults' => array(
        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
    'url' => array('controller' => 'temporary_components', 'action' => 'tempsaveinfo'), 'id' => 'tempid', 'name' => 'tempname'));
if (is_numeric($temp_amt_id)) {	
 $getlvl = $this->Common->gettemplevelbyid($temp_amt_id);
      //echo'<pre>';pr($getlvl);?>

<table class="uk-table">
<?php if (count($getlvl) > 0) { ?>
    <thead>
      <tr class="headings">

          <th>Level</th>
          <th>Name</th>                        
          <th>Date</th>
          <th>Status</th>
          <th>Remarks (if any)</th>
       </tr>
    </thead>
  <tbody>
      
<?php
$i = 0;
foreach ($getlvl as $v) {
        if($i%2 == 0)	
                $class = "cont1";
        else
                $class = "cont";?>
        <tr class="<?php echo $class; ?>">
        <td ><strong><?php echo "Level-" . $i ; ?></strong> </td>
        <td ><strong><?php echo $this->Common->getempinfo($v['TempWorkflow']['emp_code']); ?> </strong> </td>
        <td >
        <strong>
        <?php
        if (!empty($v['TempWorkflow']['fw_date'])) {
                echo date('d-M-Y', strtotime($v['TempWorkflow']['fw_date']));
        } else {
                echo   date('d-M-Y');
        } ?>
        </strong></td>
        <td >
        <strong>
        <?php
        //echo '<pre>';print_r($v);
        if (!empty($v['TempWorkflow']['status'])) {
                echo $this->Common->findSatus($v['TempWorkflow']['status']);
        } else {
            if ($i==1) {
                echo  $this->Common->findSatus(1);
            }else{
                echo  $this->Common->findSatus(2);
            }
        } ?>
      </strong> 
      </td>
     <td>
    <strong>
     <?php
      if(!empty($v['TempWorkflow']['remark'])){
      echo $v['TempWorkflow']['remark']; ?>
      <?php } else echo  "N/A"?>
        
      
    </strong>
     </td>
    <tr>
    <?php $i++; } ?>
    </tr>
    <?php } ?>
    <tr><td colspan=5> <input type="hidden" value ="<?php echo $temp_amt_id; ?>" name="data[TempWorkflow][employee_sal_mon_id]"> 
    <input type="hidden" value ="<?php echo $tempwfid; ?>" name="data[TempWorkflow][id]"></td><tr>
    <?php $deptcode = $this->Common->getemocodebydept($getlvl[0]['TempWorkflow']['emp_code']);
    
    $fwemplist= $this->Common->findLevel();
    $checklvlapp = $this->Common->findAppLevel($appId);
    
    $lvl = count($getlvl) - 1;
    
    if($lvl == $checklvlapp) {
     $fwemplist =  $this->Common->getHrList($auth['MyProfile']['emp_code']);
     
     }
    else {
    $fwemplist = $this->Common->findLevel($checllvl,'Apply');    
     }
    if(count($getlvl) > 2){
    $checkrevert = $this->Common->checkltarevert($ltaid);     
   }            
               
      ?>
     <tr class="hidehr"> 
             <style>
                .flattravel12{
                  
                 opacity: 1 !important;
                 margin-left: -9px !important;
                }
                .flattravel13{
                  
                 opacity: 1 !important;
                 margin-left: -12px !important;
                }
                
            </style>	             
        <?php
        
        if($lvl < $checklvlapp  && $tempstatus!=6) { ?>
        <td><input type="radio" class ="flat " checked="checked" name="data[TempWorkflow][type]" value="2"  onClick="displaytype();"><strong> Forward 
        </strong>
        </td>
        <?php } else { ?>
	<td>
	   
         <input type="radio" name="data[TempWorkflow][type]" value="5" class="flat" checked="checked"> <strong>Approve</strong>
        </td>
        <?php } ?>

        <?php if($checkrevert && $ltastatus !=6) {
         $revertemplist = $this->Common->getTempRevertEmp($tempid);   
         ?>
        <td 
            <input type="radio"  name="data[TempWorkflow][type]" value="3" class ="flat" onClick="displaytype();"><strong> Revert </strong>
        </td>
        <?php } ?>
        <td>
            <input type="radio"  name="data[TempWorkflow][type]" value="4" class ="flat" id="reject" ><strong> Reject </strong>
        </td>
        <td></td>
        <td></td>
        <td></td>
        </tr>

        <tr id="reject" style="display:none;"><br/>
            <td align="right">Remark*:</td>
            <td colspan="4">
                <textarea  name="data[TempWorkflow][reject_remark]" id="cmnt" col="100" row="100" > </textarea>
            </td>
        </tr> 
	<?php if($checkrevert && $tempstatus !=6) { 
          $revertemplist = $this->Common->getTempRevertEmp($tempid);         
        ?>
        
        <tr id="revert" style="display:none;">
        <td align="right">Revert :</td><br/>
        <td colspan="4">
        <table>
	<tr><td>
	<?php echo $this->Form->input('TempWorkflow.revert_emp_code', array('type' => 'select', 'label' => false, 'options' => $revertemplist, 'class' => 'round_select', 'id' => 'revertempcode')); ?> </td></tr>
        <tr><td><textarea name="data[TempWorkflow][revert_remark]" id="revcmnt" col="100" row="100" ></textarea></td></tr></table>
        </td>
        </tr>  
        <?php } ?>			
        <?php
        if($lvl < $checklvlapp ) {
	?>
        <tr id="forward" class="hidehr">					
        <td align="right">Forward :</td><br/>
        <td colspan="8">
        <table>
        <tr>
        <td>
       <?php echo $this->Form->input('TempWorkflow.forward_emp_code', array('type' => 'select', 'label' => false,  'options' => $fwemplist, 'class' => 'round_select', 'id' => 'fwlvlempcode')); ?>
        </td>
        <td>&nbsp; &nbsp;&nbsp;</td>
        <td><textarea  name="data[TempWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td>
        </tr>
         </table>
         </tr>
	 <?php } else {?>
         <?php if($checkForwardHr) { 
                                     
        $hrList = $this->Common->getHrList($auth['MyProfile']['emp_code']);

        ?>
        <tr id="forward_hr_tr" class="hidehr">					
        <td align="right">Forward to HR:</td>
        <td colspan="2"
        <table>
        <tr><td>
        <?php echo $this->Form->input('LtaWorkflow.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'round_select', 'id' => 'fwhrempcode')); ?>
        </td></tr><tr><td><textarea  name="data[LtaWorkflow][hr_forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea></td></tr>
        </table></td>
        </tr>
				
        <?php } else { ?>
                        <tr id="approved_tr" class="hidehr">
                                <td align="right">Remark*:</td>
                                <td colspan="4"><textarea  name="data[TempWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea></td>
                        </tr>
        <?php }?>
		
			
         <?php } ?>

      
   </tbody>
</table><?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[LtaWorkflow][save]','class'=>'md-btn md-btn-success')); ?></div>
<?php } ?>     
<?php $this->Form->end(); ?>

 </div>
</div>
</div>

  </div>
  </div>
 </div>




<script type="text/javascript">
function checkSubmit()
{
var typeval = $("input[name='data[TempWorkflow][type]']:checked").val();
	    
		if ($.trim($("#appcmnt").val()) === "" && typeval==4)
		{
                        $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Remark.").show();
			return false;
		}else {
        return true;    
        }
	
}
function displaytype(a)
{
    
    //var typeval = $("input[name='data[TravelWorkflow][type]']:checked").val();
    var typeval = a;
    if (typeval == 2)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', 'none');
        $("#forward").css('display', '');
	$("#approved_tr").css('display', 'none');
	$("#forward_hr_tr").css('display', 'none');
    } else if (typeval == 3)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', '');
        $("#forward").css('display', 'none');
		$("#approved_tr").css('display', 'none');
		$("#forward_hr_tr").css('display', 'none');
    } else if (typeval == 4)
    {
        $("#reject").css('display', '');
        $("#revert").css('display', 'none');
        $("#forward").css('display', 'none');
		$("#approved_tr").css('display', 'none');
		$("#forward_hr_tr").css('display', 'none');
    }else if (typeval == 5)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', 'none');
		$("#forward").css('display', 'none');
        $("#approved_tr").css('display', '');
		$("#forward_hr_tr").css('display', 'none');
    }else if (typeval == 6)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', 'none');
        $("#forward").css('display', 'none');
		$("#approved_tr").css('display', 'none');
		$("#forward_hr_tr").css('display', '');
    }
}
$(document).ready(function(){
$('#alerts').hide();    
});    

</script>
