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
          <h2>List of Employees </h2>
          
          <div class="clearfix"></div>
        </div>
            

          <div class="x_content">
            <?php echo $this->Form->create('medicalConfig', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'Users', 'action' => 'medicalConfig'), 'id' => 'pendingDocuments', 'name' => 'pendingDocuments'));
             ?>
            <table class="table table-striped responsive-utilities jambo_table bulk_action">
              <thead>
                <tr class="headings">
                  <th class="column-title">Sr.No </th>
                  <th class="column-title">Employee Name </th>
                  <th class="column-title">Employee ID </th>
                  <th class="column-title">Employee Code </th>
                  <th class="headings"><input type="checkbox" class="allpendingDocs" id="allCheck" placeholder="Select All"></th>  
                 </tr>
              </thead>
              <tbody>

                  <?php if(empty($emp)) { ?>
                <tr class="even pointer">
                <td style="text-align:center;" colspan="11">
                        <em>--No Records Found--</em>
                </td>
                </tr>
              <?php } ?>

             <?php foreach($emp as $key=>$val)  {
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
               <tr class="even pointer">
                        <td><?php echo $i+1;//echo $srcdet['MstEmpExpVoucher']['voucher_id'];?></td> 
                        <td><?php  echo $this->Common->getempinfo($val['MyProfile']['emp_code']); ?></td>
                        <td><?php  echo $val['MyProfile']['emp_id']; ?></td>
                        <td><?php  echo $val['MyProfile']['emp_code']; ?></td>
                        <td><?php echo $this->Form->input('pending_docs.'.$key, array('type' => 'checkbox','class' => 'pendingDocs')); ?><?php echo $this->Form->input('pending_docs_vl.'.$key, array('type' => 'hidden','value'=>$val['MyProfile']['id'])); ?></td>
                         
              </tr>
             <?php $i++ ;} ?>
            </tbody>
            </table>
<div class="form-group col-md-6 col-sm-6 col-xs-6">
<div class="col-md-2 col-sm-32 col-xs-3 ">

<?php echo $this->Form->submit('Enable', array('name'=>'settingsave','class'=>'btn btn-success')); ?>

</div>
<div class="col-md-2 col-sm-8 col-xs-12">

<?php echo $this->Form->submit('Disable', array('name'=>'settingsave','class'=>'btn btn-success')); ?>

</div>   
 <div class="col-md-3 ">    
 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Users/dashboard/" title="Click to Cancel.">Cancel</a>
 </div>						
 </div>             
 </div><?php $this->Form->end(); ?>
           <div class="navigation navigation-left" >
            <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
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
<script>
    jQuery(document).ready(function () {
        jQuery(".allpendingDocs").change(function () {
            jQuery(".pendingDocs").prop('checked', jQuery(this).prop("checked"));
        });
    });
</script>
