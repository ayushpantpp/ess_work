
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
                              <b> Candidate Details Form</b>
                            </h3>
                         
                        
                            </div>
                            <?php    
                          foreach($reqdetails as $requisitiondata)
                          {
                            
                          
                            ?>

            <div class="md-card-content large-padding">
                <?php 
                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'Candidateprofile'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked','enctype'=>'multipart/form-data')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                ?><div id="empResponse">
                <div class="uk-grid"   data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Position Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name','value'=>$reqdetails['RequirementDetail']['position_name']));
                               
                               ?>
                        </div>

                    </div>
                    
                        <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   $department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);
                                ?>

                                <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Department','options' =>$department,'required'=>true,'class' => "md-input",'id'=>'first_name',"data-md-selectize" => "data-md-selectize",'value'=>$reqdetails['RequirementDetail']['dept_code'])); ?>
                                  
                        </div>

                    </div>
                   
                        

                    </div>
                    
                  
                  
                

                  
            <div class="uk-grid" data-uk-grid-margin > 

                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationList();
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'empty'=>'Select Designation','readonly' => true, 'options' => $desgName,'required'=>true,'class' => "md-input",'id'=>'d_name',"data-md-selectize" => "data-md-selectize",'value'=>$reqdetails['RequirementDetail']['desg_code'])); 
                            ?>         
                        </div>

                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Location <span class="req fixed">*</span></label>
                            <?php 
                            $locName =$this->Common->findLocationName();
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select', 'empty'=>'Select Location','readonly' => true, 'options' => $locName,'required'=>true,'class' => "md-input",'id'=>'l_name',"data-md-selectize" => "data-md-selectize",'value'=>$reqdetails['RequirementDetail']['location_name'])); }
                            ?>                
                        </div>
                    </div>
                   </div>
               <div class="uk-grid" data-uk-grid-margin > 
                     <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Type <span class="req">*</span></label>
                               <?php 
                               $candidate_type=array('1'=>'Fresher','2'=>'Experience');
                               echo $this->form->input('Candidate Type', array('label'=>false, 'type' => 'select', 'class' => "md-input",'required'=>true,'id'=>'c_type' ,'options'=>$candidate_type,'onchange'=>'return getcandidate(this.value)',"data-md-selectize" => "data-md-selectize"));
                               
                               ?>    
                            
                        </div>
                    </div>
                    <!-- <div class="uk-width-medium-1-2">
                     <label for="dor">Preffered Interview Date<span class="req">*</span></label>
                        <div class="parsley-row">
                               <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' =>'text',"data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'".date('d-m-Y'+1)."'}",'required'=>true));?>
                  </div>
                </div> -->
              </div>
                <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Candidate Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_name'));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Gender <span class="req">*</span></label>
                               <?php 
                               $gender=array('1'=>'Male','2'=>'Female');
                               echo $this->form->input('Gender', array('label'=>false, 'type' => 'select','options'=>$gender ,'class' => "md-input",'required'=>true,'id'=>'Candidate_gender',"data-md-selectize" => "data-md-selectize"));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                 <!-- <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Religion <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Religion', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_Religion'));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Nationality<span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Nationality', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_nationality'));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div> -->
                 <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Current Address <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('current Address', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_address'));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Permanent Address <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Permanent Address', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_paddress'));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin > 
                      <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Mobile <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('mobileno', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'Candidate_number'));
                               
                               ?>        
                        </div>
                        
                    </div>

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                             <label for="req_cat">Candidate Marital Status <span class="req">*</span></label>
                               <?php 
                               $Marital_status = array('1' =>'Single' ,'2'=>'Married' );
                               echo $this->form->input('marital', array('label'=>false, 'type' => 'select','options'=>$Marital_status,'class' => "md-input",'required'=>true,'id'=>'Cog',"data-md-selectize" => "data-md-selectize"));
                               
                               ?>    
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
                 <div class="uk-grid" data-uk-grid-margin > 
                       <div class="uk-width-medium-1-2" id="enddate_div">
                          <label class="subject" >Candidate Email <span class="req">*</span></label>
                        <div class="parsley-row" >
                          
                             
                                <?php echo $this->form->input('email', array('label' =>false, 'class'=>"md-input autosize_init",'required'=>true, "id" => "email" )); ?> 

                        </div>
                    </div>
                        
                    

                    
                
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label class="subject" >Candidate Adhar <span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('Candidate Adhar', array('label' =>false,'type'=>'text', 'class'=>"md-input autosize_init",'required'=>true, "id" => "adhar")); ?> 

                           
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                </div>
              </div>

                <div class="uk-grid" data-uk-grid-margin id="can_group"> 
                     <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="req_cat">Candidate Current Organization <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Current orgname', array('label'=>false, 'type' => 'text', 'class' => "md-input",'id'=>'Cog'));
                               
                               ?>    
                            
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="enddate_div">
                          <label for="req_cat">Candidate Notice Period <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Candidate NoticePeriod', array('label'=>false, 'type' => 'text', 'class' => "md-input",'id'=>'CNP'));
                               
                               ?>    
                        </div>
                    </div>
                        
                  
                     <div class="uk-grid" data-uk-grid-margin id="can1_group"> 
                         <div class="uk-width-medium-1-2" id="enddate_div">
                           <label class="subject" >Candidate Current CTC Per Annum <span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('Candidate CTC', array('label' =>false,'type'=>'text', 'class'=>"md-input autosize_init", "id" => "c_ctc")); ?> 
                                      

                        </div>
                        </div>
                         <div class="uk-width-medium-1-2" id="enddate_div">
                            
                          <label for="dor">Expected CTC Per Annum<span class="req">*</span></label>
                           <div class="parsley-row">
                                <?php 
                                echo $this->form->input('Expected CTC', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' =>'e_ctc'));
                                ?>
                              </div>
                             </div>
                             </div>
                            
        
                  
     <div class="uk-grid" data-uk-grid-margin id="can2_group"> 
                         <div class="uk-width-medium-1-2" >
                      
                               <label class="subject" >Candidate Experience (In Years)<span class="req">*</span></label>
                            
                     <div class="parsley-row">
                                <?php echo $this->form->input('Experience', array('label' =>false, 'type'=>'text','class'=>"md-input autosize_init", "id" => "C_exp",'onkeypress'=>'return isNumberKey(event);')); ?> 
                            
                            <span class="md-input-bar"></span>
                    
                    </div>
                  </div>
                    <div class="uk-width-medium-1-2">
                        
                       <label class="subject" >Reason for Leaving</label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->textarea('Leave Reason', array('label' =>false, 'class'=>"md-input autosize_init",'placeholder'=>"Max 250 character Allowed Only" ,"id" => "Reason")); ?> 
                        </div>
                    </div>
                   
                </div> 
              

                    <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                           
                        </div>
                    </div>
                  </div>
                    
                   
                </div>



 <div class="uk-grid" data-uk-grid-margin > 
                         <div class="uk-width-medium-1-2">
                     <div class="parsley-row">
                          <label for="kUI_multiselect_basic" class="uk-form-label">Required Skills<span class="req">*</span></label>
                             <?php
                              $skilllist=$this->Common->getskilllist();

                            echo $this->form->input('Skill List', array('label' => false,'type' =>'select','multiple'=>'multiple', 'id'=>'kUI_multiselect_basic', 'options' => $skilllist));
                            ?>
                          </div>

                        </div>
              
                  
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label class="subject" >Upload  Resume<span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('file.', array('label' =>false, 'type'=>'file', 'class'=>"md-input autosize_init",'required'=>true, "id" => "c_resume",'enctype'=>'multipart/form-data')); ?>
                                <button type='button'  id="add_more">Add More Files</button>
                                    <input type='button' class="minusbtn" value='Remove' id='removeButton'>
                           
                        </div>
                    </div>
                   
                </div>
              </div>
               






              
<div class="uk-grid">
                    
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success"  >Submit</button>                    
                    </div>
                    <div class="uk-width-1-2 uk-margin-top">                            
                        <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/Recruitment/opening') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>

</div>
</div>
</div>
</div>
</div>

           
<script type="text/javascript">
 

   $(document).ready(function(){
    $("#can_group").hide();
         $("#can1_group").hide();
         $("#can2_group").hide();
      
 var counter=1;
        $('#add_more').click(function(e){
     
          e.preventDefault();
        $(this).before('<?php echo $this->form->input('file.',array('type'=>'file', 'id'=>"jd_resume",'enctype'=>'multipart/form-data'));?>');
   counter++;
   
        });
       /* $('.minusbtn').click(function () {
      

            $("#add_more #jd_resume:last-child").remove();
          

        
       
    });*/
           
      });


    function pos_type(val)
    {
       var ptype= $("#position_type").val();
       if(ptype==2)
       {

        $("#emp_group").show();
       }
       else{
         $("#emp_group").hide();
       }
    }
    function getcandidate(val)
    {
      
       
       if(val==2)
       {

        $("#can_group").show();
        $("#can1_group").show();
         $("#can2_group").show();
       }
       else{
         $("#can_group").hide();
         $("#can1_group").hide();
         $("#can2_group").hide();
       }
    }
     function get_details(emp_code)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Recruitment/emp_details/' + emp_code,
            success: function (data) {
                //alert(data);
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
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
  
</script>




  <script>
$(function() {

    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }
    
    $( "#skills" ).bind( "keydown", function( event ) {

        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();

        }
    })
    .autocomplete({

        minLength: 1,
        source: function( request, response ) {

            // delegate back to autocomplete, but extract the last term
            $.getJSON('<?php echo $this->webroot ?>Recruitment/skillmaster', { term : extractLast( request.term )},response);
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
   
            var terms = split( this.value );
              var skillvalue=[];
            // remove the current input
            terms.pop();
            // add the selected item
             term1=ui.item.value.split('-');
           
            terms.push(term1[1]);
          terms.push( "" );

            this.value = terms.join( ", " );
         

          //var skill1 = skillvalue.join( ", " );
         
        /*  $("#skills1").val(skillvalue);
     
           
            
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );*/
             
            return false;
        }
    });
});

</script>
