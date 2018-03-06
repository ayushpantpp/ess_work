<script type="text/javascript">
    $(function(){

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal:true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                    document.trvoucher.submit();

                },
                "Cancel": function() {
                    $(this).dialog("close");
                }
            }
        });


    });
</script>
<script type="text/javascript">
    function getrejectreson(voucherno,startdate,enddate){

        jQuery.get('<?php echo $this->webroot; ?>travels/getrejectionresion/'+voucherno+'/'+startdate+'/'+enddate,{}, function(data){
            jQuery('#getrejectionresion').html(data);

        });
       
     
        jQuery('#dialog').dialog('open');

    }
</script>

<?php
if (!empty($_GET['order'])) {
    if ($_GET['order'] == "asc") {
        $or = "desc";
?>

<?php $voucher_detail = Set::sort($voucher_detail, '{n}.vc_voucher_no', 'asc'); ?>
<?php } else {
        $or = "asc"; ?>
<?php $voucher_detail = Set::sort($voucher_detail, '{n}.vc_voucher_no', 'desc'); ?>

<?php }
} ?>

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
            <li>Self Services<?php //echo $this->Html->link('Self Services', $this->Html->url('/selfservices', true)); ?> </li>
            <li>Travel Expense<?php //echo $this->Html->link('Travel Expense ', $this->Html->url('/selfservices/#travel', true)); ?>  </li>

        </ul>
    </div>
</div>

<h2 class="demoheaders">Travel Expense Report: Summary</h2>
<div class="travel-voucher">
    <div>
        <table  frame="void" width="100%" align="center" cellspacing="1" cellpadding="0" border="0" class="exp-voucher">

            <thead class="vrTableHeader">
                <tr class="head">
                    <th>Voucher No.</th>
                    <th><strong>Place of Visit</strong></th>
                    <th>Voucher Date</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Tour Advance<br> (in Rs.)</th>
                    <th>Balance Amount<br> (in Rs.)</th>
                    <th>Sanctioned Amount<br> (in Rs.)</th>
                    <th colspan="2">Status</th>
                </tr>
            </thead><tbody>
<?php if (empty($voucher_detail)) { ?>
<tr class="cont">
<td style="text-align:center;" colspan="10">
<em>--No Records Found--</em>
</td>
</tr>


            <?php } ?>
                <?php
                $i = 0;

//pr($voucher_detail);
                foreach ($voucher_detail as $detail) {
                ?>

                    <tr <?php if ($i % 2 == 0) { ?>class="cont1" <?php } else { ?>class="cont" <?php } ?>>
                        <td><?php echo $detail['MStEmpExpVoucher']['voucher_id']; ?></td>
                        <td><?php echo $detail['Travel']['place_visit']; ?></td>
                        <td><?php echo $detail['MStEmpExpVoucher']['voucher_date']; ?></td>
                        <td><?php echo $detail['Travel']['tour_start_date']; ?></td>
                        <td><?php echo $detail['Travel']['tour_end_date']; ?></td>
                        <td><?php echo $detail['Travel']['adv_amount']; ?></td>
                        <td><?php echo $detail['Travel']['pending_amount']; ?></td>
                    <td><?php echo $detail['Travel']['return_amount']; ?></td>
                    <td>
                        <?php
                       $statusD =  $this->Common->findSatus($detail['Travel']['travel_status']);
                       
                        ?>


                        <input type="hidden" id="vouchno" name="voucher_no" value="<?php echo $detail['MStEmpExpVoucher']['voucher_id']; ?>"/>
                        <input type="hidden" id="ccode" name="comp_code" value="#" />
                        <input type="hidden" id="stdate" name="start_date" value="<?php echo $detail['Travel']['tour_start_date']; ?>"/>
                        <input type="hidden" id="eddate" name="end_date" value="<?php echo $detail['Travel']['tour_end_date']; ?>"/>
                        <input type="hidden" id="rejectres" name="rejectreson" value=""/>

                   <?php if ($statusD == "Rejected") { ?>
                            <a href="#" <?php if ($statusD == "Rejected") { ?> onclick="getrejectreson('<?php echo $detail['MStEmpExpVoucher']['voucher_id']; ?>','<?php echo $detail['Travel']['tour_start_date']; ?>','<?php echo $detail['Travel']['tour_end_date']; ?>')" <?php } ?>><?php echo $statusD; ?></a>
                    <?php }else{ echo strtoupper($statusD); ?>

                            <?php } ?>
                    </td>
                </tr>
<?php $i++;
                    
                }  ?>
   

            <div id="dialog" title="Remark/Comment" style="display:none">
                <div id="getrejectionresion"></div>
            </div>
            </tbody>
        </table>
    </div>
    <div class="navigation">
                    <div style="float:left;">
                                  <?php echo $this->Paginator->counter(); ?> Pages
                                  <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'eabled')); ?>
                                  <?php echo $this->Paginator->numbers(); ?>
                                  <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
                    </div>
                 </div>
        </div>
</div>