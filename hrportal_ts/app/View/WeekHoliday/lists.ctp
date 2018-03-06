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
$dowMap = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
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
        <th width="30%"><?php echo $this->Paginator->sort('day_code', 'Day'); ?></th>
         <th width="30%"><?php echo $this->Paginator->sort('Emp_Group', 'Employee Group'); ?></th>
		<th width="30%"><?php echo $this->Paginator->sort('numbers', 'Occurence'); ?></th> 
        <th width="35%">Action</th>   


    </tr>
<?php $i = 1; ?>

<?php if

 (empty($list)) { ?>
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

    $arr = unserialize($res['WeekHoliday']['numbers']);
    $ret_str = "";
    foreach ($arr as $key => $value) {
        if($value == 1) {
            switch ($key) {
                case 0: $ret_str .="First ";break;
                case 1: $ret_str .="Second ";break;
                case 2: $ret_str .="Third ";break;
                case 3: $ret_str .="Fourth ";break;
                case 4: $ret_str .="Fifth ";break;                
                default:break;
            }
        }
        # code...
    }
    ?>
        <!-- View -->
    <tr class="<?php echo $class; ?>" id="vw<?php echo $res['WeekHoliday']['id']; ?>">
        <td ><?php
			
			$ctr = (($this->params['paging']['WeekHoliday']['page'] * $this->params['paging']['WeekHoliday']['limit']) - $this->params['paging']['WeekHoliday']['limit']) + $i;
			echo $ctr;
			?>
		</td>
		<td>
		<span id="empn<?php echo $res['WeekHoliday']['day_code']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $dowMap[$res['WeekHoliday']['day_code']]; ?></span>
			</td> 


            <td>
        <span id="empn<?php echo $res['WeekHoliday']['emp_group']; ?>" style="width:300px; word-wrap:break-word;">
            <?php  


            echo $this->Common->findEmployeeGroupNameByCode($res['WeekHoliday']['emp_group']); ?></span>
            </td> 
			<td>
		<span id="empn<?php echo $res['WeekHoliday']['numbers']; ?>" style="width:300px; word-wrap:break-word;">
			<?php echo $ret_str;?></span>
			</td> 		
         			
            <td> <a href="javascript:void(0);" mid="<?php echo $res['WeekHoliday']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <!-- End View -->


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
