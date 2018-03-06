<!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Fill Topic Details</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"> <br />
                
                <?php $check = array(1=>'New',2=>'Existing'); ?>
                <?php echo $this->form->create('mom', array('url'=>'','method'=>'post','action'=>'momtopic','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>
                  <?php echo $this->form->input('hd', array('type' => 'hidden', 'id'=>'hd','value'=>'0')); ?>
                   <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Topic Type: <span class="required">*</span> </label></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="radio" name="proj" value="new" checked="checked">New</input>
                     <?php If($sr!=NULL){?>
                    <input type="radio" name="proj" value="existing">Existing</input>
                      <?php } ?>                
                    <?php echo $this->form->input('pnameold', array('label'=>false, 'type' => 'select', 'style'=>'width:310px',
                                                'options' => $sr,'class' => "form-control col-md-7 col-xs-12",'id'=>'pname_existing' ,'style' =>'display:none')); ?>
                    
                    <?php echo $this->form->input('pnamenew', array('label'=>false, 'type' => 'text', 'style'=>'width:310px',
                                                'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'pname_new'
                                               ,  'placeholder'=>'Add New Topic....')); ?>
                    </div>
                  </div> 
                                    
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                 <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Add Function:<span class="required">*</span> </label>
                  <div class="col-md-4 col-sm-8 col-xs-12">
                    
                      <?php echo $this->form->input('mname', array('label'=>false, 'type' => 'text', 'style'=>'width:310px',
                                                'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'mname', 
                                              'required'=>"true", 'placeholder'=>'Add New Function....')); ?>
                   
                      
                  
                 </div>
                 </div>
                          
                                   
                <div class="x_content">
              
               </div>
                  <div class="clearfix"></div>
                   <div class="ln_solid"></div>
                 
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                    <div class="col-md-8 col-sm-8 col-xs-12">
                    <input type="submit" class="btn btn-success" value="Add Topic" onclick= "return post1();">  

                    </div>
                  </div>
              </div>
            </div>
              <div class="clearfix"></div>
                <?php echo $this->form->end(); ?>
              </div>
            </div>
        </div>
    </div>
<script type="text/javascript" >
  function post1()
   {
      
     // var m = document.getElementById("mname").value;
      //var p = document.getElementById("pname_existing").value;
      //alert(m);
      //alert(p); 
      //alert("BBBBB..."); 
     document.forms["mom"].submit();
       
   }
    
      
</script>
<script>
jQuery(document).ready(function(){
    $('#alerts').hide;
    $('input[name="proj"]').change(function(){
  $("#pname_new").hide();
  $("#pname_existing").hide();
  $("#pname_"+$(this).val()).show();
  
});
}); 
function Get_Details(id)
{   //alert(id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/view1/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
}

function Get_Details2(pid)
{   //alert(pid);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/topicedit/'+pid,
        success: function(data){
  //alert(data);
            jQuery('.HRcontent2').html(data);
        }
    });
}
 
 
</script>