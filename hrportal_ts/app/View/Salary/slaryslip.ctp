<?php

$size = sizeof($earnings);
$ded = sizeof($deductions);
$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body style="margin:0px; padding:0px;">
<center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="background:#e7e6e6;">
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333; padding:10px 0px 10px 10px; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000;">Earnings</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333; padding:10px 10px 10px 10px; border-top:solid 1px #000000; border-bottom:solid 1px #000000; ">Amount (Rs.)</td>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333; padding:10px 0px 10px 10px; border-top:solid 1px #000000;  border-bottom:solid 1px #000000; border-left:solid 1px #000000; border-right:solid 1px #000000;">Deductions</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; color:#333; padding:10px 10px 10px 10px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">Amount (Rs.)</td>
  </tr>'; 
?>
<?php 
    for($i=0;$i<=$size;$i++){
        $html.='<tr>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 0px 10px 10px; border-left:solid 1px #000000; border-right:solid 1px #000000; " >'.$earnings[$i]['OptionAttribute']['name'].'</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;  color:#333; padding:10px 10px 10px 0px;">'.$earnings[$i]['SalaryProcessingAddition']['sal_amt'].'</td>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 0px 10px 10px;border-left:solid 1px #000000; border-right:solid 1px #000000; ">'.$deductions[$i]['HcmDed']['ded_desc'].'
           </td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 10px 10px 0px; border-right:solid 1px #000000; ">'.$deductions[$i]['SalaryProcessingDeduction']['ded_amt'].' </td>
  </tr>';
   }
  $html.='<tr>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 10px 10px 0px; font-weight:bold; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000; ">Total Earnings</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 10px 10px 0px; font-weight:bold; border-top:solid 1px #000000;  border-bottom:solid 1px #000000;">137532.00</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 10px 10px 0px; font-weight:bold; border-left:solid 1px #000000; border-right:solid 1px #000000; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; ">Total Desuctions</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#333; padding:10px 10px 10px 0px; font-weight:bold; border-right:solid 1px #000000; border-top:solid 1px #000000;  border-bottom:solid 1px #000000; ">14136.00</td>
  </tr>
</table>
</center>
</body>
</html>

';

// output the HTML content
$pdf->writeHTML($html, 2);

$pdf->Output();
    

?>