<script language="javascript">
    function CheckDetails(obj){
        if(!ValidateForm(obj))
            return false;

        var myOption=false;
        for (i=0;i< obj.rate_type.length; i++) {
            if (obj.rate_type[i].checked) {
                myOption =true;
            }
        }
        if (myOption == false) {
            alert("You must select a rate type");
            obj.rate_type[0].focus();
            return false;
        }else{
            return true;
        }
    }
    var ajaxObjects = new Array();

    function LastFormRecord(url){
        jQuery.ajax({
            url: '<?php echo $this->webroot . "Timesheet/billingmasterdetail" ?>',
            data: url,
            success: function(data){
                if(data!=0){
                    var DateSetter=data.split('::');
                    if(DateSetter[1]!=''){
                        document.getElementById('price').value=DateSetter[1];
                        if(DateSetter[2]){(DateSetter[2]=='H')?document.frmSearch.rate_type[0].checked=true:document.frmSearch.rate_type[1].checked=true;}
                        document.getElementById('TR_effective_date').value=DateSetter[3];
              
                    }
                }else {
                    document.getElementById('price').value='';
                    document.getElementById('TR_effective_date').value='';

                }
            }
        });
    }


</script>

<form name="frmSearch" method="POST" action="billingmaster" onSubmit="return CheckDetails(this);">
<div class="breadCrumbHolder module">
    <div id="breadCrumb0" class="breadCrumb module">
        <ul>
            <li><a href="<?php echo $this->webroot;?>employees/dashboard" class="vtip" title="Home">Home</a></li>
            <li><?php echo $html->link('Self Services', $html->url('/selfservices', true)); ?> </li>
            <li><?php echo $html->link(' Timesheet', $html->url('/selfservices/#timesheet', true)); ?> </li>
            <li>Billing</li>
            <li>Designation Wise Rate</li>
        </ul>
    </div>
</div>

<h2 class="demoheaders"> Designation Wise Rate</h2>
    <input type="hidden" name="posted" value='1'>
   
    <?php if(!empty($sno)){ ?>
    <input type="hidden" name="sno" value='<?php  echo $sno; ?>'>

<?php  } ?>
    <div class="wrpper">
        <!-- Center Content Starts -->

            <div class="travel-voucher">

                <div class="input-boxs">

                    <table width="100%" border="0" cellspacing="5" cellpadding="5">
                
                        <h2 style="color:blue;" align="middle"> </h2>
                        <tr>
                            <th scope="row">Designation :</th> <?php if(empty($empdesignation)){ $empdesignation=0; } ?>
                            <td> <select name="TR_designation"  id="desg"class="textbox" onChange="javascript:LastFormRecord('task=CustomerDetail&desg_code='+this.value);">
                                    <option value="">All Region</option>
                                    <?php foreach ($rwDesg as $rwDesg1) {  
 ?>
                                        <option value="<?php echo $rwDesg1[0]['vc_desg_code'] ?>" <?php if(!empty($detail)){ if($detail[0][0]['VC_DESG_CODE']==$rwDesg1[0]['vc_desg_code']) echo 'SELECTED'; } ?>><?php echo $rwDesg1[0]['vc_description'] ?></option>
<?php } ?>
                                </select></td>
                        </tr>
                        <tr>
                            <th scope="row">Rate Type:</th>
                            <td>
                                <div style="float:left; "><input type="radio" name="rate_type" value="H" <?php if(!empty($detail)){if($detail[0][0]['CH_TYPE']=='H') echo 'CHECKED';} ?>> Per Hour</div>
                            
                                <div style="float:left; margin-left: 8px;"><input type="radio" name="rate_type" value="D"   <?php if(!empty($detail)){ if($detail[0][0]['CH_TYPE']=='D') echo 'CHECKED';}  ?>> Per Day</div>
                            </td>      </tr>

                        <tr>
                            <th scope="row">Rate :</th>
                            <td> <div id="allemp"><input type="text" id="price" size='13' maxlength='13'name="MR_price" class="textbox" value="<?php if(!empty($detail)){  echo ($detail[0][0]['NU_AMOUNT']!='')?$detail[0][0]['NU_AMOUNT']:(($rwRate['NU_AMOUNT'][0]!='')?$rwRate['NU_AMOUNT'][0]:'');} ?>" ></div></td>

                        </tr>
                        <tr>
                            <th scope="row">Rate Effective Form :</th>
                            <td><input name="TR_effective_date" class="textBox" value="<?php if(!empty($detail)){  echo ($detail[0][0]['VC_EFFECTIVE_FROM']!='')?$detail[0][0]['VC_EFFECTIVE_FROM']:(($rwRate['VC_EFFECTIVE_FROM'][0]!='')?$rwRate['VC_EFFECTIVE_FROM'][0]:'');} ?>"   id="TR_effective_date" readonly size="10"  maxlength="10" type="text" >


                                <script type="text/javascript"> jQuery(function(){jQuery('#TR_effective_date').datepicker({ inline: true,changeMonth:true, changeYear:true, dateFormat: 'dd-mm-yy' });});</script></td>


                        </tr>
                    </table>


                </div>

            </div>

            <div class="submit-form">

                <input type="submit"  class="textBox" name="action_perform" value="<?php echo ($task=="Edit")?'Edit':'Add' ?> Price"> &nbsp;
                <input type="button" Name="Add New" Value="<< Back" class="textbox" onClick="window.location.href='billinglist'">

            </div>



            <!-- Center Content Ends -->

      

    </div>
</form>
<script type="text/javascript">
    
</script>

