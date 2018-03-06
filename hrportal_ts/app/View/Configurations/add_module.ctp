
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Configurations
            </li>
            <li>
                Admin options
            </li>            
        </ul>
    </div>
</div>
<br>
<div id="add_msg_div">
    <h2 class="demoheaders">Add Department<a href="#" id="create"></a></h2>
    <?php echo $this->Form->create('Departments', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <div class="travel-voucher">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <?php $company = $this->Common->findCompanyName(); ?>
                    <th scope="row"><strong>Current Organization :</strong>  </th>
                    <td><?php echo $this->Form->input("company_name", array("type" => "select", "options" => $company, "empty" => "Select Company", "class" => "round_select", "id" => "companyName")); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                    <?php $option = $this->Common->findModuleName(); ?>
                    <th scope="row"><strong>Select Module :</strong>  </th>
                    <td><?php echo $this->Form->input("option_name", array("type" => "select", "options" => $option, "empty" => "Select Module", "class" => "round_select", "id" => "moduleName")); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                    <th scope="row"><strong>Current Organization :</strong>  </th>
                    <td><?php echo $this->Form->input("status", array("type" => "select", "options" => array(""=>"Select","1"=>"Yes","0"=>"No"), "empty" => "Select Company", "class" => "round_select", "id" => 'companyName')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>
                
                <tr>
                    <td colspan="4" align="center">
                        <div align="center" class="submit">
                            <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'add', 'class' => 'submit-btn')); ?>
                            &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                            <?php echo $this->Form->button('Reset', array('type' => 'reset','onclick'=>'window.reload();', 'class' => 'submit-btn')); ?>
                            <?php echo $this->Form->button('Add More', array('type' => 'button', 'id' => 'add', 'class' => 'add submit-btn')); ?>
                            
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


<div id="list_msg_div1">

    <h2 class="demoheaders">Configurations</h2>
    <div class="travel-voucher1" style="min-height: 300px;">
        <div class="input-boxs">

            <div id="result"></div>


        </div>
    </div>
    <div id="files"></div>
</div>
</div>
<script type="text/javascript">   
    $('.add').click(function() {
            $(this).before('<div class="uk-grid" data-uk-grid-margin><div class="uk-width-medium-1-3"><div class="parsley-row"><?php echo $this->form->input('ministry_name.', array('label' => false, 'type' => 'text','class' => "md-input",'id' => 'ministry_name', 'required' => true)); ?></div></div><div class="uk-width-medium-1-3"><div class="parsley-row"><?php echo $this->form->input('ministry_code.', array('label' => false,'class' => "md-input",'type' => 'text', 'id' => 'ministry_code', 'required' => true)); ?></div></div><br><br><a class="remove md-btn md-btn-danger md-btn-wave-light waves-effect waves-button waves-light">Remove</a></div>');
    });

    $(document).on('click','.remove',function() {
            $(this).parent('div').remove();
    });
    
</script>   

<script>
    jQuery(document).ready(function () {
        lists();



    });
    /*Add record script*/

    jQuery("#add").click(function () {
        doChk();
    });

    jQuery("form[name='msgForm']").keypress(function (e) {
        if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
            doChk();
            return false;
        } else {

        }
    });

    jQuery('.option_values').find('input[type=checkbox]').live('click', function (e) {
        if ($(this).is(':checked')) {
            val = 1;
        }
        else {
            val = 0;
        }
        var fdata = 'id=' + $(this).parent().find('.id').val() + '&value=' + val;
        console.log(fdata);
        jQuery.post('<?php echo $this->webroot; ?>Configurations/update_value',
                fdata,
                function (data) {
                    // jQuery("#result").html(data);                    
                    /*console.log(data);*/
                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });

    });


    function lists() {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();
        jQuery.post('<?php echo $this->webroot; ?>Configurations/lists',
                fdata,
                function (data) {
                    jQuery("#result").html(data);
                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    }



</script>   
<style>
    .submit{text-align:left;}
</style>