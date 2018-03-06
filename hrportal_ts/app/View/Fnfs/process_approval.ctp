<div role="main" class="right_col">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3> FNF List </h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
          <div class="clearfix"></div>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              
              <div class="x_content">
                <?php 
                  echo $this->Form->create('fnf', array(
                    'inputDefaults' => array(
                      'label' => false, 
                      'div' => false, 
                      'error' => array(
                        'wrap' => 'span', 
                        'class' => 'my-error-class'
                        )
                      ),
                    'url' => array(
                      'controller' => 'fnfs', 
                      'action' => 'process_approval'
                      ), 
                    'id' => 'fnfid', 
                    'name' => 'fnf_name')
                  );
                  echo $this->Form->input('FnfWorkflow.id', array('type' => 'hidden', 'label' => false, 'value' => $fnf['Fnf']['id']));
                  echo $this->Form->input('FnfWorkflow.wf_id', array('type' => 'hidden', 'label' => false, 'value' => $current_wf_id));
                ?>
                <table class="table table-striped responsive-utilities jambo_table bulk_action">
                    <thead>
                      <tr class="headings">
                      <th>Sr.No</th>
                       <th>Emp Name</th>
                       <th>Applied Date</th>
                       <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                     
                        <?php 
                        $i=1;
                        if(empty($fnf)) { ?>
                          <tr>
                          <td colspan="4"> No records Found</td>
                          </tr>
                       <?php } else {

                        foreach ($fnf['FnfWorkflow'] as $workFlow ) { ?>
                         <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo $this->Common->getempinfo($workFlow['emp_code']); ?></td>
                          <td><?php echo $workFlow['fw_date']; ?></td>
                          <td><?php echo $workFlow['remarks'];  ?></td>
                          </tr>
                        <?php
                        $i++;
                        }
                        $checllvl = $this->Common->findcheckLevel1($appId);
                        $fwemplist = $this->Common->findLevel1($checllvl,'Apply'); 

                         ?>
                         <tr>
                          <td colspan="4">
                            <input type="radio" class="flat" name="data[FnfWorkflow][type]" value="5" checked="checked" ><strong> Approve </strong>
                            <?php
                            if(!empty($fwemplist)) {
                            ?>
                            <input type="radio" class="flat" name="data[FnfWorkflow][type]" value="2"><strong> Forward </strong>
                            <?php
                            }
                            ?>
                            
                            <input type="radio" class="flat" name="data[FnfWorkflow][type]" value="4"><strong> Reject </strong>
                             
                          </td>
                         </tr>
                         <tr id="forward" style="display:none;">
                          <td align="right">Forward :</td>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <?php echo $this->Form->input('FnfWorkflow.emp_code', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'form-control round_select', 'id' => 'fwlvlempcode')); ?>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  <textarea cols="form-control"  name="data[FnfWorkflow][forward_remark]" id="frwdcmnt" col="100" row="100" > </textarea>
                                </td>
                              </tr>
                            </table>
                          </tr>
                         <tr id="reject" style="display:none;">
                          <td align="right">Reject :</td>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <textarea cols="form-control"  name="data[FnfWorkflow][reject_remark]" id="rejectcmnt" col="100" row="100" > </textarea>
                                </td>
                              </tr>
                            </table>
                          </tr>
                         <!-- <tr>
                          <td colspan="4">
                            <table>
                              <tr>
                                <td>
                                  <?php echo $this->Form->submit('Submit');?>
                                </td>
                              </tr>
                            </table>
                          </tr> -->
                      
                    </tbody>
                  </table>
                 
                  <!-- Form to approve/forward/reject/revert a fnf-->
                    <?php echo $this->Form->submit('Submit',array('onClick' => 'return checkSubmit()','class'=>'btn btn-success'));?>
                  <?php
                   echo $this->Form->end();
                  } ?>


              </div>
            </div>
          </div>
        </div>
      </div>
      

    </div>
<script type="text/javascript">
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
