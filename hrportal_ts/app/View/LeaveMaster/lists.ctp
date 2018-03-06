<style type="text/css">
    td{
        word-wrap: break-word;
        white-space: normal;

    }
    .td1{
        display:block;
        width:500px;
        overflow: hidden;
    }
    .highlight_word{

        background-color: #ACA;

    }
    
    .selectpicker{width:100%;

        position:relative;}
</style>
<?php

function match($mat) {
    return "^^^^^" . $mat[0] . "~~~~~";
}

function highlightWords($string, $words) {
    $search_exploded = explode(" ", $words);
    foreach ($search_exploded as $search_each) {
        //echo $search_each;
        $search_each = htmlspecialchars_decode($search_each, ENT_QUOTES);
        $search_each = preg_quote($search_each);
        //$string = preg_replace("/\b($search_each)\b/i", '<span class="highlight_word">\1</span>', $string);
        $string = preg_replace_callback("/$search_each/i", "match", $string);
    }
    $string = str_replace('^^^^^', '<span class="highlight_word">', $string);
    $string = str_replace('~~~~~', '</span>', $string);
    return $string;
    /*     * * return the highlighted string ** */
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  

    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('org_id', 'Related Organization'); ?></th> 
        <th width="30%"><?php echo $this->Paginator->sort('name', 'Leave Type'); ?></th> 
             <th width="30%"><?php echo $this->Paginator->sort('name', 'Leave Code'); ?></th> 
              <th width="30%"><?php echo $this->Paginator->sort('name', 'Leave Max days'); ?></th> 
               <th width="10%"><?php echo $this->Paginator->sort('name', 'weekoff'); ?></th> 
                   <th width="10%"><?php echo $this->Paginator->sort('name', 'Half Day'); ?></th> 
                       <th width="10%"><?php echo $this->Paginator->sort('name', 'File Upload '); ?></th> 
                         <th width="30%"><?php echo $this->Paginator->sort('name', 'Number of Files Upload '); ?></th> 
                          <th width="30%"><?php echo $this->Paginator->sort('name', 'Details '); ?></th> 
        <th width="35%">Action</th>   


    </tr>
<?php $i = 1; ?>
<?php if (empty($list)) { ?>
        <tr class="cont">
            <td style="text-align:center;" colspan="6">
                <em>--No Records Found--</em>
            </td>
        </tr>
<?php } ?>
<?php
//pr($this->params);
foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    ?>
        <!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['LeaveMaster']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['LeaveMaster']['page'] * $this->params['paging']['LeaveMaster']['limit']) - $this->params['paging']['LeaveMaster']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
                <span id="empn<?php echo $res['LeaveMaster']['comp_code']; ?>" style="width:100px; word-wrap:break-word;">
            <?php echo $this->Common->findCompanyNameByCode($res['LeaveMaster']['comp_code']); ?></span>
            </td>
                        <td>
        <span id="empn<?php echo $res['LeaveMaster']['leave_type']; ?>" >
            <?php echo $this->Form->input('name', array( 'options'=>array('SL','EL','LWP','OP','WL','PL'), 'type'=>'select' ,'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['LeaveMaster']['leave_type'], 'value' => $res['LeaveMaster']['leave_type'])) ?></span>
            </td>  
                  <td>
                    <?php $type_loc = $this->Common->findLeavecode();
                      ?>
        <span id="empn<?php echo $res['LeaveMaster']['leave_code']; ?>" style="width:100px; word-wrap:break-word;">
            <?php echo $this->Form->input('name', array('class' => 'round_select_tbl_leave', 'disabled' => 'true','type'=>'select','options'=>$type_loc, 'label' => false, 'id' => 'appCode' . $res['LeaveMaster']['leave_code'], 'value' => $res['LeaveMaster']['leave_code'])) ?></span>
            </td>  
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['max_days']; ?>" style="width:100px; word-wrap:break-word;">
            <?php echo $this->Form->input('name', array('class' => 'round_select_tbl_leave', 'disabled' => 'true', 'label' => false, 'id' => 'appLeave' . $res['LeaveMaster']['max_days'], 'value' => $res['LeaveMaster']['max_days'])) ?></span>
            </td>    
         			   <td>
        <span id="empn<?php echo $res['LeaveMaster']['week_off']; ?>" style="width:40px; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['week_off']=='1')
{
    
             echo $this->Form->checkbox('weekoff', array( 'disabled' => 'true','checked' => 'true', 'label' => false, 'id' => 'weekoff' . $res['LeaveMaster']['week_off'], 'value' => $res['LeaveMaster']['week_off']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['week_off']=='0')
{
    
  echo $this->Form->checkbox('weekoff', array('disabled' => 'true',  'label' => false, 'id' => 'weekoff' . $res['LeaveMaster']['week_off'], 'value' => $res['LeaveMaster']['week_off']))?></span>
            </td> 
            <?php }?>
                     <td>
        <span id="empn<?php echo $res['LeaveMaster']['half_day_chk']; ?>" style="width:40px; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['half_day_chk']=='1')
{
    
             echo $this->Form->checkbox('halfday', array( 'disabled' => 'true','checked' => 'true', 'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['half_day_chk']=='0')
{
    
  echo $this->Form->checkbox('halfday', array('disabled' => 'true',  'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk'] ))?></span>
            </td> 
            <?php }?>

             <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload']; ?>" style="width:40px; word-wrap:break-word;">
            <?php //echo $res['LeaveMaster']['file_upload']; 
if($res['LeaveMaster']['file_upload']=='1')
{
    
             echo $this->Form->checkbox('file_upload', array('disabled' => 'true', 'checked' => 'true', 'label' => false, 'id' => 'check' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['file_upload']=='0')
{
    
  echo $this->Form->checkbox('file_upload', array('disabled' => 'true', 'label' => false, 'id' => 'check' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php }?>
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload_no']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('file_upload_no', array( 'disabled' => 'true', 'label' => false, 'id' => 'nleave' . $res['LeaveMaster']['file_upload_no'], 'value' => $res['LeaveMaster']['file_upload_no'])) ?></span>
            </td>   
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['details']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('info', array('class' => 'round_select_tbl_leave', 'disabled' => 'true', 'label' => false, 'id' => 'details' . $res['LeaveMaster']['details'], 'value' => $res['LeaveMaster']['details'])) ?></span>
            </td>     
            <td> <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['LeaveMaster']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['LeaveMaster']['page'] * $this->params['paging']['LeaveMaster']['limit']) - $this->params['paging']['LeaveMaster']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td><span id="empn<?php echo $res['LeaveMaster']['comp_code']; ?>" style="width:10px; word-wrap:break-word;">
             <?php
                
                $company = $this->Common->findCompanyName();
                echo $this->Form->input('comp_code', array('class'=>'selectpicker','disabled' => 'false', 'label' => false,  'id' => 'org_id' . $res['LeaveMaster']['id'],'options'=>$company,'default'=>$res['LeaveMaster']['comp_code'])); ?></span>
            </td>
   <td> 
                                
               
                <?php echo $this->Form->input('leave_type', array('disabled' => 'false','type'=>'select','options'=>array('SL','EL','LWP','OP','WL','PL'),'label' => false,  'id' => 'appName' . $res['LeaveMaster']['id'],'value'=>$res['LeaveMaster']['leave_type'])); ?>
                <div id="dcnameErr<?php echo $res['LeaveMaster']['id']; ?>" style="color:red"></div>
               </td > 
                      <td><?php $type_loc = $this->Common->findLeavecode();
                      ?>
        <span id="empn<?php echo $res['LeaveMaster']['leave_code']; ?>" style="width:100%; word-wrap:break-word;">
            <?php echo $this->Form->input('leave_code', array('class' => 'round_select_tbl_leave','disabled' => 'false','type'=>'select','options'=>$type_loc, 'label' => false, 'id' => 'appCode' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['leave_code'])) ?></span>
            </td>  
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['max_days']; ?>" style="width:100%; word-wrap:break-word;">
            <?php echo $this->Form->input('max_days', array('class' => 'round_select_tbl_leave', 'disabled' => 'false', 'label' => false, 'id' => 'appLeave' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['max_days'],'onkeypress'=>'return isNumber(event)')) ?></span>
            </td>    
                       <td>
        <span id="empn<?php echo $res['LeaveMaster']['week_off']; ?>" style="width:100%; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['week_off']=='1')
{
    
             echo $this->Form->checkbox('week_off', array('disabled' => 'false','checked' => 'true', 'label' => false, 'id' => 'weekoff' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['week_off']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['week_off']=='0')
{
    
  echo $this->Form->checkbox('week_off', array('disabled' => 'false', 'disabled' => 'false' , 'label' => false, 'id' => 'weekoff' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['week_off']))?></span>
            </td> 
            <?php }?>
                     <td>
        <span id="empn<?php echo $res['LeaveMaster']['half_day_chk']; ?>" style="width:100%; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['half_day_chk']=='1')
{
    
             echo $this->Form->checkbox('half_day_chk', array('disabled' => 'false','checked' => 'true', 'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['half_day_chk']=='0')
{
    
  echo $this->Form->checkbox('half_day_chk', array('disabled' => 'false', 'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php }?>

             <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload']; ?>" style="width:100%; word-wrap:break-word;">
            <?php //echo $res['LeaveMaster']['file_upload']; 
if($res['LeaveMaster']['file_upload']=='1')
{
    
             echo $this->Form->checkbox('file_upload', array('disabled' => 'false','checked' => 'true', 'label' => false, 'id' => 'check' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['file_upload']=='0')
{
    
  echo $this->Form->checkbox('file_upload', array('disabled' => 'false','label' => false, 'id' => 'check' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php }?>
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload_no']; ?>" style="width:100%; word-wrap:break-word;">
            <?php echo $this->Form->input('file_upload_no', array('class' => 'round_select_tbl_leave' , 'disabled' => 'false','label' => false, 'id' => 'nleave' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['file_upload_no'],'onkeypress'=>'return isNumber(event)')) ?></span>
            </td>   
              <td>
        <span id="empn<?php echo $res['LeaveMaster']['details']; ?>" style="width:100%; word-wrap:break-word;">
            <?php echo $this->Form->input('info', array('class' => 'round_select_tbl_leave' , 'disabled' => 'false','label' => false, 'id' => 'details' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['details'])) ?></span>
            </td>   
            <td > <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="save" >Update</a>  
                <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++;
    
}?>

</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>

</div>

<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

/*function check(){
    alert(0);
    var leave_days=jQuery("#appLeave"+id).val();

    alert(leave_days);
    var filenumber=jQuery("#nleave"+id).val();
    alert(filenumber);
if(filenumber>leave_days)
{
    alert("Number of file upload is not greater then leave max days");
     jQuery("#nleave").focus();
     return false;
}
}*/

</script>

