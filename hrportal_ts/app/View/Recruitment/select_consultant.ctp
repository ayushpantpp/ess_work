
<?php 
$emp_code = $_SESSION['Auth']['MyProfile']['emp_code'];
$comp_code = $this->Common->findEmpCompany($emp_code);
$fwemplist = $this->Common->findLevel($emp_code,$comp_code);

?>

<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  

             <div class="md-card">
             
        <div class="md-card-toolbar">
          

                          
                             
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Consultant  Form</b>
                            </h3>
                            
                          

                        
                            </div>
            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'select_consultant'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                $req_no = $this->Common->getreqnum();
                
        
                ?>
                <div class="uk-grid"   data-uk-grid-margin>
                  <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Requisition  Number <span class="req">*</span></label>
                               <?php 
                                                              echo $this->form->input('Requisition Number', array('label'=>false, 'type' => 'text', 'class' => "md-input",'readonly'=>true,'required'=>true,'id'=>'req_no','value'=>"0".$req_no));
                               
                               ?>
                        </div>
                      </div>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="department"> Consultant <span class="req">*</span></label>
                             <?php 
                                $empname=$this->Common->getemplist();
                               
                              
                                
                            echo $this->form->input('required_skills1', array('label' => false,'type' =>'select','multiple'=>'multiple', 'id'=>'kUI_multiselect_basic','placeholder' => ' -- Select Consultant --','required'=>true,  'options' => $empname));?>

                        </div>

                    </div>
                  </div>
                    
                
                  
                






              
<div class="uk-grid">
                    <div class="uk-width-1-1 uk-margin-top">                            
                        <button type="submit" name="type" value="post"  class="md-btn md-btn-success"  >Send Mail</button> <button type="submit" name="type" value="park" class="md-btn md-btn-danger"  >Send Mail Later</button> 

                    </div>
                    <div class="uk-width-1-2 uk-margin-top">                            
                                          
                    </div>
                    
                </div>
                <?php echo $this->Form->end();?>

</div>
</div>
</div>
</div>
</div>

           
<script type="text/javascript">
 function check(){
 var file=$("#jd_resume").val();
var ext = file.split('.').pop();

if(ext!="pdf" && ext!="docx" &&  ext!="doc"){

    
   alert("Please Upload only Pdf Docx and doc files ");
      return false;
            }
  

 var final=$("#skills1").val();
 if(final=='')
 {
  alert("Please Fill Required Skills");
  $("#skills").focus();
 }
}

   

    function pos_type(val)
    {
       $("#emp_group").hide();
       var ptype= $("#position_type").val();

       if(ptype==2)
       {

        $("#emp_group").show();
        $("#p_number").val(1);
       document.getElementById('p_number').readOnly=true;
 jQuery.ajax({

            url: '<?php echo $this->webroot ?>Recruitment/pos_details/' + val,
            
            success: function (data) {
            

     
               $id=jQuery('#empResponse').html(data);

               

            }
        });
       }
       else{
         $("#emp_group").hide();
          $("#p_number").val(' ');
   document.getElementById('p_number').readOnly=false;

          /*$("#d_name").val(' ');
          $("#first_name").val(' ');
          $("#employeegrp").val(' ');*/

          jQuery.ajax({

            url: '<?php echo $this->webroot ?>Recruitment/pos_details/' + val,
            
            success: function (data) {
            

     
               $id=jQuery('#empResponse').html(data);

               

            }
        });


       }
    }
     function get_details(emp_code)
    {
        jQuery.ajax({

            url: '<?php echo $this->webroot ?>Recruitment/emp_details/' + emp_code,
            
            success: function (data) {
            

     
               $id=jQuery('#empResponse').html(data);

               

            }
        });
    }
function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;
 
          return true;
       }
      
    /** Days to be disabled as an array */
    $(function () {
        $("#emp_group").hide();
        $("#datepicker").datepicker({ dateFormat: 'dd-mm-yy',

          minDate:'+1D',
         });
    });

   

  
</script>

<script>
   
  
   

    

</script> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="jquery.tag-editor.js"></script>

<link rel="stylesheet" href="jquery.tag-editor.css">
<script>
    
   // $('textarea').tagEditor({ autocomplete: { 'source': '/url/', minLength: 3 } });

    </script>