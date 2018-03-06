
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Masters</li>
            <li>Add KRA Type </li>           
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <?php echo $this->Session->flash(); ?>
    <h2 class="demoheaders">Add KRA Type<a href="#" id="create"></a></h2>
    
    <?php echo $this->Form->create('kraMasters', array('url' => array('controller' => 'kraMasters', 'action' => 'addKraType'), 'inputDefaults' => array('label' => false, 'div' => false))); ?>    
    <div class="travel-voucher">        
        <div class="input-boxs">            
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                
                <tr>                   
                    <th width="253" scope="row" scope="row"><strong>KRA Type :</strong> </th>                    
                    <td>
                        <?php 
                        
                            echo $this->Form->input('kra_type', array(
                                'type' => 'radio',                                
                                'legend' => false,
                                'class' => 'radio-btn',
                                'options' => array(
                                    1 => ' Manual ',
                                    2 => ' Pre Define ', 
                                    3 => ' Both '
                                ),
                                'value' => "$totalRecords"
                            ));
                        ?>
                        
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'id' => 'add', 'class' => 'successButton')); ?>

                            <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'infoButton')); ?>
                        </div>
                    </td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    echo $this->Form->end();
    ?>

</div>