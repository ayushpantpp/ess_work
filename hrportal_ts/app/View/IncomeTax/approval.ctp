<style>

    .ForwardLeave{  color: #329ACF; font-weight:bold;}
    .PendingLeave{ color: #DF8040; font-weight:bold;}
    .RejectedLeave{ color: #CC0001; font-weight:bold;}
    .OpenLeave{ color: #00f303; font-weight:bold;}
    .ApprovedLeave{ color: #006300; font-weight:bold;}
    .RevertdLeave{ color: #9804F0; font-weight:bold;}
</style>

<?php $i=0; ?>

<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" href="#">×</a>
    <div class="HRcontent big-table"> </div>
  </div>
</div>
<div class="right_col" role="main">
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
          <h2>Income Tax Declaration Pending For Approval </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
            </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
            

     <div class="x_content">

            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title">Sr.No </th>
                  <th class="column-title">Employee Name </th>
                  
                  <th> Action </th>
                 </tr>
              </thead>
              <tbody>

                  <?php if(empty($list)) { ?>
                <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                        <em>--No Records Found--</em>
                </td>
                </tr>
              <?php } ?>

             <?php foreach($list as $srcdet)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                        <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                        <td><?php  echo $this->Common->getempinfo($srcdet['EmpInvestDtl']['emp_code']); ?></td>
                        
                        <td><a href="#popup1" class="btn btn-primary btn-xs" onclick="Get_Details('<?php echo $srcdet['EmpInvestDtl']['emp_invest_id']; ?>')" class="view vtip" title="Click to View.">View</a>
                       <a href="<?php echo $this->webroot.'incometax/saveinfo/'
                            .base64_encode($srcdet['EmpInvestDtl']['emp_invest_id']);?>" class="btn btn-primary btn-xs" title="Click to View.">Approve</a>
                       <a href="<?php echo $this->webroot.'incometax/reject/'
                            .base64_encode($srcdet['EmpInvestDtl']['emp_invest_id']);?>" class="btn btn-primary btn-xs"  class="view vtip" title="Click to View.">Reject</a>
                        </td>
                           
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
 </div>
</div>
</div>
<!--<div class="navigation">
     <?php echo $this->Paginator->counter(); ?> Pages
     <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
     <?php echo $this->Paginator->numbers(); ?>
     <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div>-->

  </div>
  </div>
 </div>

<script type="text/javascript">
function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>incometax/detailView/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
 }


   
    </script>