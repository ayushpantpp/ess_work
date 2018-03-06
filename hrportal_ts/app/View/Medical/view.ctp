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

<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>medical/medicaldetail/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }
     function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>medical/view/"+val; 

 }
</script>

<?php

$i = 1; ?>
<div id="page_content">
    <div id="page_content_inner">
        
        <?php echo $flash = $this->Session->flash(); ?>
        <div class="md-card">
      
        <div class="md-card-toolbar">
                             <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                    echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                                 <b> Medical Claim Details</b>
                            </h3>
                        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair jambo_table bulk_actions" id="ts_pager_filter">
                        <colgroup class="tablesorter-colgroup"><col class="wrp" style="width: 0% !important;"></colgroup>
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No</th>           
                                <th>Employee Name </th>
                                <th>Applied Date  </th>
                                <th>Bill Amount</th>
                                <th>Location Type</th>
                                <th class="filter-false remove sorter-false">Status </th>
                                <th class="filter-false remove sorter-false">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($MedicalDetails)) { ?>
                            <tr>
                                <td style="text-align:center;">
                                    <em>&nbsp;</em>
                                </td>
                                <td style="text-align:center;">
                                    <em>&nbsp;</em>
                                </td>
                                <td style="text-align:center;">
                                    <em>--No Records Found--</em>
                                </td>
                                <td style="text-align:center;">
                                    <em>&nbsp;</em>
                                </td>
                                <td style="text-align:center;">
                                    <em>&nbsp;</em>
                                </td>
                                <td style="text-align:center;">
                                    <em>&nbsp;</em>
                                </td>
                            </tr>
                            <?php } ?>

                            <?php foreach ($MedicalDetails as $srcdet) {                                   
                                
                                if ($srcdet['MedicalBillAmount']['status'] == 1) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                } elseif ($srcdet['MedicalBillAmount']['status'] == 2) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                } elseif ($srcdet['MedicalBillAmount']['status'] == 3) {
                                    $btnClass = "uk-badge uk-badge-warning";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                } elseif ($srcdet['MedicalBillAmount']['status'] == 4) {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                } elseif ($srcdet['MedicalBillAmount']['status'] == 5) {
                                    $btnClass = "uk-badge uk-badge-success";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                } else {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus =  $this->Common->findSatus($srcdet['MedicalBillAmount']['status']);
                                }
                                
                                ?>
                            <tr>
                                <td><?php echo $ctr = (($this->params['paging']['MedicalBillAmount']['page']*$this->params['paging']['MedicalBillAmount']['limit'])-$this->params['paging']['MedicalBillAmount']['limit'])+$i;?></td>
                                <td><?php echo $this->Common->getempinfo($srcdet['MedicalBillAmount']['emp_code']); ?></td>

                                <td><?php echo date('d-m-Y', strtotime($srcdet['MedicalBillAmount']['created_at'])); ?></td>
                                <td><?php echo $srcdet['MedicalBillAmount']['bill_amount']; ?></td>
                                <td><?php if($srcdet['MedicalBillAmount']['loc_type'] == 'M') echo "Metro";elseif($srcdet['MedicalBillAmount']['loc_type'] == 'N') echo "Non Metro"; ?></td>
                                <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>

                                <td>
                                    <a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $srcdet['MedicalBillAmount']['id']; ?>')" class="uk-badge uk-badge-success" title="Click to View." >View Bill</a>
                                    
                                    <?php if ($srcdet['MedicalBillAmount']['status'] == 1) { ?>
                                    <a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot . 'medical/workflow_display/' . $srcdet['MedicalBillAmount']['id']; ?>" title="Click to Edit.">Forward</a>
                                        <?php } ?>
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

                