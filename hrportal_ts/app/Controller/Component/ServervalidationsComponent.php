<?php
////////////////////////////////////////////////////////////////////////////////////////////////
//
// Function    : validate_email
//
// Arguments   : email   email address to be checked
//
// Return      : true  - valid email address
//               false - invalid email address
//
// Description : function for validating email address that conforms to RFC 822 specs
//
// Sample Valid Addresses:
//
//    first.last@host.com
//    firstlast@host.to
//    "first last"@host.com
//    "first@last"@host.com
//    first-last@host.com
//    first.last@[123.123.123.123]
//
// Invalid Addresses:
//
//    first last@host.com
//
//
////////////////////////////////////////////////////////////////////////////////////////////////

class ServerValidationsComponent extends object {
function validate_email($email) {
	$valid_address = true;
	
	$mail_pat = '^(.+)@(.+)$';
	$valid_chars = "[^] \(\)<>@,;:\.\\\"\[]";
	$atom = "$valid_chars+";
	$quoted_user='(\"[^\"]*\")';
	$word = "($atom|$quoted_user)";
	$user_pat = "^$word(\.$word)*$";
	$ip_domain_pat='^\[([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\]$';
	$domain_pat = "^$atom(\.$atom)*$";
	
	if (eregi($mail_pat, $email, $components))
	{
	  $user = $components[1];
	  $domain = $components[2];
	  
	  // validate user
	  if (eregi($user_pat, $user))
	  {
		// validate domain
		if (eregi($ip_domain_pat, $domain, $ip_components)) {
		  // this is an IP address
		  for ($i=1;$i<=4;$i++) {
			if ($ip_components[$i] > 255) {
			  $valid_address = false;
			  break;
			}
		  }
		}
		else
		{
		  // Domain is a name, not an IP
		  if (eregi($domain_pat, $domain)) {
			/* domain name seems valid, but now make sure that it ends in a valid TLD or ccTLD
			   and that there's a hostname preceding the domain or country. */
			$domain_components = explode(".", $domain);
			// Make sure there's a host name preceding the domain.
			if (sizeof($domain_components) < 2) {
			  $valid_address = false;
			} else {
			  $top_level_domain = strtolower($domain_components[sizeof($domain_components)-1]);
			  // Allow all 2-letter TLDs (ccTLDs)
			  if (eregi('^[a-z][a-z]$', $top_level_domain) != 1) {
				$tld_pattern = '';
				// Get authorized TLDs from text file
				$tlds = file(DIR_WS_INCLUDES . 'tld.txt');
				while (list(,$line) = each($tlds)) {
				  // Get rid of comments
				  $words = explode('#', $line);
				  $tld = trim($words[0]);
				  // TLDs should be 3 letters or more
				  if (eregi('^[a-z]{3,}$', $tld) == 1) {
					$tld_pattern .= '^' . $tld . '$|';
				  }
				}
				// Remove last '|'
				$tld_pattern = substr($tld_pattern, 0, -1);
				if (eregi("$tld_pattern", $top_level_domain) == 0) {
					$valid_address = false;
				}
			  }
			}
		  }
		  else {
			$valid_address = false;
		  }
		}
	  }
	  else
	  {
		$valid_address = false;
	  }
	}
	else
	{
	  $valid_address = false;
	}
	
	if ($valid_address)
	{
	  if (!checkdnsrr($domain, "MX") && !checkdnsrr($domain, "A")) {
		$valid_address = false;
	  }
	}
	
	return $valid_address;
}
  
// More functions to be included for other type of validations



// ---------------------------------------------------
function getFormattedmsg($sVal)
{

	$strreplace=str_replace("_"," ",$sVal);
	$strreplace=ucfirst($strreplace);
	/*while(sVal.indexOf("_")!=-1)
	{
		sVal = sVal.replace("_", " ")
	}
	var b;
	b=sVal.charAt(0).toUpperCase();
	b=b+sVal.substring(1);*/
	return $strreplace;
	
}
// length of password
function check_Pwd($obj,$fld_name)
{
	
	$x=$obj;
	
	$b=strlen($x);

	if($b<6)
	{
		$msg="<br>- ".$fld_name ." Should Be Of Minimum 6 Characters ";
		return $msg;
		
	}

	if(!eregi("^[a-zA-Z0-9_]+",$x))
	{
	   $msg="<br>- Only Characters a-z,A-Z,0-9 and '_' are allowed for ".$fld_name;
		return $msg;
	}
	else
	{
		return false;
	}
}

//length of password

//email validation
function ValidateEMail($email)
{
	
  
  $expr = '/^(.+)@(([a-z0-9\.-]+)\.[a-z]{2,5})$/i';
		$uexpr = "/^[a-z0-9\~\!\#\$\%\&\(\)\-\_\+\=\[\]\;\:\'\"\,\.\/]+$/i";
		if (preg_match($expr, $email, $regs)) {
			$username = $regs[1];
			$host = $regs[2];
			//if (checkdnsrr($host, MX)) {
				if (preg_match($uexpr, $username)) {
					return true;
				} 
				else {
					return false;
				}
			//} 
			//else {
			//	return false;
			//}
		} 
		else {
			return false;
		}
	}
	
function ValidateDomain($email)
{
	//$host=strstr($email,'@');
	$host=explode('@', $email);
	if(checkdnsrr($host[1], 'MX'))
		return true;
	else
		return false; 
	
}
//email validation
//valid phone
function checkInternationalPhone($phone)
{
	if(!ereg('^\(*[0-9]{3}\)*[[:space:]][0-9]{3}-*[0-9]{4}$',$phone))
	{
		return false;
	}
}
function isURL($url){

if(!eregi("^(http|https)+(:\/\/)+[a-z0-9_-]+\.+[a-z0-9_-]", $url ))
{
	return false;
}
//print_r($m);

//if (!preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\//i', $url, $m)) { 
//return false;
    
//} 
}


//valid phone
///////valid image
function validimage($arr,$value)
{
	$len=count($arr);
	$len=len-2;
	
	$iPos = strrpos($value,".");
	echo "substr..".$sExt = substr($value,iPos);
	$sExt=strtolower($sExt);
	
		for($i=0;$i<=$len;$i++)
        {
			$arr[i]=strtolower($arr[i]);
			if($arr[i]=="img")
		   {
				if(($sExt=='.jpeg') || ($sExt=='.jpg') || ($sExt=='.gif') || ($sExt=='.bmp') || ($sExt=='.png'))
				{
					 $sExt_old=$sExt;
					 $sExt="img";
			 
				}
		   }
		   else if($arr[i]=="fla")
		   {
				if(($sExt=='.swf') || ($sExt=='.fla'));
				$sExt_old=$sExt;
				$sExt="fla";
							
		   }
		 switch($sExt)
        {
		   case ".doc":
		      if($arr[i]=='doc')
			   {
				   return true;
			   }
              
           case "img":
			    if(($sExt_old=='.jpeg') || ($sExt_old=='.jpg') || ($sExt_old=='.gif') || ($sExt_old=='.bmp') && ($arr[i] =='img'))
		        {
		         	
					return true;
		        }
		       
            case ".xls":
			   if($arr[i] =='xls')
			   {
		               return true;
			   }
               
          case ".ppt":
			   if($arr[i] =='ppt')
			   {
		               return true;
			   }
               
           case ".pdf":
			   if($arr[i] =='pdf')
			   {
		               return true;
			   }
               
          case "fla":
			   if((($sExt_old=='.fla') ||($sExt_old=='.swf'))&& ($arr[i] =='fla'))
			   {
		               return true;
			   }
               
          case ".txt":
		  
			   if($arr[i] =='txt')
			   {
		               return true;
			   }
			   
           default:
			    if(($sExt!=$arr[i]) && ($i==$len) )
			    {
		              //alert(sExt.toUpperCase()+" file type not allowed");
				       return false;
				        break;
		        }
				
				
		}//switch here
			
		}//for loop
	
	
}

///////valid image

  
function validate_data($param_arr)
{
    
   
	$sChangedName="";
	$req=1;
	$flag=1;
	
	$msg="<b>Following ERRORS occurred during submission!</b>";	
	
	$param_arr_len = count($param_arr);
        
	//for( $i = 0; $i< $post_arr_len; $i++)
	while(list($key, $value) = each($param_arr))
	{	 
		//echo $key."=".$value."<br>";
		$value = trim($value);

		$objDataTypeHolder = substr($key, 0, 3);
		
		if(substr($key, 0, 3)=='TR_')
				$objDataTypeHolder = substr($key, 0,3);
		 if(substr($key, 0, 4)=='TRC_')
				$objDataTypeHolder = substr($key, 0, 4);
		if(substr($key, 0, 3)=='TR_')
				$objDataTypeHolder = substr($key, 0, 3);
		else if(substr($key, 0, 5)=='TRCP_')
				$objDataTypeHolder = substr($key, 0, 5);
		else if(substr($key, 0, 4)=='TNC_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 4)=='TLN_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 5)=='TRFN_')
				$objDataTypeHolder = substr($key, 0, 5);
		else if(substr($key, 0, 5)=='TNFN_')
				$objDataTypeHolder = substr($key, 0, 5);
		else if(substr($key, 0, 6)=='TRURL_')
				$objDataTypeHolder = substr($key, 0, 6);
		else if(substr($key, 0, 6)=='TNURL_')
				$objDataTypeHolder = substr($key, 0, 6);
		else if(substr($key, 0, 4)=='ANR_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 4)=='ANN_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 7)=='TREFUN_')
				$objDataTypeHolder = substr($key, 0, 7);
		else if(substr($key, 0, 4)=='TRU_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 4)=='TRP_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 5)=='TRCP_')
				$objDataTypeHolder = substr($key, 0, 5);
		else if(substr($key, 0, 5)=='TROP_')
				$objDataTypeHolder = substr($key, 0, 5);
		else if(substr($key, 0, 4)=='PHN_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 4)=='PHR_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 4)=='IMG_')
				$objDataTypeHolder = substr($key, 0, 4);
		else if(substr($key, 0, 5)=='TREF_' || substr($key, 0, 5)=='TNEF_')
			$objDataTypeHolder = substr($key, 0, 5);
			
			
		if($objDataTypeHolder=="TRU_")
		{			
			$sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".<br>";
				$flag=0;
			}
			$uservalid=check_Pwd($value,$sChangedName);
			if($uservalid)
			{
			$msg.=$uservalid;
				$flag=0;
			}
			
		}
		
		if(($objDataTypeHolder=="TRP_") )
		{			
			$sChangedName = substr($key, 4);
			$passvalue=$value;
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".<br>";
				$flag=0;
				
			}
			else if(stristr($value," "))
			{
				$msg.="<br>- Spaces are not allowed in password.";
				$flag=0;
			}
			$uservalid=check_Pwd($value,$sChangedName);
			if($uservalid)
			{
			$msg.=$uservalid;
				$flag=0;
			}
			
						
	
		}
		if(($objDataTypeHolder=="TRCP_"))
		{
			$sChangedName = substr($key, 5);
			$conpassvalue=$value;
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".<br>";
				$flag=0;
				
			}
			else if($conpassvalue!=$passvalue)
			{
				$msg.="<br>- Password and confirm password fields are not matching";
				$flag=0;
			}
		
		}
		
		if(($objDataTypeHolder=="TROP_") )
		{			
			$sChangedName = substr($key, 5);
			$passvalue=$value;
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".<br>";
				$flag=0;
				
			}
			else if(stristr($value," "))
			{
				$msg.="<br>- Spaces are not allowed in password.";
				$flag=0;
			}
			$uservalid=check_Pwd($value,$sChangedName);
			if($uservalid)
			{
			$msg.=$uservalid;
			$flag=0;
			}
			
						
	
		}
		
		


		if(($objDataTypeHolder=="TR_" || $objDataTypeHolder=="TRC_" || $objDataTypeHolder=="TRFN_" || $objDataTypeHolder=="TL_")&& ($value==''))
		{	
			
			
			if($objDataTypeHolder=="TRC_")
				$sChangedName = substr($key, 4);
			else
				$sChangedName = substr($key, 3);

			if($objDataTypeHolder=="TRFN_")
				$sChangedName = substr($key, 5);
			else
				$sChangedName = substr($key, 3);
			

			 $sChangedName = getFormattedmsg($sChangedName);
			 
			$msg .= "<br>- Please enter ". $sChangedName .".";
			$flag=0;
		}
		
		if(($objDataTypeHolder=="TR_") && is_array($value))
		{
			$sChangedName = substr($key, 3);
			
			$sChangedName = getFormattedmsg($sChangedName);
			$msg .= "<br>- Please enter ". $sChangedName .".";
			$flag=0;
			
		}

		
		if($objDataTypeHolder=="TRC_" && $value!='')
		{
			$bb11= strlen($value);
			$x= $value;
			if(eregi("[0-9\'\"]",$x) || ($bb11 > 30))
			{
				$sChangedName = substr($key, 4);
				$sChangedName = getFormattedmsg($sChangedName);
				$msg.="<br>- Please enter correct ". $sChangedName .", numeric or ' or \" not allowed.";
				$flag=0;
			}
			
		}

		if($objDataTypeHolder=="TNC_" && $value!='')
		{
			$bb11= strlen($value);
			$x= $value;
			if(eregi("[0-9\'\"]",$x) || ($bb11 > 30))
			{
				$sChangedName = substr($key, 4);
				$sChangedName = getFormattedmsg($sChangedName);
				$msg.="<br>- Please enter correct ". $sChangedName .", numeric or ' or \" not allowed.";
				$flag=0;
			}
		}

		

		if($objDataTypeHolder=="TREF_" && $value=='')
		{
			$sChangedName = substr($key, 5);
			$sChangedName = getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter ". $sChangedName .".";
			$flag=0;

		}
		if(($objDataTypeHolder=="MR_" || $objDataTypeHolder=="IR_") && ($value==''))
		{
				$sChangedName = substr($key, 3);
			 	$sChangedName = getFormattedmsg($sChangedName);
			 
				$msg .= "<br>- Please enter ". $sChangedName .".";
				$flag=0;
		
		}

		else if(($objDataTypeHolder=="IR_" || $objDataTypeHolder=="MR_" )&& (!is_numeric($value)))
		{
			$sChangedName = substr($key, 3);
			$sChangedName = getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter numeric ". $sChangedName .".";
			$flag=0;
		}
		
		else if(($objDataTypeHolder=="IR_" || $objDataTypeHolder=="MR_" )&& ($value<=0))
		{
			$sChangedName = substr($key, 3);
			$sChangedName = $this->getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter valid ". $sChangedName .".";
			$flag=0;
		}

		if(($objDataTypeHolder=="IN_" || $objDataTypeHolder=="MN_" )&& (!is_numeric($value) && $value!='' ))
		{
			$sChangedName = substr($key, 3);
			$sChangedName = getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter numeric ". $sChangedName .".";
			$flag=0;
		}

		else if(($objDataTypeHolder=="IN_" || $objDataTypeHolder=="MN_" )&& ($value<=0 && $value!=''))
		{
			$sChangedName = substr($key, 3);
			$sChangedName = getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter valid ". $sChangedName .".";
			$flag=0;
		}

		if(($objDataTypeHolder=="IR_" || $objDataTypeHolder=="IN_" ) && (strstr($value,".")))
		{
			$sChangedName = substr($key, 3);
			$sChangedName = getFormattedmsg($sChangedName);
			$msg.="<br>- Please enter valid ". $sChangedName .".";
			$flag=0;
		}

		if((($objDataTypeHolder=="TREF_") || ($objDataTypeHolder=="TNEF_")) && $value!='' )
		{
			$validatemail=ValidateEMail($value);
			if(!$validatemail)
			{
				$sChangedName = substr($key, 5);
				$sChangedName = getFormattedmsg($sChangedName);
				//$msg.="Please enter valid ". $sChangedName .". (It should be an Email)");

				$msg.="<br>- Please enter valid email.";
				$flag=0;
			}
			if(!ValidateDomain($value))
			{
				$msg.="<br>- email domain does not exist.";
				$flag=0;
			}
		}
		/*
		//Checks for valid email if the field is username
		if(($objDataTypeHolder=="TREFUN_")  && $value!='' )
		{
			if(!ValidateEMail($value))
			{
				$sChangedName = $key.substring(7);
				$sChangedName = getFormattedmsg($sChangedName)
				alert("Please enter valid "+ $sChangedName +". (It should be an Email)");

//					alert("Please enter valid email.");
				$post_arr.focus();
				$post_arr.select();
				return false;
				break;
			}
		}
		//ValidateNumber(objName)
		if(($objDataTypeHolder=="MR_") || ($objDataTypeHolder=="MN_" && $value!='' ))
		{
			if(!ValidatePrice($value))
			{
				$sChangedName = substr($key, 3);
				$sChangedName = getFormattedmsg($sChangedName)
				alert("Please enter valid "+ $sChangedName +".");
				//alert("Please enter valid email.");
				$post_arr.focus();
				$post_arr.select();
				return false;
				break;
			}
		}

		if(($objDataTypeHolder=="NR_"))
		{
			if(!ValidateNumber($value))
			{
				$post_arr.focus();
				return false;
				break;
			}
		}*/	
		if($objDataTypeHolder=="PHR")
		{
		    $sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".";
				$flag=0;
				
				
			}
			if(!ereg('^\(*[0-9]{3}\)*[[:space:]][0-9]{3}-*[0-9]{4}$',$value))
			{
				$msg.="<br>- Please enter valid ". $sChangedName ."( like (XXX) XXX-XXXX  or XXX XXX-XXXX ).";
				$flag=0;
				
			}
			
			
		
		}
/*
		//ValidateNumber(objName)
		if(($objDataTypeHolder=="NR_"))
		{
			if(!ValidateNumber($value))
			{
				$post_arr.focus();
				return false;
				break;
			}
			if(parseFloat($value)<=0)
			{
				$post_arr.focus();	
				alert('Price should be greater then 0');
				return false;
			}
		}
		*/
		if($objDataTypeHolder=="PHN_")
		{
			$sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName);
			
			if($value!="")
			{
				if(!ereg('^\(*[0-9]{3}\)*[[:space:]][0-9]{3}-*[0-9]{4}$',$value))
				{
					$msg.="<br>- Please enter valid ". $sChangedName ."( like (XXX) XXX-XXXX  or XXX XXX-XXXX ).";
					$flag=0;					
				}
			}
			
			return true;				
		}
		/*
		if(($objDataTypeHolder=="IMG_") )
		{
			echo $sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName);
			$extnname=explode("-".$sChangedName);
			if($value!="")
			{
				$valid=validimage($extnname,$value);
				if(!$valid)
				{
				   $msg.="<br>- Please enter valid ".$sChangedName .".";
				   $flag=0;
				}

//					alert("Link cannot be left blank");
				
			}
			//alert(isURL($value));
						
			
		}
		*/
		if(($objDataTypeHolder=="TRURL_") )
		{
			$sChangedName = substr($key, 6);
			$sChangedName = getFormattedmsg($sChangedName);
			if($value=="")
			{
				$msg.="<br>- Please enter ". $sChangedName .".";
				$flag=0;
			}
			else if(!eregi("^(http|https)?(:\/\/)?[a-z0-9_-]+\.+[a-z0-9_-]", $value))
			{
				$msg.="<br>- Please enter valid ". $sChangedName .".";
				$flag=0;
			}
			//alert(isURL($value));
			
			
		}

		if(($objDataTypeHolder=="TNURL_") )
		{
			$sChangedName = substr($key, 6);
			$sChangedName = getFormattedmsg($sChangedName);
			if($value!="")
			{
				if(!eregi("^(http|https)?(:\/\/)?[a-z0-9_-]+\.+[a-z0-9_-]", $value))
				{
					$msg.="<br>- Please enter valid ". $sChangedName .".";
					$flag=0;
				}
			}
		}


		/*if(($objDataTypeHolder=="TRFN_"))
		{
			$sChangedName = substr($key, 5);
			$sChangedName = getFormattedmsg($sChangedName)
			if(!onlyString($value))
			{
				alert("Please enter valid "+ $sChangedName +".");
				$post_arr.focus();
				$post_arr.select();
				return false;
				break;
			}	
		}

		if(($objDataTypeHolder=="TNFN_") )
		{
			$sChangedName = substr($key, 5);
			$sChangedName = getFormattedmsg($sChangedName)
			if($value!="")
			{
				if(!onlyString($value))
				{
					alert("Please enter valid "+ $sChangedName +".");
					$post_arr.focus();
					$post_arr.select();
					return false;
					break;
				}
			}
		}
		
		//subhash 
		//(To check Alpha nemeric and spaces only)
		if(($objDataTypeHolder=="ANR_"))
		{
			$sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName)
			if(!AlphaNumeric($value))
			{
				alert("Please enter Valid "+ $sChangedName +".");
				$post_arr.focus();
				$post_arr.select();
				return false;
				break;
			}	
		}

		if(($objDataTypeHolder=="ANN_") )
		{
			$sChangedName = substr($key, 4);
			$sChangedName = getFormattedmsg($sChangedName)
			if($value!="")
			{
				if(!AlphaNumeric($value))
				{
					alert("Please enter Valid "+ $sChangedName +".");
					$post_arr.focus();
					$post_arr.select();
					return false;
					break;
				}
			}
		}
		//(To check Alpha nemeric and spaces only)
		//subhash 
		
		
		//validate fax number
		if($objDataTypeHolder=="FXR_")
		{
			var val=$value;
			if (val!="")
			{
				for(var j=0; j < val.length;j++)
				{
					//Fax start with + sign
					if(val.charAt(0)!='+' && iAllowPlus==1)
					{
						$sChangedName = substr($key, 4);
						$sChangedName = getFormattedmsg($sChangedName)
						alert("Please enter valid "+ $sChangedName +". Example '+1234567'");
						$post_arr.focus();
						$post_arr.select();
						return false;
						break;
					}

					if((val.charAt(0)!='+')&&(val.charAt(j)!='(')&&(val.charAt(j)!=')')&&(val.charAt(j)!="-")&&(val.charAt(j)!=" ")&& !((val.charAt(j)>=0)&&(val.charAt(j)<=9)))
					{
						if(j==0 && iAllowPlus==1) 
						{
							//Nothing to do
						}
						else
						{
							$sChangedName = substr($key, 4);
							$sChangedName = getFormattedmsg($sChangedName)
							//alert("Please enter valid "+ $sChangedName +".");
//								alert("Enter your "+ $sChangedName +" with no special chars other than ( ) - +");
							alert("Please enter numeric "+ $sChangedName +" with no special chars other than ( ) - ");

//							alert("Please enter valid Fax Number");
							$post_arr.focus();
							$post_arr.select();
							return false;
							break;
						}
					}
					if((val.charAt(j)==' ') && iAllowSpace==0)
					{
						$sChangedName = substr($key, 4);
						$sChangedName = getFormattedmsg($sChangedName)
						alert("Enter your "+ $sChangedName +" with no spaces");

//							alert("Please enter valid Fax Number");
						$post_arr.focus();
						$post_arr.select();
						return false;
						break;
					}
				}
			}
			else
			{
				$sChangedName = substr($key, 4);
				$sChangedName = getFormattedmsg($sChangedName)
				alert("Please Enter "+ $sChangedName +".");

//					alert("Please Enter Fax Number");
				$post_arr.focus();
				$post_arr.select();
				return false;
				break;
			}
		}*/
		//end of fax number
/////////////////////////////////////////////////////////////////////////////
	}
	if($flag==0)
	{		
		return $msg;		
	}
	else
	{
		return true;
	}
}
}