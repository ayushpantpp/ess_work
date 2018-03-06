<script type="text/javascript">
$(document).ready(function () {
     $("#chkAll").click(function () {
         $(".chk").attr("checked", $("#chkAll").attr("checked"));
     });
     var reqID = $('#reqestID').val();
   
     $('#reguest_id').val(reqID);

     $("#add_trainee").click(function () {
         if ($('input[type=checkbox]').is(':checked')) {
             if (confirm("Are you sure ? ")) {
		
             } else {
                 return false;
             }
         } else {
             alert('Please select at least one record.');
             return false;
         }
     });
	 
 });
 </script>
 <?php echo $this->Form->create('TrainingMaster', array('url' => array('controller' => 'trainingmasters', 'action' => 'add_more_trainees'),'name'=>'add_trainee_form'));
  echo $this->Form->input('TrainingMaster.nu_request_id', array('type' =>'hidden','id'=>'reguest_id','value'=>$requestid));
?>
 <div class="" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
           
          </div>
          <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
             
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 col-sm-12 col-xs-12">
    
      <div class="x_panel">
        <div class="x_title">
          <h2>Add Trainees</h2>
          
          <div class="clearfix"></div>
        </div>
            
    
     <div class="x_content">
         <div style="width:100%; float:left;overflow-x:scroll ">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="headings">

                  <th width="3%" height="30"><input type="checkbox" value="1" id="chkAll" name="data[chkAll]"></th>
                    <th width="9%" height="30"><strong>Employee Code</strong></th>
                    <th width="19%" height="30"><strong>Employee Name</strong></th>
                    <th width="20%" height="30"><strong>Designation</strong></th>
                    <th width="12%" height="30"><strong>Department</strong></th>
                </tr>
              </thead>
              <tbody>

                  <?php 
			$mgrcode = $_SESSION['Auth']['MyProfile']['emp_code'];
			$mgrname = $_SESSION['Auth']['MyProfile']['emp_firstname'];
		?>
			<td><input type="checkbox" value="<?php echo $mgrcode;?>" class="chk" name="data[vc_emp_code][]"></td>
			<td><?php echo $mgrcode;?></td>
			<td><?php echo $mgrname;?>
			<td><?php echo $this->traininghlp->getDesg($mgrcode);?></td>
			<td><?php echo $this->traininghlp->getDept($mgrcode);?></td>
		 </tr>
		<?php
		 $i = 1;
		 foreach ( $data as $emp_code => $emp_name ){ 
			if($i%2==0){
			   $class = 'cont1';			
			}else{
			   $class  = 'cont';
			}
		?>
	    <tr class="<?php echo $class;?>">
			<td><input type="checkbox" value="<?php echo $emp_code;?>" class="chk" name="data[vc_emp_code][]"></td>
			<td><?php echo $emp_code;?></td>
			<td><?php echo $emp_name;?>
			<td><?php echo $this->traininghlp->getDesg($emp_code);?></td>
			<td><?php echo $this->traininghlp->getDept($emp_code);?></td>
		 </tr>
		  <?php $i++;
		   }
		 ?>
            </tbody>
            </table> </div>
 </div>
</div>
</div>
 <div class="col-md-5">
<?php
        echo $this->Form->submit(__('Approve & Move Forward',true),array('name'=>'data[AddMore]','class'=>'btn btn-primary','id'=>'add_trainee')); 
?>
</div>	  
  <?php echo $this->Form->end(); ?>
  </div>
  </div>
 </div>


 
 
 
 
