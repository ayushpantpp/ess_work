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

        background-color: #800000;

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
         <td colspan="4"><b>Manual One Time Crons  </b></td> 

    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="7%">S. No.</th>
        <th width="20%">MODULE NAME</th> 
	<th width="20%">Status</th>
        <th width="20%">LAst Run</th>
   
    </tr>
    <tr class="cont">
        <td>1</td>
        <td>ORG</td> 
	<td><?php if($this->Common->checkImport('import_org') == 0){ ?><a href="import_org" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td>
        <td><?php $this->Common->impDate('import_org'); ?></td>
    </tr>
    <tr class="cont">
        <td>2</td>
        <td>ATTRIBUTE TYPE</td> 
        <td><?php if($this->Common->checkImport('import_attribute_type') == 0){ ?><a href="import_attribute_type" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td>
        <td><?php $this->Common->impDate('import_attribute_type'); ?></td>
</tr>
    <tr class="cont">
        <td>3</td>
        <td>SETUP</td> 
	<td><?php if($this->Common->checkImport('import_options') == 0){ ?><a href="import_options" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
         <td><?php $this->Common->impDate('import_options'); ?></td>
</tr>
    <tr class="cont">
        <td>4</td>
        <td>OPTION ATTRIBUTE</td> 
	<td><?php if($this->Common->checkImport('import_options_attr') == 0){ ?><a href="import_options_attr" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
        <td><?php $this->Common->impDate('import_options_attr'); ?></td>
</tr>
    <tr class="cont">
        <td>5</td>
        <td>DEPARTMENTS</td> 
	<td><?php if($this->Common->checkImport('import_departments') == 0){ ?><a href="import_departments" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
         <td><?php $this->Common->impDate('import_departments'); ?></td>
    </tr>
    <tr class="cont">
        <td>6</td>
        <td>USER</td> 
       <td><?php if($this->Common->checkImport('import_users') == 0){ ?><a href="import_users" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
       <td><?php $this->Common->impDate('import_users'); ?></td>
</tr>
    <tr class="cont">
        <td>19</td>
        <td>IMPORT DEPNDENTANTS</td> 
	<td><?php if($this->Common->checkImport('import_dependants') == 0){ ?><a href="import_dependants" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
        <td><?php $this->Common->impDate('import_dependants'); ?></td>
</tr>
    <tr class="cont">
        <td>20</td>
        <td>EMP EDUCATION</td> 
	<td><?php if($this->Common->checkImport('import_emp_edu') == 0){ ?><a href="import_emp_edu" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>21</td>
        <td>EMP EXPERIENCE</td> 
	<td><?php if($this->Common->checkImport('import_emp_exp') == 0){ ?><a href="import_emp_exp" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>5</td>
        <td>LEAVES</td> 
	<td><?php if($this->Common->checkImport('import_leaves') == 0){ ?><a href="import_leaves" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>6</td>
        <td>LEAVE GROUPS</td> 
	<td><?php if($this->Common->checkImport('import_leave_groups') == 0){ ?><a href="import_leave_groups" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>7</td>
        <td>LEAVE LEVELS</td> 
	<td><?php if($this->Common->checkImport('import_desg_levels') == 0){ ?><a href="import_desg_levels" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>8</td>
        <td>TICKERS AND ICONS</td> 
	<td><?php if($this->Common->checkImport('ticker_and_icons') == 0){ ?><a href="ticker_and_icons" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>9</td>
        <td>IMPORTS SECTIONS</td> 
	<td><?php if($this->Common->checkImport('import_section') == 0){ ?><a href="import_section" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>10</td>
        <td>IMPORT INVESTMENT</td> 
	<td><?php if($this->Common->checkImport('import_invest_dtl') == 0){ ?><a href="import_invest_dtl" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>11</td>
        <td>ATTENDANCE</td> 
	<td><?php if($this->Common->checkImport('import_attendance') == 0){ ?><a href="import_attendance" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    
    <tr class="cont">
        <td>13</td>
        <td>LTA LEAVE</td> 
	<td><?php if($this->Common->checkImport('import_lta_leave') == 0){ ?><a href="import_lta_leave" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>14</td>
        <td>LTA GROUP SAL</td> 
	<td><?php if($this->Common->checkImport('import_lta_grp_sal') == 0){ ?><a href="import_lta_grp_sal" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>15</td>
        <td>LTA GROUP</td> 
	<td><?php if($this->Common->checkImport('import_lta_group') == 0){ ?><a href="import_lta_group" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>16</td>
        <td>LEAVE ENCASH</td> 
	<td><?php if($this->Common->checkImport('import_leave_encsh') == 0){ ?><a href="import_leave_encsh" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>17</td>
        <td>EMPLOYEE INVEST</td> 
	<td><?php if($this->Common->checkImport('import_emp_invest') == 0){ ?><a href="import_emp_invest" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
    </tr>
    <tr class="cont">
        <td>18</td>
        <td>FINACIAL YEAR</td> 
	<td><?php if($this->Common->checkImport('import_fy') == 0){ ?><a href="import_fy" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
        
    </tr>
    <tr class="cont">
        <td>12</td>
        <td>DEDUCTION</td> 
	<td><?php if($this->Common->checkImport('import_deductions') == 0){ ?><a href="import_deductions" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
          
    </tr>
    <tr class="cont">
        <td>12</td>
        <td>Bank Details</td> 
	<td><?php if($this->Common->checkImport('import_app_eo') == 0){ ?><a href="import_app_eo" id="edit">Import</a><?php } else { ?> <?php echo "Already Done";}?></td> 
          
    </tr>

    <tr class="cont">
        <td>4</td>
        <td>SALARY 6</td> 
	<td><a href="import_salary" id="edit">Import</a>
            <a href="import_salary_proc" id="edit">Import</a>
            <a href="import_salary_proc_addition" id="edit">Import</a>
            <a href="import_salary_proc_deduction" id="edit">Import</a>
            <a href="import_org_hcm_salary" id="edit">Import</a>
            <a href="import_it_proc" id="edit">Import</a>
        </td>  
    </tr>
</table>


<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
<?php echo $this->Paginator->numbers(); ?>


<?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
