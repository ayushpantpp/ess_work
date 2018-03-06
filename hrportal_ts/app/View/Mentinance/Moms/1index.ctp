
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>MOM Schedule Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Meeting Assign Form</h2>
                
                 <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
            <?php echo $this->form->create('mom', array('url'=>'','method'=>'post','action'=>'','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false))); ?>
             <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">MOM ID:<span class="required">*</span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('mid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$asd,'type' => 'text', 'id' =>'mid', 'required'=>true, 'readonly'=>TRUE)); ?>
                    </div>
                  </div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Select Topic:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('tname', array('label'=>false, 'type' => 'select', 'required'=>true,
                        'options' => array('' => 'Select Topic'),
                        'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'tname')); ?>
                    </div>
                </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Meeting Date:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                     <?php echo $this->form->input('startdate', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",
                                   'type' => 'text', 'id' => 'startdate','value'=>$dt,'placeholder'=>'Click here to Select Assign Date','required'=>true,)); ?>
                    </div>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Function Name:<span class="required"></span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <?php echo $this->form->input('spname', array('label'=>false, 'type' => 'select', 
                        'options' => array('' => 'Select Sub Point'),
                        'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'spname')); ?>
                    </div>
                </div>
                 
                 <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Add Member: <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        <select multiple class="form-control tickerWidth" name="ticker[]" id="ticker" style="width: 705px" required="true" >
                            
                    <?php foreach($employee_name as $k=>$val){ ?>
                    <option  value='<?php echo $k ?>'> <?php foreach($employee_name as $t=>$value){if($value == $k ) echo 'selected';} ?> <?php echo $val ?></option>
                    <?php } ?>
                   </select>
                           
                    </div>
                  </div> 
                  
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remark:<span class="required"></span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    
                      <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"form-control",
                          'style'=>"width: 705px; height: 50px;")); ?>
                    </div>
                  </div>
                  
                  
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <input type="button" class="btn btn-danger" value="Save As Draft" > 
                        <input type="submit" class="btn btn-success" value="Send" name='b1' id="b1" />
                    
                    </div>
                  </div>
                  
                 
                 <?php echo $this->form->end(); ?>
              </div>
            </div>
          </div>
        </div>

 <script type="text/javascript">
        $('.remark').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^\w ]/$,'') ); }
        );
 </script> 
        
<script type="text/javascript" >
        jQuery(document).ready(function() {
        jQuery("#startdate").datepicker({
                //inline: true,
                changeMonth: true,
                autoclose:true,
                 format: 'dd-mm-yy',
                
        });
    });
</script>
</div>
        