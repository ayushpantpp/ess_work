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
</style>
<?php

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
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="#" class="vtip" title="Home">Home</a></li>
            <li>Core</li>
            <li>Work Flow Application Level Department Master</li>            
        </ul>
    </div>
</div>


<br>
<div id="add_msg_div">
    <h2 class="demoheaders">Application Level Work Flow - Department<a href="#" id="create"></a></h2>
    
    <div class="travel-voucher">
        <div class="input-boxs">
<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
    <tr class="head">
        <th><?php echo $this->Paginator->sort('wf_id'); ?></th>
        <th><?php echo $this->Paginator->sort('wf_app_map_lvl_id'); ?></th>
        <th><?php echo $this->Paginator->sort('wf_lvl'); ?></th>
        <th><?php echo $this->Paginator->sort('wf_dept_id'); ?></th>
        <th><?php echo $this->Paginator->sort('wf_desg_id'); ?></th>
        <th><?php echo $this->Paginator->sort('skip_status'); ?></th>
        <th><?php echo $this->Paginator->sort('revoke_level_id'); ?></th>
        <th class="actions"><?php echo __('Actions'); ?></th>
    </tr>





    <?php $i = 1; ?>
    <?php
//pr($this->params);
    foreach ($wfDtAppMapLvls as $wfDtAppMapLvl) {
        if ($i % 2 == 0) {
            $class = 'cont';
        } else {
            $class = 'cont1';
        }
        ?>

        <?php if (empty($wfDtAppMapLvl)) { ?>
            <tr class="cont">
                <td style="text-align:center;" colspan="6">
                    <em>--No Records Found--</em>
                </td>
            </tr>
        <?php } ?>
        <!-- View -->
        <tr class="<?php echo $class; ?>" id="vw<?php echo $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id']; ?>">
            <td><?php echo $i; ?>&nbsp;</td>
            <td><?php echo h($wfDtAppMapLvl['ApplicationDetails']['vc_application_name']); //echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_app_map_lvl_id']);   ?>&nbsp;</td>
            <td><?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_lvl']); ?>&nbsp;</td>
            <td><?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_dept_id']); ?>&nbsp;</td>
            <td><?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['wf_desg_id']); ?>&nbsp;</td>
            <td><?php echo h($wfDtAppMapLvl['WfDtAppMapLvl']['skip_status']); ?>&nbsp;</td>
            <td><?php echo $wfDtAppMapLvl['RevokeLevelDetails']['wf_lvl']; //echo $wfDtAppMapLvl['WfDtAppMapLvl']['revoke_level_id'];   ?>&nbsp;</td>
            <td> <a href="<?php echo $this->webroot; ?>wf_dt_app_map_lvls/edit/<?php echo $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id']; ?>" id="edit">Edit</a>  
                || <a href="#" mid="<?php echo $wfDtAppMapLvl['WfDtAppMapLvl']['wf_id']; ?>" class="level_delete">Delete</a> </td>

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
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".level_delete").click(function () {
            console.log('test');
            level_delete($(this).attr('mid'));
        });


    });


    function level_delete(level_id) {
        var list = '';
        $.ajax({
            url: '<?php echo $this->webroot; ?>wf_dt_app_map_lvls/delete/' + level_id,
            success: function (data) {
                location.reload(true);

            }
        });
    }
</script>