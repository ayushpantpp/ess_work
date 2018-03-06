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



<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
  

    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%">Latitude</th>
		<th width="30%">Longitude</th> 
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
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['Company']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['Company']['page'] * $this->params['paging']['Company']['limit']) - $this->params['paging']['Company']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['Company']['comp_name']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('comp_name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName' . $res['Company']['comp_name'], 'value' => $res['Company']['comp_name'])) ?></span>
			</td> 
			<td>
		<span id="empn<?php echo $res['Company']['comp_code']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('comp_code', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appCode' . $res['Company']['comp_code'], 'value' => $res['Company']['comp_code'])) ?></span>
			</td> 		
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['Company']['id']; ?>" style="display:none;">
            <td ><?php
                $ctr = (($this->params['paging']['Company']['page'] * $this->params['paging']['Company']['limit']) - $this->params['paging']['Company']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php echo $this->Form->input('comp_name', array('class' => 'round_select', 'label' => false,  'id' => 'appName' . $res['Company']['id'],'value'=>$res['Company']['comp_name'])); ?>
				<div id="dnameErr<?php echo $res['Company']['id']; ?>" style="color:red"></div>
			</td>
		<td> 
                <?php echo $this->Form->input('comp_code', array('class' => 'round_select', 'label' => false,  'id' => 'appName1' . $res['Company']['id'],'value'=>$res['Company']['comp_code'])); ?>
				<div id="dnameErr<?php echo $res['Company']['id']; ?>" style="color:red"></div>
			</td>
		

            <td > <a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['Company']['id']; ?>" id="cancel">Cancel</a> </td>
        </tr>
        <!-- End Edit --> 
        <?php $i++;
    
}?>





</table>

