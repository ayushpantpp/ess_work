

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

<!--<h2 class="demoheaders">Complaint Management System</h2>-->
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

        
		<div><h2 class="demoheaders">Ebizframe 10 Customers Listing</h2>
		</div><div style="float:right;">
		
		<!--<a href="type"><b>Add Complaint</b></a>&nbsp;&nbsp;|-->&nbsp;&nbsp;<a href="addebiztencustomers"><b>Add Customers</b></a></div>
	
		<table border="0" width="100%"  cellspacing="1" cellpadding="0"  class="exp-voucher">
                        <tr class="head">
						    <th align="left">S.no</th>
                            <!--<th align="left">Customer code</th>-->
                            <th align="left">Customer Name</th>
                        	<th align="left">Created date</th>
<th align="left">Action </th>
                           
                            
                        </tr>

                        <tr class="cont">
						<?php if($len == 0) { ?>
                            <td style="text-align:center;" colspan="11">
                                <em>--No Records Found--</em>
                            </td>
							<?php }  ?>
                        </tr>
						<?php $i=1; foreach($customers as $customers):
                                                    
                                                    if($i%2==0)
                                                    {
                                                       $class="cont"; 
                                                    }else{
                                                         $class="cont1";
                                                    }?> 
					<tr class="<?php echo $class; ?>">
					    <td  align="left"><?php echo $i; ?></td>
						<!--<td align="left"><?php echo $customers['Mstcomplaintcustomer']['vc_customer_code']?></td>-->
						<td align="left"><?php echo ucfirst($customers['Mstcomplaintcustomer']['vc_customer_name']);?></td>
						<td align="left"><?php  echo date('d-M-y',strtotime($customers['Mstcomplaintcustomer']['dt_created_date']))?></td>

                                                 <td align="left">
<?php 
//echo  $customers['Mstcomplaintcustomer']['id'];
$rows= $this->Complaindetail->projectcheck($customers['Mstcomplaintcustomer']['vc_customer_code']);
//pr($rows);
if($rows>0){}else{
?>

<a href="<?php echo $this->webroot;?>empcomplaint/view_summary/D/<?php echo $customers['Mstcomplaintcustomer']['id'];?>"  title="Delete">Delete</a>
<?php
} 
?>
</td>
						
						
						
						
						
				</tr>
				<?php $i++; endforeach; ?>
				
                </table>
				
                    </table>
    </div>

</div>



 <html><head></head><body></body></html>