<script type="text/javascript">
    function getemployee()
    {  document.emplist.submit();
    }
    </script>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>

            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
           
        </ul>
    </div>
</div>

<h2 class="demoheaders"> Designation Wise Rate</h2>


<?php echo $form->create('emp_list', array('url' => array('controller' => 'Timesheet', 'action' => 'emplist'), 'id' => 'emplist','name'=>'emplist')); ?>

<div class="travel-voucher1">
    <div class="input-boxs">

                <table width="100%" cellspacing="5" cellpadding="5" border="0">
                    <tbody><tr>
                        <td nowrap="nowrap" align="center" id="error_div" colspan="10"></td>
                    </tr>
                    <tr>
                        <th> Region </th>
                     <td> <?php echo $form->input('Timesheet_emplist.region', array('type' => 'select', 'label' => false, 'options' => $Region, 'default' => '', 'onChange' => "getemployee()")); ?></td>
                   </tr>
           
                    </tbody></table>
            </div>
    
<div class="input-boxs">

<?php if(count($empetail)>0) { ?>
<div class="travel-voucher1">

<table  frame="void" width="100%" align="center" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">

  <thead class="vrTableHeader">
  <tr class="head">
   <th>S.No</th>
   <th>Employee ID</th>
   <th>Employee Name</th>
   </tr>
  </thead><tbody>
<?php //$empetail = Set::sort($empetail, '{n}.vc_emp_id', 'asc');


$empetail = Set::sort($empetail, '{n}.vc_emp_name', 'desc');

//pr($empetail);
?>

<?php $i=0; foreach($empetail as $emp_det) {?>
<tr class="cont1">
   <td><?php echo $i+1;?></td>
   <td><?php echo $emp_det[0]['vc_emp_id'];?></td>
   <td>
   <?php echo $emp_det[0]['vc_emp_name'];?>
   </td>
</tr>

<?php $i++; } ?>
 

</table>

<?php  } else { ?>

	<h2 class="demoHeaders" style="color:red;" ></h2>
		<div class="ui-widget">

	<div class="ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0pt 20em; margin-left: 0px;">
				<marquee><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
				<strong></strong> No Employee Found.</p>
			</div></marquee>
		</div>
    <?php } ?>
</div>

</div>

</div>
 
	
<?php $form->end(); ?>