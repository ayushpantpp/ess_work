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
                                    <th class="uk-text-center">Employee Name</th>
                                    <th class="uk-text-center">Leave Date</th>
                                    <th class="uk-text-center">Leave Type</th>
                                    <th class="uk-text-center">Leave Status</th>
        </tr>';
$i = 1;
foreach ($VoucherDetails as $rec) {
    
    $html .= '<tr>
            <td align="center">' . $i . ' </td>
            <td >' . $this->Common->getempname($rec["LeaveDetail"]["emp_code"]) . '</td>
                
            <td align="center">' . date("d/m/Y", strtotime($rec["LeaveDetail"]["leave_date"])) . '</td>
            <td align="center">' . $this->Common->findLeaveType($rec["LeaveDetail"]["leave_code"]). '</td>
            <td align="center">' . $this->Common->findSatus($rec["LeaveDetail"]["leave_status"]) . '</td>
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