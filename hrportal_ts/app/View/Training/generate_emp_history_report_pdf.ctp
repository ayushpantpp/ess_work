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
        <td>&nbsp;</td>
        <td colspan="2" align="right">
        <b><span>Employee Training History</span></b>
        <br>
        </td>
        <td align="right">
        <b><span>Date:-</span>' . date("d-m-Y") . '</b>
        <br>
        <b><span>Time:-</span>' . date("H:i:s") . '</b>
        </td>
    </tr>
</table>

<table border="1" width="100%" align="center">
        <tr>
            <th class="uk-text-center">Country</th>
            <th class="uk-text-center">Location</th>
            <th class="uk-text-center">Position</th>
            <th class="uk-text-center">Employee Name</th>
            <th class="uk-text-center">Employee No.</th>
            <th class="uk-text-center">Course Name</th>
            <th class="uk-text-center">Course Date</th>
            <th class="uk-text-center">Status</th>
            <th class="uk-text-center">Score</th>
        </tr>';
$i = 1;
foreach ($training['TrainingEmployee'] as $rec) {
    $details = $this->Common->getEmployeeMatrixDetail($rec, $training['TrainingCreation']['training_id']);
    $empdetl = $this->Common->getEmpDetails($rec['trainee_code']);
   
    if ($details['TrainingDtMatrix']['present'] == 1) {
        $passed = 'Passed';
    } else {
        $passed = 'Failed';
    }
    $html .= '<tr>
            <td align="left">' . trim($empdetl['MyProfile']['cur_country_id']) . '</td>
            <td align="left">' . ucfirst(strtolower($this->Common->findLocationNameByCode($rec['location'], $rec['trainee_comp_code']))) . '</td>
            <td align="left">' . $this->Common->findDesignationName($rec['desg_code'], $rec['trainee_comp_code']) . '</td>
            <td align="left">' . $this->Common->getempname($rec['trainee_code']) . '</td>
            <td align="left">' . $this->Common->getempid($rec['trainee_code']) . ' </td>
            <td align="left">' . $training['TrainingCourseCreation']['name'] . '</td>
            <td align="left">' . date("d/m/Y", strtotime($training['TrainingScheduleCreation']['sch_start_date'])) . '</td>
            <td align="left">' . $passed . '</td>
            <td align="left">' . $details['TrainingDtMatrix']['score'] . '</td>
        </tr>';
    $i++;
    unset($details, $passed);
}
$html .= '</table>
</center>
</body>
</html>';
// output the HTML content
$pdf->SetDisplayMode('fullpage');
$pdf->writeHTML($html);

$pdf->Output();
?>