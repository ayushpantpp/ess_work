<?php //echo "Hello"; ?>
<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>-->
<!--<script src="https://code.highcharts.com/modules/exporting.js"></script>-->
   
    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        
        <div class="clearfix"></div>
        <div class="row" >
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Meeting Details</h2>
                
                  
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <!--<div id="container" style="height: 400px"></div>-->
                  <br />
                   <table class="table table-striped responsive-utilities jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                    <th scope="row">S.No.</th>
                    <th class="column-title">Date</th>
                    <th class="column-title">Description</th>
                    <th class="column-title">Minutes Remarks</th>
                    <th class="column-title">Responsibility</th>
                    <th class="column-title">Remark</th>
                    <th class="column-title">Remark Response</th>
                    <th class="column-title">Lead By</th>
                    
                    <th class="column-title">Attachment</th>
                    
                    
                    </tr>
                  </thead>
                  <tbody>
                      
                      <?php
                      //print_r($ar); die();
                      if(isset($ar)){
                      for($i=0;$i<count($ar);$i++)
                      {?>
                     <tr>
                         <td> <?php echo $i+1;   ?> </td> 
                          <td> <?php echo $ar[$i][0]['MomAssign']['date'];   ?> </td> 
                          <?php $str1= substr($ar[$i][0]['MomAssign']['description'], 0, 10);?>
                          
                           <td> <?php if($ar[$i][0]['MomAssign']['description']==""){ echo "--N/A--";} else {?>
                               <a href="#popup6" onclick="Get_Details6('<?php echo $ar[$i][0]['MomAssign']['mid'] ?>')" title="Click here"><?php echo $str1."..";?></a>
                               
                           <?php }//echo $ar[$i]['MomAssign']['responsibility'];   ?>
                           </td> 
                              
                              <!--<textarea rows="1" style="height: 30px"><?php //echo $ar[$i]['MomAssign']['mremark']; ?></textarea>-->
                           <td>     <a href="#popup2" onclick="Get_Details2('<?php echo $ar[$i][0]['MomAssign']['mid'] ?>')" title="Click here">Click to show</a>
                              
                          
                          </td>
                          
                           <?php $str= substr($ar[$i][0]['MomAssign']['responsibility'], 0, 10);?>
                          
                           <td> <?php if($ar[$i][0]['MomAssign']['responsibility']==""){ echo "--N/A--";} else {?>
                               <a href="#popup5" onclick="Get_Details5('<?php echo $ar[$i][0]['MomAssign']['mid'] ?>')" title="Click here"><?php echo $str."..";?></a>
                               
                           <?php }//echo $ar[$i]['MomAssign']['responsibility'];   ?>
                           </td>  
                           
                           <td> <textarea rows="1" style="height: 30px; width: 150px" readonly="true"><?php 
                           if($ar[$i][0]['MomAssign']['remark']==""){echo "--N/A--";}else {echo $ar[$i][0]['MomAssign']['remark'];}
                           ?></textarea> </td>
                           
                           
                           
                           
                           <td> 
                              
                              <!--<textarea rows="1" style="height: 30px"><?php //echo $ar[$i]['MomAssign']['mremark']; ?></textarea>-->
                              <a href="#popup3" onclick="Get_Details3('<?php echo $ar[$i][0]['MomAssign']['mid'] ?>')" title="Click here">Click to Response</a>
                              
                          
                          </td>
                           
                           
                           <td> <?php echo $ar[$i][0]['MomAssign']['createby'];   ?> </td>
                           
                           
                           
                           <td> 
                               <?php  if($ar[$i][0]['MomAssign']['uploaded_file']!=Null){
                               echo "<a target='blank' href='".$this->webroot."uploads/mom/".$ar[$i][0]['MomAssign']['uploaded_file']."'>".$ar[$i][0]['MomAssign']['uploaded_file']."</a>"; 
                               
                               } else { echo "--N/A--";}  ?>
                           </td>
                           
                          
                          
                        </tr>    
                     <?php } }  ?>
                      
                  
                 </tbody>
                          
                      </tbody>
                </table>
                  <div class="navigation navigation-left" >
                    <?php echo $this->Paginator->counter(); ?> Pages
                    <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
                    <?php echo $this->Paginator->numbers(); ?>
                    <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                  </div>
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
    
function Get_Details(id)
{   //alert("MOM ID=="+id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/view2/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
} 

function Get_Details2(id)
{   //alert("MOM ID=="+id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/view3/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent2').html(data);
        }
    });
} 

function Get_Details3(id)
{   //alert("MOM ID=="+id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/response/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent3').html(data);
        }
    });
} 
function Get_Details5(id)
{   //alert("MOM ID=="+id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/responsibility/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent5').html(data);
        }
    });
}

function Get_Details6(id)
{   //alert("MOM ID=="+id);
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>moms/description/'+id,
        success: function(data){
      //alert(data);
            jQuery('.HRcontent6').html(data);
        }
    });
}

</script>
</div>
               
    
<div id="popup1" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent"> 
      <div id="container" style="width: 400px; height: 450px; margin: 0 auto"></div>
    </div>    
  </div>
</div> 
   
<div id="popup2" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent2"> 
      <div id="container" style="width: 600px; height: 900px; margin: 0 auto"></div>
    </div>    
  </div>
</div>  
<div id="popup3" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent3"> 
      <div id="container" style="width: 400px; height: 450px; margin: 0 auto"></div>
    </div>    
  </div>
</div> 
<div id="popup5" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent5"> 
      <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
    </div>    
  </div>
</div> 
    
<div id="popup6" class="HRoverlay">
  <div class="HRpopup">
    <a class="HRclose" style="margin-top:-30px" href="#">×</a>
    <div class="HRcontent6"> 
      <div id="container" style="width: 800px; height: 600px; margin: 0 auto"></div>
    </div>    
  </div>
</div>         
        

