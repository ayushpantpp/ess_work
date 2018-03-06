<script>
    function GetPreviousVoucher(emp_code) {
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>travels/previousVoucherEmp/' + emp_code,
            success: function (data) {
                jQuery('#empResponse').html(data);
            }
        });
    }
    
    function getDetail(){
        var id = jQuery('#vocucher_primary_id').val();
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>travels/getLocalExpDetail/' + id,
            success: function (data) {
                jQuery('#detailResponse').html(data);
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
<div class="uk-width-medium-1-4">
    <div id="modal_detail" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-large">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="detailResponse"></span>
            </div>          
        </div>
    </div>
</div>



<?php $i = 0; ?>

<div id="page_content" role="main">
        <div id="page_content_inner">  
            <h3 class="heading_b uk-margin-bottom">Travel Approval</h3>
            <?php
            $auth = $this->Session->read('Auth');
            echo $flash = $this->Session->flash();
            ?>

            <div id="alerts"></div>

            <div class="md-card">

                <div class="md-card-content large-padding">
                    <a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-success" onclick="GetPreviousVoucher(<?php echo $emp_code ?>)" class="view vtip" title="Click to View."> Previously applied travel voucher</a>
                    

                    
                        <?php
                        echo $this->form->create('TravelWorkflow', array(
                            'url' => 'fwtravel',
                            'name' => 'travelapprove',
                            'inputDefaults' => array(
                                'label' => false,
                                'div' => false,
                                'error' => array(
                                    'wrap' => 'span',
                                    'class' => 'my-error-class'
                                )
                            )
                                )
                        );
                        ?>
                        <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair">
                            <thead>
                                <tr class="headings">

                                    <th>Company Name</th>
                                    <th>Department</th>
                                    <th>Employee Name</th>
                                    <th>Voucher date</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr class="even pointer">
                                    <td><?php echo $this->Common->findCompanyNameByCode($emptraveldetail[0]['MstEmpConveyence']['comp_code']); ?></td>
                                    <td><?php echo $this->Common->getdepartmentbyid($emptraveldetail[0]['MstEmpConveyence']['dept_code']); ?></td>
                                    <td><?php echo $this->Common->getempinfo($emptraveldetail[0]['MstEmpConveyence']['emp_code']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($emptraveldetail[0]['MstEmpConveyence']['voucher_date'])); ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table class="uk-table uk-table-bordered">
                            <thead>
                                <tr>

                                    <th>Travel Start Date</th>
                                    <th>Travel End Date</th>
                                    <th>Travel To</th>
                                    <th>Daily Allowance</th>
                                    <th>Local Conveyance Expense</th>
                                    <th>Miscellaneous Expense</th>
                                    <th>Client Expense</th>
                                    <th>Stay Expense</th>
                                    <th>Other Expense</th>
                                    <th>Amount</th>
                                    <th>View Bill</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($emptraveldetail as $emptraveldetail) { ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($emptraveldetail['DtTravelVoucher']['tour_start_date'])); ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($emptraveldetail['DtTravelVoucher']['tour_end_date'])); ?></td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['place_visit']; ?></td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['da']; ?> </td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['conv_expense']; ?>
                                        <a data-uk-modal="{target:'#modal_detail'}" 
                                           class="uk-badge uk-badge-success" 
                                           onclick="getDetail()" 
                                           class="view vtip" 
                                           title="Click to View.">Detail</a>
                    
                                        </td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['miscellaneous_exp']; ?></td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['client_exp']; ?></td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['hotel_stay']; ?></td>
                                        <td><?php echo $emptraveldetail['DtTravelVoucher']['other_exp']; ?></td>
                                        <td><?php 
                                        if($emptraveldetail['DtTravelVoucher']['return_amount'] > 0){
                                            echo $this->Form->input('return_amount', array('type' => 'text', 'label' => false, 'value' => $emptraveldetail['DtTravelVoucher']['return_amount']));
                                        }else{
                                            echo $this->Form->input('claim_amount', array('type' => 'text', 'label' => false, 'value' => $emptraveldetail['DtTravelVoucher']['pending_amount']));
                                        }
                                         ?></td>
                                        <?php echo $this->Form->input('emp_code', array('type' => 'hidden', 'label' => false, 'value' => $emptraveldetail["DtTravelVoucher"]["emp_code"])); ?>
                                        <?php if ($emptraveldetail['DtTravelVoucher']['file']) { ?>
                                            <td><a href="<?php echo $this->webroot . 'uploads/Travel/' . $emptraveldetail['DtTravelVoucher']['file']; ?>" target="_blank">View Bill</a></td>
                                        <?php } else { ?>
                                            <td><p>N/A</p></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>  
                        <div class="ln_solid"></div>
                        
                        <div class="uk-grid">
                        <div class="uk-width-1-1 uk-margin-top">    
                                <?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[ConveyenceWorkflow][save]', 'class' => 'md-btn md-btn-success')); ?>

                                <input type="hidden" id = "vocucher_primary_id" name="TravelWorkflow[voucher_id]" value="<?php echo $emptraveldetail['DtTravelVoucher']['id']; ?>">
                            </div>
                            <?php $this->Form->end(); ?>
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
                    
                
                <div id="container" ></div>
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
                    depth: 25,
                }
            },
            xAxis: {
                categories: ['Dailly Allowance', 'Convenyance Expense', 'Misclleneous Expense', 'Hotel Stay', 'other Expense', 'Pending Amount']
            },
            yAxis: {
                title: {
                    text: null
                }
            },
            series: [{
                    name: 'Expenses',
                    data: [<?php echo $exp ?>]
                }]
        });

    });
    
 
</script>
