<script>
    function Get_Details(id)
    {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>conveyence_expenses/getInfo/' + id,
            success: function (data) {
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

<?php $i = 0 ?>
<div id="page_content">
    <div id="page_content_inner">
        <?php echo $flash = $this->Session->flash(); ?>
           <div class="md-card">  
            <div class="md-card-toolbar">
                         <div class="md-card-toolbar-actions">
                               <div class="md-card-toolbar-heading-text" style="margin-top:-9px; "> <?php $a=array(10=>'10',20=>'20',30=>'30');
                   // echo $this->form->input('pagination', array('label'=>false, 'empty'=>'Select Pagination','class'=>'md-input','type' => 'select', 'onchange'=>'get_paginate(this.value)', 'id' => 'paginate', 'options'=>$a,'value'=>$pen_val)); ?>
                              </div>
                            
                            </div>
                            <h3 class="md-card-toolbar-heading-text">
                              <b> Expenses List</b>
                            </h3>
             </div>
            <div class="md-card-content">
               
                <div class="uk-overflow-container uk-margin-bottom">
                    <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="dt_colVis">
                        <thead>
                            <tr>

                                <th >Sr.No</th>
                                <th>Employee Name</th>
                                <th>Voucher Id</th>
                                <th>Distance</th>
                                <th>Amount</th>
                                <th>Voucher Date</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($searchdetail)) { ?>
                                <tr class="even-pointer">
                                    <td style="text-align:center;" colspan="11">
                                        <em>--No Records Found--</em>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            $p = 0;
                            foreach ($searchdetail as $srcdet) { 
                                if ($srcdet['ExpVoucher']['conveyence_status'] == 1) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                } elseif ($srcdet['ExpVoucher']['conveyence_status'] == 2) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                } elseif ($srcdet['ExpVoucher']['conveyence_status'] == 3) {
                                    $btnClass = "uk-badge uk-badge-warning";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                } elseif ($srcdet['ExpVoucher']['conveyence_status'] == 4) {
                                    $btnClass = "uk-badge uk-badge-primary";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                } elseif ($srcdet['ExpVoucher']['conveyence_status'] == 5) {
                                    $btnClass = "uk-badge uk-badge-success";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                } else {
                                    $btnClass = "uk-badge uk-badge-danger";
                                    $btnStatus = $this->Common->findSatus($srcdet['ExpVoucher']['conveyence_status']);
                                }
                                
                                $comp_name = $this->Common->findCompanyNameByCode($srcdet['MstEmpExpVoucher']['comp_code']);
                                $empname = $this->Common->getempinfo($srcdet['ExpVoucher']['emp_code']);
                                ?>
                                <tr class = <?php echo $class; ?> >
                                    <td><?php
                                        echo $i + 1;
                                        $code = $srcdet['ExpVoucher']['emp_code'];  
                                        ?></td> 
                                    <td> <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $empname;?></span></td>
                                    <td> <span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $srcdet['ExpVoucher']['voucher_id'];?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $this->Common->getVoucherDistance($srcdet['ExpVoucher']['voucher_id'])." Km"; ?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo $this->Common->getVoucherTotalAmt($srcdet['ExpVoucher']['voucher_id']);?></span></td>
                                    <td><span class="uk-text-small uk-text-muted uk-text-truncate"><?php echo date('d-m-Y', strtotime($srcdet['ExpVoucher']['created_on'])); ?></td>
                                    <td><a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Details('<?php echo $srcdet['ExpVoucher']['voucher_id']; ?>')" class="uk-badge uk-badge-primary" title="Click to View.">View</a></td>
                                    
                                    <td><span class="<?php echo $btnClass; ?>"><?php echo $btnStatus; ?></span></td>  
                                    <td>
                                        <?php if ($srcdet['ExpVoucher']['conveyence_status'] == 7 || $srcdet['ExpVoucher']['conveyence_status'] == 8) { ?>
                                            <a href="<?php echo $this->webroot; ?>conveyence_expenses/parkedit/<?php echo base64_encode($srcdet['ExpVoucher']['voucher_id']); ?>/" class ="uk-badge uk-badge-success"   title="Click to Edit.">Edit</a>
                                        <?php } ?> 
                                        <?php if ($srcdet['ExpVoucher']['conveyence_status'] == 7 || $srcdet['ExpVoucher']['conveyence_status'] == 8) { ?>
                                            <a class="uk-badge uk-badge-danger" href="<?php echo $this->webroot; ?>conveyence_expenses/deleteConveyenceDetails/<?php echo base64_encode($srcdet['MstEmpExpVoucher']['voucher_id']); ?>/" title="Click to Delete.">Delete</a>    
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $i++; $p++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="container" ></div>
        </div>
    </div>
</div>
    <script>

        $(function () {
            $('#container').highcharts({
                title: {
                    text: 'Monthly Average Claim',
                    x: -20 //center
                },
                subtitle: {
                    text: '',
                    x: -20
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },
                yAxis: {
                    title: {
                        text: 'Amount'
                    },
                    plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                },
                tooltip: {
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{
                        name: 'Amount',
                        data: [<?php echo $claim ?>]
                    }, {
                        name: 'distance',
                        data: [<?php echo $distance ?>]
                    }]
            });
        });

         function get_paginate(val)
  {   
  window.location.href="<?php echo $this->webroot;?>conveyence_expenses/view/"+val; 

 }






    </script>