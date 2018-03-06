<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>

<?php  $fieldid=$divcountno-1; ?>
<div id="redRow<?php echo $fieldid ;?>">
<?php $html_name = 'name="milestone'.$fieldid.'" style="width:120px;"';?>
<table width="100%" cellspacing="1" cellpadding="5" border="0" class="exp-voucher">

<tr class="cont1">
      <td width="134" valign="top"  id='M<?php echo $divcountno; ?>'>
         <?php  $projects = $Function->TSMilestone($emp_code, $html_name);
            echo $projects;
            ?></td >
      <td><input type="text" style="width:70px;" name="subproject<?php echo $fieldid; ?>" id="subproject<?php echo $fieldid; ?>"   class="textBox" /></td>
             <?php
         $con=$Function->connRet();
         $arrWeek=$Function->SQLYearWeek($con);
        $currentWeekStart =$arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_DMY'];
        $currentWeekEnd=$arrWeek['CUR_YEAR_CUR_WEEK_END_DATE_DMY'];
  ?>
        <?php  strtotime($arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']); ?>
        <td  id='weekCombo<?php echo $divcountno; ?>' width="107"><?php  $weekdate=$Function->WeeklySingleCombo(strtotime($arrWeek['CUR_YEAR_CUR_WEEK_START_DATE_RRRR']),'1');
               echo $weekdate;
        ?></td>
		   <td width="38"><input type="checkbox"  name="leave<?php echo $fieldid;?>" id="leave<?php echo $fieldid;?>" value="Y" onClick="CheckLeave(this.value,'<?php echo $fieldid; ?>')"/></td>

        <td width="69"><input type="text" style="width:50px;" name="stTime<?php echo $fieldid;?>" id="stTime<?php echo $fieldid;?>" value="00:00" maxlength="5" onBlur="IsValidTime(this.value , this.id);"/></td>
        <td width="69"><input type="text" style="width:50px;" name="edTime<?php echo $fieldid;?>" id="edTime<?php echo $fieldid;?>" value="00:00" maxlength="5" onBlur="CheckTime(this.value , <?php echo $fieldid;?> , this.id)"/></td>
        <td width="68"><input type="text" style="width:50px;" name="hrs<?php echo $fieldid;?>"  id="hrs<?php echo $fieldid;?>"  value="00:00" readnoly="readonly"/></td>
        <td width="58"><input type="text" style="width:40px;" name="module<?php echo $fieldid;?>" id="module<?php echo $fieldid;?>" /></td>
        <td width="123"><textarea rows='0' cols='10' name="remarks<?php echo $fieldid;?>" id="remarks<?php echo $fieldid;?>"></textarea></td>
        <td width="123"><textarea cols="10" name="pname<?php echo $fieldid;?>" id="pname<?php echo $fieldid;?>"> </textarea></td>
        <td><input type="text" style="width:50px;" name="fr<?php echo $fieldid;?>" type="text" id="fr<?php echo $fieldid;?>"/></td>
        <td><input type="text" style="width:50px;" name="mmpid<?php echo $fieldid;?>" type="text" id="mmpid<?php echo $fieldid;?>"/></td>
</tr>
</table>
</div>