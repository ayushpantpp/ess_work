<!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Edit LTA Claim Form</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <!-- <h2>LTA Claim</h2> -->
                </ul>
                <div class="clearfix"></div>
              </div>
               
              <div class="x_content"> <br />
               <?php echo $this->Form->create('lta', array('inputDefaults' => array(
               'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
               'url' => array('controller' => 'Lta', 'action' => 'LtaClaimEdit'), 'enctype' => 'multipart/form-data','id' => 'ltaid', 'name' => 'editlta') );
                ?>
              
              <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee ID</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php echo $emp_details['emp_id'];?>
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">Employee Name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <?php $v = $this->Common->option_attribute_name($gender); 
                        if($v[$gender] == 'MALE'){
                        ?>
                        <p> <span>Mr.</span><?php echo $emp_name ;?> <span><?php echo $lastname;?></span></p>
                        <input name="title" type="hidden" value="<?php echo $emp_name;?>" class="form-control col-md-7 col-xs-12">
                         <input name="ltaid" type="hidden" value="<?php echo $ltaid;?>" class="form-control col-md-7 col-xs-12">
                        <?php }else{?>
                        <p> <span>Mrs.</span><?php echo $emp_name ;?> <span><?php echo $lastname;?></span></p>
                        <input name="title" type="hidden" value="<?php echo $emp_name;?>" class="form-control col-md-7 col-xs-12">
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">LTA Claim Year</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <select name='ltaclaimyear'>
                  <?php  for($i=1;$i<=$lta_block;$i++){ ?>
                    <option <?php if($lta_claim['LtaBillAmount']['lta_years']== $i){ echo selected;}?> value=<?php echo $i;?>><?php echo $i;?></option>
                  <?php } ?>  
                    </select> Years
                    </div>
                </div>    
                <!-- <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee Name</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input name="title" type="text" class="form-control col-md-7 col-xs-12">
                    </div>
                </div> -->
                
                 <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">Bill Amount *</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <input name="bill_amt" id="bill"  type="text" value="<?php echo $lta_claim['LtaBillAmount']['bill_amount'];?>" required class="form-control col-md-7 col-xs-12">
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">Journey Start Date*</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                       <?php echo $this->form->input('jour_start_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text', 'value'=>date('d-m-Y',strtotime($lta_claim['LtaBillAmount']['jour_start_date'])),'id' => 'jour_start_date','readonly'=>true)); ?>
                    </div>
                </div>
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">Journey End Date *</label>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                    <?php echo $this->form->input('jour_end_date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",'type' => 'text','value'=>date('d-m-Y',strtotime($lta_claim['LtaBillAmount']['jour_end_date'])), 'id' => 'jour_end_date','readonly'=>true)); ?>    
                    </div>
                </div> 
               
                <div class="form-group col-md-6 col-sm-6 col-xs-6">
                    <label class="control-label col-md-3 " for="first-name">Upload Document*</label>
                    <div class="col-md-9 col-sm-9 col-xs-12"> 
                     <img width= 50 height= 50 src="<?php echo $this->webroot.'uploads/Lta/'.$lta_claim['LtaBillAmount']['uploaded_file'];?>">   
                    </div>
                    <div class="col-md-9 col-sm-9 ">
                        <input class="avatar-input" id="docInput" name="doc_file" id ="doc" type="file" value='' >
                    </div>
                </div>
                  
                <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                       <input type="submit" class="btn btn-success" value="Apply" name='post_leave' onclick="return checkSubmit(); ">
                    </div>
                </div>
            </form>
               
              </div>
            </div>
          </div>
        </div>
      </div>
 <script type="text/javascript" >
        jQuery(document).ready(function() {
       jQuery("#jour_start_date").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                endDate:'today',
                orientation: "right bottom",
                format: 'dd-mm-yyyy'
                
        });
     jQuery("#jour_end_date").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                endDate:'today',
                orientation: "right bottom",
                format: 'dd-mm-yyyy'
                
        });
      jQuery("#bill_date").datepicker({
                inline: true,
                changeMonth: true,
                autoclose:true,
                //changeYear: true,
                Format: 'dd-mm-yy'
                
        });       
  });    
    function checkSubmit()
    {

        var jour_start_date = $('#jour_start_date').datepicker("getDate");
        var jour_end_date = $('#jour_end_date').datepicker("getDate")
        var millisecondsPerDay = 1000 * 60 * 60 * 24;
        var millisBetween = jour_end_date.getTime() - jour_start_date.getTime();
        var days = millisBetween / millisecondsPerDay;
       
        if(days < 0){
        $("#alerts").html('Please Enter Proper Dates').show();

        return false;

        }
        if($('#bill').val() !== "") {
        var value = $('#bill').val().replace(/^\s\s*/, '').replace(/\s\s*$/, '');
        var intRegex = /^\d+$/;
        if(!intRegex.test(value)) {
            
        $("#alerts").html('Bill Amount Field must be numeric').show();
        return false;
        }
      } 
      if($('#bill').val() == ""){
        $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Bill Amount").show();
        return false;
      }
      
     else if($('#jour_start_date').val() == "")
        {
         $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Start Date Required").show();
          return false;

        }
        
        else if($('#jour_end_date').val() == "")
        {
           $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Ending Date Required").show();
           return false;
        }
        

    }
    </script>