
<script type="text/javascript">
    $(function(){

        // Dialog
        $('#dialog').dialog({
            autoOpen: false,
            width: 800,
            height:400,
            modal:true,
            buttons: {

                "Cancel": function() {
                    $(this).dialog("close");


                }
            }
        });


    });

    function managerfrwd()
    {
        var empid=document.getElementById('emp_ids').value;
        var stdate='2';
        var eddate='2';
        var managerdesg='<?php echo $rwEmpDesg['DESG'][0] ?>';
      
        $("#getexpdetail").empty().html('<img src="<?php echo $this->webroot; ?>img/ajax-loader1.gif" />');

        jQuery.get('<?php echo $this->webroot; ?>Timesheet/managerfrwd/'+empid+'/'+stdate+'/'+eddate+'/'+managerdesg,{}, function(data){
            jQuery('#getexpdetail').html(data);

        });


        jQuery('#dialog').dialog('open');


    }
</script>
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a></li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
            <li>Billing</li>
              <li>Filter By Designation</li>
        </ul>
    </div>
</div>

<h2 class="demoheaders">Filter By Designation</h2>

<!-- Center Content Starts -->
    <div class="travel-voucher">

        <div class="input-boxs">
            <?php echo $form->create('sanctionlist', array('url' => array('controller' => 'Timesheet', 'action' => 'billinglist'), 'id' => 'Timesheet', 'name' => 'Timesheet')); ?>

            <table width="100%" border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <th scope="row">Filter By Designation :</th>
                    <td> <select name="TR_designation"  id="desg"class="textbox"  onChange="javascript:this.form.submit();">
                                    <option value="">Select Designation</option>
                                    <?php for($i=0;$i<$totaldesg;$i++) {  ?>
                                        <option value="<?php echo $rwFilter['VC_DESG_CODE'][$i] ?>" <?php if($seldesignation==$rwFilter['VC_DESG_CODE'][$i]){ echo "selected"; } ?>><?php echo $rwFilter['VC_DESCRIPTION'][$i] ?></option>
                                    <?php } ?>
                                </select></td>
                </tr> </table>
           
            
            </div>
        </div>
       <div class="travel-voucher1">
            <div class="input-boxs-timesheet">
                <div>
                    <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                        <tr class="head">

                        <th>Designation</th>
                        <th>Code</th>
                        <th>Rate</th>
                        <th>Type</th>
                        <th>Rate Effective From</th>
                        <th>Action</th>
                        
                    </tr>
                    <?php if($totdesgbydetail=='0') {
            ?>
    <tr class="cont">
    <td style="text-align:center;" colspan="8">
    <em>--No Records Found--</em>
    </td>
    </tr>
<?php } ?>

      <?php for($j=0;$j<$totdesgbydetail;$j++) {  ?>
                   
                     <tr class="<?php if($j%2==0){ echo "cont1"; }else{ echo "cont"; }?>">
                                <td align="center" nowrap="nowrap"><?php echo $rwDesg['VC_DESCRIPTION'][$j]?></td>
                                <td align="center" nowrap="nowrap"><?php echo $rwDesg['VC_DESG_CODE'][$j]?></td>
                                <td align="center"><?php echo $rwDesg['NU_AMOUNT'][$j]?></td>
                                <td align="center"><?php echo ($rwDesg['CH_TYPE'][$j]=='D')?'Per Day':'Per Hour'?></td>
                                <td align="center"><?php echo $rwDesg['VC_EFFECTIVE_FROM'][$j]?></td>
                                <td align="center">
                                        <ul class="edit-delete-icon">
        <li style="border:none">
                                    <a href="billingmaster?task=Edit&s_no=<?php echo $rwDesg['S_NO'][$j]?>" class="edit vtip" Title="Edit">Edit </a>
        </li>
                                        </ul>           </td>
                     </tr>
<?php }   ?>

                </table>
<?php $form->end(); ?>
            </div>

        </div>

    </div>







<!-- Center Content Ends -->



