<!--<div role="main" class="right_col">
      <div class="">-->
       <div id="page_content">
        <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
            
            <h1>FNFS Approval List</h1>
            <span class="uk-text-upper uk-text-small">
                <?php foreach($bredcrum as $breC ){?>
                <a href="<?php echo $this->Html->url('currentfolder/'.$breC['Category']['id']); ?>"> <?php echo $breC ['Category']['name'];?></a>/  
                <?php }?>
            </span>
        </div>
           
           
           <div id="page_content_inner">
            <?php echo $this->Session->flash();?>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-overflow-container uk-margin-bottom">
                        
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                            <thead>
                                <tr>
                                    
                                    <th class="uk-text-center">Sr.No</th>
                     <th>Emp Name</th>
                     <th>FNFS Applied Date</th>
                    <!-- <th>Reject Reason/Forward Remark</th>
                     <th>HR Remark</th>
                     -->
                     <th>Status</th>
                     <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php  $auth=$this->Session->read('Auth'); ?>

                <?php if(count($pending_fnf)==0) { ?>
                  <tr class="cont">
                      <td style="text-align:center;" colspan="8">
                          <em>--No Records Found--</em>
                      </td>
                  </tr>
                <?php } ?>
                                <?php $i=1; 
                  for($p=0;$p<count($pending_fnf);$p++)              
                  { ?>
                    <tr <?php if($i%2==0){?>class="cont1" <?php } else {?>class="cont" <?php } ?>>
                    <td>
                      <?php 
                      //@$ctr = (($this->params['paging']['Fnf']['page']*$this->params['paging']['Fnf']['limit'])-$this->params['paging']['Fnf']['limit'])+$i;
                      $ctr = (($this->params['paging']['FnfDetail']['page']*$this->params['paging']['FnfDetail']['limit'])-$this->params['paging']['FnfDetail']['limit'])+$i;
                        echo $ctr;
                        
                        
                      ?>
                    </td>
                    <td>
                        <?php 
                        $empname =$this->Common->getempinfo($pending_fnf[$p]['Fnf']['emp_code']);
                        echo $empname ;?>
                    </td>
                    <td>
                        <?php echo date("d-M-Y",strtotime($pending_fnf[$p]['Fnf']['created']));?>
                    </td>
                   <!-- <?php if($pending_fnf[$p]['FnfDetail']['approver_remark'] != " "){ ?>
                    <td>
                    <?php  echo $pending_fnf[$p]['FnfDetail']['approver_remark'];?>
                   </td>
                    <?php } else {?>
                   <td>
                       <p>N/A</p>
                   </td>
                    <?php } ?>
                   <?php if($pending_fnf[$p]['FnfDetail']['remarks'] != " "){?>
                   <td>
                      <?php  echo $pending_fnf[$p]['FnfDetail']['remarks'];?>
                   </td>
                   <?php } else {?>
                   <td>
                       <p>N/A</p>
                   </td>
                   <?php }?>-->
                    <td>
                      <?php
                      echo $this->Common->findSatus($pending_fnf[$p]['FnfDetail']['status']);
                      ?>
                    </td>
                    <td>
                    <?php
                    if($pending_fnf[$p]['FnfDetail']['status'] == 1) {
                        //process
                        echo $this->Html->link('Approve / Reject',  array('action'=>'process_fnf_detail',$pending_fnf[$p]['FnfDetail']['id']));
                      
                    }
                    else {
                      echo 'N/A';
                    }
                    ?>

                    </td>
                  </tr>
                  <?php 
                  $i++ ;
                    }  
                    ?>
                                
                            </tbody>
                            
                            <div id="dialog" title="Remark/Comment" style="display:none">
    <div>
        <textarea  name="reject_reson" id="cmnt" col="100" row="100" style="width: 550px; height:200px;" onKeypress="getcmtval()" > </textarea>
        <div class="ui-widget" id="errdis" style="display:none">
            <div class="ui-state-error ui-corner-all" style="margin-top: px; padding: 0pt 9em; margin-left: 0px;">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            <strong></strong> Please write rejection reason.</p>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="wf_id" name="wf_id" value=''/>
<input type="hidden" id="leaveno" name="leave_no" value=""/>
<input type="hidden" id="ccode" name="comp_code" value=""/>
<input type="hidden" id="stdate" name="start_date" value=""/>
<input type="hidden" id="eddate" name="end_date" value=""/>
<input type="hidden" id="rejectres" name="rejectreson" value=""/>
                        </table>
                    </div>
                    
                    <div  class="uk-width-medium-1-1">           
                        <ul class="uk-pagination uk-pagination-right">
                                <?php
                                  echo $this->Paginator->prev('Previous', array('tag' => 'li', 'escape' => false), '<a>Previous</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                  echo $this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'uk-active', 'currentTag' => 'a'));
                                  echo $this->Paginator->next('Next', array('tag' => 'li', 'escape' => false), '<a>Next</a>', array('class' => 'uk-disabled', 'tag' => 'li', 'escape' => false));
                                ?>
                            </ul>
                    </div>
                    
                    
                    <?php /*?><div class="navigation navigation-left" >
            <?php echo $this->Paginator->counter(); ?> Pages
            <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
          </div><?php */?>
                    
                </div>
            </div>
        </div>
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
           
        <div class="clearfix"></div>
       
      </div>
      

   <!-- </div>-->


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
