
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
   
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent"> </div>
  </div>
</div>
<!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>FNF Details</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_content"> <br />

                  <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                      <th>Sr.No</th>
                      <th>Pending task</th>
                      <th>Assignee</th>
                      <th>Status</th>
                      <th>Approver's remark</th>
                    </tr>
                  </thead>
                    <?php 
                    $ctr =1;
                    foreach ($fnfs['FnfDetail'] as $value) {

                      ?>
                    <tr>
                      <td><?php echo $ctr;?></td>
                      <td><?php echo $value['Project']['name'];?></td>
                      <td><?php echo $value['MyProfile']['emp_name'];?></td>
                      <td><?php echo $this->Common->findSatus($value['status']);?></td>
                      <td><?php echo ($value['approver_remark'])?$value['approver_remark']:'NA';?></td>
                      
                    </tr>
                    <?php $ctr++;
                    }?>
                  <tbody>
                    
                  </tbody>
                  </table>
                  <div class="col-md-12"> 
                  
                  <?php if(!isset($fnfs['Fnf']['status']) ) { ?>
                    <a class="btn btn-success" href="<?php echo $this->Html->url('/separations/add');?>"> Apply for separations first</a>
                  <?php }
                  else { 
                    ?> 
                    <label class="control-label"> FNF status :</label>
                    <?php echo $this->Common->findSatus($fnfs['Fnf']['status']);?><br/>
                  <?php if($fnfs['Fnf']['status'] == 1) { /*
                    echo $this->Html->link('Edit', array('action'=>'fnf_edit',$fnfs['Fnf']['id']));*/
                    ?>
                    <!--  <a class="btn btn-success" href="<?php echo $this->Html->url('/fnfs/fnf_edit/').$fnfs['Fnf']['id'];?>"> Edit</a> -->
                    <?php
                   }

                  }
                  ?>
                  </div>
                  <a class="btn btn-success" href="<?php echo $this->Html->url('/fnfs/approve_fnf/').$fnfs['Fnf']['id'];?>"> Approve FNF</a> 
                  <!-- <a class="btn btn-danger" href="<?php echo $this->Html->url('/fnfs/reject_fnf/').$fnfs['Fnf']['id'];?>"> Reject FNF</a> -->
                   <a href="#popup1" class="btn btn-danger" onclick="Get_Details('<?php echo $fnfs['Fnf']['id']; ?>')"  title="Click to Reject.">Reject FNF</a>
                  <div class="ln_solid"></div>
                </div>
            </div>
          </div>
        </div>
 
      </div>


<script type="text/javascript">
  function approve_fnf(fnf_id) {
    alert('Approved'+fnf_id);
  } 

  function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>fnfs/rejectId/'+id,
        success: function(data){
			//alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
 }
</script>