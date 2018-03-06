



<?php
            
             
		class csv
		{					 
		
		
		
		
		
  
   public  function   mydata( $code ,$firstname,$lastname) 
							 
	{
	
	         $Link = mysql_connect('localhost','root','');
             
             if ($Link)
			  {
             
              mysql_select_db('csvtest', $Link);
              }
				
				
						
		echo"<b>Data Inserted in Database</b><br>";
        
         echo"<table  border='1' width='100'>
  			<tr>
    			<th width='200'>code  </th>
				<th width='200'>firstname  </th> 
				<th width='200'>lastname  </th> 
 			</tr>
	  
  			<tr>
    
				<td width='200'>$code</td>
				<td width='200'>$firstname  </td>
				<td width='200'>$lastname </td> 
			</tr></table>";
						 
						 
						 
						 
 
 
  $query="insert into testdata  (code, firstname, lastname) value ( '". $code."','".$firstname."','".$lastname."')";
 mysql_query($query);
						 
						 }
                           
                            
       
  
  public function datamining()
  {
	 
  
  if ($_FILES['file']['tmp_name']  )
	 {
			 
		   
		   $dom = DOMDocument::load( $_FILES['file']['tmp_name'] );
		   
		  $rows = $dom->getElementsByTagName('Row');  
		  $first_row = true;
		 foreach ($rows as $row )
		  {
			 
		  if (!$first_row )
		  {     
					 $code  =""; 
					 $firstname  ="";
					 $lastname  ="";
					 
				 
		
		  
		  $index = 1;
		 
		 
		  
		  $cells = $row->getElementsByTagName( 'Cell' );
		  
		  foreach( $cells as $cell )
		  { 
			 $ind = $cell->getAttribute('Index' );
		  if ( $ind != null ) $index = $ind;
		   
		 if ( $index == 1 ) { $code  =  trim($cell->nodeValue   ); }  
		 if ( $index == 2 ) { $firstname  =  trim($cell->nodeValue   ); } 
		 if ( $index == 3 ) { $lastname  =  trim($cell->nodeValue   ); } 
		
		 
		 
		  
		  $index += 1;
		 
		 
		  }
		  
		   
		  
		  
		$this->mydata($code , $firstname  ,$lastname);		
		 
			
		  }
		  $first_row = false;
	 }
	}
	}
}	

$csvdata = new csv;

$csvdata->datamining();

  ?>
 