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

<table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
    <tr >


    </tr>
    <tr class="head">
     <!-- <th width="3%"><input type="checkbox" id="ch"></th> -->
        <th width="3%">S. No.</th>
        <th width=5%"><?php echo $this->Paginator->sort('org_id', 'Company Name'); ?></th>
        <th width="5%"><?php echo $this->Paginator->sort('module_code', 'Module Name'); ?></th>
        <th width="10%"><?php echo $this->Paginator->sort('event_id', 'Event Name'); ?></th>
        <th width="5%"><?php echo $this->Paginator->sort('active_status', 'Mail Enabled'); ?></th>
        <th width="7%"><?php echo $this->Paginator->sort('frequency', 'Frequency of Mail'); ?></th>
        <th width="55%"><?php echo $this->Paginator->sort('body_data', 'Body Data'); ?></th>
        <th width="10%">Action</th>   


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
    foreach ($list as $res) {
        if ($i % 2 == 0) {
            $class = 'cont';
        } else {
            $class = 'cont1';
        }
        //	 echo $this->Form->create('MailerMaster1', array('url' => '#', 'name' => 'msgForm','id'=>'deptFrm', 'inputDefaults' => array('label' => false, 'div' => false)));
        ?><!-- View -->
        <tr class="<?php echo $class; ?>" id="vw<?php echo $res['MailerMaster']['id']; ?>">
            <td><?php
                $ctr = (($this->params['paging']['MailerMaster']['page'] * $this->params['paging']['MailerMaster']['limit']) - $this->params['paging']['MailerMaster']['limit']) + $i;
                echo $ctr;
                ?>
            </td>
            <td>
                <?php
                $comp_name = $this->Common->findCompanyNameByCode($res['MailerMaster']['org_id']);
                echo $comp_name;
                ?>
            </td>
            <td>
                <?php
                $dept_name = $this->Common->getApplicationNamebyid($res['MailerMaster']['module_code']);
                echo $dept_name;
                ?>
            </td>
            <td>
                <?php echo $this->Common->getEventNamebyid($res['MailerMaster']['event_id']);  ?>
            </td>
            <td>
                <?php
                if ($res['MailerMaster']['active_status'] == 0)
                    echo'No';
                else
                    echo'Yes';
                ?>
            </td>
            <td>
                <span id="empn<?php echo $res['MailerMaster']['frequency']; ?>" style="width:300px; word-wrap:break-word;">
                    <?php echo $this->Form->input('frequency', array('class' => 'round_select', 'disabled' => 'true', 'label' => false, 'id' => 'appName1' . $res['MailerMaster']['frequency'], 'value' => $res['MailerMaster']['frequency'])) ?></span>
            </td> 
            <td>
                <span id="body_data<?php echo $res['MailerMaster']['id']; ?>" style="width:300px; word-wrap:break-word;">
                    <?php echo html_entity_decode(htmlspecialchars_decode($res['MailerMaster']['body_data'])); ?></span>
                <br>
                <span style="width:300px; word-wrap:break-word;background-color: azure;"><?php array_walk(json_decode($res['MailerMaster']['tags']), function(&$x) {echo $x ? '{'.trim($x).'} ':'';}) ; ?></span>
            </td>
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MailerMaster']['id']; ?>" id="edit">Edit</a>  
                <a href="javascript:void(0);" mid="<?php echo $res['MailerMaster']['id']; ?>" id="delete">Delete</a> </td>

        </tr>
        <tr class="<?php echo $class; ?>" id="update<?php echo $res['MailerMaster']['id']; ?>" style="display:none;">

            <td ><?php
                $ctr = (($this->params['paging']['MailerMaster']['page'] * $this->params['paging']['MailerMaster']['limit']) - $this->params['paging']['MailerMaster']['limit']) + $i;

                echo $ctr;
                ?>
            </td>
            <td>
                <?php
                $comp_name = $this->Common->findCompanyNameByCode($res['MailerMaster']['org_id']);
                echo $comp_name;
                ?>
            </td>
            <td>
                <?php
                $dept_name = $this->Common->getApplicationNamebyid($res['MailerMaster']['module_code']);
                echo $dept_name;
                ?>
            </td>
            <td>
                <?php echo $this->Common->getEventNamebyid($res['MailerMaster']['event_id']);  ?>
            </td>
            <td> 
                <?php
                if ($res['MailerMaster']['active_status'] == 1)
                    $checkbox = 'checked';
                else
                    $checkbox = '';
                echo $this->Form->input('active_status', array('label' => false, 'id' => 'appName_hr' . $res['MailerMaster']['id'], 'value' => $res['MailerMaster']['active_status'], 'type' => 'checkbox', 'checked' => $checkbox));
                ?>
                <div id="dnameErr<?php echo $res['MailerMaster']['id']; ?>" style="color:red"></div>
            </td>
            <td>
                <span id="empn<?php echo $res['MailerMaster']['frequency']; ?>" style="width:300px; word-wrap:break-word;">
                    <?php echo $this->Form->input('frequency', array('class' => 'round_select', 'disabled' => 'false', 'label' => false, 'id' => 'frequency' . $res['MailerMaster']['id'], 'value' => $res['MailerMaster']['frequency'])) ?></span>
            </td> 
            <td>
                <span id="body_data<?php echo $res['MailerMaster']['id']; ?>" style="width:300px; word-wrap:break-word;">
                    <?php echo $this->Form->textarea('body_data', array('class' => 'round_select b_data',  'label' => false, 'id' => 'b_data' . $res['MailerMaster']['id'], 'value' => html_entity_decode(htmlspecialchars_decode($res['MailerMaster']['body_data']))   )) ?></span>
                <br>
                <span style="background-color: azure;width:300px; word-wrap:break-word;"><?php array_walk(json_decode($res['MailerMaster']['tags']), function(&$x) {echo $x ? '{'.trim($x).'} ':'';}) ; ?></span>
            </td>
            <td> <a href="javascript:void(0);" mid="<?php echo $res['MailerMaster']['id']; ?>" id="save">Update</a>  <a href="javascript:void(0);" mid="<?php echo $res['MailerMaster']['id']; ?>" id="cancel">Cancel</a> </td>

        </tr>
        <!-- End Edit --> 
        <?php
        $i++;
    }
    ?>

    <?php //echo $this->Form->end(); ?>
</table>

<div class="navigation">
    <div style="float:left;">
        <?php echo $this->Paginator->counter(); ?> Pages
        <?php echo $this->Paginator->prev('[<< Previous]', null, null, array('class' => 'disabled')); ?>
        <?php echo $this->Paginator->numbers(); ?>


        <?php echo $this->Paginator->next('[Next >>]', null, null, array('class' => 'disabled')); ?>
  </div> <div style="float:left; padding-left:180px; margin-top:10px;"> <!-- <input type="button" value="Delete" id="remove" > --></div>


</div>