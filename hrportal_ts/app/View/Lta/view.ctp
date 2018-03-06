
<div id="page_content">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <span class="momStatus"></span>
        <div class="md-card">  
        <div class="md-card-toolbar">
                           <?php ?>

                            <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                <b>LTA Claim Details ( <span><?php echo $emp_name; ?> </span>  - <span><?php echo $emp_id; ?></span></span>)</b>
                            </h3>
                        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>                          
                                <th class="filter-false remove sorter-false">Sr.No</th>           
                                <th> Applied Date  </th>
                                <th> Bill Amount</th>
                                <th> Location Type</th>
                                <th> Journey Start Date</th>
                                <th> Journey End Date</th>
                                <th>Status </th>
                                <th>Remark</th>
                                <th>LTA Bill</th>
                                <th>LTA Years</th>
                                <th>LTA Balance</th>                 
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($LtaDetails)) { ?>
                            <tr>
                                <td style="text-align:center;" colspan="11"><em>--No Records Found--</em></td>
                            </tr>
                            <?php } ?>

                            <?php
                            $i = 0;$p=1;
                            foreach ($LtaDetails as $srcdet) {
                                
                                if ($srcdet['LtaBillAmount']['status'] == 1) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                } elseif ($srcdet['LtaBillAmount']['status'] == 2) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                } elseif ($srcdet['LtaBillAmount']['status'] == 3) {
                                    $btnClass = "uk-badge uk-badge-warning";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                } elseif ($srcdet['LtaBillAmount']['status'] == 4) {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                } elseif ($srcdet['LtaBillAmount']['status'] == 5) {
                                    $btnClass = "uk-badge uk-badge-success";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                } else {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus =  $this->Common->findSatus($srcdet['LtaBillAmount']['status']);
                                }
                                ?>
                            <tr>
                                <td><?php echo $ctr = (($this->params['paging']['LtaBillAmount']['page']*$this->params['paging']['LtaBillAmount']['limit'])-$this->params['paging']['LtaBillAmount']['limit'])+$p;?></td>
                                <td><?php echo date('d-M-Y', strtotime($srcdet['LtaBillAmount']['created_at'])); ?></td>
                                <td><?php echo $srcdet['LtaBillAmount']['bill_amount']; ?></td>
                                <td><?php if($srcdet['LtaBillAmount']['loc_type'] == 'M') echo "Metro";elseif($srcdet['LtaBillAmount']['loc_type'] == 'N') echo "Non Metro"; ?></td>
                                <td><?php echo date('d-M-Y', strtotime($srcdet['LtaBillAmount']['jour_start_date'])); ?></td>
                                <td><?php echo date('d-M-Y', strtotime($srcdet['LtaBillAmount']['jour_end_date'])); ?></td>
                                <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>
                                    <?php if (!empty($srcdet['LtaBillAmount']['remark'])) { ?>
                                <td><?php echo $srcdet['LtaBillAmount']['remark']; ?></td>
                                    <?php } else { ?>
                                <td>N/A</td>    
                                    <?php } ?>    

                                <td>
                                        <?php if ($srcdet['LtaBillAmount']['uploaded_file']) { ?>
                                    <a href="<?php echo $this->webroot . 'uploads/Lta/' . $srcdet['LtaBillAmount']['uploaded_file']; ?>" target="_blank" class="uk-badge uk-badge-primary">View Bill</a>
                                        <?php } else {
                                            echo 'N/A';
                                        } ?>   
                                </td>   
                                <td><?php echo $srcdet['LtaBillAmount']['lta_years'] ?></td>
                                <td><?php echo $ltabalance ?></td>
                                <td> 

                                        <?php $status = $this->Common->findSatus($srcdet['LtaBillAmount']['status']); ?>
                                        <?php if ($status != 'Parked' && $status != 'Open') {
                                            echo 'NA';
                                        }?>
                                        <?php if ($status == 'Parked') { ?>
                                    <a class="uk-badge uk-badge-success" href="<?php echo $this->webroot; ?>lta/edit/<?php echo $srcdet['LtaBillAmount']['id']; ?>" title="Click to Edit.">Edit</a>    
                                    <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>lta/delete/<?php echo $srcdet['LtaBillAmount']['id']; ?>" title="Click to Delete.">Delete</a>    
                                        <?php } ?>
                                            <?php if ($status == 'Open') { ?>
                                    <a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot; ?>lta/workflow_display/<?php echo $srcdet['LtaBillAmount']['id']; ?>" title="Click to Edit.">Forward</a>    

                                        <?php } ?>  
                                </td>

                            </tr>
                            <?php $i++;$p++; } ?>

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
    $(function () {

        $('#container').highcharts({
            chart: {
                type: 'column',
                margin: 75,
                options3d: {
                    enabled: true,
                    alpha: 10,
                    beta: 25,
                    depth: 70
                }
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: ['Dialy Allowance', 'Conveyanace Expense', 'Miscellaneous Expense', 'Client Expense', 'Stay Expense', 'other Expense']
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                    name: 'Applied  Leaves',
                    data: [<?php echo $leavetype ?>]
                }]
        });

    });
  function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>lta/view/"+val; 

 }


</script>