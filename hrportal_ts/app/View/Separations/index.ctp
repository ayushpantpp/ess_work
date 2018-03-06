

<?php $i = 1; ?>
<div id="page_content">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
          <div class="md-card-toolbar">
                            <div class="md-card-toolbar-actions">
                                
                               
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                               <b>Separation List</b>
                            </h3>
                        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>           
                                <th>Employee Name</th>
                                <th>Resign Date </th>
                                <th>Separation Status</th>
                                <th class="filter-false remove sorter-false">Resignation Reason</th>
				<th class="filter-false remove sorter-false">Remark</th>
				<th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php if (empty($separations)) { ?>
                                <tr>
                                    <td style="text-align:center;" colspan="5">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php   $i=1; foreach($separations as $pending_detail) {                               
                                ?>
                                <tr>
                                    <td>
                          <?php 
        @$ctr = (($this->params['paging']['Separation']['options']['page']*$this->params['paging']['Separation']['options']['limit'])-$this->params['paging']['Separation']['options']['limit'])+$i;
         echo $ctr; ?>
                    </td>
                                    <td>
                        <?php $empname =$this->Common->getempinfo($pending_detail['Separation']['emp_code']);
                        echo $empname ;?>
                    </td>
				 <td>
                        <?php echo date("d-M-Y",strtotime($pending_detail['Separation']['created']));?>
                    </td>    
			 <td>
                    <?php
                    echo $this->Common->findSatus($pending_detail['Separation']['status']);

                    ?> 
                    </td>
			<td><?php echo $this->Common->getReason($pending_detail['Separation']['reason']);?></td>
                    	                                        
                        <td><?php if(!empty($pending_detail['Separation']['remark'])){ echo $pending_detail['Separation']['remark'];}else{ echo 'N/A';}?></td>

			<td>
                    <?php 
                    if($pending_detail['Separation']['status'] == 1):?>
                     <a class="btn btn-primary" href="<?php echo $this->webroot;?>separations/workflow_display/<?php echo $pending_detail['Separation']['id'];?>" title="Click to Forward.">Forward</a>      
                   <?php endif;
                   if($pending_detail['Separation']['status'] == 5) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-xs btn-success" href="'.$this->Html->url('/fnfs').'"> View FNFS</a>';
                    }
                    ?>
                   </td>
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