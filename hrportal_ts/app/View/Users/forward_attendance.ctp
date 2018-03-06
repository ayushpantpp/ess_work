<?php
$auth = $this->Session->read('Auth'); ?>
<div id="page_content" role="main">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">HR Approval </h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content large-padding">
                <?php
                echo $this->Form->create('forward', array('inputDefaults' => array(
                        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
                    'url' => array('controller' => 'users', 'action' => 'hr_approve_attendance'), 'id' => 'fwdid', 'name' => 'forwardfname'));
                ?>
         
                <table class="uk-table">
        
                    <thead>
                        <tr class="headings">

                            <th>SR No</th>
                            <th>Emp Name</th> 
                            <th> Forwarded BY</th>                       
                            <th> Forwarded Date</th>
                            <th>Remarks (if any)</th>
                        </tr>
                    </thead>
                    <tbody>
              <?php        

              foreach($pen_attendances as $srcdet)  {
            
              if($srcdet['AttendanceDetail']['status']==2)
              {
                   
              
                    if($i%2==0)$class='even pointer'; else $class='odd pointer';?>
                            
                              
                        <tr class="<?php echo $class; ?>">
                            <td ><strong><?php echo $i+1;?></strong> </td>
                            <td ><strong> <?php echo $this->Common->findEmpNameDocID($srcdet['AttendanceDetail']['emp_doc_id']);?></strong> </td>
                            <td ><strong>
                                    <?php


                                     echo $this->Common->findEmpnamebycode($srcdet['AttendanceDetail']['approver_id']);?>         
                                </strong> </td>

                            <td><strong>
                                  <?php


                                     echo $srcdet['AttendanceDetail']['modify_date'];?></strong>

                            </td><tr>
                              

                        <tr>
                            <td colspan="3" style="display:none"> 
                                <input type="hidden" value ="<?php echo $srcdet['AttendanceDetail']['id']; ?>" name="data[AttendanceDetail][id]"> 
                               
                            </td>
                        <tr>
                      
                              
                        <tr class="hidehr"> 

                            <td>
                                <input type="radio" class="flat" name="data[AttendanceDetail][type]" value="5" checked="checked" onclick="displaytype(this.value);"> <strong>Approve </strong>
                            </td>
                                

                          
                           <td colspan="3">
                                <input type="radio"  class="form-control flat" name="data[AttendanceDetail][type]" onclick="displaytype(this.value);" value="4"><strong> Reject </strong>
                            </td>


                        </tr>

                        <tr id="reject" style="display:none;">
                            <td align="right">Remark*</td>
                            <td colspan="5">
                                <table>
                                    <tr>
                                        <td>
                                            <textarea class="form-control" style="width: 348px; height: 95px;"  name="data[AttendanceDetail][reject_remark]" id="rejcmnt" col="100" row="100"  ></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
  
      
                       

                            
                        <tr id="forward_hr_tr" class="hidehr">          
                            <td align="right">Forward to HR :</td>
                            <td colspan="2">
                                <table>
                                    <tr><td>
            <?php 
 $hrList = $this->Common->getemplist($auth['MyProfile']['emp_code']);
            echo $this->Form->input('AttendanceDetail.hr_emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $hrList, 'class' => 'form-control round_select', 'id' => 'fwhrempcode')); ?>
                                        </td></tr></table>

                                                

                        <tr id="approved_tr" class="hidehr">
                            <td align="right">Remark :</td>
                            <td colspan="5">
                                <table>    
                                    <tr>
                                        <td ><textarea class="form-control" style="width: 348px; height: 95px;" name="data[AttendanceDetail][approve_remark]" id="appcmnt" col="100" row="100" ></textarea>
                                        </td>
                                    </tr>
                                </table>
                        </tr>       
      <?php $i++;}}?>


                    </tbody>
                </table>
                            <?php echo $this->Form->submit('Submit', array('onClick' => 'return checkSubmit()', 'name' => 'data[AttendanceDetail][save]', 'class' => 'md-btn md-btn-success')); ?>
                <?php $this->Form->end(); ?>
            </div>

        </div>
    </div>
</div>
</div>
<div class="uk-modal" id="popup1">
    <div class="uk-modal-dialog">
        <div class= "HRcontent"></div>
        <div class="uk-modal-footer uk-text-right">
            <button type="button" class="md-btn md-btn-flat uk-modal-close">Close</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    function displaytype(a)
    {
        var typeval = a;
        if (typeval == 2)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', '');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 3)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', '');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 4)
        {
            $("#reject").css('display', '');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', 'none');
        } else if (typeval == 5)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', '');
            $("#forward_hr_tr").css('display', '');
        } else if (typeval == 6)
        {
            $("#reject").css('display', 'none');
            $("#revert").css('display', 'none');
            $("#forward").css('display', 'none');
            $("#approved_tr").css('display', 'none');
            $("#forward_hr_tr").css('display', '');
        }
    }
    function checkSubmit()
    {
        if ($('#forward').is(':visible'))
        {
            if ($("#fwlvlempcode").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward.").show();
                return false;
            }
        } else if ($('#revert').is(':visible'))
        {
            if ($("#revertempcode").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.").show();
                return false;
            }
            if ($("#revcmnt").val() == '')
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Comment").show();
                return false;
            }
        } else if ($('#reject').is(':visible'))
        {
            if ($.trim($("#rejcmnt").val()) == "")
            {
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Reject Remark.").show();
                return false;
            }
        }
        if ($('#forward_hr_tr').is(':visible'))
        {
            if ($("#fwhrempcode").val() == '')
            {
                alert("Select the HR Name to whom you want to forward.");
                return false;
            }
        }
        return true;
    }


</script>
<script>

function Get_Details(id)
{   
    jQuery.ajax({
        url: '<?php echo $this->webroot ?>users/rejectId/'+id,
        success: function(data){
			//alert(data);
            jQuery('.HRcontent').html(data);
        }
    });
 }
 
 function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>users/attendance_approve/"+val; 

 }



</script>	
