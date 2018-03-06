<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Company Management
            </li>
            <li>
                Add Company
            </li>            
        </ul>
    </div>
</div>
<br>

<div id="add_msg_div">
    <h2 class="demoheaders">Add Company<a href="#" id="create"></a></h2>
    <?php
    echo $this->Form->create('master', 
            array('action' => 'logo', 'method' => 'POST','enctype'=>'multipart/form-data','inputDefaults' => array('label' => false, 'div' => false)));
    ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="100%" cellspacing="5" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>

                    <th scope="row" width="253"><strong>Parent Organization:</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company_list, 'class' => 'round_select', 'id' => 'orgName', 'maxLength' => 90)); ?>
                        <div id="dnameErr" style="color:red"></div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><strong>Company Code :</strong>  </th>
                    <td> Select Logo <input id="doc_file" name="doc_file" type="file">
                    </td>
                </tr>
                <tr>
                <td colspan="4">
                    <div class="submit">
                        <?php echo $this->Form->button('Submit', array('type' => 'submit', 'id' => 'add', 'class' => 'successButton'));         
                echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'infoButton')); ?>
                    </div>
                </td>
            </tr>
            </table>
        </div>
    </div>
    
    <?php
    echo $this->Form->end();
    ?>

</div>

