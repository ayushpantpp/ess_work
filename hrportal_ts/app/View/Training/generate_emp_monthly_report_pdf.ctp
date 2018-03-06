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
        <b><span>Monthly Training Summary Report</span></b>
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
            <th class="uk-text-center">Course Name</th>
            <th class="uk-text-center">Schedule No</th>
            <th class="uk-text-center">Course Date</th>
            <th class="uk-text-center">Course Seats</th>
            <th class="uk-text-center">Nominees</th>
            <th class="uk-text-center">Absentees</th>
        </tr>';
$i = 1;
$absent=0;
foreach ($training as $key => $rec) {
    
    foreach ($rec['TrainingEmployee'] as $emptraining) {
        $details = $this->Common->getEmployeeMatrixDetail($emptraining, $rec['TrainingCreation']['training_id']);
        if ($details['TrainingDtMatrix']['no_show'] == 1){
            $absent+=1;
        }
    }
    $html .= '<tr>
            <td align="left">' . $rec['TrainingCourseCreation']['name'] . '</td>
            <td align="left">' . $rec['TrainingScheduleCreation']['schedule_id'] . '</td>
            <td align="left">' . date("d/m/Y", strtotime($rec['TrainingScheduleCreation']['sch_start_date'])) . '</td>
            <td align="left">' . $rec['TrainingCourseCreation']['max_class_capacity'] . ' </td>
            <td align="left">' . count($rec['TrainingEmployee']) . '</td>
            <td align="left">'.$absent.'</td>
        </tr>';
    $i++;
    unset($absent);
}
$html .= '</table>
</center>
</body>
</html>';
// output the HTML content
    //print_r($html);die;
$pdf->SetDisplayMode('fullpage');
$pdf->writeHTML($html);

$pdf->Output();
?>