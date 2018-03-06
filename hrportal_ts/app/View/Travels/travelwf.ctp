<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="<?php echo $this->webroot; ?>employees/dashboard" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <?php echo $this->Html->link('Self Services', $this->Html->url('/#', true)); ?>
            </li>
            <li>
                <?php echo $this->Html->link('Travel Voucher', $this->Html->url('/#', true)); ?> 
            </li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Travel Voucher</h2>
<div class="travel-voucher">
    <div class="input-boxs" >
        <?php
        echo $this->Form->create('fwtravelvoucher', array('inputDefaults' => array(
                'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class')),
            'url' => array('controller' => 'travels', 'action' => 'travelwfsaveinfo'), 'id' => 'travelwfid', 'name' => 'travelwfname'));
        ?>
        <?php
        if (is_numeric($voucher)) {
            $getlvl = $this->Common->getlevelbytvid($voucher);
            ?>
            <table width="100%" border="0" cellspacing="5" cellpadding="5">
    <?php if (count($getlvl) > 0) {
        ?>
                    <tr class="cont1">
                        <td width="100%" colspan="3">
                            <table width="100%">
                                <tr>
                                    <?php
                                    $i = 0;
                                    foreach ($getlvl as $v) {
                                        ?>
                                        <td>
                                            <strong><?php echo "Level-" . $i; ?></strong> <br/>
                                            <strong>
                                                <?php echo $this->Common->getempinfo($v['TravelWfLvl']['emp_code']); ?> 
                                            </strong> <br/>
                                            <strong>
                                                <?php
                                                if (!empty($v['TravelWfLvl']['fw_date'])) {
                                                    echo date('d-M-Y', strtotime($v['TravelWfLvl']['fw_date']));
                                                } else {
                                                    echo "N/A";
                                                }
                                                ?>
                                            </strong>
                                        </td>
            <?php
            $i++;
        }
        ?>
                                <tr>
                            </table>
                        </td>
                    </tr>
    <?php } ?>
 <?php $deptcode = $this->Common->getemocodebydept($getlvl[0]['TravelWfLvl']['emp_code']);?>

                <tr> 
                    <td><strong>Voucher Number :</strong></td>
                    <td colspan="2">
                        <strong><?php echo $voucher; ?></strong>
                        <input type="hidden" value ="<?php echo $voucher; ?>" name="data[TravelWfLvl][voucher_id]"> 
                        <input type="hidden" value ="<?php echo $TravelWfLvlid['TravelWfLvl']['id']; ?>" name="data[TravelWfLvl][id]"> 
                        <input type="hidden" value ="<?php echo $deptcode; ?>" name="data[TravelWfLvl][dept_id]"> 
                    </td>
                </tr>
   
   <?php $checllvl = $this->Common->findcheckmulitpleLevel('1',$deptcode);
    if (!empty($checllvl)) {
        $fwemplist      = $this->Common->findLevel($checllvl, 'Forward');
        $revertemplist  = $this->Common->findLevel($checllvl, 'Revert');
        ?>
                    <tr> 
                        <td>
                            <input type="radio" name="data[TravelWfLvl][type]" value="2" checked="checked" onclick="displaytype();"><strong>Forward </strong>
                        </td>
                        <td>
                            <input type="radio" name="data[TravelWfLvl][type]" value="3" onclick="displaytype();"><strong>Revert </strong>
                        </td>
                        <td>
                            <input type="radio" name="data[TravelWfLvl][type]" value="4" onclick="displaytype();"><strong>Reject </strong>
                        </td>
                    </tr>

                    <tr id="reject" style="display:none;">
                        <td align="right">Reject :</td>
                        <td colspan="2">
                            <textarea  name="data[TravelWfLvl][reject_remark]" id="cmnt" col="100" row="100" > </textarea>
                        </td>
                    </tr> 

                    <tr id="revert" style="display:none;">
                        <td align="right">Revert :</td>
                        <td colspan="2">
                            <?php echo $this->Form->input('TravelWfLvl.revert_doc_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $revertemplist, 'class' => 'round_select', 'id' => 'revertempcode')); ?>
                        </td>
                    </tr>  

                    <tr id="forward">
                        <td align="right">Forward :</td>
                        <td colspan="2">
                            <?php echo $this->Form->input('TravelWfLvl.forward_doc_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'round_select', 'id' => 'fwtvlempcode')); ?>
                        </td>
                    </tr>

    <?php } else { ?>
                    <tr>
                        <td colspan="3" > NO Level Define</td>
                    </tr>
    <?php } ?>




            </table>
            <div class="submit-form"><?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()', 'name' => 'data[TravelWfLvl][save]')); ?></div>
<?php } ?>     
<?php $this->Form->end(); ?>

    </div>

</div>

<script type="text/javascript">
function checkSubmit()
{
    if ($("#fwtvlempcode").val() == '')
    {
        alert("Select the employee name.");
        return false;
    } else {
        return true;
    }
}

function displaytype()
{
    var typeval = $("input[name='data[TravelWfLvl][type]']:checked").val();
    if (typeval == 2)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', 'none');
        $("#forward").css('display', '');
    } else if (typeval == 3)
    {
        $("#reject").css('display', 'none');
        $("#revert").css('display', '');
        $("#forward").css('display', 'none');
    } else if (typeval == 4)
    {
        $("#reject").css('display', '');
        $("#revert").css('display', 'none');
        $("#forward").css('display', 'none');
    }
}
</script>


