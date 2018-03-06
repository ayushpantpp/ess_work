<?php $auth = $this->Session->read('Auth'); ?>
<table class="uk-table uk-table-no-border">
   <?php
  
    
   
    $i = 1;
    foreach ($req as $rdetail) {

     
        ?> 
        <tr class="even"><td><?php echo $i; ?></td><td>Position Name :</td><td><?php echo $rdetail['position_name'];?></td></tr>
        <tr class="odd"><td></td><td>Location :</td><td><?php  echo$this->Common->findLocationnameByCode($rdetail['location_name']); ?></td></tr>
        <tr><td></td><td>Requisition Status :</td><td><?php echo $this->Common->findSatus($rdetail['status']); ?></td></tr>		
        <?php
         $getlvl = $this->Common->getreqlevelbylvid($rdetail['id']);

         $level=count($getlvl);
         

       $i++;
    } if (empty($level))
        $sanDate = '';
    else
        $sanDate = date('d-M-Y', strtotime($level));
    ?>    
    <tr><td></td><td>Requisition Raised Date  : </td><td><?php echo date('d-M-Y', strtotime($rdetail['created_date'])); ?></td></tr>
    <tr><td></td><td>RequisitionSanction date : </td><td><?php if($rdetail['modified_date']!='0000-00-00'){echo date('d-M-Y', strtotime($rdetail['modified_date']));}else{  }?></td></tr>
    <?php if(!empty($getlvl))
    {?>
    <tr><th colspan="3">Workflow Detail</th>
	</tr>
	<tr><th>Level</th><th>Employee Name</th><th>Forward/Approved Date</th><th>REMARKS</th></tr>
	 <?php
      $j = 1;

      //$getlvl = $this->Common->getreqlevelbylvid($rdetail['req_id']);


  foreach($getlvl as $v)
  {

                               
                     ?>
							<tr class="<?php echo $class; ?>">
                            <td ><?php echo "Level-" . $j; ?> </td>
                            <td ><?php echo $this->Common->getempinfo($v['RequirementWorkflow']['emp_code']);?></td>
                            <td >
                                                <?php
                                                if ($v['RequirementWorkflow']['fw_date']!='0000-00-00') {
                                                    echo date('d-M-Y', strtotime($v['RequirementWorkflow']['fw_date']));
                                                } else if (!empty($v['RequirementWorkflow']['approval_date'])) {
                                                    echo date('d-M-Y', strtotime($v['RequirementWorkflow']['approval_date']));
                                                } else {
                                                    echo "Pending ";
                                                }
                                                ?> 
                    </td>
 <td ><?php echo $v['RequirementWorkflow']['remark'] ?> </td>
	</tr>
	 <?php $j++; } ?>

</table>
<?php }?>