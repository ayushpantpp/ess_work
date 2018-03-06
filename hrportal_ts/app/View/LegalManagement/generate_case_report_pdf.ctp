<?php
foreach($CaseReceives as $CRs);
$caseStatus     =   end($CRs['CaseDetails']);
$caseStatusID   =   $caseStatus['case_status_id'];
$ServiceDate    =   date("d-m-Y", strtotime($CRs["CaseReceive"]["date_of_service"]));
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
            <td colspan="2">To : '.$CRs["CaseReceive"]["petitioners"].'</td>
            <td colspan="4">Service Date : '.$ServiceDate.'</td>
        </tr>
        <tr>
            <td colspan="6">From : '.$CRs["CaseReceive"]["respondents"].'</td>
        </tr>
        <tr>
            <td colspan="6">Court Case Number : '.$CRs["CaseReceive"]["court_case_number"].'</td>
        </tr>
        <tr>
            <td colspan="6" align="center"><b>Parties</b></td>
        </tr>
        <tr>
            <td colspan="6">Petitioners : '.$CRs["CaseReceive"]["petitioners"].'</td>
        </tr>
        <tr>
            <td colspan="6">Respondents : '.$CRs["CaseReceive"]["respondents"].'</td>
        </tr>
        <tr >
            <td colspan="6">FILE REFERENCE : '.$CRs["CaseReceive"]["court_case_number"].'</td>
        </tr>
        <tr>
            <td>Legal File</td>
            <td> NA </td>
            <td>Discipline File </td>
            <td> NA </td>
            <td>Attorney  General File</td>
            <td> NA </td>
        </tr>
        <tr>
            <td colspan="6">STATUS OF CASE : '.$this->common->findCaseStatus($caseStatusID).'</td>
        </tr>
        <tr>
            <td colspan="6">AG Office : </td>
        </tr>
        <tr>
            <td colspan="6">Industrial Court : </td>
        </tr>
        <tr>
            <td colspan="6">Status Done By : </td>
        </tr>
    </table>
</center>
</body>
</html>';
            //print_r($html);die;
// output the HTML content
$pdf->SetDisplayMode('fullpage');            
$pdf->writeHTML($html);

$pdf->Output();
    

?>