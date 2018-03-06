<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                <a href="<?php echo $this->webroot.'empcomplaint/';?>">Complaint Management System</a>
            </li>
            <li>
                Reports
            </li>            
        </ul>
    </div>
</div>
<h2 class="demoheaders">Complain Reports</h2>
<!--<?php
echo $form->create('Complaints', array(
    'url' => '/empcomplaint/prReportListHtml',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);
?>
<div class="travel-voucher">
    <div class="input-boxs">
        <table width="100%" cellspacing="5" cellpadding="5" border="0">
            <tr>
                <th>
                    Select Period Range
                </th>
                <td>
                    <?php echo $this->Form->input('period', array('empty'=>false, 'options'=>$period,'label'=>false)); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div align="center" class="submit"><button type="submit" name="Submit"/>Consolidate Report</button><button type="submit" name="Download"/>Download Excel</button></div>
<?php echo $form->end(); ?>
-->
<?php
echo $form->create('Complaints', array(
    'url' => '/empcomplaint/prReportListXls',
    'inputDefaults' => array(
        'label' => false,
        'div' => false,
        'error' => array(
            'wrap' => 'span',
            'class' => 'my-error-class'
        )
    )
        )
);
?>
<div class="travel-voucher">
    <div class="input-boxs">
        <table width="100%" cellspacing="5" cellpadding="5" border="0">
            <tr>
                <th>
                    From Date
                </th>
                <td>
                    <?php echo $this->Form->input('fromDate'); ?>
                </td>
                <th>
                    To Date
                </th>
                <td>
                    <?php echo $this->Form->input('toDate'); ?>
                </td>
            </tr>
           <!-- <tr>
                <th>
                    Select Project:
                </th>
                <td>
                    <?php echo $this->Form->input('projects', array('empty'=>false, 'options'=>$projects, 'empty'=>'--Select Project--')); ?>
                </td>
                <th> 

                </th> -->
                <td>

                </td>
            </tr>
        </table>
    </div>
</div>
<div align="center" class="submit"><button type="submit" name="Submit"/>Custom Report</button><button type="submit" name="Download"/>Download Excel</button></div>
<?php echo $form->end(); ?>
<div class="travel-voucher1">

</div>
<script type="text/javascript">
        jQuery(document).ready(function(){
            jQuery.post('<?php echo $this->webroot.'/empcomplaint/prReportListHtml';?>',{},function(data){
                jQuery('.travel-voucher1').replaceWith(data);
            },'html');            
            jQuery('#ComplaintsFromDate').datepicker({dateFormat:'dd-mm-yy'});
            jQuery('#ComplaintsToDate').datepicker({dateFormat:'dd-mm-yy'});
            jQuery('button[type=submit]').filter('*[name="Submit"]').click(function(){
                jQuery('.travel-voucher1').html('<div style="width:100%;height:250px;line-height:250px;text-align:center;display: table-cell;vertical-align:middle;"><span style="width:960px;display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
                jQuery.post(jQuery(this).parents('form:first').attr('action'),jQuery(this).parents('form:first').serialize(),function(data){
                    jQuery('.travel-voucher1').replaceWith(data);
                },'html');
               return false;
            });
            jQuery('button[type=submit]').filter('*[name="Download"]').click(function(){
                jQuery.download('<?php echo $this->webroot.'/empcomplaint/prReportListXls';?>',jQuery(this).parents('form:first').serialize()+'&data[ajax]=true','post');
                return false;
            });            
            jQuery('.navigation').find('a').live('click',function(){
                jQuery('.travel-voucher1').html('<div style="width:100%;height:250px;line-height:250px;text-align:center;display: table-cell;vertical-align:middle;"><span style="width:960px;display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
                jQuery.post(jQuery(this).attr('href'),{},function(data){
                    jQuery('.travel-voucher1').replaceWith(data);
                },'html');
               return false;
            });
            jQuery('tr.head th a').live('click',function(){
                jQuery('.travel-voucher1').html('<div style="width:100%;height:250px;line-height:250px;text-align:center;display: table-cell;vertical-align:middle;"><span style="width:960px;display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
                jQuery.post(jQuery(this).attr('href'),{},function(data){
                    jQuery('.travel-voucher1').replaceWith(data);
                },'html');
               return false;
            });            
        });
</script>


