<div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Assign Factor</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <div class="clearfix"></div>
              </div>
             <?php
             echo $this->Form->create('Apprasialfactors', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'appraisal', 'action' => 'saveappraisalfactormapping'), 'id' => 'appraisalassignfactor', 'name' => 'appraisalassignfactors'));
        $emp_list = $this->common->emplistfactors($factorid);   
        //print_r($emp_list);die;
        ?>
   
              <div class="x_content"> <br>
                    
                  <div class="form-group col-md-8 col-sm-12 col-xs-12">
                    <label for="middle-name" class="control-label col-md-6 col-sm-8 col-xs-12">Employee<span class="required">*</span></label>
                    <div class=" form-group col-md-6 col-sm-12 col-xs-12">
                    <?php echo $this->Form->input('myprofile_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $emp_list, 'class' => 'form-control col-md-4 col-xs-12')); ?>
                    </div>
                     
                  </div>
                
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-1 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                     <a href="#" onclick ="assign_factor('<?php echo $factorid ?>')" id ='factoractivate' class="btn btn-primary" title="Click to View.">Assign</a>
                    </div>
                  </div>
                
              </div>
            </div>
          </div>
        </div>

</div>
</div> 

<script>
function assign_factor(id)
{   
    var myprofile_id = $('#ApprasialfactorsMyprofileId').val();
    
    $.ajax({
        url: '<?php echo $this->webroot ?>appraisal/appraisalfactorinfo/'+id+'/'+myprofile_id,
         
        success: function(){
	location.reload();		
            
        }
    });
 }    
</script>