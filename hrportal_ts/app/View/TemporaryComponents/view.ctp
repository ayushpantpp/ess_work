<style>
    .ForwardLeave{  color: #329ACF; font-weight:bold;}
    .PendingLeave{ color: #DF8040; font-weight:bold;}
    .RejectedLeave{ color: #CC0001; font-weight:bold;}
    .OpenLeave{color: #00f303; font-weight:bold;}
    .ApprovedLeave{color: #006300; font-weight:bold;}
    .RevertdLeave{color: #9804F0; font-weight:bold;}
</style>
<div class="uk-width-medium-1-2">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>
            <div class="uk-overflow-container">
                <span id="tmpDetails" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
<?php $i=0; ?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Temporary Amount Claim Details ( <span><?php  echo $emp_name;?> <span> </span><span><?php echo $lastname;?></span> - <span><?php echo $emp_id; ?></span></span>) </h3>
      <?php echo $flash = $this->Session->flash(); ?>   
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>   
				    <th>Sr.No</th>                  
				    <th>Employee Name </th>
				    <th>Created Date</th>
				    <th>Status</th>
				    <th>Remark</th>
				    <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
 
                            <?php if (empty($temp)) { ?>
                                <tr class="even pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>

                           
             <?php foreach($temp as $srcdet)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';
                    //echo "<pre>";
                    //print_r($temp);
                    //die;
                    ?>
               <tr class="even pointer">
                        <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td>                            
                        <td><?php echo $emp_name." ".$lastname;?></td>
                        <td><?php echo date('d-m-Y', strtotime($srcdet['EmployeeSalMon']['created_at'])); ?></td>
                        <?php if($srcdet['EmployeeSalMon']['status']== 1){?>
                         <td><span class="OpenLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 2){ ?>
                        <td><span class="ForwardLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 3) {?>
                          <td><span class="RevertdLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 4){?>
                           <td><span class="RejectedLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } elseif($srcdet['EmployeeSalMon']['status']== 5){?> 
                           <td><span class="ApprovedLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php } else{?>  
                        <td><span class="PendingLeave"><?php echo $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?></span></td>
                        <?php }?> 
                        <?php  if(!empty($srcdet['EmployeeSalMon']['remark'])){?>
                        <td><?php echo $srcdet['EmployeeSalMon']['remark']; ?></td>
                        <?php } else { ?>
                        <td>N/A</td>    
                        <?php }?>    
                        
                       
                        
                        <td> 
                        <a data-uk-modal="{target:'#modal_overflow'}" href="#popup1" onclick="Get_Details('<?php echo $srcdet['EmployeeSalMon']['id']; ?>')" title="Click to View." class="uk-badge uk-badge-success">View Details</a>    
                        <?php $status= $this->Common->findSatus($srcdet['EmployeeSalMon']['status']);?>

                        <?php  if($status == 'Parked'  ) {?>
                            <a href="<?php echo $this->webroot;?>temporaryComponents/workflow_display/<?php echo $srcdet['EmployeeSalMon']['id'];?>/<?php echo $srcdet['EmployeeSalMon']['voucher_id'];?>" title="Click to Forward." class="uk-badge uk-badge-warning">Forward</a>
							<a href="<?php echo $this->webroot;?>temporaryComponents/delete/<?php echo $srcdet['EmployeeSalMon']['id'];?>/<?php echo $srcdet['EmployeeSalMon']['voucher_id'];?>" title="Click to Delete." class="uk-badge uk-badge-danger" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
	                  
                        <?php } ?>  
                        </td>
                           
              </tr>
             <?php $i++ ;} ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
<?php
echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
?>
                        </ul>
                    </div>

                </div>

            </div>

            <div id="container" ></div>

        </div>

<script type="text/javascript">
function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>TemporaryComponents/detail_view/'+id,
        success: function(data){
        jQuery('#tmpDetails').html(data);
        }
    });
 }   
</script> 

<script type="text/javascript">
$(function () {

    $('#container').highcharts({
        chart: {
            type: 'column',
            margin: 75,
            options3d: {
                enabled: true,
                alpha: 10,
                beta: 25,
                depth: 70
            }
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            column: {
                depth: 25
            }
        },
        xAxis: {
            categories: ['Dialy Allowance','Conveyanace Expense','Miscellaneous Expense','Client Expense','Stay Expense','other Expense']
        },
        yAxis: {
            title: {
                text: null
            }
        },
        series: [{
            name: 'Applied  Leaves',
            data: [<?php echo $leavetype?>]
        }]
    });
			
		});
    </script>
