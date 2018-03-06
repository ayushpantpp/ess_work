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
            <th class="uk-text-center">Country</th>
            <th class="uk-text-center">Location</th>
            <th class="uk-text-center">Course Name</th>
            <th class="uk-text-center">Emp. No.</th>
            <th class="uk-text-center">Employee Name</th>
            <th class="uk-text-center">Position</th>
            <th class="uk-text-center">Instiute</th>
            <th class="uk-text-center">Certificate</th>
            <th class="uk-text-center">Score</th>
            <th class="uk-text-center">Expiry Date</th>
        </tr>';
$i = 1;
$absent = 0;
foreach ($training as $key => $rec) {
    foreach ($rec['TrainingEmployee'] as $emptraining) {
        $details = $this->Common->getEmployeeMatrixDetail($emptraining, $rec['TrainingCreation']['training_id']);
        $empdetl = $this->Common->getEmpDetails($emptraining['trainee_code']);
        if ($details['TrainingDtMatrix']['iwcf_date'] == '0000-00-00') {
            $iwcf_date = "";
        } elseif (!empty($details['TrainingDtMatrix']['iwcf_date'])) {
            $iwcf_date = date('d-m-Y', strtotime($details['TrainingDtMatrix']['iwcf_date']));
        } else {
            $iwcf_date = "";
        }

        $html .= '<tr>
            <td align="left">' . trim($empdetl['MyProfile']['cur_country_id']) . '</td>
            <td align="left">' . ucfirst(strtolower($this->Common->findLocationNameByCode($emptraining['location'], $emptraining['trainee_comp_code']))) . '</td>
            <td align="left">' . $rec['TrainingCourseCreation']['name'] . '</td>
            <td align="left">' . $this->Common->getempid($emptraining['trainee_code']) . '</td>
            <td align="left">' . $this->Common->getempname($emptraining['trainee_code']) . ' </td>
            <td align="left">' . $this->Common->findDesignationName($emptraining['desg_code'], $emptraining['trainee_comp_code']) . '</td>
            <td align="left">' . $rec['TrainingCourseCreation']['institute_name'] . '</td>
            <td align="left">' . trim($details['TrainingDtMatrix']['certificate']) . '</td>
            <td align="left">' . trim($details['TrainingDtMatrix']['score']) . '</td>
            <td align="left">' . trim($iwcf_date) . '</td>
        </tr>';
        $i++;
    }
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