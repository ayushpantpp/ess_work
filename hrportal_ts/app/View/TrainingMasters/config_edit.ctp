
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Masters
            </li>
            <li>
                Training Configuration Master
            </li>            
        </ul>
    </div>
</div>

<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Edit Flash Configuration<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('TrainingMasters', array('url' => '','action' => 'editsaveinfo', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false)));
    
    $company_name = array('Eastern Software Systems', 'Google', 'Microsoft');
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                 <tr>
                    <?php $company = $this->Common->findCompanyName(); ?>
                    <th width = "253" scope="row"><strong>Company Name :</strong>  </th>
                    <td><?php echo $this->Form->input('company_name', array('type' => 'select', 'options' => $company, 'default' => $trainingconfig['TrainingConfig']['comp_code'], 'class' => 'round_select', 'id' => 'companyName')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Email :</strong>  </th>
                  
                <input type="hidden" name="trainingid" id="trainingid" value="<?php echo $id ?> "style = "display:none" />
                    <td><input type="checkbox" class="flat" name="email_check" id="email_check" <?php
                                    if ($trainingconfig['TrainingConfig']['email'] == 1) {
                                        echo 'checked="checked"';
                                    }
                                    
                                    ?>> 
                                      
                        <div id="memailErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                      <th scope="row"><strong>SMS :</strong>  </th>
                    <td><input type="checkbox" class="flat" name="sms_check" id="sms_check" <?php
                                    if ($trainingconfig['TrainingConfig']['sms'] == 1) {
                                        echo 'checked="checked"';
                                    }
                                    ?>default="0"> 
                        <div id="msmsErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>

                    <th scope="row"><strong>Open Attendance Flash Time :</strong>  </th>
                    <td><?php echo $this->Form->input('open_attendance_hour', array('class' => 'open_hour', 'id' => 'open_hour','value'=>$trainingconfig['TrainingConfig']['open_attendance_hour'])); ?><span>hour</span>
                      <div id="mopenhErr" style="color:red"></div>
                    </td>
                    
                    <td><?php echo $this->Form->input('open_attendance_min', array('class' => 'round_select', 'id' => 'open_min','value'=>$trainingconfig['TrainingConfig']['open_attendance_min'])); ?><span>Min</span>
                        <div id="mopnemErr" style="color:red"></div>
                    </td>
                </tr>
                    <tr>

                    <th scope="row"><strong>Close Attendance Flash Time :</strong>  </th>
                    <td><?php echo $this->Form->input('close_attendance_hour', array('class' => 'round_select', 'id' => 'close_hour','value'=>$trainingconfig['TrainingConfig']['close_attendance_hour'])); ?> <span>hour</span>            
                    </td>
                     <div id="mclosehErr" style="color:red"></div>
                    <td><?php echo $this->Form->input('close_attendance_min', array('class' => 'round_select', 'id' => 'close_min','value'=>$trainingconfig['TrainingConfig']['close_attendance_min'])); ?><span>Min</span>
                         <div id="mclosemErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <div align="center" class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'id' => 'add', 'class' => 'successButton')); ?>
                          
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


</div>


