<?php $auth=$this->Session->read('Auth');?>     
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Seperation List</h3>

<div id="alerts"></div>
        <div class="md-card">
            <div class="md-card-content">
                
                <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                    <thead>
                      <tr class="headings">
                      <th>Sr.No</th>
                       <th>Emp Name</th>
                       <th>Forwarded Date</th>
                       <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                        <?php 
                        $i=1;
                        if(empty($separation)) { ?>
                          <tr>
                          <td colspan="4"> No records Found</td>
                          </tr>
                       <?php } else {

                        foreach ($separation['SeparationWorkflow'] as $workFlow ) { ?>
                         <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $this->Common->getempinfo($workFlow['emp_code']); ?></td>
                          <td><?php if($workFlow['fw_date']){echo date("d-M-Y",strtotime( $workFlow['fw_date']));}else { echo N/A;} ?></td>
                          <td><?php if($workFlow['remarks'] == " " || is_numeric($workFlow['remarks'])) {echo 'N/A';} else {echo $workFlow['remarks'];}?></td>
                          </tr>
                        <?php
                        $i++;
                        }
                        $checllvl = $this->Common->findAppLevel($appId);
                        /*print_r($current_separation_level);
                        print_r($checllvl);*/
                        if($current_separation_level == ($checllvl-1)) {
                          $fwemplist = $this->Common->findSepLevel($separation['SeparationWorkflow']);
                        }
                        else {
                          $fwemplist = $this->Common->getSepHrList($auth['MyProfile']['emp_code'],$separation['SeparationWorkflow']);
                        }

                         ?>
                    </tbody>
                </table>
            </div>
        </div>
         <div class="md-card">
            <div class="md-card-content">
                <?php 
                  echo $this->Form->create('separation', array(
                    'inputDefaults' => array(
                      'label' => false, 
                      'div' => false, 
                      'error' => array(
                        'wrap' => 'span', 
                        'class' => 'my-error-class'
                        )
                      ),
                    'url' => array(
                      'controller' => 'separations', 
                      'action' => 'process_approval'
                      ), 
                    'id' => 'separationid', 
                    'name' => 'separation_name')
                  );
                  echo $this->Form->input('SeparationWorkflow.id', array('type' => 'hidden', 'label' => false, 'value' => $separation['Separation']['id']));
                  echo $this->Form->input('SeparationWorkflow.wf_id', array('type' => 'hidden', 'label' => false, 'value' => $current_wf_id));
                ?>
                
                          <div class="uk-grid" data-uk-grid-margin > 
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row">
                                    
                                      
                            <?php
                            if(($current_separation_level-1) < $checllvl) {
                            ?>
                            <input type="radio" class="iCheck-helper" name="data[SeparationWorkflow][type]" value="2" onclick="return displaytype(this.value)" checked="checked" ><strong> Forward </strong>
                            
                            <?php
                            }
                            else { ?>
                            <input type="radio" class="iCheck-helper" name="data[SeparationWorkflow][type]" value="5" checked="checked"  ><strong> Approve </strong>
                           
                            <?php }
                            ?>
                                         
                               
                            <input type="radio" class="iCheck-helper"  name="data[SeparationWorkflow][type]" value="4" onclick="return displaytype(this.value)"  ><strong> Reject </strong>
                            
                                </div>
                            </div>
                          </div>
                <table>
                    <tbody>
                         <?php if(($current_separation_level-1) < $checllvl) {?>
                         <tr id="forward" class="hidehr">
                          <td align="right">Forward :</td>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <?php echo $this->Form->input('SeparationWorkflow.emp_code', array('type' => 'select', 'label' => false, 'options' => $fwemplist, 'class'=>"md-input data-md-selectize ", 'id' => 'fwlvlempcode')); ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                    <textarea  class="md-input" cols="form-control"  name="data[SeparationWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea>
                                </td>
                              </tr>
                            </table>
                          </tr>
                         <?php } else {?>
                          <tr id="approved_tr" class="hidehr">
                          <td align="right">Remark:</td>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <textarea class="md-input" cols="form-control"  name="data[SeparationWorkflow][approve_remark]" id="appcmnt" col="100" row="100" ></textarea>
                                </td>
                              </tr>
                            </table>
                          </tr>
                         
                         <?php }?> 
                         <tr id="reject" style="display:none;">
                          <td align="right">Remark*</td>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <textarea class="md-input" cols="form-control"  name="data[SeparationWorkflow][reject_remark]" id="rejectcmnt" col="100" row="100" ></textarea>
                                </td>
                              </tr>
                            </table>
                          </tr>
                          
                       
                    </tbody>
                  </table>
                 
                  <!-- Form to approve/forward/reject/revert a separation-->
                    
                  <?php
                  echo $this->Form->submit('Submit',array('onClick' => 'return checkSubmit()','class'=>'md-btn md-btn-success'));
                   echo $this->Form->end();
                  } ?>


              </div>
            </div>
          </div>
        </div>
      </div>
      

    </div>


 <script type="text/javascript">
function displaytype(a)
{
  
    //var typeval = $("input[name='data[TravelWorkflow][type]']:checked").val();
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
    }else if (typeval == 5)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', 'none');
        $("#forward").css('display', 'none');
        $("#approved_tr").css('display', '');
		$("#forward_hr_tr").css('display', 'none');
    }else if (typeval == 6)
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
         $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to forward.").show();
      return false;
    } 
  }
 else if ($('#revert').is(':visible'))
  { 
    if ($("#revertempcode").val() == '')
    {
       $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Select the employee name to whom you want to revert.").show();
      return false;
    } 
    if ($("#revcmnt").val() == '')
    {
      $("html, body").animate({ scrollTop: 0 }, "slow");
$("#alerts").html("<div data-uk-alert='' class='uk-alert uk-alert-danger'><a class='uk-alert-close uk-close' href='#'></a>Enter Revert Comment").show();
      return false;
    } 
  }
 else  if ($('#reject').is(':visible'))
  {
  
    if ( $.trim( $('#rejectcmnt').val() ) == '' )
    {
       
       $("html, body").animate({ scrollTop: 0 }, "slow");
       $("#alerts").html('<div class="uk-alert uk-alert-danger" data-uk-alert=""><a href="#" class="uk-alert-close uk-close"></a>Enter Reject Remark.</div>').show();
          
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
  
      $(function(){

             // Dialog
        $('#dialog').dialog({
          autoOpen: false,
          width: 600,
          modal:true,
          buttons: {
            "Ok": function() {
             var cmnt=$('#cmnt').val();
     
            if(cmnt==' ')
            {     
              $('#errdis').show('slow', function() {
                   // Animation complete.
            });
            return false;
          }else{
            $(this).dialog("close");
              document.leave.submit();
            }

          },
            "Cancel": function() {
              $(this).dialog("close");
            }
          }
        });
                         

      });

    </script>
<script>

function reject(wfid,compcode,vno,sdate,edate)
{
  var wfid=document.getElementById("wf_id").value=wfid;
      var compcode=document.getElementById("ccode").value=compcode;
      var leaveno=document.getElementById("leaveno").value=vno;
      var stdate=document.getElementById("stdate").value=sdate;
      edate=document.getElementById("eddate").value=edate;
        $('#dialog').dialog('open');
  return false;
}

function getcmtval()
{
      var leaveno=document.getElementById("cmnt").value;
      var rjres=document.getElementById("rejectres").value=leaveno;
    
}

</script>
