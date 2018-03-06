<?php

foreach ($CaseDetails as $CRs);
$caseStatus = end($CRs['CaseDetails']);
$caseStatusID = $caseStatus['case_status_id'];
$ServiceDate = date("d-m-Y", strtotime($CRs["CaseReceive"]["date_of_service"]));
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
        <b><span>Public Service Commission <br> Legal Division <br> Court Status Report</span></b>
        </td>
    </tr>
</table>

<table border="1" width="70%" align="center" >
        <tr>
            <th>S.No.</th>
            <th>Case Number</th>
            <th>PSC file Number</th>
            <th>Ministry</th>
            <th>Request Category</th>
            <th>Action Officer</th>
            <th>Subject</th>
            <th>Date of Service</th>
        </tr>';
            $i = 1;
            foreach ($CaseReceives as $rec) {
        $html .= '<tr>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$i.' </span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['CaseReceive']['court_case_number'].'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['CaseReceive']['psc_file_number'].'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['Ministry']['ministry_name'] . " [" . $rec['Ministry']['ministry_code'] . "]".'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['MstRequest']['req_type_name'].'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['MyProfile']['emp_full_name'].'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.$rec['CaseReceive']['subject'].'</span></td>
            <td><span class="uk-text-small uk-text-muted uk-text-nowrap">'.date("d/m/Y", strtotime($rec['CaseReceive']['date_of_service'])).'</span></td>
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