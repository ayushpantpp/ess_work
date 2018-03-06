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
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('org_name', 'Organization Name'); ?></th>
        <th width="30%"><?php echo $this->Paginator->sort('Location', 'Location Name'); ?></th>
        <th width="30%"><?php echo $this->Paginator->sort('holiday_name', 'Holiday Name'); ?></th>
	<th width="30%"><?php echo $this->Paginator->sort('holiday_date', 'Holiday Date'); ?></th> 
        <th width="10%"><?php echo $this->Paginator->sort('op_leave', 'Optional'); ?></th> 
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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Holiday']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['Holiday']['page'] * $this->params['paging']['Holiday']['limit']) - $this->params['paging']['Holiday']['limit']) + $i;
			echo $ctr;
			?>
		</td>
                <td>
		<span id="orgn<?php echo $res['Holiday']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
                    
                   <?php $orgName = $this->Common->findCompanyNameByCode($res['Holiday']['org_id']);
                echo $this->Form->input('org_name', array('class' => 'round_select', 'label' => false,  'id' => 'org_name' . $res['Holiday']['id'],'value'=>$orgName,'disabled'=>'disabled')); 
			 ?></span>
			</td>
            <td>
        <span id="empn<?php echo $res['Holiday']['location_id']; ?>" style="width:300px; word-wrap:break-word;">
            <?php  if($res['Holiday']['location_id']!='0')
            {
            $locname = $this->Common->findEmployeeGroupNameByCode($res['Holiday']['location_id']);
        }
        else{
            $locname='All';
        }
            echo $this->Form->input('location_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'apploc' . $res['Holiday']['location_id'], 'value' => $locname)); ?></span>
            </td> 
		<td>
		<span id="empn<?php echo $res['Holiday']['holiday_name']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('holiday_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['Holiday']['holiday_name'], 'value' => $res['Holiday']['holiday_name'])) ?></span>
			</td> 
			<td>
		<span id="empn<?php echo $res['Holiday']['holiday_date']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('holiday_dates', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appCode' . $res['Holiday']['holiday_date'], 'value' => $res['Holiday']['holiday_date'])) ?></span>
			</td> 		
         		<td>
		<span id="empn<?php echo $res['Holiday']['op_leave']; ?>" style="width:100px; word-wrap:break-word;">
			<?php 
                        $listing = array('0'=>'No','1'=>'Yes');
                        echo $this->Form->input('op_leave', array( 'disabled' => 'true', 'label' => false,'type'=>'select','id' => 'appOptional' . $res['Holiday']['id'],'options'=>$listing,'default'=>$res['Holiday']['op_leave'])) ?></span>
			</td>	
            <td> 
                <?php  $curDate = date("Y");
                  $holiday_date = date('Y', strtotime($res['Holiday']['holiday_date']));
                 if($curDate <= $holiday_date){
                ?>
               <!--  <a href="javascript:void(0);" mid="<?php echo $res['Holiday']['id']; ?>" id="edit">Edit</a>   -->
		<a href="javascript:void(0);" mid="<?php echo $res['Holiday']['id']; ?>" id="delete">Delete</a>
                 <?php }else{
                     echo "NA";
                 }?>
            </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['Holiday']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['Holiday']['page'] * $this->params['paging']['Holiday']['limit']) - $this->params['paging']['Holiday']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
		<td> 
                <?php
                $orgName = $this->Common->findCompanyNameByCode($res['Holiday']['org_id']);
                echo $this->Form->input('org_name', array('class' => 'round_select', 'label' => false,  'id' => 'org_name' . $res['Holiday']['id'],'value'=>$orgName,'disabled'=>'disabled')); ?>
				
			</td>	
            <td> 
                <?php echo $this->Form->input('holiday_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['Holiday']['id'],'value'=>$res['Holiday']['holiday_name'])); ?>
				<div id="dnameErr<?php echo $res['Holiday']['id']; ?>" style="color:red"></div>
			</td>
		<td> 
                <?php echo $this->Form->input('holiday_dates', array('class' => 'round_select', 'label' => false,  'id' => 'appName1' . $res['Holiday']['id'],'value'=>$res['Holiday']['holiday_date'],'readonly'=>true)); ?>
				<div id="dateErr<?php echo $res['Holiday']['id']; ?>" style="color:red"></div>
			</td>
                        <script>
                     jQuery("#appName1"+<?php echo $res['Holiday']['id']; ?>).datepicker({
                    inline: true,
                    changeMonth: true,
                    autoclose: true,
                    minDate: 'today',
                    //changeYear: true,
                    format: 'dd-mm-yyyy'

                });
                </script>
		<td> 
                <?php 
                $list = array('0'=>'No','1'=>'Yes');
                //echo $this->Form->input('op_leave', array( 'label' => false,  'id' => 'appOpt'.$res['Holiday']['id'],'type'=>'checkbox','checked'=>$checked,'onclick'=>"getcheckbox(".$res['Holiday']['id'].")"));
                echo $this->Form->input('op_leave', array( 'label' => false,  'id' => 'appOpt'.$res['Holiday']['id'],'type'=>'select','options'=>$list,'default'=>$res['Holiday']['op_leave'])); 
                ?>
                
			</td>

            <td > <a href="javascript:void(0);" mid="<?php echo $res['Holiday']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Holiday']['id']; ?>" id="cancel">Cancel</a> </td>
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
