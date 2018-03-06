<?php
 foreach($Meeting_Request_Refnum as $rec){
           $data .= '<tr>';
           $data .= '<td>'.$rec['BMMeetingRequest']['meeting_number'].'</td>';
           $data .= ' <td>'.$this->common->findDepNamebycode($rec['BMReceiveRequest']['dept_code']).'</td>';
           $data .= ' <td>'.$rec['BMReceiveRequest']['reference_num'].'</td>';
           $data .= ' <td>'.date("d/m/Y", strtotime($rec['BMReceiveRequest']['date_of_receive'])).'</td>';
           $data .= ' <td>'.date("d/m/Y", strtotime($rec['BMMeetingRequest']['meeting_date'])).'</td>';
           $data .= '</tr>';
           } 
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
        <b><span>BOARD MANAGEMENT SERVICES <br> PERFORMANCE REPORT <br></span></b>
        </td>
    </tr>
</table>

    <table border="1" width="70%" align="center" >
        <tr>
            <th>Meeting Number</th>
            <th>Department</th>
            <th>Request Reference Number</th>
            <th>Date of Request Received</th>
            <th>Date of Meeting</th>
        </tr>'.$data.'</table>
</center>
</body>
</html>';
            //print_r($html);die;
// output the HTML content
$pdf->SetDisplayMode('fullpage');            
$pdf->writeHTML($html);

$pdf->Output();
    

?>