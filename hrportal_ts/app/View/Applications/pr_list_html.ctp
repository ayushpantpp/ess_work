<form>
        <div style="padding: 5px;">
                <b>Application Role Assignment list for:</b>
                <?php if(isset($names)) { ?>
                <?php foreach($names as $name):?>
                    <?php echo ucwords(strtolower($name[0]['emp_name'])) ;?>
                    <?php echo ","; ?>
                <?php endforeach; ?>
                <?php } else { ?>
                    Provided search conditions
                <?php } ?>
        </div>
        <table style="table-layout:fixed;" width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <?php $zebraClass = "";?>
                <tr class="head">
                    <th width="5%">S.No.</th>
                    <th width="40%">Application Name</th>
                    <th width="45%">Role List</th>
                    <th width="10%">Action</th>
                </tr> 
                <?php $i=0; ?>
                <?php foreach($data as $application): ?>
                <tr class="<?php echo $zebraClass= ($zebraClass=="cont")?"cont1":"cont"; ?>">
                    <td><?php echo ++$i; ?><?php echo $this->form->input('assignrole.'.$i.'.nu_application_id',array('type'=>'hidden','value'=>$application['Applications']['id'])); ?></td>
                    <td><?php echo $application['Applications']['vc_application_name']; ?></td>
                    <td>
                        <select id="assignrole<?php echo $i; ?>Nu_role_id" name="data[assignrole][<?php echo $i; ?>][nu_role_id]">
                        <?php if(!count($application['Roles'])) { ?>
                            <option value="">No Roles available</option>
                        <?php } else { ?>
                            <option value="">--Select Role--</option>
                        <?php } ?>
                        <?php  foreach($application['Roles'] as $role):?>
                            <?php $selected = ''; ?>
                            <?php foreach($aros_roles as $aros_role):?>
                                <?php if($aros_role['roles']['id']==$role['id']) $selected = 'selected="selected"';?>
                            <?php endforeach; ?>
                            <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['name']; ?></option>
                        <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                       <ul class="edit-delete-icon">
                         <li style="border:none;"><a href="#" id="<?php echo $i; ?>" class="assign vtip" title="Assign">Assign</a></li>
                       </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
    <input id="empIdList" type="hidden" value="<?php echo implode(',', $ids);?>"/>
</form>
