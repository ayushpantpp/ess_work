<?php
 //foreach($Meeting_Request_Refnum as $rec){
           $data  = '<tr>';
           $data .= '<td>'.$TotalReq.'</td>';
           $data .= ' <td>'.$count_Final.'</td>';
           $data .= ' <td>'.$Pending.'</td>';
       //    } 
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
        <b><span>BOARD MANAGEMENT SERVICES <br> SUMMERY REPORT <br></span></b>
        </td>
    </tr>
</table>

    <table border="1" width="70%" align="center" >
        <tr>
            <th>Total Number of Request</th>
            <th>Number of Request Finalized</th>
            <th>Number of Pending Request</th>
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