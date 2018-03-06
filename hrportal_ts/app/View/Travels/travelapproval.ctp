<?php
if($formshow){
echo $form->create('Voucher', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'travels', 'action' => 'travelapproval'), 'id' => 'trvoucher', 'name' => 'voucher'));
?>
<div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
                <ul>
                        <li>
                                <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a>
                        </li>          
                        <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
                        <li><?php echo $html->link('Travel Expense ', $html->url('/selfservices/#travel', true)); ?>  </li>        
                </ul>
        </div>
</div>
<h2 class="demoheaders">Travel Approval Form</h2>
<div class="travel-voucher1">
        <div class="input-boxs">
                <table width="98%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
                        <tr>
                                <td align="right">Name</td>
                                <td style=" color:#999; font-size: 11px; font-weight: bold;"><?php $auth = $this->Session->read('Auth');
                                echo ucwords(strtolower($auth['Employees']['vc_emp_name']));
                          ?></td>
                                <td align="right">Approx Expense</td>
                                <td><?php echo $form->input('Voucher.approx_expense', array('label' => false, 'type' => 'text', 'class' => 'round')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">Advance Required</td>
                                <td><?php echo $form->input('Voucher.advance_required', array('label' => false, 'type' => 'text', 'class' => 'round')); ?></td>
                                <td align="right">Currency</td>
                                <td><?php echo $form->input('Voucher.currency', array('label' => false, 'type' => 'select', 'class' => 'round_select', 'options' => $currency, 'empty' => 'Select')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">Date of Travel</td>
                                <td><?php echo $form->input('Voucher.travel_date', array('label' => false, 'type' => 'text', 'class' => 'round')); ?></td>
                                <td align="right">No of Days</td>
                                <td><?php echo $form->input('Voucher.no_days', array('label' => false, 'type' => 'text', 'class' => 'round')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">Mod of Travel</td>
                                <td><?php echo $form->input('Voucher.travel_mod', array('label' => false, 'type' => 'select', 'class' => 'round_select', 'options' => $travel_mod, 'empty' => 'Select')); ?></td>
                                <td align="right">Traveling To</td>
                                <td><?php echo $form->input('Voucher.traveling_to', array('label' => false, 'type' => 'text', 'class' => 'round')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">Mention Hotel Requirements, Visa and Flight Requirements</td>
                                <td colspan="3"><?php echo $form->input('Voucher.hotel_requirements', array('label' => false, 'type' => 'textarea', 'class' => 'round', 'style' => 'height: 70px; width: 520px;')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">Remarks, If any</td>
                                <td colspan="3"><?php echo $form->input('Voucher.remarks', array('label' => false, 'type' => 'textarea', 'class' => 'round', 'style' => 'height: 50px; width: 520px;')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right"><?php echo $form->submit('Submit', array('value' => 'Submit')); ?></td>
                                <td align="left"><?php echo $form->submit('Reset', array('value' => 'Reset', 'type' => 'reset')); ?></td>
                        </tr>
                </table>
        </div>
</div>
<?php echo $form->end(); ?>
<script type="text/javascript">
        jQuery(function(){
                jQuery('#VoucherTravelDate').datepicker({
                    dateFormat:'dd-mm-yy'
                });
        });
</script>
<?php } ?>