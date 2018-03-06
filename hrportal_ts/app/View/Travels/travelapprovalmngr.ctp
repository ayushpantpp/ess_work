<?php
echo $form->create('Voucher', array('inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                        'wrap' => 'span',
                        'class' => 'my-error-class'
                )
        ), 'url' => array('controller' => 'travels', 'action' => 'travelapprovalmngr'), 'id' => 'trvoucher', 'name' => 'voucher'));
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
<h2 class="demoheaders">Travel Approval</h2>
<div class="travel-voucher1">
        <div class="input-boxs">
                <table width="95%" border="0" cellspacing="5" cellpadding="0" style="margin:0px auto;">
                        <tr>
                                <td align="right" style="width: 25%;font-weight: bold;">Name</td>
                                <td style="width: 20%; color:#999; font-size: 11px; font-weight: bold;">Nitin Singhal</td>
                                <td align="right" style="width: 25%;font-weight: bold;">Approx Expense</td>
                                <td style="width: 20%;">12000</td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Advance Required</td>
                                <td>10000</td>
                                <td align="right" style="font-weight: bold;">Currency</td>
                                <td>INR</td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Date of Travel</td>
                                <td>10-05-2012</td>
                                <td align="right" style="font-weight: bold;">No of Days</td>
                                <td>10</td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Mod of Travel</td>
                                <td>Flight</td>
                                <td align="right" style="font-weight: bold;">Traveling To</td>
                                <td>Mumbai</td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Mention Hotel Requirements, Visa and Flight Requirements</td>
                                <td colspan="3">Hotel Park Avenue</td>
                        </tr>
                        <tr>
                                <td align="right" style="font-weight: bold;">Remarks, If any</td>
                                <td colspan="3">Need Food allowance also.</td>
                        </tr>   
                        <?php if($formshow){ ?>
                        <tr>
                                <td align="right" style="font-weight: bold;">Comments, If any while approving/rejecting</td>
                                <td colspan="3"><?php echo $form->input('Voucher.comments', array('label' => false, 'type' => 'textarea', 'class' => 'round', 'style' => 'height: 50px; width: 550px;')); ?></td>
                        </tr>
                        <tr>
                                <td align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="right">
                                        <?php
                                        echo $form->input('action', array('type' => 'hidden'));
                                        echo $form->submit('Approve', array('value' => 'Approve', 'onclick' => 'jQuery("#VoucherAction").attr("value", "A");'));
                                        ?>
                                </td>
                                <td align="left"><?php echo $form->submit('Reject', array('value' => 'Reject', 'onclick' => 'jQuery("#VoucherAction").attr("value", "R");')); ?></td>
                        </tr>
                        <?php }else{ ?>
                             <tr>
                                <td align="right" style="font-weight: bold;">Comments, If any while approving/rejecting</td>
                                <td colspan="3"><?php echo $this->data['Voucher']['comments']; ?></td>
                        </tr>   
                        <? } ?>
                </table>
        </div>
</div>
<?php echo $form->end(); ?>