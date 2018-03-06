<?php

$size = sizeof($earnings);
$arrsize = sizeof($arr);
$temp_ded_size = sizeof($temp_ded);
$ded = sizeof($deductions);
$netpay = $salary_details['tot_earn']  - $salary_details['total_ded'];
$pay_mode = $this->Common->option_name($user_detail['emp_pay_mode']);
//$b_code = $this->Common->option_name($user_detail['bank_code']);
$b_code = $this->Common->bank_name($user_detail['bank_code']);

 
$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body style="margin:0px; padding:0px;">
<center>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="background:#e7e6e6;">
            <td colspan="4" align="left" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000;"><img src="http://localhost\hrconnect\app\webroot\theme\images\carelogo3.jpg" width="" height="" alt="Logo" /></td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;  " ><strong>Employee Code :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 0px 8px 10px; border-bottom:solid 1px #000000;">'.$user_detail['emp_id'].'</td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px;border-left:solid 1px #000000;border-bottom:solid 1px #000000; border-right:solid 1px #000000; "><strong>Payslip Month :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$p_date.'</td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Employee Name :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-bottom:solid 1px #000000;">'.$user_detail['emp_full_name'].'</td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>PF Number :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$user_detail['pf_no'].'</td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Designation :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-bottom:solid 1px #000000;">'.$designation.'</td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>ESI Number :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$user_detail['ess_no'].' </td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Department :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-bottom:solid 1px #000000;">'.$department.' </td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Superannuation Number :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">&nbsp;</td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Grade. :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-bottom:solid 1px #000000;">B1 </td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>PAN :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$user_detail['pan_no'].'</td>
          </tr>
          <tr>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000; border-bottom:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Date of Joining :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-bottom:solid 1px #000000;border-bottom:solid 1px #000000;">'.$user_detail['join_date'].' </td>
            <td align="right" valign="top" bgcolor="#c0c0c0" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;border-bottom:solid 1px #000000; "><strong>Location :</strong></td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000; border-bottom:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$location.'</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td align="center" valign="top">&nbsp;</td>
    </tr>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="background:#e7e6e6;">
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000;">Earnings</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-bottom:solid 1px #000000; ">Amount (Rs.)</td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000;  border-bottom:solid 1px #000000; border-left:solid 1px #000000; border-right:solid 1px #000000;">Deductions</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">Amount (Rs.)</td>
          </tr>;'
          ?>
       
          <?php 
    for($i=0;$i<$size;$i++){
   if(isset($deductions[$i]['OA']['name'])){
   $ded = $deductions[$i]['OA']['name'];
            
    }else
    {
   $ded = $deductions[$i]['HcmDed']['ded_desc'];
    
    } 
        $html .='<tr>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-left:solid 1px #000000; border-right:solid 1px #000000; " >'.$earnings[$i]['ot']['name'].'</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 10px 8px 0px;">'.number_format((float)$earnings[$i]['SalaryProcessingAddition']['sal_amt'], 2, '.', '').'</td>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-left:solid 1px #000000; border-right:solid 1px #000000; ">'.$ded.'
           </td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">'?>;
        <?php
            if(($deductions[$i]['SalaryProcessingDeduction']['ded_amt'])){
              $allowance = $balances['it_exam_amt'] + $balances['sal_allow_amt']; 
              if($deductions[$i]['SalaryProcessingDeduction']['ded_amt']>0){
                $html.= number_format((float)$deductions[$i]['SalaryProcessingDeduction']['ded_amt'], 2, '.', '');     
              }
              else{
               $html.= number_format((float)0, 2, '.', '');         
              }
                        
            }
            
          
    $html.='</td>
        
        
       
  </tr>';
   }
   
  for($x=0;$x<$arrsize;$x++){ 
  
  $html.='<tr>
    <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">'.$arr[$x]['op']['name'].' ARREAR'.'</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 10px 8px 0px;">'.number_format((float)$arr[$x]['arr']['arr_amt'], 2, '.', '').'</td>';
  if($temp_ded[$x]['SalaryProcessingAddition']['sal_amt']){
   $html .= '<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-left:solid 1px #000000; border-right:solid 1px #000000; ">'.$temp_ded[$x]['OptionAttribute']['name'].'</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">'.number_format((float)$temp_ded[$x]['SalaryProcessingAddition']['sal_amt'], 2, '.', '').'</td>';
  }else{
   $html .= '<td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px;border-left:solid 1px #000000; border-right:solid 1px #000000; ">&nbsp;</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">&nbsp;</td>';    
   }
  
   
    } $html.='</tr>'; ?>
  <?php
    $html .= '<tr>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; font-weight:bold; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000; ">Total Earnings</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; font-weight:bold; border-top:solid 1px #000000;  border-bottom:solid 1px #000000;">'.number_format((float)$salary_details['tot_earn'], 2, '.', '').'</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; font-weight:bold; border-left:solid 1px #000000; border-right:solid 1px #000000; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; ">Total Deductions</td>
    <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; font-weight:bold; border-right:solid 1px #000000; border-top:solid 1px #000000;  border-bottom:solid 1px #000000; ">'.number_format((float)$salary_details['total_ded'], 2, '.', '').'</td>
  </tr>

        </table></td>
    </tr>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="background:#e7e6e6;">
            <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; ">Net Pay</td>
          </tr>
          <tr style="background:#e7e6e6;">
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000;">Gross Earnings</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000; ">Gross Deductions</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">Net Pay</td>
          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;  " >'.number_format((float)$salary_details['tot_earn'], 2, '.', '').'</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 10px 8px 0px;border-bottom:solid 1px #000000; border-right:solid 1px #000000;">'.number_format((float)$salary_details['total_ded'], 2, '.', '').'</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.number_format((float)$netpay, 2, '.', '').'</td>
          </tr>
        </table></td>
       </tr>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr >
            <td colspan="3" align="left" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; ">Payment Details</td>
          </tr>
          <tr style="background:#e7e6e6;">
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000; border-left:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000;">Payment Method</td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000; border-bottom:solid 1px #000000; border-right:solid 1px #000000; ">Bank</td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 0px 8px 10px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">Account Number</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-right:solid 1px #000000; ">Payment Amount</td>
          </tr>
          <tr>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-left:solid 1px #000000; border-right:solid 1px #000000;border-bottom:solid 1px #000000; " >'.$pay_mode[$user_detail['emp_pay_mode']].'</td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 0px 8px 10px;border-bottom:solid 1px #000000;border-right:solid 1px #000000;">'.$b_code.'</td>
            <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 0px 8px 10px; border-right:solid 1px #000000;border-bottom:solid 1px #000000; ">'.$user_detail['account_no'].'</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px;  color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">'.number_format((float)$netpay, 2, '.', '').'</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr style="background:#e7e6e6;">
            <td colspan="2" align="right" valign="top" bgcolor="#FFFFFF" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; ">YTD Summary</td>
          </tr>
          <tr style="background:#e7e6e6;">
            <td align="right" width="74%" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000;  border-bottom:solid 1px #000000; border-left:solid 1px #000000; border-right:solid 1px #000000;">Description</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; color:#333; padding:8px 10px 8px 0px; border-top:solid 1px #000000; border-right:solid 1px #000000; border-bottom:solid 1px #000000;">YTD</td>
          </tr>
          <tr>
          </td>
          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px;border-left:solid 1px #000000; border-right:solid 1px #000000; ">Salary Under Section 17 </td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?><?php
            if(($balances['grss_income'] || $balances['perq_amt'])){
              $section = $balances['grss_income'] - $balances['perq_amt'];
              $html.=  number_format((float)$section, 2, '.', ''); 
                        
            } $html.='</td>
          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Value of Perquisites </td>
            <td align="right" valign="top" bgcolor="#f2f2f2" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?><?php 
            if(($balances['perq_amt'])){
              $html.=  number_format((float)$balances['perq_amt'], 2, '.', '');
                        
            } $html.='</td>
          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Gross Salary</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php
            if(($balances['grss_income'])){
              $html.= number_format((float)$balances['grss_income'], 2, '.', '') ;
                        
            } $html.='</td>
           </tr>
           <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Allowances Exempted u/s 10 </td>
            <td align="right" valign="top" bgcolor="#F2F2F2" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php
            if(($balances['it_exam_amt'] || $balances['sal_allow_amt'])){
              $allowance = $balances['it_exam_amt'] + $balances['sal_allow_amt'];  
              $html.= number_format((float)$allowance, 2, '.', '') ; 
                        
            } $html.='</td>           

          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Deductions under Sec 16</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php 
             if(($balances['profsnl_tax_amt'])){
              $html.= number_format((float)$balances['profsnl_tax_amt'], 2, '.', '');
                        
            } $html.='</td>           

          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Total Chapter VI A Deductions</td>
            <td align="right" valign="top" bgcolor="#F2F2F2" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php 
             if(($balances['it_invest_amt'])){
              $html.=  number_format((float)$balances['it_invest_amt'], 2, '.', '');
                        
            } $html.='</td>           
          </tr>
          <tr>
           <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Total Income</td>
           <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
           <?php 
             if(($balances['taxable_income'])){
              $html.=  number_format((float)$balances['taxable_income'], 2, '.', '');
                        
            } $html.='</td>           
          </tr>
          <tr>
          <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Tax on Total Income</td>
          <td align="right" valign="top" bgcolor="#F2F2F2" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
          <?php 
             if(($balances['ttl_tax'])){
              $html.= number_format((float)$balances['ttl_tax'], 2, '.', '');
                        
            } $html.='</td>           
         </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Tax Paid Till Date</td>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php 
             if(($balances['paid_tax_amt'])){
              $html.= number_format((float)$balances['paid_tax_amt'], 2, '.', '');
                        
            } $html.='</td>           
          </tr>
          <tr>
            <td align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-left:solid 1px #000000; border-right:solid 1px #000000; ">Total Tax payable</td>
            <td align="right" valign="top" bgcolor="#F2F2F2" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; border-right:solid 1px #000000; ">';?>
            <?php 
             if(($balances['ttl_tax'] )){
              $html.= number_format((float)$balances['ttl_tax'] , 2, '.', '');
                        
            } $html.='</td>           

          </tr>
          <tr>
            <td colspan="2" align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:8px 10px 8px 0px; font-weight:bold;  border-top:solid 1px #000000;  ">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="right" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#333; padding:20px 10px 8px 0px; font-weight:bold;">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2" align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:center; font-style: italic; color:#333; padding:8px 10px 8px 0px; ">This payslip is computer generated no signature is required</td>
          </tr>
        </table></td>
    </tr>
      </td>
    
      </tr>
    
  </table>
</center>
</body>
</html>


';
     //print_r($html);die;
//output the HTML content;
 $pdf->SetDisplayMode('fullpage');            
$pdf->writeHTML($html);

$pdf->Output();
    

?>