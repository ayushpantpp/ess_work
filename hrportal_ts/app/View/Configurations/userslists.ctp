<style type="text/css">
    td{
        word-wrap: break-word;
        white-space: normal;

    }
    .td1{
        display:block;
        width:500px;
        overflow: hidden;
    }
    .highlight_word{

        background-color: #ACA;

    }
    .ui-dialog-content.ui-widget-content{
        width:96% !important;
    }

</style>	
<?php
$user_control_action = false;
if (Router::parse($this->request->referer(1))['action'] == 'usercontrol')//to check the referer or the function controller function
    $user_control_action = true;

function match($mat) {
    return "^^^^^" . $mat[0] . "~~~~~";
}

function highlightWords($string, $words) {
    $search_exploded = explode(" ", $words);
    foreach ($search_exploded as $search_each) {
        //echo $search_each;
        $search_each = htmlspecialchars_decode($search_each, ENT_QUOTES);
        $search_each = preg_quote($search_each);
        //$string = preg_replace("/\b($search_each)\b/i", '<span class="highlight_word">\1</span>', $string);
        $string = preg_replace_callback("/$search_each/i", "match", $string);
    }
    $string = str_replace('^^^^^', '<span class="highlight_word">', $string);
    $string = str_replace('~~~~~', '</span>', $string);
    return $string;
    /*     * * return the highlighted string ** */
}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
    <tr >


    </tr>
    <tr class="head">
        <?php if ($user_control_action): ?>
            <th width="3%"><input type="checkbox" class="main_cb"></th>
        <?php endif; ?>
        <th width="7%">S. No.</th>
        <th width="25%"><?php echo $this->Paginator->sort('name', 'User Name'); ?></th> 
        <th width="15%">Emp Code</th>
        <th width="15%">Comp Code</th>
        <th width="30%">Department</th>
        <th width="30%"><?php echo $user_control_action ? 'Action' : 'Assign' ?></th>


    </tr>
    <?php $i = 1; ?>
    <?php if (empty($list)) { ?>
        <tr class="cont">
            <td style="text-align:center;" colspan="6">
                <em>--No Records Found--</em>
            </td>
        </tr>
    <?php } ?>
    <?php
//print_r($this->params);
    foreach ($list as $res) {
        if ($i % 2 == 0) {
            $class = 'cont';
        } else {
            $class = 'cont1';
        }
        ?>
        <!-- View -->
        <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MyProfile']['id']; ?>">
            <?php if ($user_control_action): ?>
                <td width="3%"><input type="checkbox" class="user_cb" value="<?php echo $res['MyProfile']['id']; ?>"></td>
            <?php endif; ?>
            <td ><?php
                $ctr = (($this->params['paging']['MyProfile']['page'] * $this->params['paging']['MyProfile']['limit']) - $this->params['paging']['MyProfile']['limit']) + $i;
                echo $ctr;
                ?>
            </td>
            <td>
                <span id="empn<?php echo $res['MyProfile']['emp_code']; ?>" style="width:300px; word-wrap:break-word;">
                    <?php echo $res['MyProfile']['emp_full_name']; ?> </span>
            </td>
            <td>
                <span  style="width:300px; word-wrap:break-word;">
                    <?php echo $res['MyProfile']['emp_code']; ?></span>
            </td>
            <td>
                <span  style="width:300px; word-wrap:break-word;">
                    <?php echo $res['MyProfile']['comp_code']; ?></span>
            </td>
            <td>
                <span  style="width:300px; word-wrap:break-word;">
                    <?php echo $this->Common->getdepartmentbyid($res['MyProfile']['dept_code']); ?></span>
            </td>
            <td>
                <span id="empn<?php //echo $res['ADMIN_ORG']['status'];             ?>" class="option_values" style="width:300px; word-wrap:break-word;">
                    <a href="#" mid="<?php echo $res['MyProfile']['emp_code']; ?>" id="dialog_link" onclick="modal(<?php echo $res['MyProfile']['emp_code']; ?>);" value="<?php echo $res['MyProfile']['emp_code']; ?>"><?php echo $user_control_action ? 'Action' : 'Assign' ?></a> 


                </span></td> 


        </tr>
        <!-- End View -->



        <?php
        $i++;
    }
    ?>





</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>


        <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>
<div id="dialog" title="<?php echo $user_control_action ? 'Action' : 'ACL Information'; ?>" style="display:none;">
    <div id="load"></div>
    <div id="frm" style="overflow: scroll; height: 400px;">

    </div>
</div>

<div id="viewdetails" title="Employee Details" style="width:590px;display:none">
    <span id="display_details">Loading....</span>   
</div>

<script type="text/javascript">
    function modal(id)
    {
        var user_control_action = "<?php echo $user_control_action; ?>";
        $('#dialog').dialog('open');
        jQuery("#load").html('Loading...');
        $("#frm").hide();
        $('.ui-widget-overlay').hide();
        if (user_control_action) {
            $.ajax({
                type: "POST",
                cache: false,
                data: {"id": id, "comp_code": '<?php echo $res['MyProfile']['comp_code']; ?>', "uc_action": 'usercontrol'},
                url: "<?php echo $this->webroot; ?>Configurations/getAllEnabledModule/",
                success: function (data) {
                    jQuery("#load").html('');
                    jQuery("#frm").html(data);
                    $("#frm").show();
                }
            });
        }
        else {
            $.ajax({
                type: "POST",
                cache: false,
                data: {"id": id, "comp_code": '<?php echo $res['MyProfile']['comp_code']; ?>', "action": 'accesscontrol'},
                url: "<?php echo $this->webroot; ?>Configurations/getAllEnabledModule/",
                success: function (data) {
                    jQuery("#load").html('');
                    jQuery("#frm").html(data);
                    $("#frm").show();
                }
            });
        }
    }
    $(function () {
        var user_control_action = "<?php echo $user_control_action; ?>";
        $('#dialog').dialog({
            autoOpen: false,
            width: 600,
            modal: true,
            buttons: {
                "Ok": function () {
                    if (user_control_action) {
                        jQuery("#overlay").hide();
                        $('#dialog').dialog('close');
                    }
                    else {
                        var mod_id = JSON.stringify($('#frm :input.mod_id').serializeArray());
                        var rights_type = JSON.stringify($('#frm :input.rights_type').serializeArray());
                        var emp_code = $('#emp_code').val();
                        var comp_code = $('#comp_code').val();
                        $('#dialog').dialog('close');
                        jQuery("#overlay").show();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $this->webroot ?>Configurations/UpdateACL/",
                            data: {"rights_type": rights_type, "emp_code": emp_code, "comp_code": comp_code},
                            success: function (data_var)
                            {
                                jQuery("#overlay").hide();
                                createMsg(data_var);
                            }
                        });
                    }
                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }

        });


    });




</script>

