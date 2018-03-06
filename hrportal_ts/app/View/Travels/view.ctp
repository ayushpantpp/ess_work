<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>travels/getInfo/' + id,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }

</script>
<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="empResponse" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>


<?php $i = 0; ?>
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
                               <b> Travel Voucher List</b>
                            </h3>
                        </div>
            <div class="md-card-content">
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                            <tr>
                                <th class="filter-false remove sorter-false">Sr.No </th>
                                <th>Voucher No</th>
                                <th>Employee Name </th>
                                <th>Applied Date  </th>
                                <th class="filter-false remove sorter-false">Document  </th>
                                <th>Status </th>
                                <th class="filter-false remove sorter-false">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if (empty($travellist)) { ?>
                                <tr>
                                    <td class="uk-text-center" colspan="7">
                                        <span class="uk-text-italic uk-text-primary">--No Records Found--</span>
                                    </td>
                                </tr>
                            <?php } 
                            //echo "<pre>";print_r($dt);die('here');
                            ?>

                            <?php foreach ($travellist as $srcdet) {
                                
                                if ($srcdet['DtTravelVoucher']['travel_status'] == 1) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
                                } elseif ($srcdet['DtTravelVoucher']['travel_status'] == 2) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
                                } elseif ($srcdet['DtTravelVoucher']['travel_status'] == 3) {
                                    $btnClass = "uk-badge uk-badge-warning";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
                                } elseif ($srcdet['DtTravelVoucher']['travel_status'] == 4) {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
                                } elseif ($srcdet['DtTravelVoucher']['travel_status'] == 5) {
                                    $btnClass = "uk-badge uk-badge-success";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
                                } else {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);
}
                                
                                
                                $empname = $this->Common->getempinfo($srcdet['DtTravelVoucher']['emp_code']);
                                
                                ?>
                                <tr>
                                    <td><?php echo $i + 1;?></td> 
                                    <td> <?php echo $srcdet['DtTravelVoucher']['voucher_id'] ?></td>
                                    <td><?php echo $empname;?></td>
                                    <td><?php echo date('d-m-Y', strtotime($srcdet['MstEmpExpVoucher']['voucher_date'])); ?></td>
                                    <?php if ($srcdet['DtTravelVoucher']['file']) { ?>
                                    <td><a class="uk-badge uk-badge-primary" href="<?php echo $this->webroot . 'uploads/Travel/' . $srcdet['DtTravelVoucher']['file']; ?>" target="_blank">View Bill</a></td>
                                    <?php } else { ?>
                                    <td>N/A</td>
                                    <?php }?>
                                    <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>  
                                    <td >
                                        <a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-primary" onclick="Get_Details('<?php echo $srcdet['DtTravelVoucher']['voucher_id']; ?>')"  title="Click to View.">View</a>
                                        <?php
                                        $status = $this->Common->findSatus($srcdet['DtTravelVoucher']['travel_status']);

                                        if ($status == 'Parked' || $status == 'Posted') {
                                            ?>
                                            <a href="<?php echo $this->webroot; ?>travels/editvoucher/<?php echo base64_encode($srcdet['DtTravelVoucher']['id']); ?>/" class="uk-badge uk-badge-success"  title="Click to Edit.">Edit</a>
                                <?php } ?> 
                                <?php if ($status == 'Parked' || $status == 'Posted') { ?>
                                            <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>travels/deleteTravelDetails/<?php echo base64_encode($srcdet['DtTravelVoucher']['voucher_id']); ?>/" title="Click to Edit.">Delete</a>    
    <?php } ?>
                                    </td>
                                </tr>
    <?php $i++;
} ?>
                        </tbody>
                    </table>

                </div>
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
<script>
  function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>travels/view/"+val; 

 }






    </script>