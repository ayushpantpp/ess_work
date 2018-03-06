<?php

$i=0; ?>

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Income Tax Declaration Details</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
             <?php echo $this->Form->create('pendingDocuments', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'income_tax', 'action' => 'editConfig'), 'id' => 'pendingDocuments', 'name' => 'pendingDocuments'));
                ?>
                <div class="uk-overflow-container">
                    <table class="uk-table uk-text-nowrap table table-striped responsive-utilities jambo_table bulk_action hr_inctax">
                        <thead>
                            <tr>

                                <th>Sr.No </th>
                                <th class="headings">
                                    <input type="checkbox" class="allpendingDocs" id="allCheck" placeholder="Select All"></th>  
                                <th>Employee Name </th>
                                <th> Financial Year  </th>
                                <th> Location</th>
                               <!-- <th> Status</th>-->
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>

                  <?php if(empty($incometax)) { ?>
                            <tr class="cont">
		              <td style="text-align:center;" colspan="6">
		                  <em>--No Records Found--</em>
		              </td>
		          </tr>
              <?php } ?>

             <?php 
             $p = 1;
             foreach($incometax as $key => $val)  {
                  $ctr = (($this->params['paging']['EmpInvest']['page']*$this->params['paging']['EmpInvest']['limit'])-$this->params['paging']['EmpInvest']['limit'])+$p;
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
                            <tr class="even pointer">
                                <td><?php echo $ctr;//echo $val['MstEmpExpVoucher']['voucher_id'];?></td> 
                                <td><?php echo $this->Form->input('pending_docs.'.$key, array('type' => 'checkbox','class' => 'pendingDocs')); ?><?php echo $this->Form->input('pending_docs_vl.'.$key, array('type' => 'hidden','value'=>$incometax[$key]['EmpInvest']['id'])); ?></td>
                                <td><?php  echo $this->Common->getempinfo($val['EmpInvest']['emp_code']); ?></td>
                                <td><?php echo $this->Common->findfyDesc( $val['EmpInvest']['Fy_id']); ?></td>
                                <td><?php if($val['EmpInvest']['loc_type'] == 'N'){echo 'Non Metro';}else {echo 'Metro';}  ?></td>

                                <!-- <?php if($val['EmpInvest']['invest_status']== 1){?>
                                 <td><span class="OpenLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php } elseif($val['EmpInvest']['invest_status']== 2){ ?>
                                <td><span class="ForwardLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php } elseif($val['EmpInvest']['invest_status']== 3) {?>
                                  <td><span class="RevertdLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php } elseif($val['EmpInvest']['invest_status']== 4){?>
                                  <td><span class="RejectedLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php } elseif($val['EmpInvest']['invest_status']== 5){?> 
                                  <td><span class="ApprovedLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php } else{?>  
                                <td><span class="PendingLeave"><?php echo $this->Common->findSatus($val['EmpInvest']['invest_status']);?></span></td>
                        <?php }?>-->         

                                <td>
                                    <a data-uk-modal="{target:'#modal_overflow'}"  class="uk-badge uk-badge-success btn btn-primary btn-xs" onclick="Get_Details('<?php echo $val['EmpInvest']['id']; ?>')" title="Click to View.">Detailed View</a>
                                   <!-- <span><?php if($val['EmpInvest']['invest_status']!= 4){?><a href="<?php echo $this->webroot;?>incometax/editHr/<?php echo base64_encode($val['EmpInvest']['id']);?>/" class="btn btn-primary btn-xs"  class="view vtip" title="Click to View.">Edit</a><?php }?></span>-->
<?php
if($fin_check==0){}else{
?>
                                    <span><?php if($val['EmpInvest']['config']== 0){?><a href="<?php echo $this->webroot;?>income_tax/Configure/<?php echo base64_encode($val['EmpInvest']['id']);?>/" class="uk-badge uk-badge-success btn btn-primary btn-xs"  class="view vtip" title="Click to Enable.">Enable</a><?php }?></span>
                                    <span><?php if($val['EmpInvest']['config']== 1){?><a href="<?php echo $this->webroot;?>income_tax/ReConfigure/<?php echo base64_encode($val['EmpInvest']['id']);?>/" class="uk-badge uk-badge-success btn btn-primary btn-xs"  class="view vtip" title="Click to Disable.">Disable</a><?php }?></span>
<?php
}
?>
                                </td>

                            </tr>
             <?php $i++ ;$p++;} ?>
                        </tbody>
                    </table>
                </div>

        <?php
if($fin_check==0){}else{
?>
        <div class="uk-grid">
                    <div class="uk-width-medium-1-6 uk-margin-top">
                            <?php echo $this->Form->submit('Enable', array('name'=>'settingsave','id'=>'ena_settingsave','class'=>'md-btn md-btn-success btn btn-success')); ?>
                    </div>
                    <div class="uk-width-medium-1-6 uk-margin-top">
<?php echo $this->Form->submit('Disable', array('name'=>'settingsave','id'=>'dis_settingsave','class'=>'md-btn md-btn-primary btn btn-success')); ?>
                    </div>
<?php

}
?>
                    <div class="uk-width-medium-1-6 uk-margin-top">
                        <a class="md-btn btn btn-primary" href="<?php echo $this->webroot;?>income_tax/investment_financial/" title="Click to Cancel.">Cancel</a>					
                    </div>
                </div>

                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">


 <?php $this->Paginator->options(array('url'=> array('controller' => 'IncomeTax',
                                  'action'=>'hrView','slug'=>$fy_year),
                                  'convertKeys' => array('page','slug')));?> 
      <?php echo $this->Paginator->counter(); ?> Pages
     
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                        </ul>
                    </div>
                </div>

            <?php $this->Form->end(); ?>
                <div class="clearfix"></div>
            </div>
        </div>


    </div>
</div>
</div>

<script type="text/javascript">
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>income_tax/detailView/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }



</script>
<script>
    jQuery(document).ready(function () {


jQuery( "#dis_settingsave" ).click(function() {

if(jQuery(".hr_inctax input[type='checkbox']:checked").length==0){
	 alert("Please select a record.");return false;
}
	  
});

jQuery( "#ena_settingsave" ).click(function() {
//alert(jQuery(".hr_inctax input[type='checkbox']:checked").length);
if(jQuery(".hr_inctax input[type='checkbox']:checked").length==0){
	 alert("Please select a record.");return false;
}
	  
});


        jQuery(".allpendingDocs").change(function () {
            jQuery(".pendingDocs").prop('checked', jQuery(this).prop("checked"));
        });
    });
</script>
