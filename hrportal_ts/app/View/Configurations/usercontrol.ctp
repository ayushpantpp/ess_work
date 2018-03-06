<?php
$auth = $this->Session->read('Auth');
//$auth['User']['comp_code'];
?><div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Configurations
            </li>
            <li>
                User Control
            </li>            
        </ul>
    </div>
</div>
<br>
<div id="add_msg_div" style=" margin-bottom: 160px;">
    <h2 class="demoheaders">Add/View Modules<a href="#" id="create"></a></h2>
    <?php echo $this->Form->create('Module', array('url' => '#', 'name' => 'msgForm', 'inputDefaults' => array('label' => false, 'div' => false))); ?>
    <div class="travel-voucher" style="padding-bottom: 0;padding-top: 0;height:140px">
        <div class="input-boxs">
            <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                <tr>
                    <td>
                <tr>
                    <?php $company = $this->Common->findCompanyName(); ?>
                    <th scope="row"><strong>Select Organization :</strong>  </th>
                    <td><?php echo $this->Form->input('org_id', array('type' => 'select', 'options' => $company, 'empty' => 'Select Company', 'class' => 'round_select', 'id' => 'org_name')); ?>
                        <div id="dCnameErr" style="color:red"></div>
                    </td>
                </tr>



                <tr id="serch">
                    <th scope="row"><strong>Search Employee by Name :</strong>  </th>
                    <td><?php echo $this->Form->input('search_text', array('type' => 'text', 'id' => 'search_text')); ?>


                    </td>
                </tr>
                <tr>
                    <th scope="row"> </th>
                    <td>

                        <?php echo $this->Form->button('Submit', array('type' => 'button', 'id' => 'search', 'class' => 'submit-btn')); ?>

                        &nbsp; 	&nbsp; 	&nbsp; 	&nbsp; 
                        <?php echo $this->Form->button('Reset', array('type' => 'reset', 'class' => 'submit-btn')); ?>


                    </td>
                </tr>

            </table>
        </div>
    </div>
    <?php
    echo $this->Form->end();
    ?>

</div>


<div id="list_msg_div1">

    <h2 class="demoheaders">List Of Employees</h2>
    <div class="travel-voucher1" style="min-height: 300px;">
        <div style="float:right;padding-right: 25px">
            <select id="choose_action">
                <option >Action</option>
                <option value="change_password">Change Password</option>
                <option value="reset_password">Reset Password</option>
                <option value="activate_user">Activate User</option>
                <option value="deactivate_user">Deactivate User</option>
            </select>
        </div>

        <div class="input-boxs">

            <div id="result"></div>


        </div>
    </div>
    <div id="files"></div>
</div>
</div>


<script>
    jQuery(document).ready(function () {




    });
    userslists('01');//on page load the first option
    $('#org_name option[value="01"]').attr("selected", "selected")
    /*Add record script*/

    jQuery("#add").click(function () {
        var org_id = jQuery("#org_name").val();
        if (org_id != '') {
            var search_text = '';
            userslists(org_id, search_text);
            jQuery("#org_name").css("border", "none");
            //jQuery("#serch").css("display","block");
        } else {
            jQuery("#org_name").css("border", "1px solid red");
            return false;
        }

    });

    jQuery("#reset1").click(function () {
        jQuery("#org_name").val('');
        jQuery("#search_text").val('');
        jQuery("#org_name").css("border", "none");

    });


    jQuery("#search").click(function () {
        var org_id = jQuery("#org_name").val();
        var search_text = jQuery.trim(jQuery("#search_text").val());
        if (org_id == '') {
            jQuery("#org_name").css("border", "1px solid red");
            return false;
        } else {
            jQuery("#org_name").css("border", "none");
            jQuery("#search_text").css("border", "none");
            userslists(org_id, search_text);
        }
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
        var org_id = jQuery("#org_name").val();
        var fdata = 'id=' + $(this).parent().find('.id').val() + '&value=' + val + '&org=' + org_id
        console.log(fdata);
        jQuery.post('<?php echo $this->webroot; ?>Configurations/update_value',
                fdata,
                function (data) {
                    // jQuery("#result").html(data);

                    console.log(data);
                }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });

    });

    jQuery('.navigation').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';

        jQuery("#result").html(data);
        //
        // var fdata = jQuery("#searchForm").serialize();

        current_page = jQuery(this).attr('href');
        var org_id = jQuery("#org_name").val();
        //alert(org_id);
        var search_text = jQuery.trim(jQuery("#search_text").val());
        jQuery.post(current_page, {id: org_id, search_text: search_text}, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });

    jQuery('.head').find('a').live('click', function (e) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        //var fdata = jQuery("#searchForm").serialize();
        current_page = jQuery(this).attr('href');
        var org_id = jQuery("#org_name").val();
        //alert(org_id);
        var search_text = jQuery.trim(jQuery("#search_text").val());
        jQuery.post(current_page, {id: org_id, search_text: search_text}, function (data) {
            jQuery("#result").html(data);

        }, 'html');
        return false;
    });
    function userslists(id, search_text) {
        var data = '<div align="center" style="margin-top:100px; font-size:12px;"><?php echo $this->Html->image("../img/load.gif"); ?><br/><b>Loading Please Wait....</b> </div>';
        jQuery("#result").html(data);
        var fdata = jQuery("#searchForm").serialize();

        jQuery.post('<?php echo $this->webroot; ?>configurations/userslists/',
                {id: id, search_text: search_text},
        function (data) {

            jQuery("#result").html(data);
        }, 'html'
                ).error(function (e) {
            alert("Error : " + e.statusText);
        });
    }

    jQuery('.reset_password').live('click', function () {//to reset password
        bool = confirm("Are you sure you want to reset password");

        if (bool) {
            jQuery.post('<?php echo $this->webroot; ?>configurations/resetUserPassword/',
                    {user_id: jQuery('.user_id').val()},
            function (data) {
                alert(data);
            }, 'html'
                    ).error(function (e) {
                alert("Error : " + e.statusText);
            });
        }
    });

    jQuery('#change_password').live('click', function () {//to change passowrd
        if (jQuery('#cp_value').val() == '' || jQuery('#cp_value').val().length < 4) {
            alert('Password should be more than 3 characters');
            return false;
        }
        bool = confirm("Are you sure you want to change password");
        if (bool) {
            jQuery.post('<?php echo $this->webroot; ?>configurations/changeUserPassword/',
                    {user_id: jQuery('.user_id').val(), new_pass: jQuery('#cp_value').val()},
            function (data) {
                jQuery('#cp_value').val('');
                alert(data);
            }, 'html'
                    ).error(function (e) {
                alert("Error : " + e.statusText);
            });
        }

    });

    jQuery('#toggle_status').live('click', function () {//to  change  status of users
        var status = jQuery(this).is(':checked') ? 'activate' : 'deactivate';
        bool = confirm("Are you sure you want to " + status + " user from portal");
        if (bool) {
            var value = jQuery(this).is(':checked') ? 1 : 0;
            jQuery.post('<?php echo $this->webroot; ?>configurations/changeUserStatus/',
                    {user_id: jQuery('.user_id').val(), portal_status: value},
            function (data) {
                alert(data);
            }, 'html'
                    ).error(function (e) {
                alert("Error : " + e.statusText);
            });
        }
        else {
            return false;
        }

    });

    jQuery('.main_cb').live('click', function () {
        if (jQuery(this).is(':checked')) {
            jQuery('.user_cb').each(function () {
                jQuery(this).attr('checked', true);
            });
        }
        else {
            jQuery('.user_cb').each(function () {
                jQuery(this).attr('checked', false);
            });
        }
    });

    jQuery('#choose_action').live('change', function () {

        var user_ids = [];
        jQuery('.user_cb').each(function () {
            if (jQuery(this).is(':checked'))
                user_ids.push(jQuery(this).val());

        });
        if (user_ids.length > 0) {
            bool = confirm("Are you sure you want to continue with your action");
            if (bool) {

                var selected = jQuery(this).val();
                var new_password = null;
                if (selected == 'change_password') {
                    var new_password = prompt("Please enter new password");
                    if (new_password == null || new_password.length < 4) {
                        alert("Please select password of more than 3 characters");
                        jQuery('#choose_action').val('');
                        jQuery('.main_cb').attr('checked', false);
                        jQuery('.user_cb').each(function () {
                            jQuery(this).attr('checked', false);
                        });
                        return false;
                    }
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->webroot ?>Configurations/updateMultipleUser/",
                    data: {"user_ids": user_ids, "selected": selected, "new_password": new_password},
                    success: function (resp) {
                        alert(resp);
                        jQuery('.user_cb').each(function () {
                            jQuery(this).attr('checked', false);
                        });
                        jQuery('.main_cb').attr('checked', false);
                        jQuery('#choose_action').val('');
                    }
                });
            }
            else {
                jQuery('.user_cb').each(function () {
                    jQuery(this).attr('checked', false);
                });
                jQuery('.main_cb').attr('checked', false);
                jQuery('#choose_action').val('');
                return false;
            }
        }
        else {
            alert('Please Select Users');
            jQuery('#choose_action').val('');
            return false;
        }

    });



</script> 

<style>
    .submit{text-align:left;}
</style>
