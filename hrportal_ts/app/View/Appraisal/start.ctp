<h2 class="demoheaders">Start Appraisal Process</h2>
<?php
echo $this->Form->create('Appraisals', array(
    'url' => '/appraisal/prStartEditHtml',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);
?>
<?php
$dept_code = $appraisalRequest['Appraisals']['dept_code']; 

$desg_code = $appraisalRequest['MyProfile']['desg_code']; 
//$checllvl = $this->Common->findcheckLevelappraisal('4',$dept_code,'01');
        
$emp_code = $appraisalRequest['Appraisals']['emp_code'];


$review_degree = $appraisalRequest['Appraisals']['review_degree'];

if($review_degree == 1){
    
   $peerlist = $this->Common->peerlist($emp_code); 
}


 
     $fwemplist = $this->Common->findAppraisalRep($emp_code,'01'); 
  
 ?>
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
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Basic Details</h2>
                
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br>
                <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">First Name <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $appraisalRequest['MyProfile']['emp_firstname']; ?>
                        <?php echo $this->Form->hidden('Appraisals.id', array('value'=>$appraisalRequest['Appraisals']['id'])); ?>
			<?php echo $this->Form->hidden('Appraisals.emp_code', array('value'=>$appraisalRequest['Appraisals']['emp_code'])); ?>
                   
                    </div>
                  </div>
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Period</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('Appraisals.dt_fromDate', array('type'=>'text','autocomplete'=>'off','size'=>'10','value'=>date('Y-m-d',strtotime($appraisalRequest['Appraisals']['dt_fromDate'])),'class'=>'form-control col-md-7 col-xs-12')); ?> To 
                      <?php echo $this->Form->input('Appraisals.dt_toDate', array('type'=>'text','autocomplete'=>'off','size'=>'10','value'=>date('Y-m-d',strtotime($appraisalRequest['Appraisals']['dt_toDate'])),'class'=>'form-control col-md-7 col-xs-12')); ?>
                   
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Appraisal Type</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <?php echo $this->Form->input('Appraisals.app_type', array('style' => 'width:150px;', 'type' => 'select', 'options' => array('1' => 'First Two', '2' => 'After Two'), 'selected' => $appraisalRequest['Appraisals']['app_type'],'class'=>'form-control col-md-7 col-xs-12')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12"> Effective From </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('Appraisals.dt_appraisal', array('type' => 'text', 'value' => date('Y-m-d',strtotime($appraisalRequest['Appraisals']['dt_appraisal'])),'class'=>'form-control col-md-7 col-xs-12')); ?>                
                    </div>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    
                  </div>
                  <div class ="col-md-8">
                  <h2> HR Factor </h2>  
                  <hr/>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Department *</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('Appraisals.dept_code', array('class'=>'form-control col-md-7 col-xs-12', 'type' => 'select', 'options' => $departments, 'selected' => $appraisalRequest['Appraisals']['dept_code'])); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Date of Joining *</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <?php echo $this->Form->input('dt_join', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text', 'value' => date('Y-m-d',strtotime($appraisalRequest['Appraisals']['dt_join'])))); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Experience With ESS (In months)*</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('ess_exp', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text', 'value' => $appraisalRequest['Appraisals']['ess_exp'])); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Total Experience *</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('tot_exp', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text', 'value' => $appraisalRequest['Appraisals']['tot_exp'])); ?>
                    </div>
                  </div> 
                 
                 
                 <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Amount of last Appraisal *</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php echo $this->Form->input('amt_lst_inc', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text', 'value' => $appraisalRequest['Appraisals']['amt_lst_inc'])); ?>
                    </div>
                  </div> 
                 
                 <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Category *</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <?php echo $this->Form->input('slab_category_id', array('class'=>'form-control col-md-7 col-xs-12', 'type' => 'select', 'options' => $categories, 'selected' => 1)); ?>
                    </div>
                  </div> 
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="heard" class="control-label col-md-4 col-sm-4 col-xs-12">Remark</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('amt_cu', array('class'=>'form-control col-md-7 col-xs-12','type' => 'text', 'maxlength'=>'100')); ?>
                    </div>
                  </div> 
                
                    
<!--                <div class="x_content">
                <h2> SALARY OF PEER GROUP</h2>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <tr class="head">
                    <th colspan="2">
                        
                    </th>
                    <th>
                        AVERAGE
                    </th>
                    <th>
                        MINIMUM 
                    </th>
                    <th>
                        MAXIMUM
                    </th>                    
                </tr>
                <tr class="cont">
                    <td rowspan="2">
                        This Appraisal
                    </td>
                    <td>
                        Rating
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.rating_avg",array('autocomplete'=>'off','type'=>'select','options'=>$performance));?>
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.rating_min",array('autocomplete'=>'off','type'=>'select','options'=>$performance));?>
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.rating_max",array('autocomplete'=>'off','type'=>'select','options'=>$performance));?>
                    </td>
                </tr>
                <tr class="cont">
                    <td>
                        Salary
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.sal_avg"); ?>
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.sal_min"); ?>
                    </td>
                    <td>
                        <?php echo $this->form->input("Appraisals.nu_sal_max"); ?>
                    </td>
                </tr>                
                <?php foreach ($appraisalRequest_last_five as $appraisal_one_of_five) { ?>
                <tr class="cont">
                    <td rowspan="2">
                        last Appraisal
                    </td>
                    <td>
                        Rating
                    </td>
                    <td>
                        <?php echo $performance[$appraisal_one_of_five['Appraisals']['rating_avg']]; ?>
                    </td>
                    <td>
                        <?php echo $performance[$appraisal_one_of_five['Appraisals']['rating_min']]; ?>
                    </td>
                    <td>
                        <?php echo $performance[$appraisal_one_of_five['Appraisals']['rating_max']]; ?>
                    </td>
                </tr>
                <tr class="cont">
                    <td>
                        Salary
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['sal_avg']; ?>
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['sal_min']; ?>
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['sal_max']; ?>
                    </td>
                </tr>
                <?php } ?>
                   </table>
                  </div>-->
                   <div class="x_content">
                     <h2>Appraisal History</h2>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    
                     
                <tr class="head">
                    <th>
                        Period of Appraisal
                    </th>
                    <th>
                        Rating
                    </th>
                    <th>
                        Salary before appraisal
                    </th>
                    <th>
                        Increment Amount 
                    </th>
                    <th>
                        Remark
                    </th>                    
                </tr>
                    
                  </thead>
                  <tbody>
                    
                <?php $j=0; ?>
                <?php if(empty($appraisalRequest_last_five)){?>   
                 
                 <tr class="even pointer">
                            <td style="text-align:center;" colspan="11">
                                    <em>-- NO Appraisal History Found --</em>
                            </td>
                </tr>
                <?php } ?>
                 
                <?php foreach ($appraisalRequest_last_five as $appraisal_one_of_five) { ?>
                <tr class="cont<?php echo ($j%2)?'':'1' ?>">
                    <td>
                        <?php echo date('Y-m-d',strtotime($appraisal_one_of_five['Appraisals']['dt_fromDate'])); ?>
                         To 
                        <?php echo date('Y-m-d',strtotime($appraisal_one_of_five['Appraisals']['dt_toDate'])); ?>
                    </td>
                    <td>
                        <?php echo  (isset($performance[$appraisal_one_of_five['Appraisals']['rating']]))?$performance[$appraisal_one_of_five['Appraisals']['rating']]:$appraisal_one_of_five['Appraisals']['rating']; ?>
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['gross_sal']; ?>
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['amt_inc']; ?>
                    </td>
                    <td>
                        <?php echo $appraisal_one_of_five['Appraisals']['remark']; ?>
                    </td>                    
                </tr> 
                <?php $j++; ?>
                <?php } ?>
                   </tbody>
                   </table>
                  </div>  
                  <div class="ln_solid"></div>
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Appraiser <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('Appraisers.emp_code_appraiser', array('autocomplete'=>'off', 'type' => 'select', 'options' => $fwemplist,'class'=>'form-control col-md-7 col-xs-12')); ?>
                    </div>
                  </div>
               
                 <?php if(!empty($peerlist)){?>   
                   <div class=" form-group col-md-12 col-sm-12 col-xs-12">
                    <label for="heard" class="control-label col-md-2 col-sm-4 col-xs-12">Select Peer List</label>
                    <div class = "col-md-8 col-sm-8 col-xs-8 ">
                      <select multiple  class="form-control" name="peer[]" id="peer">
                        <?php foreach($peerlist as $k=>$val){ ?>
                        <option value='<?php echo $k?>'><?php echo $val ?></option>
                       <?php } ?>
                      </select>
                    </div>
                 </div> 
                 <?php } ?>  
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                     <input class="form-control btn btn-success" type="Submit" name="appraisal_start" id="appraisal_start" value="Start Appraisal"/>
                    </div>
                        
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
<?php echo $this->form->end(); ?>



<script language="javascript" type="text/javascript">
    
    jQuery(document).ready(function(){
      
        jQuery('input[name*="[dt_"]').datepicker({'dateFormat':'yy-mm-dd','changeYear':true,'changeMonth':true});
        jQuery('#AppraisalsNuSlabCategoryId, #AppraisalsVcDeptCode, #AppraisalsVcDesgCode').change(function(){
            var dept = $('#AppraisalsVcDeptCode').val();
            var desg = $('#AppraisalsVcDesgCode').val();
            var cat = $('#AppraisalsNuSlabCategoryId').val();
            $.get('<?php echo $this->webroot;?>appraisal/prSlabViewText/'+dept+'/'+desg+'/'+cat,function(data){
                $('td:contains(Applicable Slab)').siblings('td').html(data);
            });
        });
        jQuery('#AppraisalsNuSlabCategoryId, #AppraisalsVcDeptCode, #AppraisalsVcDesgCode').trigger('change');
        jQuery('#AppraisalsDtTodate').change(function(){
            var s = jQuery(this).val().split('-');
            if (s[0].length === 2) {
              s[0] = '20' + s[0];
              jQuery(this).val(s.join('-'));
              return;
            }
            var d = new Date(s[0], parseInt(s[1])-1, parseInt(s[2])+1, 0, 0, 0, 0);
            jQuery('#AppraisalsDtAppraisal').datepicker("setDate",d);
        });
        
        jQuery('#AppraisalsChEmpType').change(function(){
            if(jQuery(this).val()=='MANAGER'){
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').hide();
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').find('input').attr('disabled', 'disabled');
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').find('select').attr('disabled', 'disabled');
            }else{
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').find('input').removeAttr('disabled');
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').find('select').removeAttr('disabled');                
                jQuery('th:contains(SALARY OF PEER GROUP)').parents('table.exp-voucher:first').show();
            }
        });
    });
</script>
