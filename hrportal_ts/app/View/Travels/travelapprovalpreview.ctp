<?php

echo $form->create('Voucher', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'travels', 'action' => 'advancerequest'), 'id' => 'trvoucher', 'name' => 'voucher'));
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
<h2 class="demoheaders">Travel Approval Preview</h2>
<div class="travel-voucher1">
        <div class="input-boxs">
                <table width="70%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
                        <tr>
                                <td align="right" style="width: 25%;font-weight: bold;">Name</td>
                                <td style="width: 20%; color:#999; font-size: 11px; font-weight: bold;"><?php $auth = $this->Session->read('Auth');
		echo ucwords(strtolower($auth['Employees']['vc_emp_name'])); ?></td>
                                <td align="right" style="width: 25%;font-weight: bold;">Approx Expense</td>
                                <td style="width: 20%;"><?php echo $this->data['Voucher']['approx_expense']; ?></td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Advance Required</td>
                                <td><?php echo $this->data['Voucher']['advance_required']; ?></td>
                                <td align="right" style="font-weight: bold;">Currency</td>
                                <td><?php echo $currency[$this->data['Voucher']['currency']]; ?></td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Date of Travel</td>
                                <td><?php echo $this->data['Voucher']['travel_date']; ?></td>
                                <td align="right" style="font-weight: bold;">No of Days</td>
                                <td><?php echo $this->data['Voucher']['no_days']; ?></td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Mod of Travel</td>
                                <td><?php echo $travel_mod[$this->data['Voucher']['travel_mod']]; ?></td>
                                <td align="right" style="font-weight: bold;">Traveling To</td>
                                <td><?php echo $this->data['Voucher']['traveling_to']; ?></td>
                        </tr>
                         <tr>
                                <td align="right" style="font-weight: bold;">Mention Hotel Requirements, Visa and Flight Requirements</td>
                                <td colspan="3"><?php echo $this->data['Voucher']['hotel_requirements']; ?></td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Remarks, If any</td>
                                <td colspan="3"><?php echo $this->data['Voucher']['remarks']; ?></td>
                        </tr>
                </table>
        </div>
</div>
<?php echo $form->end(); ?>