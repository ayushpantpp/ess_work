<?php echo "hi"; ?>

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
<!--        <div class="page-title">
          <div class="title_left">
            <h3>MOM Schedule Form</h3>
          </div>
        </div>-->
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>MOM Assign Form</h2>
                
                 <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
            <?php echo $this->form->create('mom', array('url'=>'','method'=>'post','action'=>'momupdate','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false))); ?>
<!--             <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">MOM ID:<span class="required">*</span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('mid', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'value'=>$a['MomAssign']['mid'],'type' => 'hidden', 'id' =>'mid')); ?>
                    </div>
                  </div>-->
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Description:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <?php echo $this->form->input('des', array('class' => "form-control s-form-item s-form-all", 
                          'label'=>false,'type' => 'text','value'=>$a['MomAssign']['description'], 'id' =>'des','required'=>true, )); ?>  
                        
                    <?php //echo $this->form->input('tid', array('label'=>false, 'type' => 'select', 'required'=>true,
                        //'options' => array('' => 'Select Topic',$ar),
                        //'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'tid','onChange'=>'getfunction(this.value)')); ?>
                    </div>
                </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Meeting Date:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                     <?php echo $this->form->input('date', array('label'=>false,'class'=>"form-control col-md-7 col-xs-12 ",
                                   'type' => 'text', 'id' => 'date','value'=>$edt,'required'=>true,)); ?>
                    </div>
                  </div>
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Minutes Remarks:<span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        
                        <?php echo $this->form->textarea('mr', array('label'=>false,'class'=>"form-control",
                          'style'=>"width: 186px; height: 100px;",'id' =>'mr','required'=>true,'value'=>$a['MomAssign']['mremark'],)); ?>
                        
                        
                     <?php //echo $this->form->input('fid', array('label'=>false, 'type' => 'select', 
                        //'options' => array('' => 'Select Function'),
                        //'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'fid')); ?>
                      
                    </div>
                </div>
                  
<!--                  <div class="form-group col-md-6 col-sm-6 col-xs-12" style="line-height:35px;">                      
                    <label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">Time:<span class="required"></span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="time" id="myTime" value="--:--">
                        <?php //echo $this->form->input('time', array( 
                          //'label'=>false,'type' => 'time', 'id' =>'time', 'required'=>true, 'style'=>"width: 59px; height: 38px;",
                            //'default' => array('hour'=>'0','min'=>'0')  )); ?>
                    </div>
                </div>-->
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Responsibility:<span class="required"></span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    
                      <?php echo $this->form->textarea('res', array('label'=>false,'class'=>"form-control",
                          'style'=>"width: 186px; height: 100px;",'id' =>'res', 'value'=>$a['MomAssign']['responsibility'],)); ?>
                    </div>
                  </div>
                 <!--<div class="clearfix"></div>-->
                 
                  
                  <!--<div class="clearfix"></div>-->
                  
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Remark:<span class="required"></span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    
                      <?php echo $this->form->textarea('remark', array('label'=>false,'class'=>"form-control",
                          'style'=>"width: 186px; height: 100px;",'id' =>'remark', 'value'=>$a['MomAssign']['remark'],)); ?>
                    </div>
                  </div>
                  <!--<div class="clearfix"></div>-->
                  
                  <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Message">Upload Document:<span class="required"></span> </label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    
                        <input class="avatar-input" id="docInput" name="doc_file" type="file" class="form-control col-md-7 col-xs-12" value="<?php echo $a['MomAssign']['uploaded_file'];?>">
                    </div>
                    <?php if($a['MomAssign']['uploaded_file']!=""){ ?>
                    <div class="form-group col-md-6 col-sm-6 col-xs-12" >
                    <label  for="Message">Already Attached:<span > <?php echo "<a target='blank' href='".$this->webroot."uploads/mom/".$a['MomAssign']['uploaded_file']."'>".$a['MomAssign']['uploaded_file']."</a>"; ?></span> </label>
                    </div>
                    <?php } ?>
                    
                  </div>
                  <div class="clearfix"></div>
                  
                  <div class="clearfix"></div>
                  <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12">Add Member: <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                        
                     <select multiple class="form-control tickerWidth" name="ticker[]" id="ticker" style="width: 700px; height: auto"  required="true" >
                            
                    <?php for($i=0;$i<count($emp);$i++){ ?>
                    <option  value='<?php echo $emp[$i][0]['MyProfile']['emp_code']; ?>' selected="selected"> <?php echo $emp[$i][0]['MyProfile']['emp_name'] ?> </option>  
                    <?php } ?>        

      
                    <?php foreach($employee_name as $k=>$val){ ?>
                    <option  value='<?php echo $k ?>'> <?php foreach($employee_name as $t=>$value){if($value == $k ) echo 'selected';} ?> <?php echo $val ?></option>
                    <?php } ?>
                   </select>
                           
                    </div>
                  </div> 
                  
                  
                  
                  
                  
                  <div class="ln_solid"></div>
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        
                        <input type="submit" class="btn btn-success" value="Send" name='b1' />
                        <input type="button" class="btn btn-danger" title="Click to Cancel" value="Cancel" onClick="javascipt:window.location.href='<?php echo $this->Html->url(array('controller'=>'moms','action'=>'mdashboard')) ?>'" >
                        <input type="hidden" id="h1" name="h1" value="<?php echo $asd; ?>"/>
                        <input type="hidden" id="h2" name="h2" value="<?php echo $a['MomAssign']['uploaded_file'] ?>"/>
                    
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
        jQuery("#date").datepicker({
                //inline: true,
                changeMonth: true,
                autoclose:true,
                 //minDate: dateToday,
                 format: 'dd-mm-yy',
                 startDate: 'today',
                // minDate: 0,
                
        });
    });
</script>
 <script type="text/javascript">
// jQuery(document).ready(function() {             
//$("#date").datetimepicker({
//        format: "dd MM yyyy - hh:ii",
//        autoclose: true,
//        todayBtn: true,
//        pickerPosition: "bottom-left"
//    }); });
</script>
</div>
<script>        
function getfunction(val) {
    //alert("--PROJECT ID--"+val);
    $.ajax({
    type: "POST",
    url: '<?php echo $this->webroot ?>moms/module/'+val,
        
    //data:'project_id='+val,
    success: function(data){
                 //alert(data);
        $("#fid").html(data);
    }
    });
}
</script>        

<script type="text/javascript" >
   
  function post1()
   {
        alert("hiiii");
        document.getElementById("h1").value= 1;
        document.getElementById("mom").action = "/assign";
        document.forms["mom"].submit();
   }
</script>   