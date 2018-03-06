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
     <?php echo $this->Form->create('fwtravelvoucher', array('inputDefaults' => array(
           'label' => false,'div' => false, 'error' => array( 'wrap' => 'span','class' => 'my-error-class' )),
         'url' => array('controller' => 'travels', 'action' => 'saveinfomation'), 'id' => 'fwtravelvoucherid', 'name' => 'fwtravelvouchername'));
        ?>
<?php if (is_numeric($voucher)) { ?>
<table width="100%" border="0" cellspacing="5" cellpadding="5">
 <tr> 
    <td width="50%" align="right">Voucher Number :</td>
    <td>
        <strong><?php echo $voucher; ?></strong>
        <input type="hidden" value ="<?php echo $voucher; ?>" name="data[TravelWfLvl][voucher_id]"> 
    </td>
</tr>
  <?php
    $checllvl = $this->Common->findcheckLevel('1');
    if (!empty($checllvl)) {
        $fwemplist = $this->Common->findLevel($checllvl); ?>
        <tr>
            <td align="right">Forward :</td>
            <td>
                <?php echo $this->Form->input('TravelWfLvl.doc_id', array('type' => 'select', 'label' => false, 'empty' => '- -Select- -', 'options' => $fwemplist, 'class' => 'round_select','id'=>'fwtvlempcode')); ?>
            </td>

        </tr>
    <?php } else { ?>
        <tr>
            <td> NO Level Define</td>
        </tr>
    <?php } ?>
   
</table>
        <div class="submit-form"><?php echo $this->Form->submit('SAVE', array('onClick' => 'return checkSubmit()','name'=>'data[TravelWfLvl][save]')); ?></div>
   <?php } ?>     
 <?php $this->Form->end(); ?>

    </div>

</div>

<script type="text/javascript">
    function checkSubmit()
    {
       if($("#fwtvlempcode").val() =='')
        {
            alert("Select the employee name.");
            return false;
        }else{
            return true;
        }
    }
</script>


