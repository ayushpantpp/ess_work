<?php $x=$divcountno-1; 
for($i = 0; $i<=6;$i++){
				$n_date = date('Y-m-d',strtotime($values['MstTimesheet']['dt_start_date'] . '+'.$i.'day'));
				$data_dt[$n_date]	= $n_date;					
}

$tms_id = 1;?>
<tr class="tr_clone">
						<?php $cgeh = 'selected="selected"'; ?>
                        <td valign="top" id='tms'>
							<input  style="width: 80px;" type="text" id="tmsids<?php echo $x ?>" name="tmsids[]" onselectstart='javascript:return false;' 
							<?php  ?> onKeyUp="Show12('<?php echo $x ?>','<?php echo $this->webroot . 'Timesheet' ?>');" onBlur="SetCustomer12(document.getElementById('tms_ids<?php echo $x ?>').value,'<?php echo $x; ?>'); " class="textBox"/>
							<input type="hidden" id="tmsid<?php echo $x ?>" name="tmsid[]" />
						</td>
                         <td valign="top" id='customer<?php echo $x ?>'>
                                <input  style="width: 80px;" type="text" id="cust_name<?php echo $x ?>" name="cust_name[]"  onselectstart='javascript:return false;' <?php echo $read0nly ?>  onKeyDown="Show1('<?php echo $x ?>','<?php echo $this->webroot . 'Timesheet' ?>');"  onBlur="SetCustomer(document.getElementById('cust_id<?php echo $x ?>').value,'<?php echo ($x) ?>');"/>
                                <input type="hidden" id="cust_id<?php echo $x ?>" name="cust_id<?php echo $x ?>" readonly/>
                        </td>
                        <td id='M<?php echo $x; ?>'>
                        </td >
                               <td style="width: 80px;" valign="top" id='customer<?php echo $x ?>'></td>
							   <td style="width: 80px;" valign="top" id='customer<?php echo $x ?>'><?php echo $this->Form->input("data_dt.", array("options" => $data_dt, "type" => "select")); ?>
								</td>
								<td><input  type="checkbox" name="leave[]>" id="leave<?php echo $x ?>" value="Y"  onClick="CheckLeave(this.value,<?php echo $x;?>)"></td>
<								<td><input type="text" name="stTime[]" id="stTime<?php echo $x ?>" size="5" maxlength="5" <?php echo $read0nly ?>  class='md-input' onBlur="IsValidTime(this.value , this.id);"></td>

                                <td><input class='md-input'type="text" name="edTime[]" id="edTime<?php echo $x ?>" size="5" <?php echo $read0nly ?>  maxlength="5" onBlur="CheckTime(this.value , '<?php echo $x ?>' ,this.id)"></td>
                                <td><input class='md-input' name="hrs[]" type="text" id="hrs<?php echo $x ?>"  size="5"  readonly></td>
                                <td><input type="text" class='md-input' name="module[]"  id="module<?php echo $x ?>" <?php echo $read0nly ?> /></td>

                                <td><textarea  name="remarks[]" id="remarks<?php echo $x ?>" <?php echo $read0nly ?>></textarea></td>
                                <td><input <?php echo $read0nly ?> class='md-input' name="fr[]" type="text" id="fr<?php echo $x ?>" size="10" >
            </tr>