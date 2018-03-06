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
     <tr >
         

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="22%">Company Name</th> 
	<th width="22%">Email Check</th> 
        <th width="22%">SMS Check</th> 
	<th width="22%">Open Attendance Hour</th> 
        <th width="12%">Open Attendance Min</th> 
        <th width="25%">Close Attendance Hour</th>   
        <th width="25%">Close Attendance Min</th> 
        <th>Actions</th> 

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
 echo $this->Form->create('TrainingConfig1', array('url' => '#', 'name' => 'msgForm','id'=>'trainingconfigfrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('Departments1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['TrainingConfig']['id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['TrainingConfig']['page'] * $this->params['paging']['TrainingConfig']['limit']) - $this->params['paging']['TrainingConfig']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
			<?php //echo $res['Departments']['comp_code']; 
			$comp_name=$this->Common->findCompanyNameByCode($res['TrainingConfig']['comp_code']);
					echo $comp_name [0]['Company']['comp_name'];
			?>
		</td>
                <td>
		<span id="empn<?php echo $res['TrainingConfig']['email']; ?>" style="width:300px; word-wrap:break-word;">
                <?php 
                $status = array('1'=>'Active','0'=>'Inactive');
                echo $status[$res['TrainingConfig']['email']];?></span></td> 
                <td><span id="empn<?php echo $res['TrainingConfig']['sms']; ?>" style="width:300px; word-wrap:break-word;">
                <?php 
                $status = array('1'=>'Active','0'=>'Inactive');
                echo $status[$res['TrainingConfig']['sms']];?></span></td>
		<td>
		<span id="openattendanceh<?php echo $res['TrainingConfig']['open_attendance_hour'];?>" style="width:300px; word-wrap:break-word;">
                    
                <?php echo $res['TrainingConfig']['open_attendance_hour'];?></span>
		</td> 
		<td>
		<span id="openattendancem<?php echo $res['TrainingConfig']['open_attendance_min']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo  $res['TrainingConfig']['open_attendance_min']; ?></span>
			</td>
                        <td>
		<span id="closeattendanceh<?php echo $res['TrainingConfig']['close_attendance_hour']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $res['TrainingConfig']['close_attendance_hour']; ?></span>
			</td>
                        <td>
		<span id="closeattendancem<?php echo $res['TrainingConfig']['close_attendance_min']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo  $res['TrainingConfig']['close_attendance_min']; ?></span>
			</td>
		
         			
<td> <a href="<?php echo $this->webroot; ?>TrainingMasters/configEdit/<?php echo base64_encode($res['TrainingConfig']['id']); ?>/" mid="<?php echo $res['TrainingConfig']['id']; ?>" id="edit">Edit</a> | 
		 <a href="javascript:void(0);" mid="<?php echo $res['TrainingConfig']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
		
       
        <!-- End Edit --> 
        <?php $i++;
      
}?>
<?php echo $this->Form->end();?>




</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
