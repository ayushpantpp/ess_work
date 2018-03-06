<?php

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body style="margin:0px; padding:0px;">
<center>
<table border="0" width="100%">
    <tr>
        <td colspan="2" align="center">
        <b><span>Employee Medical Reports <br> Medical System</span></b>
        <br><br><br>
        </td>
    </tr>
</table>

<table border="1" width="100%" align="center" >
        <tr>
            <th class="uk-text-center">S.No.</th>
            <th class="uk-text-center">Employee Name</th>
            <th class="uk-text-center">Start Date</th>
            <th class="uk-text-center">End Date</th>
        </tr>';
$i = 1;
foreach ($VoucherDetails as $rec) {
    if($rec['LtaBillAmount']['status'] == '1'){
        $paymentStatus = "Paid";
    }else{
        $paymentStatus = "Due"; 
    }
    $html .= '<tr>
            <td align="center">' . $i . ' </td>
            <td >' . $this->Common->getempname($rec['LtaBillAmount']['emp_code']) . '</td>
            <td align="center">' . date("d/m/Y", strtotime($rec['LtaBillAmount']['jour_start_date'])) . '</td>
            <td align="center">' . date("d/m/Y", strtotime($rec['LtaBillAmount']['jour_end_date'])) . '</td>
        </tr>';
    $i++;
}
$html .= '</table>
</center>
</body>
</html>';
//    print_r($html);die;
// output the HTML content
$pdf->SetDisplayMode('fullpage');
$pdf->writeHTML($html);

$pdf->Output();
?>