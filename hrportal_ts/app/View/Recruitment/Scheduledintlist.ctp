

<div class="uk-width-medium-1-2">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="overflow container"></span>
            </div>          
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function () {
        $('#alerts').hide;

    });
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>Recruitment/candidateeditprofile/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script> 

<?php $i = 0; ?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">  
        <div class="md-card-toolbar">
          

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> 
              
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Candidate Interview Scheduled Details </b>
                            </h3>
                        </div>

            <div class="md-card-content">
                <?php 
                echo $this->Form->create('candidate_shortlist', array('url' =>array('controller' => 'Recruitment', 'action' =>'shortlisting'),'type' => 'file','name'=>'Form1','id'=>'form_validation','class' => 'uk-form-stacked'));
                 echo $this->form->input('candidate_shortlist.can_list', array('id'=>'sel_list', 'type' => 'hidden')); ?>
                <div class="uk-overflow-container uk-margin-bottom">

                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>                
                                 <?php

                   
                                                if ($block[0]['LabelBlock']['block_status'] == 1) {
                                 
                                                    $candidate_labels = $this->Common->block_labels($block[0]['LabelBlock']['id']);

                                                    if ($candidate_labels['0']['Labels']['label_status'] == 1) {

                                                  
                                                    ?>
                                <th> <?php echo __d('debug_kit',   $candidate_labels['1']['Labels']['name']);?></th>
                                 <th><?php echo __d('debug_kit',   $candidate_labels['2']['Labels']['name']);?></th>
                                 <!-- <th><?php //echo __d('debug_kit',   $candidate_labels['3']['Labels']['name']);?></th> -->
                                <th><?php echo __d('debug_kit',   $candidate_labels['4']['Labels']['name']);?></th>
                                <th><?php echo __d('debug_kit',   $candidate_labels['5']['Labels']['name']);?></th>
                                <th><?php echo __d('debug_kit',   $candidate_labels['6']['Labels']['name']);?></th>
                               <!--  <th>Designation</th>
                                 <th>Experience</th>
                                <th>Position Name</th>
                                <th>Interview Date</th>
                                
                                <th>Location</th>
                                 <th>Status</th>  -->
                                <th>Action</th> 
                                <?php }}?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $auth = $this->Session->read('Auth');
                          
                    
                            if (!empty($candidatedetails)) {
                                    $i=0;
                                foreach ($candidatedetails as $list) {                        
                                  
                                    ?>    
                                    <tr> 
                                      
                                        <td> <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $list['InterviewerDetails']['candidate_id']; ?>')"  title="Click to View." ><?php echo $this->common->getcandidatenamebyid($list['InterviewerDetails']['candidate_id']);?></a></td>
                                        <td><?php echo $rqdate=$list['scheduleinterview']['req_int_date'];?></td>
                                     <!--    <td><?php echo $list['scheduleinterview']['avl_int_date'];?></td>
                                         -->
                                        <td><?php if($list['InterviewerDetails']['int_type ']==1){ echo 'Skype';}else if($list['InterviewerDetails']['int_type ']==2){ echo "Telephonic";}else{
                                          echo "F2F";
                                        } ?></td>
                                    
                                        <td><?php echo $list['InterviewerDetails']['int_date'];?></td>
                                        <td><?php  echo $list['InterviewerDetails']['int_time']; 
                                        echo $list['InterviewerDetails']['interviewer_level'];?></td>

                            
                                        <td>
<a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot; ?>Recruitment/interviewrating/<?php echo base64_encode($list['InterviewerDetails']['candidate_id']); ?>/" title="Click to Schedule Interview." >Interview Rating</a>   
                                          <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>Recruitment/deleteCandidateDetails/<?php echo base64_encode($list['InterviewerDetails']['candidate_id']); ?>/" title="Click to Edit." onclick="return confirm('Are you sure?')" >Deactivate</a>    
                                            
                                        

                                            <!-- </ul> -->
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                
                            }}
                            else {
                                ?>

                                <tr>
                                    <td colspan="12">
                                        No records found
                                    </td>
                                </tr>
                                <?php
                            }
                            ?> 

                        </tbody>
                    </table>
            
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
                             

                            
                        </ul>
                    </div>

                </div><?php 
if (!empty($candidateprofile)) {?>
                <button type="submit"  class="md-btn md-btn-primary"  id="buttonClass" >Send</button>
<?php }?>
            </div>

            <div id="container" ></div>
             <?php echo $this->Form->end();?>
        </div>

       <script type="text/javascript">
        var selected = new Array();

    $(document).ready(function () {
    /* Get the checkboxes values based on the class attached to each check box */

  
    $("#buttonClass").click(function() {
        get_sel();
    });
    
  $("#check_all").change(function(){
    if(this.checked){
      $(".checkSingle").each(function(){
        this.checked=true;

    
      })              
    }else{
      $(".checkSingle").each(function(){
        this.checked=false;
      })              
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")){

      var isAllChecked = 0;
      $(".checkSingle").each(function(){
        if(!this.checked)

           isAllChecked = 1;
      })              
      if(isAllChecked == 0){ $("#check_all").prop("checked", true); }     
    }else {
      $("#check_all").prop("checked", false);
    }
  });
});

function get_sel()
{
   var chkArray = [];
    
    /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
    $(".checkSingle:checked").each(function() {
        chkArray.push($(this).val());
    });
    
    /* we join the array separated by the comma */
    var selected;
    selected = chkArray.join(',') ;
    //alert(selected.length);
     
    /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
    if(selected.length > 0){
      /*  alert("You have selected " + selected); */
        /*alert(selected.length);*/
          $("#sel_list").val(selected);
    }else{
        alert("Please at least one of the checkbox");   
    }
   
 //var n=$("input[id=check_]",+ids).val()

}
function get_paginate(val)
  {   
//var page= $("#paginate").val(val);
  window.location.href="<?php echo $this->webroot;?>Recruitment/view/"+val; 


 }
 </script>

  
   