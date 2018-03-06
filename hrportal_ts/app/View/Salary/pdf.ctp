<?php
    $fpdf->AddPage();
    $fpdf->SetTopMargin('0.35');
	$fpdf->SetLeftMargin('0.25');
	$fpdf->SetRightMargin('0.25');
	$fpdf->SetFont('Times','',11);
	
    $fpdf->Line(10, 15, 205, 15);
	//Get cursor position and reset position
   	$x = $fpdf->GetX();
	$y = $fpdf->GetY();
	$fpdf->SetXY($x,$y+5);
   	//Print Restaurant Name and Order Number
   	$fpdf->Cell(100,10,$restaurantname,0,0,'L',false);
   	$fpdf->Cell(10,10,'Order #: '.$ordernumber,0,1,'L',false); 		
    $fpdf->Output();

?>