<script>
    function Get_Details(emp_code)
    { 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>conveyence_expenses/previousConveyence/' + emp_code,
            success: function (data) {
                //alert(data);
                jQuery('#empResponse').html(data);
            }
        });
    }


function Get_Conve_Details(id)
    { 
        jQuery.ajax({
            url: '<?php echo $this->webroot ?>conveyence_expenses/get_convey_Info/' + id,
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

<div class="uk-width-medium-1-4">
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog uk-modal-dialog-medium">
            <button type="button" class="uk-modal-close uk-close"></button>            
            <div class="uk-overflow-container">
                <span id="abc" class="verflow container"></span>
            </div>          
        </div>
    </div>
</div>

<?php $i = 0; ?>

<div id="page_content" role="main">
    <div id="page_content_inner">        
        <h3 class="heading_b uk-margin-bottom">Conveyance Approval </h3>
        <?php
        $auth = $this->Session->read('Auth');
        echo $flash = $this->Session->flash();
        ?>
        <div id="alerts"></div>
        <div class="md-card">

            <div class="md-card-content large-padding">
                <a data-uk-modal="{target:'#modal_overflow'}" class="uk-badge uk-badge-primary alignright" onclick="Get_Details(<?php echo $emp_code ?>)" title="Click to View."> Previously applied Expense voucher</a>
                <div class="x_panel">

                    <div class="uk-overflow-container">
                        <?php
                        echo $this->form->create('ConveyenceWorkflow', array(
                            'url' => 'conveyencewf',
                            'name' => 'conveyenceapprove',
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

                        <table class="uk-table uk-table-bordered">
                            <thead>
                                <tr>
                                    <th><strong>Company Name</strong></th>
                                    <th><strong>Department</strong></th>
                                    <th><strong>Employee Name</strong></th>
                                    <th><strong>Voucher date</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $this->Common->findCompanyNameByCode($empconveyencedetail[0]['MstEmpConveyence']['comp_code']); ?></td>
                                    <td><?php echo $this->Common->getdepartmentbyid($empconveyencedetail[0]['MstEmpConveyence']['dept_code']); ?></td>
                                    <td><?php echo $this->Common->getempinfo($empconveyencedetail[0]['MstEmpConveyence']['emp_code']); ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($empconveyencedetail[0]['MstEmpConveyence']['voucher_date'])); ?></td></tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <table class="uk-table uk-table-bordered">
                            <thead>
                                <tr>
                                    <th>Claim Date</th>
                                    <th>Travel Mode</th>
                                    <th>Wheeler Type</th>
                                    <th>Distance</th>
                                    <th>Details</th>
                                    <th>Claim-Amount (in &#8377.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($empconveyencedetail as $dt) { ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y', strtotime($dt['ConveyencExpenseDetail']['claim_date'])); ?></td>
                                        <td><?php echo $this->Common->getConveyenceTravelModeById($dt['ConveyencExpenseDetail']['travel_mode']); ?></td>
                                        <td><?php if($dt['ConveyencExpenseDetail']['wheeler_type']=='1'){ echo "Personal"; }else{ echo "Commercial"; } ?></td>
                                        <td><?php echo $dt['ConveyencExpenseDetail']['distance']; ?></td>
                                        <td><a data-uk-modal="{target:'#modal_overflow'}" onclick="Get_Conve_Details('<?php echo $dt['ConveyencExpenseDetail']['voucher_id']; ?>')" class="uk-badge uk-badge-primary" title="Click to View.">View</a></td>

                                        <td><?php echo $this->Form->input('ConveyenceWorkflow_amount.claim_amount.', array('type' => 'text', 'label' => false, 'value' => $dt['ConveyencExpenseDetail']['total_exp'])); ?></td>
                                        <?php 
                                        echo $this->Form->input('ConveyenceWorkflow_amount.emp_code.', array('type' => 'hidden', 'label' => false, 'value' => $dt["ConveyencExpenseDetail"]["emp_code"]));
                                        echo $this->Form->input('ConveyenceWorkflow_amount.id.', array('type' => 'hidden', 'label' => false, 'value' => $dt["ConveyencExpenseDetail"]["id"]));
                                        
                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>  
                        
                        <div class="form-group">
                            <div class="col-md-4 ">
                                <div ><input class="md-btn md-btn-success" type="submit" value="Proceed"></div>
                                <input type="hidden" name="ConveyenceWorkflow[voucher_id]" value="<?php echo $empconveyencedetail[0]['ConveyencExpenseDetail']['voucher_id']; ?>">
                                <?php echo $this->form->end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>