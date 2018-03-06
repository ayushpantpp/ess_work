
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
        <b><?php echo $pageheading;?></b>
        </h3>
         </div>
            <div class="md-card-content large-padding">
                <?php
               if(!empty($candidatedetails))
                {

                ?>
                <?php 

                echo $this->Form->create('doc', array('url' =>array('controller' => 'Recruitment', 'action' =>'saveintinfo'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked')); 
                $auth=$this->Session->read('Auth');  $options = $this->Common->option_name($auth['MyProfile']['emp_nm_ttl']);
                 echo $this->form->input('id', array('value' => $candidatedetails['CandidateDetail']['id'], 'type' => 'hidden'));
                 echo $this->form->input('rowcounter', array('id'=>'rowcount', 'type' => 'hidden'));

                ?>
                <div class="uk-grid" data-uk-grid-margin>
                    <?php
                   
                                                if ($block[0]['LabelBlock']['block_status'] == 1) {
                                 
                                                    $candidate_labels = $this->Common->block_labels($block[0]['LabelBlock']['id']);

                                                    if ($candidate_labels['0']['Labels']['label_status'] == 1) {

                                                  
                                                    ?>
                    <div class="uk-width-medium-1-2" >
                        <div class="parsley-row">
                            <label for="req_cat"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels['0']['Labels']['name']);
                                                                ?> <span class="req">*</span></label>
                               <?php 
                               echo $this->form->input('Candidate No', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'readonly'=>true,'id'=>'p_name','value'=>"0". $candidatedetails['CandidateDetail']['id']));
                               
                               ?>
                        </div>
                    </div>
                     <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                         
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels[1]['Labels']['name']);
                                                                ?></label>
                        
                                  <?php 
                               echo $this->form->input('Candidate Name', array('label'=>false, 'type' => 'text', 'class' => "md-input",'required'=>true,'id'=>'p_name','readonly'=>true,'value'=> $candidatedetails['CandidateDetail']['cndt_nm']));
                               
                               ?>
                               
                        </div>
                    </div>
                    
                </div>
            <div class="uk-grid" data-uk-grid-margin > 
                <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="department"><?php
                                                                //Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels[2]['Labels']['name']);
                                                                ?><span class="req">*</span></label>
                               

                                <?php 
                                echo $this->form->input('Join Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' =>'datepicker','required'=>true,"data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'".date('d-m-Y'+1)."'}"));?>
                        </div>
                    </div>
                    <!-- <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="resp" class="fixed"><?php
                                                               
                                                                //echo __d('debug_kit',   $candidate_labels[3]['Labels']['name']);
                                                                ?><span class="req fixed">*</span></label>
                             <?php 
                                 //echo $this->form->input('Available Date', array('label'=>false,'class'=>"md-input ",'type' => 'text', 'id' =>'datepicker1','required'=>true,"data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'".date('d-m-Y'+1)."'}"));?>
                        </div>
                    </div> -->
                    
                    
                </div>
                
                <hr>
                     <div class="uk-grid" data-uk-grid-margin > 
                          <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="department"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels[4]['Labels']['name']);
                                                                ?><span class="req">*</span></label>
                                <?php   $interview_type=array('1'=>'Skype','2'=>'Telephonic','3'=>'F2F');
                                ?>

                                <?php 
                                echo $this->form->input('int_type1', array('label'=>false,'class'=>"md-input ",'type' => 'select','required'=>true,'options'=>$interview_type,"data-md-selectize" => "data-md-selectize"));?>
                        </div>
                    </div>
                <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="department"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels[5]['Labels']['name']);
                                                                ?><span class="req">*</span></label>
               
                                <?php 
                                echo $this->form->input('interview_date1', array('label'=>false,'class'=>"md-input",'type' => 'text', 'id' =>'datepicker2','required'=>true,"data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'".date('d-m-Y'+1)."'}"));?>
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="resp" class="fixed"><?php
                                                                Configure::write('I18n.preferApp', true);
                                                                echo __d('debug_kit',   $candidate_labels[6]['Labels']['name']);
                                                                ?><span class="req fixed">*</span></label>
                             <?php echo $this->form->input('in_time1', array('label'=>false,'class'=>"md-input", "data-uk-timepicker"=> "",'id' => 'in_time')); ?>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="resp" class="fixed"><?php
                             $hrList = $this->Common->getemplist();
                            /* foreach( $hrList as $hr=>$value)
                             {
                               $listing .= '<option value='.$hr.'>'.$hr.'</option>';
                                print_r($$value);
                             }*/          /*  Configure::write('I18n.preferApp', true);*/
                                                                echo __d('debug_kit',   $candidate_labels[7]['Labels']['name']);
                                                                ?><span class="req fixed">*</span></label>
                             <?php 
                               echo $this->form->input('interviewer_1', array('label' => false,'type' =>'select', 'options' =>$hrList, 'id'=>'interviewercode',"data-md-selectize" => "data-md-selectize" ));
                            ?>
                        </div>
                    </div>
                    
                </div>
                <div class="uk-grid" data-uk-grid-margin  id="container"> 
                    
                </div>

               <?php }}
               ?>


              
<div class="uk-grid">
                   <div class=" uk-margin-top">                            
                       <button type="button" name="type" align="left" class="md-btn md-btn-success" id="addmore" >Add More</button>                    
                    </div>
                    <div class=" uk-margin-top">                            
                        <button type="submit" name="type" value="post" class="md-btn md-btn-success" >Submit</button>                    
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
         var counter = 2;
        $("#addmore").click(function () {
  $("#container").append('<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="department"><?php
                echo __d('debug_kit',$candidate_labels[4]['Labels']['name']);?><span class="req">*</span></label><select name="int_type'+counter+'" id="interview_type_'+counter+'" type="select" class="md-input" data-md-selectize><option value="1">Skype</option><option value="2">Telephonic</option><option value="3">F2F</option></select> </div></div>'+'<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="department"><?php
    echo __d('debug_kit',   $candidate_labels[5]['Labels']['name']);?><span class="req">*</span></label><?php 
    echo $this->form->input("interview_date'+counter+'", array('label'=>false, "data-uk-datepicker"=>"{format:'DD-MM-YYYY',minDate:'".date('d-m-Y'+1)."'}",'class'=>"md-input",'type' => 'text','required'=>true));?></div></div>'+'<div class="uk-width-medium-1-4"><div class="parsley-row"><label for="resp" class="fixed"><?php
    echo __d('debug_kit',   $candidate_labels[6]['Labels']['name']);
        ?><span class="req fixed">*</span></label><?php echo $this->form->input("in_time'+counter+'", array('label'=>false,'class'=>"md-input", "data-uk-timepicker"=> "",'id' => 'in_time')); ?></div></div>'+' <div class="uk-width-medium-1-4"><div class="parsley-row"> <label for="resp" class="fixed"><?php 
    echo __d('debug_kit',   $candidate_labels[7]['Labels']['name']);?><span class="req fixed">*</span></label> <select name="interviewer_'+counter+'" id="interviewercode_'+counter+'" class="selecters"  ><option value="0">Select Interviewer</opton><?php $hrList = $this->Common->getemplist();
    foreach ($hrList as $hr=>$value) {?><option value="<?php echo $hr?>"><?php echo $value;?></option><?php } ?></select></div></div></div>');
 
   $('#form_validation').val(counter);
   
        counter++;
        var rowcount=$('#form_validation').val();
        $('#rowcount').val(rowcount);


         $('.selecters').change(function() {
            
      self = $(this);
      choosen = $(this).val();
     var intval=$("#interviewercode").val();
     if(choosen==intval)
     {
         alert('Interviewer is already selected for this Candidate');
       $(self).val($(this).find("option:first").val()); 
     }

      $('.selecters').not(self).each(function() {


        if ($(this).val() == choosen) {

          // $(this).prop('disabled', true);
          alert('Interviewer is already selected for this Candidate');

         $(self).val($(this).find("option:first").val());

      
        }


      });

    });
  

});
        $("#emp_group").hide();
       
            



    });

</script>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="jquery.tag-editor.js"></script>

<link rel="stylesheet" href="jquery.tag-editor.css">
