<?php //echo "hiii";?>
 
    
    <div class="right_col" role="main">
      <div class="">
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Meeting Topic Details</h2>
                </ul>
                <div class="clearfix"></div>
              </div>
                    <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    <th scope="row">S.No.</th>
                    <th class="column-title">Topic</th>
                    <!-- <th class="column-title">No. of Function</th> -->
                    <th class="column-title">MOM Details</th>
                     <th class="column-title">Action</th>
                     
                    </tr>
                  </thead>
                       <tbody>
                             <?php foreach ($ar as $k) { static $i =0;?> 
                           <tr>
                               <td> <?php echo $i+1;?> </td>
                               <td><?php echo $k['MomTopic']['tname']; ?></td>
                               <!-- <td><?php  //echo $module[$i]; ?></td> -->
                               
                               
                               <td><a href="#popup1"  
                                      onclick="Get_Details('<?php echo $k['MomTopic']['tid']; ?>')"  title="Click to View.">Click To View</a></td>
         
                                <td>
                                    <a href="#popup2"  
                                      onclick="Get_Details2('<?php echo $k['MomTopic']['tid']; ?>')"  title="Click to Edit.">Edit</a> |
                                    <a href="topicdelete/<?php echo $k['MomTopic']['tid']; ?>"  
                                        title="Click to delete.">Delete</a>
                               </td>
                           </tr>
                           <?php $i++;}?>
                      </tbody>
                </table>
                        <div class="navigation navigation-left" >
                    <?php echo $this->Paginator->counter(); ?> Pages
                    <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
                    <?php echo $this->Paginator->numbers(); ?>
                    <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                  </div>
 
            </div>
                       
                
                 <?php echo $this->form->end(); ?>
              </div>
            <!--</div>-->
          </div>
        </div>

 </div>





<!--<div class="clearfix"></div>
 page content 
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
                
                <?php //$check = array(1=>'New',2=>'Existing'); ?>
                <?php //echo $this->form->create('mom', array('url'=>'','method'=>'post','action'=>'momtopic','enctype' => 'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'form-horizontal form-label-left'))));
                ?>
                  <?php //echo $this->form->input('hd', array('type' => 'hidden', 'id'=>'hd','value'=>'0')); ?>
                   <div class="form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">Topic Type: <span class="required">*</span> </label></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="radio" name="proj" value="new" checked="checked">New</input>
                     <?php //If($sr!=NULL){?>
                    <input type="radio" name="proj" value="existing">Existing</input>
                      <?php //} ?>                
                    <?php //echo $this->form->input('pnameold', array('label'=>false, 'type' => 'select', 'style'=>'width:310px',
                                               // 'options' => $sr,'class' => "form-control col-md-7 col-xs-12",'id'=>'pname_existing' ,'style' =>'display:none')); ?>
                    
                    <?php //echo $this->form->input('pnamenew', array('label'=>false, 'type' => 'text', 'style'=>'width:310px',
                                               // 'value' => '','class' => "form-control col-md-7 col-xs-12",'id'=>'pname_new'
                                               //, 'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')", 'placeholder'=>'Add New Topic....')); ?>
                    </div>
                  </div> 
                                    
                  <div class="form-group col-md-12 col-sm-6 col-xs-6">
                 <label class="control-label col-md-2 col-sm-4 col-xs-12" for="first-name">Add Function:<span class="required">*</span> </label>
                  <div class="col-md-4 col-sm-8 col-xs-12">
                    
                      <?php //echo $this->form->input('mname', array('label'=>false, 'type' => 'text', 'style'=>'width:310px',
                                               // 'value' => '','class' => "form-control col-md-7 col-xs-12",'required'=>true,'id'=>'mname', 
                                              //'onkeyup'=> "this.value=this.value.replace(/[^\w ]+$/g,'')" , 'required'=>"true", 'placeholder'=>'Add New Function....')); ?>
                   
                      
                  
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
                <?php //echo $this->form->end(); ?>
              </div>
            </div>
        </div>
    </div>-->
    
    
   
<script type="text/javascript">
        $('.pnamenew').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^\w ]/$,'') ); }
        );
 </script> 
 <script type="text/javascript">
        $('.mname').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^\w ]/$,'') ); }
        );
 </script> 
 
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
 
      
 
 
          
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent"> 
      <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
    </div>    
  </div>
</div>

<div id="popup2" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent2"> 
      <div id="container" style="width: 400px; height: 200px; margin: 0 auto"></div>
    </div>    
  </div>
</div>
 

