<?php
echo $this->Form->create('Appraisals', array(
    'url' => '/appraisal/prGenerateAddJson',
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
              <h2>Select Employee</h2>
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
                
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br>
                <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">Select Employee <span class="required">*</span> </label>
                    
                    <div class=" form-group col-md-6 col-sm-6 col-xs-10">
                      <select data-type="text" class="form-control s-form-item s-form-all" name="employee" id="MaritalStatus">
                        <?php foreach($data as $k=>$val){ ?>
                        <option value='<?php echo $k?>'><?php echo $val ?></option>
                       
                        <?php } ?>
                      </select>
                 
                    </div>
                    <label class="control-label col-md-4 col-sm-8 col-xs-10" for="first-name">Review Type <span class="required">*</span> </label>
                    
                     <div class=" form-group col-md-6 ">
                      <select data-type="text" class="form-control col-md-6 col-sm-6 col-xs-10 " name="review" id="MaritalStatus">
                        <option value=0>180</option>
                        <option value=1>360</option>
                      </select>
                 
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-4">
                    <button type="submit" class="btn btn-success">Generate Appraisal</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
       </div>
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
 <?php echo $this->Form->end(); ?>