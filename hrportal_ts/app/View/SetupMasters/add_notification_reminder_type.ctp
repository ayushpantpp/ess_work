
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Masters</li>
            <li>Notification Reminder Type </li>           
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <?php echo $this->Session->flash(); ?>
    <h2 class="demoheaders">Add Notification Reminder Type<a href="#" id="create"></a></h2>
    
    <?php echo $this->Form->create('setupMasters', array('url' => array('controller' => 'setupMasters', 'action' => 'addNotificationReminderType'), 'inputDefaults' => array('label' => false, 'div' => false))); ?>    
    <div class="travel-voucher">        
        <div class="input-boxs">            
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                
                <tr>                   
                    <th width="253" scope="row" scope="row"><strong>Notification Reminder Type :</strong> </th>                    
                    <td>
                        <?php 
                        
                            echo $this->Form->input('notification_reminder_type', array(
                                'type' => 'radio',
                                'required' => 'required',
                                'legend' => false,
                                'class' => 'radio-btn',
                                'options' => array(
                                    1 => ' Yes ',
                                    2 => ' No '
                                ),
                                'value' => "$notificationReminderType",
                                'onclick' => "enableDisableDays(this.value)"
                            ));
                        ?>                        
                    </td>
                </tr>
                <tr>                   
                    <th width="253" scope="row" scope="row"><strong>Reminder Days :</strong> </th>                    
                    <td>
                        <?php
                        if($notificationReminderType == 2){
                            $reminderDaysText = "disabled='disabled'";
                        }
                            echo $this->Form->input('reminder_days', array(
                                'type' => 'number',                                
                                'label' => false,
                                'min'   => "1",
                                'max'   => "10",
                                'maxlength' => '2',
                                'value' => "$reminderDays",
                                'id' => 'reminderDays',
                                'style' => 'padding:5px;',
                                'pattern' => "([0-9]|[0-9]|[0-9])",
                                "$reminderDaysText"
                            ));
                        ?>
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
<script type="text/javascript">
    function enableDisableDays(chkType) {
        var txtReminderDays = document.getElementById("reminderDays");
        
        if(chkType == 1){
            txtReminderDays.disabled = false;
        }
        if(chkType == 2){
            txtReminderDays.disabled = true;
        }
        
    }
</script>