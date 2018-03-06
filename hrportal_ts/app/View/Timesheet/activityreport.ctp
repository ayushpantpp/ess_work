<?php

App::import('Model', 'General');
$General = new General ;
App::import('Component', 'Functions');
// We need to load the class
 $Function = new FunctionsComponent();
?>
 <script language="javascript">
     function printpage(){
     window.print();
     }

 </script>

<!-- Header Ends -->
 <!-- Center Content Starts -->
 <h2><?php if(!empty($rwEmp['VC_CUSTOMER_NAME'][0])){ echo $rwEmp['VC_CUSTOMER_NAME'][0]?>'s <?php } ?> Activity Report</h2>
<div class="center-content">
       <div style="float:right; margin-bottom:10px;"><img src="<?php echo $this->webroot;?>img/esslogo2.gif"></div>
<div class="travel-voucher">
<div class="input-boxs">
<table width="78%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td><table id="corner" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td><b class="xtop"><b class="xb1"></b><b class="xb2"></b><b class="xb3"></b><b class="xb4"></b></b></td>
				</tr>
				<tr style="text-align:center;">
					 <?php if(!empty($rwEmp['VC_CUSTOMER_NAME'][0])){ ?><td class="tableHeaderTitle1"><?php echo $rwEmp['VC_CUSTOMER_NAME'][0]?>'s   Activity Report</td><?php } ?>
				</tr>
				<tr>
					<td class="xboxcontent"><table border="0" width="100%;" >
							
					<?php if($numEmp != '0'){?>
							<tr>
								<td align="center"><b>Activity</b></td>
								<td align="center"><b>Hours (Days)</b></td>
							</tr>
							<?php $tot=0;
						for($i=0;$i<$numEmp;$i++){

                                                    if($tot==''){
                                                        $tot=0;
                                                    }
                                                    $tot +=$rwEmp['MIN'][$i];
?>
							<tr >
								<td width="77%" valign="top" style="padding-left:5px; border:1px solid #feeddb; color:#b42f00; "><?php echo $rwEmp['VC_ACTIVITY'][$i];?></td>
								<td width="23%" colspan="2" style="background-color:#ffe7cd; vertical-align:middle; padding-top:8px; "><p><?php echo $Function->ConvertTime($rwEmp['MIN'][$i],true).'('.((round($rwEmp['MIN'][$i]/3600))/8).')';?></td>
							</tr>

							<?php }?>
							<tr >
								<td width="77%" valign="top" style="padding-left:5px; border:1px solid #feeddb; color:#b42f00; ">Total</td><?php // if($rwEmp['MIN'][$i]==''){ $rwEmp['MIN'][$i]=0;}?>
								<td width="23%" colspan="2" style="background-color:#ffe7cd; vertical-align:middle; padding-top:8px; "><p><?php echo $Function->ConvertTime($tot,true).'('.((round(@$rwEmp['MIN'][$i]/3600))/8).')';?></td>
							</tr>
                                                        <tr>
                                                            <td class="submit-form"><input type="button" onClick="printpage()" value="Print"/></td>
                                                        </tr>
							<?php }else{ ?>
							<tr>
								<td  colspan="2"align='center'><b>Either no activity has been defined yet or no activity has been done for selected period </b></td>
							</tr>
							<?php }?>
						</table></td>
				</tr>
				<tr>
					<td><b class="xbottom"><b class="bxb4"></b><b class="bxb3"></b><b class="bxb2"></b><b class="bxb1"></b></b></td>
				       
                                </tr>
			</table></td>
	</tr>
</table>


</div>

</div>  </div>

  
  <!-- Center Content Ends -->
  
