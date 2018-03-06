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
        <th width="5%">S. No.</th>
        <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster', 'Organization Name'); ?></th>
        <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster', 'Leave Type '); ?></th>
	<th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'Leave Code'); ?></th> 
    <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'Week OFF'); ?></th> 
       <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'Max Leave'); ?></th> 
        <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'half day'); ?></th> 
         <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'File Upload'); ?></th> 
         <th width="5%"><?php echo $this->Paginator->sort('LeaveMaster ', 'No OF Files'); ?></th> 
     
        <th width="15%">Action</th>   


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
		<span id="orgn<?php echo $res['LeaveMaster']['comp_code']; ?>" style="width:40px; word-wrap:break-word;">
                    
                   <?php $orgName = $this->Common->findCompanyNameByCode($res['LeaveMaster']['comp_code']);

                echo $this->Form->input('org_name', array('class' => 'round_select', 'label' => false,  'id' => 'org_name' . $res['LeaveMaster']['comp_code'],'value'=>$orgName,'disabled'=>'disabled')); 
			 ?></span>
			</td>
		<td>
		<span id="empn<?php echo $res['LeaveMaster']['leave_type']; ?>" style="width:40px; word-wrap:break-word;">
			<?php echo $this->Form->input('Leave_type', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['LeaveMaster']['leave_type'], 'value' => $res['LeaveMaster']['leave_type'])) ?></span>
			</td> 
			<td>
		<span id="empn<?php echo $res['LeaveMaster']['leave_code']; ?>" style="width:40px; word-wrap:break-word;">
			<?php echo $this->Form->input('leave_code', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appCode' . $res['LeaveMaster']['id'], 'value' => $res['LeaveMaster']['leave_code'])) ?></span>
			</td> 		
         		<td>
        <span id="empn<?php echo $res['LeaveMaster']['week_off']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('wo', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'weekoff' . $res['LeaveMaster']['week_off'], 'value' => $res['LeaveMaster']['week_off'])) ?></span>
            </td>    
                <td>
        <span id="empn<?php echo $res['LeaveMaster']['max_days']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('LeaveMaster_type', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appleave' . $res['LeaveMaster']['max_days'], 'value' => $res['LeaveMaster']['max_days'])) ?></span>
            </td>    

                    <td>
        <span id="empn<?php echo $res['LeaveMaster']['half_day_chk']; ?>" style="width:40px; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['half_day_chk']=='1')
{
    
             echo $this->Form->checkbox('halfday', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['half_day_chk']=='0')
{
    
  echo $this->Form->checkbox('halfday', array('class' => 'round_select',  'label' => false, 'id' => 'apphd' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php }?>





           
             <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload']; ?>" style="width:40px; word-wrap:break-word;">
            <?php //echo $res['LeaveMaster']['file_upload']; 
if($res['LeaveMaster']['file_upload']=='1')
{
    
             echo $this->Form->checkbox('file_upload', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'check' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['file_upload']=='0')
{
    
  echo $this->Form->checkbox('file_upload', array('class' => 'round_select',  'label' => false, 'id' => 'check' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php }?>
                 <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload_no']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('file_upload_no', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'nleave' . $res['LeaveMaster']['file_upload_no'], 'value' => $res['LeaveMaster']['file_upload_no'])) ?></span>
            </td>     
                    
               <td > <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="edit">Edit</a>  <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['LeaveMaster']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['LeaveMaster']['page'] * $this->params['paging']['LeaveMaster']['limit']) - $this->params['paging']['LeaveMaster']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
		     <td>
        <span id="orgn<?php echo $res['LeaveMaster']['comp_code']; ?>" style="width:40px; word-wrap:break-word;">
                    
                   <?php $orgName = $this->Common->findCompanyNameByCode($res['LeaveMaster']['comp_code']);

                echo $this->Form->input('org_name', array('class' => 'round_select', 'label' => false,  'id' => 'org_name' . $res['LeaveMaster']['comp_code'],'value'=>$orgName)); 
             ?></span>
            </td>
        <td>
        <span id="empn<?php echo $res['LeaveMaster']['leave_type']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('Leave_type', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['LeaveMaster']['leave_type'], 'value' => $res['LeaveMaster']['leave_type'])) ?></span>
            </td> 
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['leave_code']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('leave_code', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appCode1' . $res['LeaveMaster']['leave_code'], 'value' => $res['LeaveMaster']['leave_code'])) ?></span>
            </td>       
                <td>
        <span id="empn<?php echo $res['LeaveMaster']['week_off']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('wo', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'weekoff1' . $res['LeaveMaster']['week_off'], 'value' => $res['LeaveMaster']['week_off'])) ?></span>
            </td>    
                <td>
        <span id="empn<?php echo $res['LeaveMaster']['max_days']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('LeaveMaster_type', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appleave1' . $res['LeaveMaster']['max_days'], 'value' => $res['LeaveMaster']['max_days'])) ?></span>
            </td>  
                   <td>
        <span id="empn<?php echo $res['LeaveMaster']['half_day_chk']; ?>" style="width:40px; word-wrap:break-word;">
            <?php 
  
if($res['LeaveMaster']['half_day_chk']=='1')
{
    
             echo $this->Form->checkbox('halfday', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'apphd1' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['half_day_chk']=='0')
{
    
  echo $this->Form->checkbox('halfday', array('class' => 'round_select',  'label' => false, 'id' => 'apphd1' . $res['LeaveMaster']['half_day_chk'], 'value' => $res['LeaveMaster']['half_day_chk']))?></span>
            </td> 
            <?php }?>
            <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload']; ?>" style="width:40px; word-wrap:break-word;">
            <?php //echo $res['LeaveMaster']['file_upload']; 
if($res['LeaveMaster']['file_upload']=='1')
{
    
             echo $this->Form->checkbox('file_upload', array('class' => 'round_select', 'checked' => 'true', 'label' => false, 'id' => 'check1' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php 
}
else if($res['LeaveMaster']['file_upload']=='0')
{
    
  echo $this->Form->checkbox('file_upload', array('class' => 'round_select',  'label' => false, 'id' => 'check1' . $res['LeaveMaster']['file_upload'], 'value' => $res['LeaveMaster']['file_upload']))?></span>
            </td> 
            <?php }?>
           <td>
        <span id="empn<?php echo $res['LeaveMaster']['file_upload_no']; ?>" style="width:40px; word-wrap:break-word;">
            <?php echo $this->Form->input('file_upload_no', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'nleave1' . $res['LeaveMaster']['file_upload_no'], 'value' => $res['LeaveMaster']['file_upload_no'])) ?></span>
            </td>   


            <td > <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['LeaveMaster']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++;
}
    
?>





</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
