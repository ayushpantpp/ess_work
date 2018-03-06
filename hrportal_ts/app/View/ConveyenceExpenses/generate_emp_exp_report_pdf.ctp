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
        <b><span>Employee Expense Reports <br> Conveyance System</span></b>
        <br><br><br>
        </td>
    </tr>
</table>

<table border="1" width="100%" align="center" >
        <tr>
            <th class="uk-text-center">S.No.</th>
            <th class="uk-text-center">Voucher ID</th>
            <th class="uk-text-center">Employee Name</th>
            <th class="uk-text-center">Claim Date</th>
            <th>Mode</th>
            <th>Type</th>
            <th>From</th>
            <th>To</th>
            <th>Misc Amount</th>
            <th>Misc Description</th>
            <th>Distance</th>
            <th>Travel Expenses</th>
            <th class="uk-text-center">Employee Claimed</th>
            <th class="uk-text-center">Manager Approved</th>
            <th class="uk-text-center">Reimbursement</th>
        </tr>';
$i = 1;
$tot_amt = 0;
foreach ($VoucherDetails as $rec) {
    if($rec['ConveyencExpenseDetail']['payment_status'] == '1'){
        $paymentStatus = "Paid";
    }else{
        $paymentStatus = "Due"; 
    }
    $tot_amt += $rec['ConveyencExpenseDetail']['total_exp'];
    if($rec['ConveyencExpenseDetail']['wheeler_type'] == "1"){ $val =  "Personal"; }else{ $val = "Commercial"; } 
    $html .= '<tr>
            <td align="center">' . $i . ' </td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['voucher_id'] . '</td>
            <td >' . $this->Common->getempname($rec['ConveyencExpenseDetail']['emp_code']) . '</td>
            <td align="center">' . date("d/m/Y", strtotime($rec['ConveyencExpenseDetail']['claim_date'])) . '</td>
            <td align="center">' . $this->Common->getConveyenceTravelModeById($rec['ConveyencExpenseDetail']['travel_mode']) . '</td>
            <td align="center">' . $val . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['from_place'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['to_place'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['miscl_exp'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['miscl_exp_desc'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['distance'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['travel_exp'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['emp_exp'] . '</td>
            <td align="center">' . $rec['ConveyencExpenseDetail']['total_exp'] . '</td>
            <td align="center">' . $paymentStatus . '</td>
        </tr>';
    $i++;
}
$html .= '<tr><th colspan="13" style="text-align:right;">Total Amount</th><td>'.$tot_amt.'</td></tr>';
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