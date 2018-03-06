<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                User Management
            </li>
            <li>
                Assigned Role Report
            </li>            
        </ul>
    </div>
</div>

<h2 class="demoheaders">Assigned Role Report</h2>
<?php
echo $this->form->create('UserDetail', array('url' => '/admins/prListAssignedRoleReportHtml', 'inputDefaults' => array(
        'label' => false, 'div' => false, 'error' => array('wrap' => 'span', 'class' => 'my-error-class'))));
?>

<div style="height:100px;" class="travel-voucher">
    <div class="input-boxs">
        <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr>
                <th scope="row" width="253"><strong>Name</strong>  :</th>
                <td><?php echo $this->form->input('name', array('value' => isset($this->passedArgs['name']) ? $this->passedArgs['manager'] : '')); ?></td>                
            </tr>
            <tr>
                <th scope="row"><strong>Applications</strong>  :</th>
                <td><?php echo $this->form->input('application', array('options' => $applications, 'class' => 'round_select', 'value' => isset($this->passedArgs['department']) ? $this->passedArgs['department'] : '')); ?></td>
            </tr>
            <tr>
                <td colspan="4">
                    <div class="submit">
                        <input type="submit" value="Search" class="successButton">
                        <input type="button" value="download comprehensive excel" class="successButton">
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php echo $this->form->end(); ?>
<h2 style="margin-top:180px;" class="demoheaders">Employee List</h2>
<div class="travel-voucher1"></div>
<div id="dialogAssignApplicationRole"></div>
<script type="text/javascript">
    $(function () {
        jQuery.post('<?php echo $this->webroot . 'admins/prListAssignedRoleReportHtml'; ?>', {}, function (data) {
            jQuery('.travel-voucher1').replaceWith(data);
            vTipQTip('.travel-voucher1');
        }, 'html');
        jQuery('.navigation').find('a').live('click', function () {
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $this->html->image('loading.gif', array('style' => 'display:inline;margin:0 auto;')); ?></span></div>');
            jQuery.post(jQuery(this).attr('href'), {}, function (data) {
                jQuery('.travel-voucher1').replaceWith(data);
                vTipQTip('.travel-voucher1');
                jQuery.each(jQuery.gdata.eidarr, function (index, value) {
                    jQuery('input[id=select]').filter('input[value=' + value + ']').attr('checked', true);
                });
            }, 'html');
            return false;
        });
        jQuery('tr.head th a').live('click', function () {
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $this->html->image('loading.gif', array('style' => 'display:inline;margin:0 auto;')); ?></span></div>');
            jQuery.post(jQuery(this).attr('href'), {}, function (data) {
                jQuery('.travel-voucher1').replaceWith(data);
                vTipQTip('.travel-voucher1');
            }, 'html');
            return false;
        });
        jQuery('input[type=submit]').click(function () {
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $this->html->image('loading.gif', array('style' => 'display:inline;margin:0 auto;')); ?></span></div>');
            jQuery.post(jQuery(this).parents('form:first').attr('action'), jQuery(this).parents('form:first').serialize(), function (data) {
                jQuery('.travel-voucher1').replaceWith(data);
                vTipQTip('.travel-voucher1');
            }, 'html');
            return false;
        });
        jQuery('input[value="download comprehensive excel"]').click(function () {
            jQuery.download('<?php echo $this->webroot . 'admins/prListAssignedRoleReportXls'; ?>', jQuery(this).parents('form:first').serialize() + '&data[ajax]=true', 'post');
            return false;
        });
        jQuery('.travel-voucher1 .edit-delete-icon a.assign').live('click', function (e) {
            e.preventDefault();
            var div = jQuery('<div id="dialog_application_list" title="Application List"><table width="650px"><tr><td><div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $this->html->image('loading.gif', array('style' => 'display:inline;margin:0 auto;')); ?></span></div></td></tr></table></div>');
            div.dialog({autoOpen: false, modal: true, width: 700, height: 400, close: function () {
                    jQuery('#dialog_application_list').dialog('destroy');
                    jQuery('#dialog_application_list').remove();
                }});
            div.dialog("open");
            jQuery.post('<?php echo $this->webroot . 'applications/prListHtml/' ?>', {'data[empIdList]': jQuery(this).attr('id')}, function (data) {
                jQuery('#dialog_application_list').html(data);
                jQuery('#dialog_application_list').dialog({buttons: {
                        "Assign All": function () {
                            jQuery.post('<?php echo $this->webroot . 'acls/prAssignroleJson/' ?>', jQuery(this).find('form').serialize() + '&data[empIdList]=' + jQuery('#dialog_application_list #empIdList').val(), function (data) {
                                if (data.status == 1) {
                                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                                    jQuery('#response-message').highlightStyle();
                                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                }
                                if (data.status == 0) {
                                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                                    jQuery('#response-message').errorStyle();
                                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                }
                            }, 'json');
                            jQuery('#dialog_application_list').dialog('destroy');
                            jQuery('#dialog_application_list').remove();
                        },
                        "Cancel": function () {
                            jQuery('#dialog_application_list').dialog('destroy');
                            jQuery('#dialog_application_list').remove();
                        }
                    }});
            }, 'html');
        });
        jQuery('button[id^="application_id_"]').click(function () {
            var application_id = $(this).attr('id').replace('application_id_', '');
            var role_id = $('#roles_' + application_id).val();
            var user_id = 0;
            var selectednode = jQuery.jstree._reference('#tree')._get_node(null, false);
            if (selectednode)
                user_id = selectednode.attr('id');
            //alert('Application:= '+application_id+' |  Role Id:= '+role_id+' | User ID:= '+user_id);
            $.post(
                    '<?php echo $this->webroot . "acls/pr_assignrole_json"; ?>',
                    {'data[nu_application_id]': application_id, 'data[nu_role_id]': role_id, 'data[vc_emp_code]': user_id},
            function (data) {
                //alert(data.message);
                $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                $('#response-message').highlightStyle();
                //$('#debug').html(data);
                //$('#debug').html(data);
                //$('#tree').jstree('refresh',-1);
            },
                    'json'
                    );
        });
        jQuery('#dialog_application_list_search .edit-delete-icon li a').live('click', function (e) {
            e.preventDefault();//alert(jQuery('input.successButton[value="assign to search result"]').parents('form').serialize());
            index = jQuery(this).attr('id');
            application_id = jQuery('#dialog_application_list_search input[name="data[assignrole][' + index + '][nu_application_id]"]').val();
            role_id = jQuery('#dialog_application_list_search select[name="data[assignrole][' + index + '][nu_role_id]"]').val();
            data = 'data[assignrole][0][nu_application_id]=' + application_id + '&data[assignrole][0][nu_role_id]=' + role_id + '&' + jQuery('input.successButton[value="assign to search result"]').parents('form').serialize();
            jQuery.post('<?php echo $this->webroot . 'acls/prAssignroleJson/' ?>', data, function (data) {
                if (data.status == 1) {
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                }
                if (data.status == 0) {
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                    jQuery('#response-message').errorStyle();
                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                }
            }, 'json');
        });
        jQuery('#dialog_application_list .edit-delete-icon li a').live('click', function (e) {
            e.preventDefault();
            //alert('testing'+jQuery('#dialog_application_list #empIdList').val());
            if (jQuery('#dialog_application_list #empIdList').val() == '') {
                data = jQuery('#dialog_application_list form').serialize() + '&' + jQuery('input.successButton[value="assign to search result"]').parents('form').serialize();
            } else {
                index = jQuery(this).attr('id');
                if (jQuery('#dialog_application_list_search').length != 0) {
                    application_id = jQuery('#dialog_application_list_search input[name="data[assignrole][' + index + '][nu_application_id]"]').val();
                    role_id = jQuery('#dialog_application_list_search select[name="data[assignrole][' + index + '][nu_role_id]"]').val();
                } else {
                    application_id = jQuery('#dialog_application_list input[name="data[assignrole][' + index + '][nu_application_id]"]').val();
                    role_id = jQuery('#dialog_application_list select[name="data[assignrole][' + index + '][nu_role_id]"]').val();
                }
                data = 'data[assignrole][0][nu_application_id]=' + application_id + '&data[assignrole][0][nu_role_id]=' + role_id + '&data[empIdList]=' + jQuery('#dialog_application_list #empIdList').val();
                //alert(data);
            }
            jQuery.post('<?php echo $this->webroot . 'acls/prAssignroleJson/' ?>', data, function (data) {
                if (data.status == 1) {
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                    jQuery('#response-message').highlightStyle();
                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                }
                if (data.status == 0) {
                    jQuery('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">' + data.message + '</div>');
                    jQuery('#response-message').errorStyle();
                    jQuery('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                }
            }, 'json');
        });
    });

</script>
<div id="debug"></div>