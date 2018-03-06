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
         <td colspan="4"><b>Wheeler Type</b></td> 

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="30%"><?php echo $this->Paginator->sort('org_id', 'Orgnization'); ?></th> 
		<th width="30%"><?php echo $this->Paginator->sort('vehical', 'Vehicle'); ?></th> 
                <th width="30%"><?php echo $this->Paginator->sort('wheeler_type', 'Wheeler Type'); ?></th>
                <th width="30%"><?php echo $this->Paginator->sort('price', 'Price'); ?></th>
                <th width="30%"><?php echo $this->Paginator->sort('effected_date', 'Effected Date'); ?></th>
        <th width="20%"><?php echo $this->Paginator->sort('status', 'Status'); ?></th> 
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
 echo $this->Form->create('MstWheelerType', array('url' => '#', 'name' => 'searchForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));

foreach ($list as $res) {
	if ($i % 2 == 0) {
        $class = 'cont';
    } else {
        $class = 'cont1';
    }
    
        
	//	 echo $this->Form->create('Designations1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
?><!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MstWheelerType']['id']; ?>">
        <td><?php
			
			$ctr = (($this->params['paging']['MstWheelerType']['page'] * $this->params['paging']['MstWheelerType']['limit']) - $this->params['paging']['MstWheelerType']['limit']) + $i;
			echo $ctr;
			?>
		</td>
                <?php /*
		<td>
		<span id="empn<?php echo $this->common->findTravelModeById($res['MstWheelerType']['name']); ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('name', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'name' . $res['MstWheelerType']['name'], 'value' =>$this->common->findTravelModeById($res['MstWheelerType']['name']))) ?></span>
			</td> **/?>
                        <td>
                            <?php $company = $this->Common->findCompanyName();?>
		<span id="empn<?php echo $res['MstWheelerType']['org_id']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('org_id', array('class' => 'round_select_tbl', 'disabled' => 'true', 'label' => false, 'id' => 'org_id' . $res['MstWheelerType']['org_id'],'options'=>$company, 'value' => $res['MstWheelerType']['org_id'])) ;
                               echo $this->Form->input('id', array('type'=>'hidden','id'=>'rec_id'.$res['MstWheelerType']['id'],'value'=>$res['MstWheelerType']['id'])) ; 
                                ?></span>
			</td>
                        
                        <td>
                            <?php //$Wheeler = array('1'=>'Two Wheeler','2'=>'Three Wheeler','3'=>'Four Wheeler','4'=>'Cab');
                            $Wheeler = $this->Common->findAllVehical($res['MstWheelerType']['org_id']);
                            ?>
		<span id="empc<?php echo $res['MstWheelerType']['vehicle']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('vehicle', array('class' => 'round_select_tbl', 'disabled' => 'true', 'label' => false, 'id' => 'vehicle' . $res['MstWheelerType']['vehical'], 'options'=>$Wheeler,'value' => $res['MstWheelerType']['vehical'])) ?></span>
			</td>
                        <td>
                            <?php $Wheeler_type = array('1'=>'Personal','2'=>'Commercial');?>
		<span id="empc<?php echo $res['MstWheelerType']['wheeler_type']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('wheeler_type', array('class' => 'round_select_tbl', 'disabled' => 'true', 'label' => false, 'id' => 'wheeler_type' . $res['MstWheelerType']['wheeler_type'],'options'=>$Wheeler_type,'value' => $res['MstWheelerType']['wheeler_type'])) ?></span>
			</td>
			<td>
		<span id="emp<?php echo $res['MstWheelerType']['price']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $this->Form->input('price', array('class' => 'round_select_tbl', 'disabled' => 'true', 'label' => false, 'id' => 'price' . $res['MstWheelerType']['price'], 'value' => $res['MstWheelerType']['price'])) ?></span>
			</td>
                        <td>
		<span id="empc<?php echo $res['MstWheelerType']['effected_date']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
                        $effDate = date("d/m/Y", strtotime($res['MstWheelerType']['effected_date']));
                        echo $this->Form->input('eff_date', array('class' => 'round_select_tbl', 'disabled' => 'true', 'label' => false, 'id' => 'eff_date' . $effDate, 'value' => $effDate)) ?></span>
			</td>
		<td>
		<span id="empn<?php echo $res['MstWheelerType']['status']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
			$status = array('1'=>'Active','0'=>'Inactive');
			echo $status[$res['MstWheelerType']['status']];?></span></td> 
					
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MstWheelerType']['id']; ?>" id="edit">Edit</a>  
		<a href="javascript:void(0);" mid="<?php echo $res['MstWheelerType']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


        <!-- Edit -->
	
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MstWheelerType']['id']; ?>" style="display:none;">
		
            <td ><?php
                $ctr = (($this->params['paging']['MstWheelerType']['page'] * $this->params['paging']['MstWheelerType']['limit']) - $this->params['paging']['MstWheelerType']['limit']) + $i;

                echo $ctr;
                    ?>
            </td>
			
            <td> 
                <?php
                echo $this->Form->input('id', array('type'=>'hidden','id'=>'rec_id'. $res['MstWheelerType']['id'],'value'=>$res['MstWheelerType']['id'])) ; 
                $company = $this->Common->findCompanyName();
                echo $this->Form->input('org_id', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'org_id' . $res['MstWheelerType']['id'],'options'=>$company,'default'=>$res['MstWheelerType']['org_id'])); ?>
				<div id="nameErr1<?php echo $res['MstWheelerType']['id']; ?>" style="color:red"></div>
			</td>
                        <td> 
                <?php 
                //$Wheeler = array('1'=>'Two Wheeler','2'=>'Three Wheeler','3'=>'Four Wheeler','4'=>'Cab');
                $Wheeler = $this->Common->findAllVehical('01');
                echo $this->Form->input('vehicle', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'vehicle' . $res['MstWheelerType']['id'],'options'=>$Wheeler,'value'=>$res['MstWheelerType']['vehical'])); ?>
				<div id="nameErr0<?php echo $res['MstWheelerType']['id']; ?>" style="color:red"></div>
			</td>
                        <td> 
                <?php 
                $Wheeler_type = array('1'=>'Personal','2'=>'Commercial');
                echo $this->Form->input('wheeler_type', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'wheeler_type' . $res['MstWheelerType']['id'],'options'=>$Wheeler_type,'value'=>$res['MstWheelerType']['wheeler_type'])); ?>
				<div id="nameErr2<?php echo $res['MstWheelerType']['id']; ?>" style="color:red"></div>
			</td>
                        
			 <td> 
                <?php echo $this->Form->input('price', array('class' => 'round_select_tbl', 'label' => false,  'id' => 'price' . $res['MstWheelerType']['id'],'value'=>$res['MstWheelerType']['price'])); ?>
				<div id="priceErr<?php echo $res['MstWheelerType']['id']; ?>" style="color:red"></div>
			</td>
                        <td> 
                <?php 
                $eff_Date = date("Y-m-d", strtotime($res['MstWheelerType']['effected_date']));
                echo $this->Form->input('eff_date', array('class' => 'round_select_tbl','disabled' => 'false', 'label' => false,  'id' => 'eff_date' . $res['MstWheelerType']['id'],'value'=>$eff_Date)); ?>
				<div id="nameErr3<?php echo $res['MstWheelerType']['id']; ?>" style="color:red"></div>
			</td>
			<td>
		<span id="empn<?php echo $res['MstWheelerType']['status']; ?>" style="width:300px; word-wrap:break-word;">
			<?php 
			$status = array('1'=>'Active','0'=>'Inactive');
			echo $status[$res['MstWheelerType']['status']];?></span></td> 
		

            <td > 
                <script>
                     jQuery("#eff_date"+<?php echo $res['MstWheelerType']['id']; ?>).datepicker({
                    inline: true,
                    changeMonth: true,
                    autoclose: true,
                   // maxDate: 'today',
                    //changeYear: true,
                    format: 'dd-mm-yyyy'

                });
                </script>
                <a href="javascript:void(0);" mid="<?php echo $res['MstWheelerType']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MstWheelerType']['id']; ?>" id="cancel">Cancel</a> </td>
			
	   </tr>
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
