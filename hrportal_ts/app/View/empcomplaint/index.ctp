

<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li>
                <a href="#" class="vtip" title="Home">Home</a>
            </li>
            <li>
                Complaint Management System
            </li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Complaint Management System</h2>
<?php
echo $form->create('Empcomplaint', array(
    'url' => '/empcomplaint/prListHtml',
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

        <table width="100%" border="0" cellspacing="5" cellpadding="5">
            <tr>
                <th scope="row" width="20%"><strong>Start Date</strong>  :</th>
                <td><?php echo $form->input('startdate',array('value'=>isset($this->passedArgs['startdate'])?$this->passedArgs['startdate']:''));?></td>
                <th scope="row"><strong>End Date</strong>  :</th>
                <td><?php echo $form->input('enddate',array('value'=>isset($this->passedArgs['enddate'])?$this->passedArgs['enddate']:'')); ?></td>
                <th scope="row"><strong>Filter</strong>  :</th>
                <td>
                    <?php echo $form->select('stage', array('' => '--Select Stage--', 'Recorded' => 'Recorded', 'Work In Progress' => 'Work In Progress', 'User Feedback Awaited' => 'User Feedback Awaited', 'Closed' => 'Closed', 'ESS Feedback Awaited' => 'ESS Feedback Awaited', 'Force Close' => 'Force Close', 'Dropped' => 'Dropped',), (isset($this->passedArgs['stage'])?$this->passedArgs['stage']:'') ,array('empty' => false)); ?>
                    <?php echo $form->select('priority', array('' => '---', 'Low' => 'Low', 'Medium' => 'Medium', 'High' => 'High'), (isset($this->passedArgs['priority'])?$this->passedArgs['priority']:'') ,array('empty' => false)); ?>
                </td>
            </tr>       
        </table>
    </div>

</div>

<div align="center" class="submit"><input type="submit" value="Search" class="successButton"></div>
<?php echo $form->end(); ?>
<div class="travel-voucher1">
</div>
<div id="dialogAssignComplainProject" title="Assign Complaint to Engineer">
    <?php echo $this->Form->create('ComplainEmployees'); ?>
        Select Engineer:
        <?php echo $form->select('vc_emp_code'); ?>
        <?php echo $form->hidden('vc_complain_no'); ?>
    <?php echo $form->end(); ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#EmpcomplaintStartdate, #EmpcomplaintEnddate').datepicker({'dateFormat':'dd-mm-yy'});
        jQuery.post('<?php echo $this->webroot.'/empcomplaint/prListHtml';?>',{},function(data){
            jQuery('.travel-voucher1').replaceWith(data);
            vTipQTip('.travel-voucher1');
        },'html');
        jQuery('input[type=submit]').click(function(){
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
            jQuery.post(jQuery(this).parents('form:first').attr('action'),jQuery(this).parents('form:first').serialize(),function(data){
                    if(data!=''){
                        jQuery('.travel-voucher1').replaceWith(data);
                        vTipQTip('.travel-voucher1');                        
                    }
            },'html');
           return false;
        });        
        jQuery('.navigation').find('a').live('click',function(){
            jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
            jQuery.post(jQuery(this).attr('href'),{},function(data){
                    if(data!=''){
                        jQuery('.travel-voucher1').replaceWith(data);
                        vTipQTip('.travel-voucher1');                        
                    }
            },'html');
           return false;
        });
        jQuery('tr.head th a').live('click',function(){
                jQuery('.tab-fixed').html('<div style="position:absolute; top:50%; left:50%;"><span style="display:block;"><?php echo $html->image('loading.gif',array('style'=>'display:inline;margin:0 auto;')); ?></span></div>');
                jQuery.post(jQuery(this).attr('href'),{},function(data){
                    if(data!=''){
                        jQuery('.travel-voucher1').replaceWith(data);
                        vTipQTip('.travel-voucher1');                        
                    }
                },'html');
               return false;
        }); 
        jQuery('.edit-delete-icon').find('a.assign').live('click',function(){
            project_code = jQuery(this).parents('.edit-delete-icon:first').siblings('input[name=nu_project_code]').val();
            complain_no = jQuery(this).parents('.edit-delete-icon:first').siblings('input[name=vc_complain_no]').val();
            jQuery('#dialogAssignComplainProject form input').val(complain_no);
            jQuery.post('<?php echo $this->webroot.'projects/prAssocEmployeeListHtml/';?>'+project_code,function(data){
                jQuery('#dialogAssignComplainProject form select').html(data);
                jQuery('#dialogAssignComplainProject').dialog("open");
            },'html');
            return false;
        });
        jQuery('.edit-delete-icon').find('a.delete').live('click',function(){
            complain_no = jQuery(this).parents('.edit-delete-icon:first').siblings('input[name=vc_complain_no]').val();
            deleteDialog = jQuery('<div title="Delete Confirmation">Are you sure you want to delete this complaint?<input type="hidden" value="'+complain_no+'"/></div>');
            deleteDialog.dialog({
                autoOpen: true, 
                buttons: { 
                    "Cancel": function() { $(this).remove(); }, 
                    "Delete": function() {
                                    jQuery.post(
                                        '<?php echo $this->webroot . "empcomplaint/prDeleteJson/"; ?>'+jQuery(this).find('input').val(), 
                                        {},
                                        function(data){
                                            $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                            $('#response-message').highlightStyle();
                                            $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                        },
                                        'json'
                                    );
                                    $(this).remove();
                    } 
                }            
            });            
            return false;
        });        
        jQuery('#dialogAssignComplainProject').dialog({
            autoOpen: false, 
            buttons: { 
                "Cancel": function() { $(this).dialog("close"); }, 
                "Assign": function() {
                                jQuery.post(
                                    '<?php echo $this->webroot . "complainEmployees/prAddJson"; ?>', 
                                    jQuery("#dialogAssignComplainProject form").serialize(),
                                    function(data){
                                        $('.new-messsages').html('<div style="width:400px;margin:0 auto;text-align:center;" id="response-message">'+data.message+'</div>');
                                        $('#response-message').highlightStyle();
                                        $('#response-message').fadeIn(600).delay(10000).fadeOut(900);
                                        jQuery('#dialogAssignComplainProject').dialog("close");
                                    },
                                    'json'
                                );
                } 
            }            
        });
    });
</script>



 