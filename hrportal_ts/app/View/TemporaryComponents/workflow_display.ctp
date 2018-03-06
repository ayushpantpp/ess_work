<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Temporary Component Work Flow</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
 <?php echo $this->Form->create('fwtempcomp', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
           'url' => array('controller' => 'temporaryComponents', 'action' => 'saveinfomation'), 'id' => 'fwtempcomp', 'name' => 'fwtempcomp'));
        ?>

                 <?php
                  $dept_code = $_SESSION['Auth']['MyProfile']['dept_code'];
                  $comp_code = $_SESSION['Auth']['MyProfile']['comp_code'];
    
                  $fwemplist = $this->Common->findLevel();


?>




                <div class="md-card-content" data-uk-grid-margin>
                    <div class="uk-overflow-container" role="main">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="x_content">
					 
					<div data-uk-grid-margin="" class="uk-grid">
						<div class="uk-width-medium-1-2 uk-row-first">
						    <div class="parsley-row">
						        <label for="req_cat">Forward <span class="required">*</span> :</label>
						             
            <input type="hidden" value ="<?php echo json_decode($id); ?>" name="data[TempWorkflow][temp_id]"> 
            <input type="hidden" value ="<?php echo json_decode($voucher_id); ?>" name="data[TempWorkflow][voucher_id]"> 


												        <?php echo $this->Form->input('TempWorkflow.emp_code', array('type' => 'select', 'label' => false,  'options' => $fwemplist, 'class' => 'md-input data-md-selectize label-fixed form-control','id'=>'fwlvempcode')); ?>    
<br/>
<input onclick="return checkSubmit()" name="data[TempWorkflow][save]" class="md-btn md-btn-success" type="submit" value="Forward">&nbsp;
<input onclick="return Backreturn()" class="md-btn md-btn-danger" type="button" value="Cancel" >
                    
                    
												     </div>
											       </div>
											      
											</div>

                  
            <?php $this->Form->end(); ?>			



                                    
            </div>
        </div>
    </div>
</div>

 <script type="text/javascript">
    function checkSubmit()
    {
        if($("#fwlvempcode").val() =='')
        {
            alert("Select the employee name.");
            return false;
        }else{
            return true;
        }
    }
    function Backreturn()
    {
         window.location.href = "<?php echo Router::url('/', true) ; ?>temporary_components/View";
          //document.voucher.submit();
            return true;
    }
</script>
