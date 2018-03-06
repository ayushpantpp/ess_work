<?php
    $fpdf->AddPage();/*
    $fpdf->SetTopMargin('0.35');
	$fpdf->SetLeftMargin('0.25');
	$fpdf->SetRightMargin('0.25');*/
	$fpdf->SetFont('Times','B',14);
   $fpdf->Cell(40,30,'',1,0,'L');
      $fpdf->SetFillColor(255,255,255);

   $fpdf->Image('http://localhost/hrconnect/img/logo.jpg',12,20,38,0,'JPG');
   $fpdf->Cell(0,15,'CREDIT ANALYSIS AND RESEARCH LIMITED','LTR',2,'C');
   $fpdf->SetFont('Times','B',12);
   $fpdf->Cell(0,15,'SALARY SLIP FOR THE MONTH OF '.$monthYear,'LRB',1,'C');
   $fpdf->SetFont('Times','',10);

   $fpdf->Cell(40,5,'EMPLOYEE NO',1,0,'R');
   $fpdf->Cell(50,5,$user_detail['emp_code'],1,0,'L');
   $fpdf->Cell(40,5,'EMPLOYEE NAME',1,0,'R');
   $fpdf->Cell(0,5,$user_detail['emp_name'],1,1,'L');

   $fpdf->Cell(40,5,'DEPARTMENT',1,0,'R');
   $fpdf->Cell(50,5,$department,1,0,'L');
   $fpdf->Cell(40,5,'BANK A/C NO',1,0,'R');
   $fpdf->Cell(0,5,$user_detail['account_no'],1,1,'L');

   $fpdf->Cell(40,5,'DESIGNATION',1,0,'R');
   $fpdf->Cell(50,5,$designation,1,0,'L');
   $fpdf->Cell(40,5,'PAYABLE DAYS',1,0,'R');
   $fpdf->Cell(0,5,$salary_details['wrk_dys'],1,1,'L');

   $fpdf->Cell(40,5,'PAN NO',1,0,'R');
   $fpdf->Cell(50,5,$user_detail['pan_no'],1,0,'L');
   $fpdf->Cell(40,5,'PF ACCOUNT',1,0,'R');
   $fpdf->Cell(0,5,'NA',1,1,'L');

   $fpdf->Cell(40,5,'ESI NO',1,0,'R');
   $fpdf->Cell(50,5,'NA',1,0,'L');
   $fpdf->Cell(40,5,'UAN NO',1,0,'R');
   $fpdf->Cell(0,5,'NA',1,1,'L');


   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->SetFillColor(255,255,198);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'EARNINGS',1,0,'L',true);
   $fpdf->Cell(0,5,'AMOUNT',1,1,'R',true);
   $size = sizeof($earnings);
   $tot_earning = 0;
   $fpdf->SetFont('Times','',8);
   if($size) {
      for ($i=0; $i < $size; $i++) {
         if(isset($earnings[$i])) {
            $fpdf->Cell(90,5,$earnings[$i]['OptionAttribute']['name'],1,0,'L');
            $fpdf->Cell(0,5,$earnings[$i]['SalaryProcessingAddition']['sal_amt'] ,1,1,'R');
            $tot_earning += $allowances[$i]['SalaryProcessingAddition']['sal_amt'];  
         }
      }
   }
   else {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   $fpdf->SetFillColor(176,253,147);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'TOTAL EARNING AMOUNT (A)',1,0,'L',true);
   $fpdf->Cell(0,5,$tot_earning ,1,1,'R',true);

   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->SetFillColor(255,255,198);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'ALLOWANCES',1,0,'L',true);
   $fpdf->Cell(0,5,'AMOUNT',1,1,'R',true);
   $size = sizeof($allowances);
   $tot_allowances = 0;
   $fpdf->SetFont('Times','',8);
   if($size) {    
      for ($i=0; $i < $size; $i++) {
         if(isset($allowances[$i])) {
            $fpdf->Cell(90,5,$allowances[$i]['OptionAttribute']['name'],1,0,'L');
            $fpdf->Cell(0,5,$allowances[$i]['SalaryProcessingAddition']['sal_amt'] ,1,1,'R');
            $tot_allowances += $allowances[$i]['SalaryProcessingAddition']['sal_amt'];   
         }
      }  
   }
   else {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   $fpdf->SetFillColor(176,253,147);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'TOTAL ALLOWANCES (B)',1,0,'L',true);
   $fpdf->Cell(0,5,$tot_allowances ,1,1,'R',true);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->Cell(90,5,'TOTAL GROSS SALARY (A+B)',1,0,'L',true);
   $fpdf->Cell(0,5,$tot_earning+$tot_allowances ,1,1,'R',true);

   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->SetFillColor(255,255,198);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'Deductions',1,0,'L',true);
   $fpdf->Cell(0,5,'AMOUNT',1,1,'R',true);
   $size = sizeof($deductions);
   $tot_deduction = 0;
   $fpdf->SetFont('Times','',8);
   if($size) {
      for ($i=0; $i < $size; $i++) {
         if(isset($deductions[$i])) {
            $fpdf->Cell(90,5,$deductions[$i]['OptionAttribute']['name'],1,0,'L');
            $fpdf->Cell(0,5,$deductions[$i]['SalaryProcessingAddition']['sal_amt'] ,1,1,'R');
            $tot_deduction += $deductions[$i]['SalaryProcessingAddition']['sal_amt']; 
         }
      }
   }
   else {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   $fpdf->SetFillColor(176,253,147);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'TOTAL DEDUCTIONS (C)',1,0,'L',true);
   $fpdf->Cell(0,5,$tot_deduction ,1,1,'R',true);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->Cell(90,5,'TOTAL (A+B-C) BANK TRANSFER SALARY',1,0,'L',true);
   $fpdf->Cell(0,5,$tot_earning+$tot_allowances-$tot_deduction ,1,1,'R',true);

   /*Leave type*/
   $fpdf->Cell(0,1,'',1,1,'R');
   $fpdf->SetFillColor(255,255,198);
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(90,5,'Leave type',1,0,'L',true);
   $fpdf->Cell(0,5,'Leave balance',1,1,'R',true);
   $size = sizeof($leaves);
   $fpdf->SetFont('Times','',8);
   if($size) {
      for ($i=0; $i < $size; $i++) {
         if(isset($leaves[$i])) {
            $fpdf->Cell(90,5,$leaves[$i]['OptionAttribute']['name'],1,0,'L');
            $fpdf->Cell(0,5,$leaves[$i]['MstEmpLeaveAllot']['allot_leave'] ,1,1,'R');
         }
      }
   }
   else {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }


    $fpdf->Output();

?>