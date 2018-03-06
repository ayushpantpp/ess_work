<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'complaint/';?>">Complaint Management System</a>
            </li>
            <li>
                Select Type
            </li>            
        </ul>
    </div>
</div>
<h2 class="demoheaders">Select Type To Add</h2>
<div class="travel-voucher">
    <?php echo $this->Form->create('complainttype', array('url' => 'add/')); ?>
    <table width="80%" align="center"  border="0" cellspacing="5" cellpadding="5">
        <tr id="addComlpaint1">
            <td width="25%">Select Complaint Type :</td>
            <td width="19%" align="left">
                <select name="VC_LEVEL1" id="VC_LEVEL1" size="0" class="formselectionBox3" onChange="jQuery('#VC_LEVEL2').load('<?php echo $this->webroot ?>empcomplaint/typeListHtml/'+jQuery(this).val())">
                    <option value="">-Select Type-</option>
                    <?php foreach ($ctypeoption as $option) { ?>
                        <option value="<?php echo $option['0']['nu_complaint_id']; ?>"><?php echo $option['0']['vc_complaint_desc']; ?></option>
                    <?php } ?>
                </select>
            </td>
            <td align="center"><select id="VC_LEVEL2" name="VC_LEVEL2" onChange="jQuery(this).parents('form:first').attr('action','<?php echo $this->webroot ?>empcomplaint/add/'+jQuery('#VC_LEVEL1').val()+'/'+jQuery('#VC_LEVEL2').val())">
                    <OPTION>
                        --Select appropriate problem--
                    </OPTION></select></td>
            <td>
                <button type="submit">Continue...</button>
            </td>

        </tr>
    </table>
    <?php echo $form->end(); ?>
</div>