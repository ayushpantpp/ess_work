

<?php $i = 1; ?>
<div id="page_content">
    <div id="page_content_inner">
        <h3 class="heading_b uk-margin-bottom">Attendance List</h3>
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>           
                                <th>Employee Name</th>
                                <th>Approved BY </th>
                                <th>Approved  Date </th>
                                <th> Status</th>
                       
                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            
                            if (empty($details)) { ?>
                                <tr>
                                    <td style="text-align:center;" colspan="5">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php   $i=1; foreach($details as $pending_detail) {    

                                ?>
                                <tr>
                                    <td>
                          <?php 
        @$ctr = (($this->params['paging']['details']['options']['page']*$this->params['paging']['details']['options']['limit'])-$this->params['paging']['details']['options']['limit'])+$i;
         echo $ctr; ?>
                    </td>
                    <td>

                    <?php 


                    echo $pending_detail['emp_full_name'];?>
                    </td>
                    <td>
                    <?php echo $this->Common->findManagerNameCode($pending_detail['manager_code']);?>
                    </td>
                   <td>
<?php 

echo $this->Common->findapplydate($pending_detail['emp_id']);?>
                   </td>

                    <td>
                        <?php 

$status=$this->Common->findapprovestatus($pending_detail['emp_id']);
if($status==2)
{
    echo "Pending";
}
else{
    "Forward To HR ";
}
?>
                    </td>
                                
                   
             <td>
                    <div class="uk-width-1-3 uk-margin-top">                            
                        <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/ComplianceAudit/emp_definition') ?>">Approve</a>   
                          <a class="md-btn md-btn-danger" href="<?php echo $this->Html->url('/ComplianceAudit/emp_definition') ?>">Reject</a>                    
                    </div>
                    </td>
            <td><?php ?></td>
                                                                
            
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <ul class="uk-pagination uk-pagination-right">
<?php
echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
?>
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>


    <script type="text/javascript">
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
                                                       {     $('#errdis').show('slow', function() {
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