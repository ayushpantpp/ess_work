<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="overflow container"></span>
            </div>          
        </div>
    </div>
</div>


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
                              <b> Candidates List</b>
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
                                <th><input type="checkbox" name="all[]" id="check_all", onchange="checkAll(this);"/>All </th>
                                <th>Candidate Name</th>
                                <th>Candidate Type</th>
                                 <th>Gender</th>
                                 <th>Mobile</th>
                                <th>email</th>
                                <th>Marital status</th>
                                <th>Department</th>
                                <th>Designation</th>
                                 <th>Experience</th>
                                <th>Position Name</th>
                                <th>Interview Date</th>
                                
                                <th>Location</th>
                                <th>Download Resume</th>
                                 <th>Status</th> 
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $auth = $this->Session->read('Auth');
                          
                    
                            if (!empty($candidateprofile)) {
                                    $i=0;
                                foreach ($candidateprofile as $list) {
             $findshortstatus1=$this->Common->findshortlist($list['CandidateDetail']['id']);

              
                    foreach ($findshortstatus1 as $findshortstatus) {
                       
                      # code...
                    
                     
                  
           }
                


                                 
                    
                                 if($list['CandidateDetail']['id']==$findshortstatus['CandidateShortlist']['candidate_id']&&($findshortstatus['CandidateShortlist']['status']==2||$findshortstatus['CandidateShortlist']['status']==5))
                              {
                               //print_r($list['CandidateDetail']['status']);
                                  $disabled="disabled";
                                }
                           else{
                                    $disabled="";
                                 }
if ($list['CandidateDetail']['status']==10)
{
    $disabled="disabled";
    $checked="check";
}
else{
  $disabled=" ";
    $checked=" ";
}
                         
                                    
                                    ?>    
                                    <tr> 
                                        <td><input type="checkbox" name="all[]" id="check_<?php echo $i;?>" <?php echo ($list['CandidateDetail']['id']==$findshortstatus['CandidateShortlist']['candidate_id']&&($findshortstatus['CandidateShortlist']['status']==2||$findshortstatus['CandidateShortlist']['status']==5) ? 'checked' : '');?> <?php echo $disabled;?> <?php echo $checked;?>class="checkSingle" value="<?php echo $list['CandidateDetail']['id'];?>"   </td> 
                                        <td><?php echo $list['CandidateDetail']['cndt_nm'];?></td>
                                         <td><?php if($list['CandidateDetail']['cndt_type']==1){ echo "Fresher";}else{
                                          echo "Experience";}?></td>
                                        <td><?php if($list['CandidateDetail']['cndt_gen] ']==1){echo 'Female';}else{ echo "Male";}?></td>
                                        <td><?php echo $list['CandidateDetail']['cndt_phone1'];?></td>
                                        <td><?php echo $list['CandidateDetail']['cndt_email'];?></td>   
                                        <td><?php if($list['CandidateDetail']['cndt_mrtl_stat']==1){echo 'Single';}else{ echo "Married";} ?></td>
                                    
                                        <td><?php echo $this->Common->getdepartmentbyid($list['CandidateDetail']['cndt_dept_id']);?></td>
                                        <td><?php  echo $this->Common->findDesignationNameByCode($list['CandidateDetail']['cndt_desg_id']); ?></td>

                            <td><?php echo  $list['CandidateDetail']['cndt_exp']; ?></td>
                            <td><?php echo  $list['CandidateDetail']['position_name']; ?></td>
                           <td> <?php echo  date("d-m-y",strtotime($list['CandidateDetail']['cndt_join_date'])); ?></td>
                            <td><?php  echo $this->Common->findLocationNameByCode($list['CandidateDetail']['cndt_loc_id']);?></td>
<td ><a class="uk-badge uk-badge-success" href="<?php echo $this->webroot.'Recruitment/download/'.base64_encode($list['CandidateDetail']['id']); ?>" ><?php echo "Download"; ?></a></td>
                           <td ><a class="uk-badge uk-badge-primary"><?php  
if($list['CandidateDetail']['status']==10)
{
  echo $btnStatus = $this->Common->findSatus($list['CandidateDetail']['status']);
}

                          elseif ($findshortstatus['CandidateShortlist']['status'] == 2&&$findshortstatus['CandidateShortlist']['candidate_id']==$list['CandidateDetail']['id']) {

                                    // $btnClass = "uk-badge uk-badge-primary";
                                       echo $btnStatus = $this->Common->findSatus($findshortstatus['CandidateShortlist']['status']);

                                    } elseif ($list['CandidateDetail']['id']==$findshortstatus['CandidateShortlist']['candidate_id']) {
                                     
                                        //$btnClass = "uk-badge uk-badge-primary";
                                       echo $btnStatus = $this->Common->findSatus($findshortstatus['CandidateShortlist']['status']);
                                    } 


                                    else{
                                           echo "On Hold";

                                    } ?></a></td>
                                        <td>
                                          <?php 

if($list['CandidateDetail']['status']!=10)
{
           if($findshortstatus['CandidateShortlist']['status']==5&&$findshortstatus['CandidateShortlist']['candidate_id']==$list['CandidateDetail']['id'])
                                          {
                                          ?>
<a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot; ?>Recruitment/scheduleinterview/<?php echo base64_encode($list['CandidateDetail']['id']); ?>/" title="Click to Schedule Interview." >Schedule Interview</a>   <?php }?>
                                          <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>Recruitment/deleteCandidateDetails/<?php echo base64_encode($list['CandidateDetail']['id']); ?>/" title="Click to Edit." onclick="return confirm('Are you sure?')" >Deactivate</a>    
                                            
                                        

                                            <!-- </ul> -->
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }}
                            }
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