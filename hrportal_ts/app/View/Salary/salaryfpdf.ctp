<?php
    $fpdf->AddPage();/*
    $fpdf->SetTopMargin('0.35');
	$fpdf->SetLeftMargin('0.25');
	$fpdf->SetRightMargin('0.25');*/
	$fpdf->SetFont('Times','B',20);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->Cell(0,20,'',0,1,'L',1);

   $fpdf->Image('http://localhost/hrconnect/img/logo.jpg',12,14,50,0,'JPG');

	$fpdf->Cell(0,10,'Statement of Earnings - '.$user_detail['emp_firstname'].' '.$user_detail['emp_lastname'],0,1,'L');
   $fpdf->ln();
   	//$fpdf->Line(5,25, 200, 25);

   /*Personal information start*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(0,5,'Personal Information',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->Cell(0,5,'',0,1,'L',1);
   $fpdf->SetFillColor(119,169,207);

   	$fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Employee Number : ',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$user_detail['emp_id'],0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Position : ',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$designation,0,1,'L');

      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Assignment no  : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$user_detail['emp_id'],0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Grade : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'B1',0,1,'L');

      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Location  : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$location,0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Department : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$group,0,1,'L');

   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Organization  : ',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$company_name,0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'National identifier Payroll : ',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,'Care India monthly',0,1,'L');

   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Job: ',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$department,0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Salary Basis',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,'',0,1,'L');
   /*Personal information ends*/

   /*FUrther info start*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Further Person Information',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->Cell(0,5,'',0,1,'L',1);
   $fpdf->SetFillColor(119,169,207);
      $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Date of birth: ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$user_detail['dob'],0,1,'L');

      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Date of joining : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$user_detail['join_date'],0,1,'L');

      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'PAN  : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$user_detail['pan_no'],0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'PF No : ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,$user_detail['join_date'],0,1,'L');

      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Superannuation Number Status:',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'Resident and ordinarily resident in India',0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'ESI number :',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'',0,1,'L');
   /*Further info ends*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Payroll Processing Information',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'',0,0,'L',1);
   $fpdf->Cell(0,5,'',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);


      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Period: ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'2016 Calendar Month',0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Pay date',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'30-'.$p_date,0,1,'L');

      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Period start date: ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'1-'.$p_date,0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Period end date: ',0,1,'R');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','','');
      $fpdf->Cell(40,5,'30-'.$p_date,0,1,'L');

   /*Earnings start*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(0,5,'Earnings',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('Times','',8);
   $size = sizeof($earnings);
   if($size) {
      for ($i=0; $i < $size; $i++) {
         if(isset($earnings[$i])) {
            $fpdf->Cell(90,5,$earnings[$i]['OptionAttribute']['name'],0,0,'L');
            $fpdf->Cell(0,5,$earnings[$i]['SalaryProcessingAddition']['sal_amt'] ,0,1,'R');
            $tot_earning += $allowances[$i]['SalaryProcessingAddition']['sal_amt'];  
         }
      }
   }
   else {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total Earnings ',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$salary_details['tot_earn'] ,0,1,'R');

   /*Earning ends*/

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Advances',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   $fpdf->ln();
   $fpdf->SetFont('Times','B',10);
   $fpdf->Cell(0,5,'Fringe Benefits',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);   
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Termination payments',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   /*Deduction start*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Deductions',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $size = sizeof($deductions);
   $size_mon = sizeof($ded_monthly);
   $tot_deduction = 0;
   $fpdf->SetFont('Times','',8);
   if($size) {
      for ($i=0; $i < $size; $i++) {
         if(isset($deductions[$i])) {
            $fpdf->Cell(90,5,$deductions[$i]['HcmDed']['ded_desc'],0,0,'L');
            $fpdf->Cell(0,5,$deductions[$i]['SalaryProcessingDeduction']['ded_amt'] ,0,1,'R');
            $tot_deduction += $deductions[$i]['SalaryProcessingDeduction']['ded_amt']; 
         }
      }
   }
   if($size_mon) {
      for ($i=0; $i < $size_mon; $i++) {
         if(isset($ded_monthly[$i])) {
            $fpdf->Cell(90,5,$ded_monthly[$i]['OptionAttribute']['name'],0,0,'L');
            $fpdf->Cell(0,5,$ded_monthly[$i]['SalaryProcessingAddition']['sal_amt'] ,0,1,'R');
            $tot_deduction += $ded_monthly[$i]['SalaryProcessingAddition']['sal_amt']; 
         }
      }
   }
   if(!$size && !$size_mon) {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total Deduction ',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$salary_details['total_ded'] ,0,1,'R');
   /*Deduction ends*/

   /*Net pay start*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Net pay',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->Cell(0,5,'',0,1,'L',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Salary Net of Taxes ',0,0,'L');
   $fpdf->SetFont('','B','');
   //$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
   $fpdf->Cell(0,5,$salary_details['tot_sal_amt']/*.'    '.ucfirst($f->format($salary_details['tot_sal_amt']))*/ ,0,1,'R');


   /*Net pay end*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Taxable Perquisites',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Employer Charges',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   
   $size = sizeof($deductions);
   $size_mon = sizeof($ded_monthly);
   $tot_emp_contr = 0;
   $fpdf->SetFont('Times','',8);
   if($size) {
	   foreach($deductions as $val) {
		   if($val['HcmDed']['ded_desc'] == 'PF') {
			  
		   if($val['SalaryProcessingDeduction']['fpf_amt'] != null) {
			   $fpdf->Cell(90,5,'EPS contribution',0,0,'L');
				$fpdf->Cell(0,5,$val['SalaryProcessingDeduction']['fpf_amt'] ,0,1,'R');
				$tot_emp_contr += $val['SalaryProcessingDeduction']['fpf_amt']; 
		   }
		   if($val['SalaryProcessingDeduction']['epf_amt'] != null) {
			   $fpdf->Cell(90,5,'EPS contribution',0,0,'L');
				$fpdf->Cell(0,5,$val['SalaryProcessingDeduction']['epf_amt'] ,0,1,'R');
				$tot_emp_contr += $val['SalaryProcessingDeduction']['epf_amt']; 
		   } 
			   
		   }
	   }
   }
   if(!$size && !$size_mon) {
     $fpdf->Cell(0,5,'No data found' ,1,1,'C'); 
   }
   
   
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$tot_emp_contr,0,1,'R');

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Balances',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);


   $fpdf->Cell(90,5,'Salary(Section 17(1))',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['grss_income'] - $balances['perq_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Value of Perquisites(Section 17(2))',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['perq_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Profit in lieu of salary(Section 17(3))',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0',0,1,'R');
   $fpdf->Cell(90,5,'Gross salary(Section 17(1))',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['grss_income'] ,0,1,'R');
   $fpdf->Cell(90,5,'Allowances under Sec 10)',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['it_exam_amt'] + $balances['sal_allow_amt'] ,0,1,'R');
   $fpdf->Cell(90,5,'Deductions under section 16)',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['profsnl_tax_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Total chapter VI A deductions',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['it_invest_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Total income',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['taxable_income'],0,1,'R');
   $fpdf->Cell(90,5,'Tax on Total Income',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['gross_it_tax'],0,1,'R');
   $fpdf->Cell(90,5,'Total tax payable',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['gross_it_tax'] + $balances['oth_tax_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Income tax till date',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['paid_tax_amt'],0,1,'R');
   $fpdf->Cell(90,5,'Balance tax',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,$balances['ttl_tax'],0,1,'R');


   /*Payment details starts*/
   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Payment Details',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->Cell(0,5,'',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY());
   
   $fpdf->Cell(35,5,'Mode of payment ',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
   $fpdf->SetFont('','B','');
   $fpdf->Cell(35,5,'Disbursement Date' ,0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(35,5,'Employee Bank',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(35,5,'Account No.',0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+160,$fpdf->GetY()-5);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(35,5,'Amount',0,1,'L');
   $fpdf->Line($fpdf->GetX(),$fpdf->GetY(),200,$fpdf->GetY());


   $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY());
   $fpdf->SetFont('','','');
   $pay_mode = $this->Common->option_name($user_detail['emp_pay_mode']);
   $fpdf->Cell(35,5,$pay_mode[$user_detail['emp_pay_mode']],0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);
   $fpdf->Cell(35,5,$salary_details['proc_to_date'] ,0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   $b_code = $this->Common->option_name($user_detail['bank_code']);
   $fpdf->Cell(35,5,$b_code[$user_detail['bank_code']],0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
   $fpdf->Cell(35,5,$user_detail['account_no'],0,1,'L');
   $fpdf->SetXY($fpdf->GetX()+160,$fpdf->GetY()-5);
   $fpdf->Cell(35,5,$salary_details['tot_sal_amt'],0,1,'L');
   /*Payment details ends*/

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Other Element Information',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Other Balance Information',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(90,5,'Description',0,0,'L',1);
   $fpdf->Cell(0,5,'Amount',0,1,'R',1);
   $fpdf->SetFillColor(119,169,207);
   $fpdf->SetFont('','B','');
   $fpdf->Cell(90,5,'Total',0,1,'R');
   $fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);    
   $fpdf->SetFont('','','');
   $fpdf->Cell(0,5,'0.0',0,1,'R');

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Leave Information',0,1,'L',1);
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


   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Leave Taken',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(0,5,'No data found',0,0,'L',1);
   $fpdf->SetFillColor(119,169,207);

   $fpdf->SetFont('Times','B',10);
   $fpdf->ln();
   $fpdf->Cell(0,5,'Message to Employee',0,1,'L',1);
   $fpdf->SetFillColor(191,191,191);
   $fpdf->SetFont('Times','',8);
   $fpdf->Cell(0,5,'No data found',0,0,'L',1);
   $fpdf->SetFillColor(119,169,207);




   /*	$fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   	$fpdf->SetFont('','B','');
      $fpdf->Line($fpdf->GetX(),$fpdf->GetY(),200,$fpdf->GetY());

   	$fpdf->Cell(40,5,'Earnings ',0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Amount' ,0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Deductions',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+150,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Amount',0,1,'L');

   	//show earnings and deductions
   	$fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   	$fpdf->Line($fpdf->GetX(),$fpdf->GetY()-5,200,$fpdf->GetY()-5);
      
   	//show total
   	$fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Total Earnings ',0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$salary_details['tot_earn'] ,0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Total Departmenteductions',0,1,'R');
   	$fpdf->SetXY($fpdf->GetX()+150,$fpdf->GetY()-5);
   	$fpdf->SetFont('','','');
   	$fpdf->Cell(40,5,$salary_details['tot_ded'],0,1,'L');

      $fpdf->Line($fpdf->GetX(),$fpdf->GetY()-5,200,$fpdf->GetY()-5);

   	//show Net total
   	$fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+5);
	   $fpdf->Line($fpdf->GetX(),$fpdf->GetY()-5,200,$fpdf->GetY()-5);
   	$fpdf->SetFont('','B','');
   	$fpdf->Cell(40,5,'Salary Net of Taxes ',0,1,'L');
   	$fpdf->SetXY($fpdf->GetX()+50,$fpdf->GetY()-5);   	
   	$fpdf->SetFont('','B','');
      $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
   	$fpdf->Cell(40,5,$salary_details['tot_sal_amt'].'    '.ucfirst($f->format($salary_details['tot_sal_amt'])) ,0,1,'L');

      $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY()+10);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(40,5,'Payment details',0,1,'L');
         
      $fpdf->Line($fpdf->GetX(),$fpdf->GetY(),200,$fpdf->GetY());


      //show Bank details
      $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY());
      
      $fpdf->Cell(35,5,'Mode of payment ',0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);    
      $fpdf->SetFont('','B','');
      $fpdf->Cell(35,5,'Disbursement Date' ,0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(35,5,'Employee Bank',0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(35,5,'Account No.',0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+160,$fpdf->GetY()-5);
      $fpdf->SetFont('','B','');
      $fpdf->Cell(35,5,'Amount',0,1,'L');
      $fpdf->Line($fpdf->GetX(),$fpdf->GetY(),200,$fpdf->GetY());


      $fpdf->SetXY($fpdf->GetX(),$fpdf->GetY());
      $fpdf->SetFont('','','');
      $fpdf->Cell(35,5,$user_detail['emp_pay_mode'],0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+40,$fpdf->GetY()-5);
      $fpdf->Cell(35,5,$salary_details['proc_to_date'] ,0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+80,$fpdf->GetY()-5);
      $fpdf->Cell(35,5,$user_detail['bank_code'],0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+120,$fpdf->GetY()-5);
      $fpdf->Cell(35,5,$user_detail['account_no'],0,1,'L');
      $fpdf->SetXY($fpdf->GetX()+160,$fpdf->GetY()-5);
      $fpdf->Cell(35,5,$salary_details['tot_sal_amt'],0,1,'L');*/

   //$fpdf->Line($fpdf->GetX(),$fpdf->GetY()-5,200,$fpdf->GetY()-5);



    $fpdf->Output();

?>