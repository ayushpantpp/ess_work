            <?php foreach ($applications as $key => $application) { ?>
                <div style="padding-bottom: 30px;padding-top:10px ;border-top:2px dashed #ddd;background-color: #eee">
                    <table width="100%">
                        <tr>
                            <td width="200px">
                                <?php echo $application['name']; ?>
                            </td>
                            <td width="200px">
                                <?php echo $this->form->input('roles_' . $key, array('type' => 'select', 'style' => 'width:150px;', 'label' => false, 'options' => $application['roles'])); ?>	
                            </td>
                            <td width="180px" style="text-align: right">
                                <?php echo $this->form->button('Assign', array('type' => 'button', 'id' => 'application_id_' . $key)); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>