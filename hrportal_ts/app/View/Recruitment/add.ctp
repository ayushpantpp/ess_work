
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
                              <b> Manpower Requisition Form</b>
                            </h3>
                            
                          

                        
                            </div>
            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'add'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked','onsubmit'=>'return check();')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                $req_no = $this->Common->getreqnum();
                
        
                ?>
                <div class="uk-grid"   data-uk-grid-margin>
                  <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">Requisition  Number <span class="req">*</span></label>
                               <?php 
                                                              echo $this->form->input('Requisition Number', array('label'=>false, 'type' => 'text', 'class' => "md-input",'readonly'=>true,'required'=>true,'id'=>'req_no','value'=>"0".$req_no));
                               
                               ?>
                        </div>
                      </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="req_cat">Position Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name'));
                               
                               ?>
                        </div>

                    </div>
                    <div class="uk-width-medium-1-3" >
                        <div class="parsley-row">
                            <label for="department"> Position Type<span class="req">*</span></label>
                             <?php 
                                $position=array('1'=>'NEW','2'=>'Replacement');
                                echo $this->form->input('p_type', array('label'=>false, 'type' => 'select', 'readonly' => true, 'class' => "md-input",'empty'=>'Select Position Type','options' =>$position,'required'=>true,'id'=>'position_type','onchange'=>'return pos_type(this.value);',"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                        

                    </div>
                  </div>

                  <div class="uk-grid"   data-uk-grid-margin >
                    <div class="uk-width-medium-1-3" id="emp_group" >
                        <div class="parsley-row">
                            <label for="department"> Employee <span class="req">*</span></label>
                             <?php 
                                $empname=$this->Common->getemplist();
                               
                                echo $this->form->input('emp_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Replacement Employee','options' =>$empname,'class' => "md-input",'id'=>'employee','onchange'=>'return get_details(this.value);',"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                        

                    </div>


                 
                
                  </div>

                
         
            <div class="uk-grid" data-uk-grid-margin id="empResponse"  > 

                <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department"> Employee group<span class="req">*</span></label>
                             <?php 
                                $empname1=$this->Common->getempgroup();
                               
                                echo $this->form->input('emp_group', array('label'=>false, 'type' => 'select', 'required' => true, 'empty'=>'Select Employee Group','options' =>$empname1,'class' => "md-input",'id'=>'employeegrp',"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                        

                    </div>
                    
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                             <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationList();
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'empty'=>'Select Designation','readonly' => true, 'options' => $desgName,'required'=>true,'class' => "md-input",'id'=>'d_name',"data-md-selectize" => "data-md-selectize")); 
                            ?>         
                        </div>
                    </div>
                       <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   $department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);
                                ?>

                                <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Department','options' =>$department,'required'=>true,'class' => "md-input",'id'=>'first_name',"data-md-selectize" => "data-md-selectize")); ?>
                                  
                        </div>

                    </div>
                   </div>
              
               
                <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Location <span class="req fixed">*</span></label>
                            <?php 
                            $locName =$this->Common->findLocationName();
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select', 'empty'=>'Select Location','readonly' => true, 'options' => $locName,'required'=>true,'class' => "md-input",'id'=>'l_name',"data-md-selectize" => "data-md-selectize")); 
                            ?>                
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="dor"> Expected On Boarding  Date<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' => 'datepicker','required'=>true,'readonly'=>true));
                                ?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                     <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="subject">No Of Positions <span class="req">*</span></label>
                            <?php 
                               echo $this->form->input('nop', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_number','onkeypress'=>'return isNumberKey(event);'));
                               
                               ?>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    
                    <div class="uk-width-medium-1-3" id="enddate_div">
                          <label class="subject" >Description of Requisition</label><span class="req">*</span>
                        <div class="parsley-row" >
                          
                             
                                <?php echo $this->form->textarea('Description', array('label' =>false, 'class'=>"md-input",'required'=>true, 'placeholder'=>'Max 200 Character Allowed only',"id" => "Requirementdesc" ,'onkeypress'=>'returntext()')); ?> 

                        </div>
                    </div>
                        
                  
                         <div class="uk-width-medium-1-3" id="enddate_div">
                                     <label class="subject" >Required Experience (In Years)<span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->textarea('required_exp', array('label' =>false, 'class'=>"md-input",'required'=>true, "id" => "Experience",'onkeypress'=>'return isNumberKey(event);')); ?> 

                        </div>
                        </div>
                         <div class="uk-width-medium-1-3" id="enddate_div">
                            <label class="subject">Select Required Skills<span class="req">*</span></label>
                        <div class="parsley-row">
                            
                            <?php
                                 $skilllist=$this->Common->getskilllist();

                            echo $this->form->input('required_skills1', array('label' => false,'type' =>'select','multiple'=>'multiple', 'id'=>'kUI_multiselect_basic','placeholder' => ' -- Select Skills --','required'=>true,  'options' => $skilllist));?>

                    </div>
                    </div>
                    </div>
                            
        
                    <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label class="subject" >Upload  JD</label><span class="req">*</span>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('Jd_file', array('label' =>false, 'type'=>'file', 'class'=>"md-input autosize_init",'required'=>true, "id" => "jd_resume",'enctype'=>'multipart/form-data')); ?>
                               
                           
                        </div>
                    </div>
                   
                </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To be approved by:*</label>
                            <?php echo $this->Form->input('RequirementWorkflow.manager_Code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                   <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            <label  for="first-name">Created Date:</label>
                            <?php echo $this->Form->input('RequirementDetail.Date', array('type' => 'text','label' => "", 'readOnly' =>true, 'class' => 'md-input', 'id' => 'date','value'=>date('d-M-Y'))); ?>
                        </div>
                    </div>
                </div>






              
<div class="uk-grid">
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="type" value="park"  class="md-btn md-btn-danger"  >Save As Draft</button>

                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Save</button>                    
                    </div>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/Recruitment/add') ?>">Reset</a>                       
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
   var img = document.getElementById("jd_resume"); 
            //alert(img.files[0].size);
            if(img.files[0].size > 2097152)  // validation according to file size
            {
              alert("File Size should not Exceed 2 MB");
            
            return false;
             }
  
var ext = file.split('.').pop();

if(ext!="pdf" && ext!="docx" &&  ext!="doc"){

    
   alert("Please Upload only Pdf Docx and doc files ");
     $("#jd_resume").focus();
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