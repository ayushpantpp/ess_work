        <script type="text/javascript" >
        jQuery(document).ready(function(){
                jQuery('#leavesetion').dialog({ 
                            autoOpen: false,
                            width:750,
                            height:370,
                            modal: true,
                            closeOnEscape:false,
                                buttons:{
                                "Reject": function(){
                                jQuery('#leavereject').dialog("open");
                                },
                                "Move To HR": function(){
                                document.leaveapprove.submit();
                                },
                                "Cancel":function(){ 
                                jQuery(this).dialog("close");
                                }

                                }
                     });
                 }
            );
                    jQuery(document).ready(function(){
                    jQuery('#leavereject').dialog({ 
                                        autoOpen: false,
                                         width:355,
                                        height:255, 
                                        modal: true,
                                        closeOnEscape:false,
                            buttons:{
                                "Submit":function(){ 
                                document.rejectleave.submit();
                                 },
                                "Cancel":function(){ 
                                jQuery(this).dialog("close");
                                 }
                              }
                   });
             })

        function leavereject(compid,empid,sdate,edate,appdate,empName) 
        {
          jQuery('#leavereject').dialog("open")
          var data='Loading...';
          jQuery('#rej_empid').val(empid);
          jQuery('#rej_cid').val(compid);
          jQuery('#rej_sdate').val(sdate);
          jQuery('#rej_edate').val(edate);
          jQuery('#rej_appdate').val(appdate);
          //jQuery('#leavereject').html(data);
        }  

        function get_searchresult()
        {
            var data='Loading....'; 
            jQuery('#searchresult').html(data);

        }

        ///

        function leavesention(compid,empid,sdate,edate,appdate,empName)
        {
            jQuery('#leavesetion').dialog("open")
            var data='Loading...';
            jQuery('#leavesetion').html(data);
            jQuery.ajax({
                        url: '<?php echo $this->webroot; ?>leaves/leavesentiondetails/eid:'+empid+'/sdate:'+sdate+'/edate:'+edate+'/apdate:'+appdate+'/cid:'+compid,
                        success: function(data){
                        jQuery('#leavesetion').html(data);
                        jQuery('#leavesetion').dialog('option', 'title', 'Leave Detail for '+empName);
                    }
             });
        }
        </script>
        <div class="breadCrumbHolder module">
<div id="breadCrumb0" class="breadCrumb	module">
<ul>
<li>
<a href="#" class="vtip" title="Home">Home</a>
</li>
<li><?php echo $this->html->link('Self Services', $this->html->url('/selfservices',	true));	?> </li>
<li>Leave Sanction</li>
</ul>
</div>
</div>

<h2 class="demoheaders">Leave Sanction</h2>
        <div class="travel-voucher1">
        <div class="input-boxs">
        <div class="travel-voucher1">
        <div>
        <?php
        echo $this->form->create('leaves', array(
            'url' => '',
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
        $arrleavestatus=array('5'=>'Approved','3'=>'Cancelled','4'=>'Rejected','1'=>'Pending');
        ?>
                <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                  <tr class="head">
                    <th colspan="3">Leave Filter</th>
                  </tr>
                  <tr class="cont1">
                   <td align="center"><span style="float: left; font-weight: bold; margin-left: 346px; margin-right: 5px; margin-top: 1px;">Sort By  :</span>
                 <?php if(empty($this->passedArgs['lstatus'])) { $default='P';} else {$default=$this->passedArgs['lstatus']; } ?>
                  <?php echo $this->form->Input('lstatus', array('options'=>$arrleavestatus,'default'=>$default , 'empty'=>false,'id'=>'lstatus')); ?>
                    <div class="submit"><input type="submit" value="Search" id="btnserch" onClick="get_searchresult()"></div></td> 
                   </tr> 
                 <?php echo $this->form->input('hsed',array('type'=>'hidden','id'=>'hsed','value'=>@md5(date('YMDhis')))); ?>
                </table>
                 <?php echo $this->form->end();?>
                </div>

                 <div id="searchresult"> 
                <?php 
//pr($leavelist);
                if(!empty($leavelist)){ ?>
                <table width="100%" border="0" cellspacing="1" cellpadding="5" class="exp-voucher">
                <tr class="head">
                <th>Sr.No</th>
                <th>Employee Name</th>
                <th>Submission Date</th>
                <th>Leave From</th>
                <th>Leave upto</th>
                <th>Total Leave</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Leave Type</th>
                <?php 
                $arrleavemode=array('C'=>'Casual','M'=>'Medical','E'=>'Earned','L'=>'LWP');
                $i=1;
                foreach($leavelist as $sresult)
                {
                if($i%2==0)$class='cont'; else $class='cont1';
                if(!empty($sresult['EmpLeave']['ch_lve_status']))
                {
                    $status=$sresult['EmpLeave']['ch_lve_status'];
                } else
                {
                 $status='1';
                }

                ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $sresult['EmpLeave']['vc_emp_name'];  ?></td>
                    <td><?php echo date('d-M-Y',strtotime($sresult['EmpLeave']['dt_app_date']));  ?></td>
                    <td><?php echo date('d-M-Y',strtotime($sresult['EmpLeave']['dt_start_date']));?></td>
                    <td><?php echo date('d-M-Y',strtotime($sresult['EmpLeave']['dt_end_date']));  ?></td>
                    <td><?php echo $sresult['EmpLeave']['nu_tot_leaves'];?></td>
                <?php if(strlen($sresult['EmpLeave']['vc_leave_reason'])< 30){ ?>
                    <td><?php echo $sresult['EmpLeave']['vc_leave_reason'];?></td>
                    <?php } else { ?>
                     <td> <textarea rows='1' cols='18' ><?php echo $sresult['EmpLeave']['vc_leave_reason'];?></textarea> </td>
                <?php } ?>
                    <td><?php echo $arrleavestatus[$status]; ?></td>
                    <td><?php echo @$arrleavemode[$sresult['EmpLeave']['vc_leave_code']]; ?>
                <?php if($status=='P'){ ?> 
                &nbsp;|&nbsp;<a href="javascript:void(0)" onclick="leavesention('<?php echo $sresult['EmpLeave']['vc_comp_code'];?>',<?php echo $sresult['EmpLeave']['vc_emp_code'];?>,'<?php echo $sresult['EmpLeave']['dt_start_date'];?>','<?php echo $sresult['EmpLeave']['dt_end_date'];?>','<?php echo $sresult['EmpLeave']['dt_app_date'];?>','<?php echo $sresult['EmpLeave']['vc_emp_name'];  ?>')">Sanction</a>
                 &nbsp;|&nbsp;<a href="javascript:void(0)" onclick="leavereject('<?php echo $sresult['EmpLeave']['vc_comp_code'];?>',<?php echo $sresult['EmpLeave']['vc_emp_code'];?>,'<?php echo $sresult['EmpLeave']['dt_start_date'];?>','<?php echo $sresult['EmpLeave']['dt_end_date'];?>','<?php echo $sresult['EmpLeave']['dt_app_date'];?>','<?php echo $sresult['EmpLeave']['vc_emp_name'];  ?>')">Reject</a></td>

                <?php } ?>    
                </tr>   

                <?php $i++; } ?>
                <tr><td colspan="8" algin="right">[<?php //echo $paginator->prev(); ?> ]
                <?php //echo $paginator->numbers(array('separator'=>'&nbsp;|&nbsp;')); ?>
                 [ <?php //echo $paginator->next('Next Page'); ?> ]</td></tr>
		 
		 </table>
                <?php } 
		else
		{
		echo " <table width='100%'><tr><td colspan='9' align='center'>There is no record to view ! </td></tr></table>";
		}?>
                 </div>
                </div>
                <div id='leavesetion' title="Please Wait..."></div>

                <div id='leavereject' title="Leave Reject Remark">
                <?php
        echo $this->form->create('leavereject', array(
            'url' => 'leavereject',
            'name'=> 'rejectleave',
            'inputDefaults' => array(
                'label' => false,
                'div' => false,
                'error' => array(
                    'wrap' => 'span',
                    'class' => 'my-error-class',
                      
                )
            )
                )
        ); ?>
                    <table width="100%" class="exp-voucher">
                        <tr class="cont1">
                            <td>Remark : </td>
                            <td><textarea rows='7' cols='40' name='rejectcomment'></textarea>

                         </td>
                         <tr>
                            <td> <input type='hidden' id='rej_empid' name="rej_empid">
                                <input type='hidden' id='rej_cid' name="rej_cid">
                                <input type='hidden' id='rej_sdate' name="rej_sdate">
                                <input type='hidden' id='rej_edate' name="rej_edate">
                                <input type='hidden' id='rej_appdate' name="rej_appdate">
 </td>
                            </tr>
                        </tr> 
                    </table>
                <?php echo $this->form->end(); ?>
            </div>
        </div>
    </div>
</div>

