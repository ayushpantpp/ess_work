<script type="text/javascript">
    function approve_fnf(fnf_id) {
        alert('Approved' + fnf_id);
    }

    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>fnfs/rejectId/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
</script>

<div id="page_content">
    <div id="page_heading" data-uk-sticky="{ top: 48, media: 960 }">
        <div class="heading_actions" id="blinkText">

        </div>
        <h1>FNFS Details</h1>
    </div>

    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?> 
        <div class="md-card" >
            <div class="md-card-content">
                <h3 class="heading_a uk-margin-small-bottom">List of FNFS Details</h3>

                <div class="clearfix"></div>
                <div class="uk-overflow-container uk-margin-bottom" >
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_issues">
                        <thead>
                            <tr>
                                <th class="uk-text-center">S.No.</th>
                                <th>Pending task</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th>Approver's remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $ctr =1;
			$arr=array();
                    foreach ($fnfs['FnfDetail'] as $value) {
			$arr[]=$value['status'];
                      ?>
                            <tr>
                                <td class="uk-text-small uk-text-center uk-text-muted uk-text-nowrap"><?php echo $ctr;?></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $value['Project']['name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $value['MyProfile']['emp_name'];?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo $this->Common->findSatus($value['status']);?></span></td>
                                <td><span class="uk-text-small uk-text-muted uk-text-nowrap"><?php echo ($value['approver_remark'])?$value['approver_remark']:'NA';?></span></td>

                            </tr>
                    <?php $ctr++;
                    }
		//echo '<pre>';print_r($arr);die;
?>
                        </tbody>
                    </table>
                    <div class="col-md-12"> 

                  <?php if(!isset($fnfs['Fnf']['status']) ) { ?>
                        <a class="btn btn-success" href="<?php echo $this->Html->url('/separations/add');?>"> Apply for separations first</a>
                  <?php }
                  else { 
                    ?> 
                        <label class="control-label"> FNFS status :</label>
                    <?php echo $this->Common->findSatus($fnfs['Fnf']['status']);?><br/>
                  <?php if($fnfs['Fnf']['status'] == 1) { /*
                    echo $this->Html->link('Edit', array('action'=>'fnf_edit',$fnfs['Fnf']['id']));*/
                    ?>
                        <!--  <a class="btn btn-success" href="<?php echo $this->Html->url('/fnfs/fnf_edit/').$fnfs['Fnf']['id'];?>"> Edit</a> -->
                    <?php
                   }

                  }
                  ?>
                    </div>

<?php

if(!in_array(1, $arr)){

?>
                    <a class="md-btn md-btn-primary" href="<?php echo $this->Html->url('/fnfs/approve_fnf/').$fnfs['Fnf']['id'];?>"> Approve FNFS</a> 
                  <!-- <a class="btn btn-danger" href="<?php echo $this->Html->url('/fnfs/reject_fnf/').$fnfs['Fnf']['id'];?>"> Reject FNF</a> -->
                    <a data-uk-modal="{target:'#modal_overflow_response'}" class="md-btn md-btn-danger" onclick="Get_Details('<?php echo $fnfs['Fnf']['id']; ?>')"  title="Click to Reject.">Reject FNFS</a>
<?php
}
?>
                    <div class="uk-grid" data-uk-grid-margin></div>
                    <br/>
                </div>
            </div>   
        </div>
    </div>
</div>


<div class="uk-width-medium-1-2">
    <div id="modal_overflow_response" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-small">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>
















<!-- page content -->



