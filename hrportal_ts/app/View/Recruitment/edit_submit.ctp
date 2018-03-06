
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
        <b>  Manpower Requisition Edit  Form</b>
        </h3>
         </div>
            <div class="md-card-content large-padding">
                <?php
               if(!empty($reqdetail))
                {

                ?>
                <?php 

                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'editSubmit'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked', 'onsubmit'=>'return check()')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                 echo $this->form->input('id', array('value' => $reqdetail[0]['RequirementDetail']['id'], 'type' => 'hidden'));
                 echo $this->form->input('reqid', array('value' => $reqdetail[0]['RequirementDetail']['req_id'], 'type' => 'hidden'));
                  echo $this->form->input('position_type', array('value' => $reqdetail[0]['RequirementDetail']['position_type'], 'type' => 'hidden' ,'id'=>"pos_type"));

                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat">Position Name <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Position Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name','value'=> $reqdetail[0]['RequirementDetail']['position_name']));
                               
                               ?>
                        </div>
                    </div>
                     <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                         
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee group</label>
                            <?php 
                                 $empname1=$this->Common->getempgroup();
                               
                                echo $this->form->input('emp_group', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Replacement Employee','options' =>$empname1,'class' => "md-input",'value'=>$reqdetail[0]['RequirementDetail']['emp_group'],'id'=>'employeegrp',"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                    
                </div>
            <div class="uk-grid" data-uk-grid-margin > 
                <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department"> Department  Name<span class="req">*</span></label>
                                <?php   $department=$this->Common->findAllDepartmentName($auth['MyProfile']['comp_code']);
                                ?>

                                <?php 
                                echo $this->form->input('dept_name', array('label'=>false, 'type' => 'select', 'readonly' => true, 'empty'=>'Select Department','options' =>$department,'class' => "md-input",'required'=>true,'id'=>'first_name','value'=>$reqdetail[0]['RequirementDetail']['dept_code'],"data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Designation Name <span class="req fixed">*</span></label>
                            <?php 
                            $desgName =$this->Common->findDesignationList();
                            echo $this->form->input('desg_name', array('label'=>false, 'type' => 'select', 'empty'=>'Select Designation','readonly' => true, 'options' => $desgName,'class' => "md-input",'required'=>true,'id'=>'d_name','value'=>$reqdetail[0]['RequirementDetail']['desg_code'],"data-md-selectize" => "data-md-selectize"));
                            ?>                
                        </div>
                    </div>
                    
                    
                </div>
                    
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed">Location <span class="req fixed">*</span></label>
                            <?php 
                            $locName =$this->Common->findLocationName();
                            echo $this->form->input('location', array('label'=>false, 'type' => 'select', 'empty'=>'Select Location','readonly' => true, 'options' => $locName,'class' => "md-input",'required'=>true,'id'=>'l_name','value'=>$reqdetail[0]['RequirementDetail']['location_name'],"data-md-selectize" => "data-md-selectize"));
                            ?>                
                        </div>
                        
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="dor"> Expected On Boarding Date<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' =>'datepicker','required'=>true,'value'=>$reqdetail[0]['RequirementDetail']['max_join_date']));?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                  
                </div>
                     <div class="uk-grid" data-uk-grid-margin > 
                          <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">No Of Positions <span class="req">*</span></label>
                            <?php 
                               echo $this->form->input('nop', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'pos_number','onkeypress'=>'return isNumberKey(event);','value'=>$reqdetail[0]['RequirementDetail']['resource_req']));?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="enddate_div">
                             <label for="subject">Description of Requirement<span class="req">*</span></label>
                        <div class="parsley-row">
                       
                                <?php echo $this->form->textarea('Description', array('label' =>false, 'class' => "md-input",'required'=>true, "id" => "Requirementdesc",'value'=>$reqdetail[0]['RequirementDetail']['details']));?> 

                        </div>
                    </div>
                       
                    
                        

                    </div>

                  
                    <div class="uk-grid" data-uk-grid-margin>
                         <div class="uk-width-medium-1-2" id="enddate_div">
                                     <label for="subject">Required Experience<span class="req">*</span></label>
                            <div class="parsley-row">
                   
                                <?php echo $this->form->textarea('required_exp', array('label' =>false, 'class' => "md-input",'required'=>true, "id" => "Experience",'value'=>$reqdetail[0]['RequirementDetail']['required_exp']));
                          ?> 

                        </div>
                        </div>
                         <div class="uk-width-medium-1-2" id="enddate_div">
                            <label for="subject"><h3>Required Skills<span class="req">*</span></h3></label>
                        <div class="parsley-row" id="tags">
                           <!--  <?php foreach($reqdetail as $reqskils)
                            {   
             

                                ?>
                           
                            <?php  
                           $items[]=$reqskils['MstRequirement']['skills'];
            
             
           }
             
                           ?>  -->
                       <?php 
                       $skilllist=$this->Common->getskilllist();
          $items=$this->Common->getskilllistbycode($reqdetail[0]['RequirementDetail']['req_id']);
         
         foreach ($items as $item) {
             $value_skills[]=$item['MstRequirement']['id'];
             # code...

         }
                            echo $this->form->input('required_skills', array('label' => false,'type' =>'select','multiple'=>'multiple', 'id'=>'kUI_multiselect_basic','placeholder' => ' -- Select Skills --', 'options' => $skilllist,'value'=>$value_skills));
                            
                              
                                 ?> 


                        </div>
                       
                    </div>

                    <!-- 
                        <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                           <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hiring Type:*</label>
                            <?php 
                                $hlist=array('1'=>'Internal','2'=>'External','3'=>'Both');  
                           // echo $this->Form->input('RequirementDetail.hiring_type', array('type' => 'select', 'label' => "",'empty'=>'Select Hiring type', 'options' => $hlist, 'class' => 'md-input', 'id' => 'h_code', "data-md-selectize" => "data-md-selectize",'value'=>$reqdetail[0]['RequirementDetail']['hiring_type'])); ?>
                        </div>
                    </div> -->
                </div>
                <div class="uk-grid" data-uk-grid-margin > 
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label class="subject" >Upload  JD</label>
                            <div class="parsley-row">
                   
                                <?php 

                                echo 
                                $this->form->input('Jd_file', array('label' =>false, 'type'=>'file', 'class'=>"md-input autosize_init", "id" => "jd_resume",'value'=>$reqdetail[0]['RequirementDetail']['jd_doc'],'enctype'=>'multipart/form-data')); 
                                echo $reqdetail[0]['RequirementDetail']['jd_doc'];
                               /* echo $this->form->input('Jd_file', array('label' =>false, 'type'=>'hidden', 'class'=>"md-input autosize_init", "id" => "jd_resume",'value'=>$reqdetail[0]['RequirementDetail']['jd_doc'])); */
                                ?>
                               
                           
                        </div>
                    </div>
                   
                </div>
                 <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">To be approved by:*</label>
                            <?php echo $this->Form->input('RequirementWorkflow.manager_Code', array('type' => 'select', 'label' => "", 'options' => $fwemplist, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); ?>
                        </div>
                    </div>
                </div>



              
<div class="uk-grid">
                   
                    <div class=" uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success"  >Submit</button>                    
                    </div>
                    <div class="uk-margin-top">                            
                        <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/Recruitment/view') ?>">Cancel</a>                       
                    </div>
                </div>
                <?php echo $this->Form->end();?>

</div>
</div>
</div>
</div>
</div>

<?php }
else{ echo  "Record Not Found";}?>
           
<script type="text/javascript">
    $(document).ready(function()
    {

    
       
       var ptype= $("#pos_type").val();

       if(ptype==2)
       {
 $("#pos_number").prop('readonly', true);
      

       }
       else{
        $("#pos_number").prop('readonly', false);

       }
    });

 function check(){


 var file=$("#jd_resume").val();
 var img = document.getElementById("jd_resume"); 
            //alert(img.files[0].size);
            if(img.files[0].size > 2097152)  // validation according to file size
            {
              alert("File Size should not Exceed 2 MB");
            
            return false;
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


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="jquery.tag-editor.js"></script>

<link rel="stylesheet" href="jquery.tag-editor.css">
