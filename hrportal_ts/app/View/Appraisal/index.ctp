<h2 class="demoheaders">Appraisal System</h2>
<?php
echo $this->Form->create('Appraisals', array(
    'url' => '/appraisal/prAppraiserListHtml',
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
<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Appraisal System</h3>
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
               <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br>
                
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Start Date: <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('Appraisals.startdate', array('value' => isset($this->passedArgs['startdate']) ? $this->passedArgs['startdate'] : '')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">End Date: <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('Appraisals.enddate', array('value' => isset($this->passedArgs['enddate']) ? $this->passedArgs['enddate'] : '')); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Employee Name:</label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('Appraisals.emp_name', array('type' => 'text')); ?>
                    </div>
                  </div>
                  
                 
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Status <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                     <?php echo $this->Form->input('ch_status', array('type' => 'select', 'label' => false, 'empty' => 'Select', 'options' => array(''=>'select','OPEN' => 'OPEN', 'APPRAISEE' => 'APPRAISEE', 'APPRAISER' => 'APPRAISER', 'HR' => 'HR', 'COMPLETE' => 'COMPLETE'), 'class' => 'form-control s-form-item s-form-all')); ?>      
                    </div>
                  </div>
                   <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">With <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <?php echo $this->Form->input('appraiser_name', array('type' => 'text')); ?>
                    </div>
                  </div>  
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                      <div align="center" class="submit"><input type="submit" value="Search" class="successButton"></div>
                    </div>
                  </div>
                 <div class="form-group col-md-6 col-sm-6 col-xs-6">
     <div id="tabs" style="width:946px;">
    <ul>
        <?php if(1){ // if ($this->Permission->check('Appraisal/prAppraiseeListHtml')) { ?>
            <li><a href="#ui-tabs-1">As Appraisee</a></li>
        <?php } ?>
        <?php if(1){ // if ($this->Permission->check('Appraisal/prAppraiserListHtml')) { ?>                
            <li><a href="#ui-tabs-2">As Appraiser</a></li>
        <?php } ?>
        <?php if(1){ // if ($this->Permission->check('Appraisal/prHrListHtml')) { ?>
            <li><a href="#ui-tabs-3">As HR</a></li>
        <?php } ?>
    </ul>
    <?php if(1){ // if ($this->Permission->check('Appraisal/prAppraiseeListHtml')) { ?>
    <div id="ui-tabs-1">
        <span class="travel-voucher1"></span>
    </div>
    <?php } ?>
    <?php if(1){ // if ($this->Permission->check('Appraisal/prAppraiserListHtml')) { ?>     
    <div id="ui-tabs-2">
        <span class="travel-voucher1"></span>
    </div> 
    <?php } ?>
    <?php if(1){ // if ($this->Permission->check('Appraisal/prHrListHtml')) { ?>    
    <div id="ui-tabs-3">
        <span class="travel-voucher1"></span>
    </div>
    <?php } ?>
</div>
         <div id="tabid"></div>
    </div>
              </div>
            </div>
          </div>
     
        </div>
         
      </div>
          
   
   
    <?php echo $this->Form->end(); ?>
      <!-- /page content --> 
      
      <!-- footer content --> 
      <!-- <footer>
        <div class="">
          <p class="pull-right">HR Portal by <a href="https://essindia.com/" target="_blank">ESS</a>. | <span class="lead"> <img src="images/ess-logo.png" width="" height="20" alt="Ess Logo"> </span> </p>
        </div>
        <div class="clearfix"></div>
      </footer>--> 
      <!-- /footer content --> 
      
    </div>



<script type="text/javascript">
    jQuery(document).ready(function(){
        
     jQuery("#AppraisalsStartdate").datepicker({
                inline: true,
                changeMonth: true,
                //changeYear: true,
                dateFormat: 'dd-mm-yy'
                
        });
     jQuery("#AppraisalsEnddate").datepicker({
                inline: true,
                changeMonth: true,
                //changeYear: true,
                dateFormat: 'dd-mm-yy'
                
        });
        
        
        jQuery('input[type=submit]').click(function(){
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"></span></div>');
            url = jQuery(this).parents('form:first').attr('action');
            jQuery.post(url,jQuery(this).parents('form:first').serialize(),function(data){
                jQuery('#tabid').html(data);
               
            });
            return false;
        }); 
         $("#tabs").tabs({
         activate: function (event, ui) {
          url =  $($('#tabs ul li a').get(ui.index)).attr('href');
          
                if (url.indexOf('ui-tabs-1')!==-1) url = '<?php echo $this->webroot . 'appraisal/prAppraiseeListHtml'; ?>';
                if (url.indexOf('ui-tabs-2')!==-1) url = '<?php echo $this->webroot . 'appraisal/prAppraiserListHtml'; ?>';
                if (url.indexOf('ui-tabs-3')!==-1) url = '<?php echo $this->webroot . 'appraisal/prHrListHtml'; ?>';
               jQuery('input[type=submit]').parents('form:first').attr('action',url);                    
                if(url.indexOf('prAppraiseeList')!==-1){
                    jQuery('input[type=submit]').parents('form:first').find('th:last').css('width','0px');
                    jQuery('input[type=submit]').parents('form:first').find('th:last').css('display','none');
			
                    jQuery('input[type=submit]').parents('form:first').find('td:last').css('width','0px');
                    jQuery('input[type=submit]').parents('form:first').find('td:last').css('display','none');			
                }else {
                    jQuery('input[type=submit]').parents('form:first').find('th:last').css('width','');
                    jQuery('input[type=submit]').parents('form:first').find('th:last').css('display','');
			
                    jQuery('input[type=submit]').parents('form:first').find('td:last').css('width','');
                    jQuery('input[type=submit]').parents('form:first').find('td:last').css('display','');
                    if(url.indexOf('prHrListHtml')!==-1){
                        jQuery('input[name*=vc_appraiser_name]').parents('tr:first').show();
                        jQuery('input[type=submit]').parents('form:first').find('#AppraisalsChStatus').val('HR');
                    } else {
                        jQuery('input[name*=vc_appraiser_name]').parents('tr:first').hide();
                        jQuery('input[type=submit]').parents('form:first').find('#AppraisalsChStatus').val('OPEN');
                    }                        
                }
               var active = $('#tabs').tabs('option', 'active'); 
               var url = $("#tabs ul>li a").eq(active).attr("href");
               if (url.indexOf('ui-tabs-1')!==-1) url = '<?php echo $this->webroot . 'appraisal/prAppraiseeListHtml'; ?>';
               if (url.indexOf('ui-tabs-2')!==-1) url = '<?php echo $this->webroot . 'appraisal/prAppraiserListHtml'; ?>';
               if (url.indexOf('ui-tabs-3')!==-1) url = '<?php echo $this->webroot . 'appraisal/prHrListHtml'; ?>';
               jQuery.ajax({
                url: url,
                success: function(data){
			
               jQuery('#tabid').html(data);
        }
    });
            }
        });  
        
        jQuery('#generate_app_form').live('click',function(){
            jQuery.post('<?php echo $this->webroot . 'employees/pr_optionlist_html'; ?>',{},function(data){
                generateDialog = jQuery('<div title="Generate Appraisal Form">Select Employee: <select name="data[Appraisals][vc_emp_code]" style="width:150px;" id="AppraisalsVcEmpCode">'+data+'</select></div>');
                generateDialog.dialog({
                    autoOpen: true, 
                    buttons: { 
                        "Cancel": function() { $(this).remove(); }, 
                        "Generate": function() {
                            $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">Generating...</div>');
                            $('#response-message').highlightStyle();
                            $('#response-message').show();                                    
                            jQuery.post(
                            '<?php echo $this->webroot . "appraisal/prGenerateAddJson/"; ?>'+jQuery(this).find('select').val(), 
                            {},
                            function(data){
                                if(data.status==1){
                                    $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                    $('#response-message').highlightStyle();
                                    $('#response-message').show().delay(10000).fadeOut(900);
                                    $('#AppraisalsChStatus').val('');
                                    jQuery('input[type=submit]').trigger('click');
                                    vTipQTip('.travel-voucher1');
                                }
                                if(data.status==0){
                                    $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                    $('#response-message').errorStyle();
                                    $('#response-message').show().delay(10000).fadeOut(900);                                                            
                                }
                            },
                            'json'
                        );
                            $(this).remove();
                        } 
                    }            
                });                
            },'html');
        });
      
    });
</script>



