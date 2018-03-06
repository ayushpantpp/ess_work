
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
        <b> Requisition Edit Form</b>
        </h3>
         </div>
            <div class="md-card-content large-padding">
                <?php
            
               if(!empty($reqdetail))
                {
                ?>
                <?php 

                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'hr_approve_Requisition'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                 echo $this->form->input('id', array('value' => $reqdetail[0]['RequirementDetail']['id'], 'type' => 'hidden'));
                 echo $this->form->input('reqid', array('value' => $reqdetail[0]['RequirementDetail']['req_id'], 'type' => 'hidden'));
                  echo $this->form->input('position_type', array('value' => $reqdetail[0]['RequirementDetail']['position_type'], 'type' => 'hidden'));

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
                         
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Employee group<span class="req">*</span></label>
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
                            <label for="dor">Expected On Boarding Date<span class="req">*</span></label>
                                <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' => 'datepicker','required'=>true,'value'=>$reqdetail[0]['RequirementDetail']['max_join_date']));?>
                            <span class="md-input-bar"></span>
                        </div>
                    </div>
                   
                </div>
                     <div class="uk-grid" data-uk-grid-margin > 
                       <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="subject">No Of Positions <span class="req">*</span></label>
                            <?php 
                               echo $this->form->input('nop', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name','onkeypress'=>'return isNumberKey(event);','value'=>$reqdetail[0]['RequirementDetail']['resource_req']));?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2" id="enddate_div">
                             <label for="subject">Description of Requirement<span class="req">*</span></label>
                        <div class="parsley-row">
                       
                                <?php echo $this->form->input('Description', array('label' =>false, 'class' => "md-input",'required'=>true,'placeholder'=>"Max 200 character only", "id" => "Requirementdesc",'value'=>$reqdetail[0]['RequirementDetail']['details']));?> 

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
                           
             
                          
                       <?php 

                       $skilllist=$this->Common->getskilllist();
 $skilllist=$this->Common->getskilllist();
          $items=$this->Common->getskilllistbycode($reqdetail[0]['RequirementDetail']['req_id']);
         
         foreach ($items as $item) {
             $value_skills[]=$item['MstRequirement']['id'];
             # code...

         }
                            echo $this->form->input('required_skills', array('label' => false,'type' =>'select','multiple'=>'multiple', 'id'=>'kUI_multiselect_basic','empty' => ' -- Select Skills --', 'options' => $skilllist,'value'=>$value_skills));
                            
                              
                                 ?> 


                        </div>
                       
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
 <label for="subject"><h3>Remark<span class="req">*</span></h3></label>

                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            
                            <div class="parsley-row">
                   
                                <?php echo $this->form->input('RequirementDetail.remark', array('label' =>false, 'class' => "md-input",'placeholder'=>"Max 50 character only",'required'=>true, "id" => "remark" ));
                          ?> 

                        </div>
                        </div>
                    </div>

                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">

<?php
$hr_approval_status=$this->Common->findappstatus($reqdetail[0]['RequirementDetail']['req_id']);
 if($hr_approval_status==3)
{?>
   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hiring Type</label>
   <?php 
                                $hlist=array('1'=>'Internal','2'=>'External','3'=>'Both');  
                            echo $this->Form->input('RequirementDetail.hiring_type', array('type' => 'select', 'label' => "",'options' => $hlist, 'class' => 'md-input', 'id' => 'h_code', "data-md-selectize" => "data-md-selectize")); }
                            else {?>

                            <!-- <input type="hidden" value ="<?php //echo $leave; ?>" name="data">  -->
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">To be approved by:*</label>
                            <?php

                            if($reqdetail[0]['RequirementDetail']['status']==2&&($reqdetail[0]['RequirementDetail']['position_type']!=1)||($reqdetail[0]['RequirementDetail']['hr_approval_status']==6))
                            {
/*$emp_code=array('303','239');*/

                             
                            //cho $reqdetail[0]['RequirementDetail']['hr_approval_status'];
$hrList = $this->Common->gethrmasterlist(10);
                      
    $emp_code=$hrList;
                            
                             $hrList = $this->Common->getemloyeelist($emp_code);
                           }
                           else{

                            $hrcode=$this->common->getmd($auth['MyProfile']['comp_code']);
                            $hrList = $this->Common->getemloyeelist($hrcode);
                           }

                              echo $this->Form->input('RequirementDetail.hr_emp_code', array('type' => 'select', 'label' => "", 'options' =>  $hrList, 'class' => 'md-input', 'id' => 'fwlvempcode', "data-md-selectize" => "data-md-selectize")); }?>
                        </div>
                    </div>
                </div>


              
<div class="uk-grid">
                   <?php 
                   if ($reqdetail[0]['RequirementDetail']['position_type']==1)
{
 $getlevel=$this->Common->findAppLevel('22');
}
else{

$getlevel=$this->Common->findAppLevel('10');

}
$hr_approval_status=$this->Common->findappstatus($reqdetail[0]['RequirementDetail']['req_id']);

                   $level=$this->Common->findreqlevel($reqdetail[0]['RequirementDetail']['req_id']);


            if($hr_approval_status==3) { ?>
<div class=" uk-margin-top">                            
                         <button type="submit" name="type" value="final_App" class="md-btn md-btn-success" >Approve</button>
                    </div>
                    <div class="uk-margin-top">                            
                   <button type="submit" name="type" value="Reject" class="md-btn md-btn-danger" >Reject</button>           
                    </div>
                </div>
            <?php }
            else {?>
                    <div class=" uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Approve</button>                    
                    </div>
                    <div class="uk-margin-top">                            
                   <button type="submit" name="type" value="Reject" class="md-btn md-btn-danger" >Reject</button>           
                    </div>
                </div>
                <?php }?>
                <?php echo $this->Form->end();?>
          




</div>
</div>
</div>
</div>
</div>

        
<?php }?>   
<script type="text/javascript">
  
 function check(){

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
       }
       else{
         $("#emp_group").hide();

       }
    }
   /*  function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>Recruitment/rejectId/'+id,
        success: function(data){
            //alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
 }*/
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
