<div class="breadCrumbHolder module">
        <div id="breadCrumb0" class="breadCrumb module">
                <ul>
                        <li>
                                <a href="#" class="vtip" title="Home">Home</a>
                        </li>
                        <li>
                                Leave Management
                        </li>
                        <li>
                                Leave Report
                        </li>            
                </ul>
        </div>
</div>
<h2 class="demoheaders">Select Date<a href="#" id="create"></a></h2>
<?php
echo $this->Form->create('Search', array('url' => array('controller' => 'leaves', 'action' => 'hrleavereportexcel'), 'inputDefaults' => array('label' => false, 'div' => false)));
?>
<div class="travel-voucher">
        <div class="input-boxs">

                <table  border="0" width="97%" cellspacing="10" cellpadding="0" align="center" style="margin:0px auto;">
                        <tr>
                                <th scope="row"><strong>From</strong>  :</th>
                                <td><?php echo $form->input('fromdate', array('type' => 'text', 'class' => 'round')); ?></td>
                                </tr>
                                <tr>
                                <th scope="row"><strong>To</strong>  :</th>
                                <td><?php echo $form->input('todate', array('type' => 'text', 'class' => 'round')); ?></td>
                                </tr>
                              
                        <tr>
                    <th scope="row">Employee Name :</th>
                      <td> 
                          <?php echo $form->input('Search.vc_emp_code', array('type' => 'select', 'label' => false, 'options' => $emplist, 'default' => '', 'class' => 'round_select','style'=>'width:148px;')); ?>
                      </td>
                </tr>
                
                <tr>
                    <td align="right"><b>Status :</b></td>
                    <td>
                        <select name="data[Search][status]" id="lvsrt" class = "round_select" style="width:148px;">
                            <option value="Y" selected>Employee Mark Leave</option>
                            <option value="1">defaulter(00:00 Hours)</option>
                            <option value="2">consolidated</option>
                        </select>
                    </td>
                </tr>
                
                 <tr>
                    <td align="right"><b>Apply Leave Status :</b></td>
                    <td>
                        <select name="data[Search][app_leave_status]" id="applylvsrt" class = "round_select" style="width:148px;">
                            <option value="2" selected>All</option>
                            <option value="1" >Yes</option>
                            <option value="0">No</option>
                        </select>
                    </td>
                </tr>
                  <tr>
                    
                                <td style="width:45% ; float: none;    text-align: right;"><?php echo $this->Form->button('Search', array('type' => 'button', 'id' => 'search_leaves')); ?></td>
                                <td class="submit-form" colspan="1"  style="width:55% ;  margin-left: 20px; float: none;    text-align: left;">
                                    <input type="submit" class="taskbutton" id="exceldownload" value="Download Excel" name="data[Leave_Report][submit]" >
                    </td>
                        </tr>
                </table>
        </div>
</div>
<?php
echo $this->Form->end();
?>
<div id="report_div" style="o">

</div>
<script type="text/javascript">
        jQuery(function(){
                jQuery('#SearchFromdate').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'dd-mm-yy'
                });    
                jQuery('#SearchTodate').datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: 'dd-mm-yy'
                }); 
                jQuery('#search_leaves').click(function(){
                        jQuery('#report_div').empty().html('Loading ...');
                        jQuery.post('<?php echo $this->webroot; ?>leaves/hrleavereport',jQuery('#SearchHrleavereportForm').serialize(), function(data){
                                jQuery('#report_div').empty().html(data);
                        });
                });
        });
</script>
