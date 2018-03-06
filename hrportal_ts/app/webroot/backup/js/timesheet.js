//Validation for timesheet 10-7-2011

var sInvalidChars;
sInvalidChars="1234567890";
var iTotalChecked=0;

/*********Added by Manish*************************************/
// non-digit characters which are allowed in phone numbers
var phoneNumberDelimiters = "()- ";

// characters which are allowed in international phone numbers
// (a leading + is OK)
var validWorldPhoneChars = phoneNumberDelimiters + "+";

// Minimum no of digits in an international phone no.
var minDigitsInIPhoneNumber = 10;
/************************************************************/

//variables added to allow spaces and plus sign validation for phone and faxes
var iAllowPlus  = 0;
var iAllowSpace = 0;

function checkNumericVals(objV,  msg)
{
	for(var i=0;i<sInvalidChars.length;i++)
	{
		if(objV.value.indexOf(sInvalidChars.charAt(i))!=-1)
		{
			alert(msg);
			objV.focus();
			return false;
		}
	}
	return true;
}

function objChecked(obj)
{
	if(obj.checked)
		iTotalChecked = iTotalChecked + 1
	else
		iTotalChecked = iTotalChecked - 1
}

function fn_ValidateZipPhone(obj, iLen, sMsg)
{
	if(obj.value.length<iLen)
	{
		alert(sMsg);
		obj.select();
		obj.focus();
		return false;
	}
	return true;
}

//Purpose	: This function is used to check that Password contains minimum characters and confirm Password matches the password. 
//Arguments : password field name , confirm password field name, minimum characters to check.

function CheckConfirmPassword(fldPass,fldConPass,minChars)
{
		alert("confirm="+fldPass);
		alert("confirm="+fldConPass);
		return false;
		//minChars=5;
		/*if(fldPass.value.length == 0)
		{
			alert("Please enter your password");
			fldPass.focus();
			fldPass.select();
			return false;
		}*/
		h = fldPass.value.length;
		x = fldPass.value.value;

		/*for( i=0;i<h;i++)
		{
		 
			if (  h < minChars )
			{
							alert(" Password can't be less than " + minChars + " characters");
							fldPass.focus();
							fldPass.select();
							return false;
			}


		}*/
		//=============================

		if(fldConPass.length == 0)
		{
			alert("Please re-enter your password");
			fldConPass.focus();
			fldConPass.select();
			return false;
		}
	

		if(fldPass.value != fldConPass.value)
		{
			alert("Please ensure that you have entered the same password twice");
			fldConPass.focus();
			fldConPass.select();
			return false;
		}
	return true;

}

//Purpose	: This function is used to check that username does not contain any spaces. 
//Arguments : field name object, field alias to be used, character to be checked
function CheckCharWithinField(fldName, fldAlias, chkChar)
{
		b= fldName.value.length
		x= fldName.value
		
		if (x == "")
		{
			alert ("Please Enter Your " + fldAlias)
			fldName.focus();
			fldName.select();
			return false;
		}

		for( i=0;i<b;i++)
		{
			z = x.substring(i,i+1);
			if(z== chkChar)
			{
				alert("Please enter valid " + fldAlias + " without any '" + chkChar + "' in-between");
				fldName.focus();
				fldName.select();
				return false;
			}
		}
		//------------------------------

return true;
}

//Purpose	: This function is used to check all the checkboxes basedon state of chk checkbox. 
//Arguments : checkbox object
function CheckAll(chk)
{

	for (var i=0;i < document.forms[0].elements.length;i++)
	{
		var e = document.forms[0].elements[i];
		if (e.type == "checkbox")
		{
			e.checked = chk.checked;
		}
	}
}

function CheckAllbyForm(frmObj,chk)
{

	for (var i=0;i < frmObj.elements.length;i++)
	{
		var e = frmObj.elements[i];
		if (e.type == "checkbox")
		{
			e.checked = chk.checked;
		}
	}
}

function fnRemoveSpaces(sFldval)
{
	var sTemp=sFldval;
  var sNewval=sTemp;
  //remove spaces from the front
  for(var i=0;i<sTemp.length;i++)
  {	
		if(sTemp.charAt(i)!=" ")
			break;
		else
			sNewval = sTemp.substring(i+1);
	}
	return sNewval;
}

//Purpose	: This function is used to remove spaces. 
//Arguments : text field object value
function fnFixSpace(sFldval)
{
	
	var sTemp=sFldval;
	  var sReversedString="";
	  var sTemp1;
	  
	  //remove spaces from the front
	  sNewval = fnRemoveSpaces(sTemp);
	  
	  // reverse n remove spaces from the front
	  for(var i=sNewval.length-1;i>=0;i--)
		sReversedString = sReversedString + sNewval.charAt(i);
	sTemp1 = fnRemoveSpaces(sReversedString);
	//reverse again
	sReversedString="";
	for(var i=sTemp1.length-1;i>=0;i--)
		sReversedString = sReversedString + sTemp1.charAt(i);
	sNewval = sReversedString;
	return sNewval;
}

//Purpose	: This function is used to validate email. 
//Arguments : Email object
function ValidateEMail(objName)
{
	var sobjValue;
	var iobjLength;
	
	sobjValue=objName;
	iobjLength=sobjValue.length;
	iFposition=sobjValue.indexOf("@");
	iSposition=sobjValue.indexOf(".");
	iTmp=sobjValue.lastIndexOf(".");	
	iPosition=sobjValue.indexOf(",");
	iPos=sobjValue.indexOf(";");
	
	if (iobjLength!=0)
	{
		if ((iFposition == -1)||(iSposition == -1))
		{
			return false;
		}
		else if(sobjValue.charAt(0) == "@" || sobjValue.charAt(0)==".")
		{
			return false;				
		}
		else if(sobjValue.charAt(iobjLength) == "@" ||
			sobjValue.charAt(iobjLength)==".")
		{
			return false;				
		}	
		else if((sobjValue.indexOf("@",(iFposition+1)))!=-1)
		{	
			return false;
		}
		else if ((iobjLength-(iTmp+1)<2)||(iobjLength-(iTmp+1)>3))
		{
			return false;
		}
		else if ((iPosition!=-1) || (iPos!=-1))
		{
			return false;
		}
		else
		{
			return true;
		}		
	}		
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

/*--------------------------------------------------------------------------------------
	this sub routine checks for the mandatory fields, their data types and maximum length
	also validates valid email entered or not
	Return : True/False
	Input : objFrm ( form object name)
	Version : 1.0.0
**** new validateForm that check numerics in first name, last name etc  ---TRC,TLN  ,,      PHR, PHN -  phone numbers along with hyper and spaces , 
----------------------------------------------------------------------------------------*/
function ValidateForm(objFrm)
{
        var iConventionPos;
	var sChangedName;
	var req=1;

	for( var i =0; i< objFrm.elements.length;i++)
	{		
		if(objFrm.elements[i].disabled == false)
		{		
			if(objFrm[i].type=='text' || objFrm[i].type=='textarea' || objFrm[i].type=='select-one' || objFrm[i].type=='select-multiple' || objFrm[i].type=='password' || objFrm[i].type=='file')
			{
				if(objFrm[i].type=='text' || objFrm[i].type=='textarea' || objFrm[i].type=='password')
					objFrm[i].value = fnFixSpace(objFrm[i].value);
				
				var objDataTypeHolder = objFrm[i].name.substring(0,3);
				if(objFrm[i].name.substring(0,4)=='TRC_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,3)=='TR_')
						objDataTypeHolder = objFrm[i].name.substring(0,3);
				if(objFrm[i].name.substring(0,4)=='TNC_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,4)=='TLN_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,5)=='TRFN_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,5)=='TNFN_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,6)=='TRURL_')
						objDataTypeHolder = objFrm[i].name.substring(0,6);
				if(objFrm[i].name.substring(0,6)=='TNURL_')
						objDataTypeHolder = objFrm[i].name.substring(0,6);
				if(objFrm[i].name.substring(0,4)=='ANR_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,4)=='ANN_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,7)=='TREFUN_')
						objDataTypeHolder = objFrm[i].name.substring(0,7);
				if(objFrm[i].name.substring(0,4)=='TRU_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,4)=='TRP_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,5)=='TRCP_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,5)=='TROP_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,4)=='TNP_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,5)=='TNCP_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);		
				if(objFrm[i].name.substring(0,4)=='PHN_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,4)=='PHR_')
						objDataTypeHolder = objFrm[i].name.substring(0,4);
				if(objFrm[i].name.substring(0,5)=='IMGR_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,5)=='IMGN_')
						objDataTypeHolder = objFrm[i].name.substring(0,5);
				if(objFrm[i].name.substring(0,5)=='TREF_' || objFrm[i].name.substring(0,5)=='TNEF_')
					objDataTypeHolder = objFrm[i].name.substring(0,5);
				//alert("data_type_holder="+objDataTypeHolder);
				
/*
				if((objFrm[i].type=='select-one' && objFrm[i].options[objFrm[i].selectedIndex].value=='' && objDataTypeHolder=="TR_"))
				{
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please select "+ sChangedName +".");
					objFrm[i].focus();
					return false;
					break;
				}
*/
				
				if(objDataTypeHolder=="TR_")
				{
					if((objFrm[i].type=='select-one' && objFrm[i].options[objFrm[i].selectedIndex].value==''))
					{
						sChangedName = objFrm[i].name.substring(3);
						sChangedName = getFormattedmsg(sChangedName)
						alert("Please select "+ sChangedName +".");
						objFrm[i].focus();
						return false;
						break;
					}			
				}
				
				// This is coding for multiple select list boxes 
				if(objFrm[i].type=='select-multiple' && objDataTypeHolder=="TR_")
				{
					var optselected=false;
					for(var j=0;j<objFrm[i].length;j++) 
					{
						if(objFrm[i].options[j].selected==true)
						{
							optselected=true;
							break;
						}
					}
					
					if(optselected==false) 
					{
						sChangedName = objFrm[i].name.substring(3);
						sChangedName = getFormattedmsg(sChangedName);
						alert("Please select "+ sChangedName +".");
						objFrm[i].focus();
						return false;
						break;
					}
				}
				
				if((objDataTypeHolder=="TRU_") )
				{
					
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
	
	
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
	
					else if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					
				}
/*
				if((objDataTypeHolder=="TRP_") )
				{			
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName);
					
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(objFrm[i].value.indexOf(" ")!=-1)
					{
						alert("Spaces are not allowed in password.");
						objFrm[i].select();
						return false;
						break;
					}
					else if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
*/
				if((objDataTypeHolder=="TRP_") || (objDataTypeHolder=="TNP_" && objFrm[i].value!=''))
				{			
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName);
					
					if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
/*
				if((objDataTypeHolder=="TRCP_") )
				{
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName);
					
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(objFrm[i].value.indexOf(" ")!=-1)
					{
						alert("Spaces are not allowed in confirm password.");
						objFrm[i].select();
						return false;
						break;
					}
					else if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(objFrm[i].type=='password' && objFrm[i-1].type=='password' && objFrm[i-1].name=='TRP_Password' && objFrm[i].value!=objFrm[i-1].value)
					{
						alert("Password and confirm password fields are not matching.");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
*/
				if((objDataTypeHolder=="TRCP_") || objDataTypeHolder=="TNCP_")
				{
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName);
/*
					if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else
*/
					if(objFrm[i].type=='password' && objFrm[i-1].type=='password' && objFrm[i-1].name=='TRP_Password' && objFrm[i].value!=objFrm[i-1].value)
					{
						alert("Password and confirm password fields are not matching.");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(objFrm[i].type=='password' && objFrm[i-1].type=='password' && objFrm[i-1].name=='TNP_Password' && objFrm[i].value!=objFrm[i-1].value)
					{
						alert("Password and confirm password fields are not matching.");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
/*
				if((objDataTypeHolder=="TROP_") )
				{					
					sChangedName = objFrm[i].name.substring(5);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
	
	
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(objFrm[i].value.indexOf(" ")!=-1)
					{
						alert("Spaces are not allowed in password.");
						objFrm[i].select();
						return false;
						break;
					}
					else if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
*/
				if((objDataTypeHolder=="TROP_"))
				{			
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName);
					
					if(!check_Pwd(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
				
				if((objDataTypeHolder=="IMGR_") )
				{
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					
						
						if(!ValidateImg(objFrm[i].value,1,sChangedName))
						{
							//alert("Please enter Valid "+ sChangedName +".");
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
				}
				if((objDataTypeHolder=="IMGN_") )
				{
					   sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					
						if(!ValidateImg(objFrm[i].value,0,sChangedName))
						{
							//alert("Please enter Valid "+ sChangedName +".");
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
				}
				
				if((objDataTypeHolder=="TR_" || objDataTypeHolder=="TRC_" || objDataTypeHolder=="TRFN_" || objDataTypeHolder=="TL_" ||objDataTypeHolder=="IR_" || objDataTypeHolder=="MR_"  || objDataTypeHolder=="IMGR_" )&& (objFrm[i].value==''))
				{	
					
					if(objDataTypeHolder=="TRC_"){
						sChangedName = objFrm[i].name.substring(4);
					}
					else if(objDataTypeHolder=="TRFN_" || objDataTypeHolder=="IMGR_"){
						sChangedName = objFrm[i].name.substring(5);
					}					
					else{
						sChangedName = objFrm[i].name.substring(3);
					}

					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter "+ sChangedName +".");
					objFrm[i].focus();
					return false;
					break;
				}
	
				if((objDataTypeHolder=="TR_" || objDataTypeHolder=="TRC_" || objDataTypeHolder=="TRFN_" || objDataTypeHolder=="TL_" ||objDataTypeHolder=="IR_" || objDataTypeHolder=="MR_"  )&& (objFrm[i].value==''))
				{	
					if(objDataTypeHolder=="TRC_")
						sChangedName = objFrm[i].name.substring(4);
					else
						sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					
					alert("Please enter "+ sChangedName +".");
					objFrm[i].focus();
					return false;
					break;
				}
	
				if(objDataTypeHolder=="TRC_" && objFrm[i].value!='')
				{
					bb11= objFrm[i].value.length;
					x= objFrm[i].value;
					for( p=0;p<bb11;p++)
					{
						z = x.substring(p,p+1);
						if (  (z >="1" && z <= "9") || (bb11 > 30 )||z=='"' || z=="'")
							{
								sChangedName = objFrm[i].name.substring(4);
								sChangedName = getFormattedmsg(sChangedName)
								alert("Please enter correct "+ sChangedName +".");
								objFrm[i].focus();
								objFrm[i].select();
								return false;
							}
					}
				}
	
				if(objDataTypeHolder=="TNC_" && objFrm[i].value!='')
				{
					bb11= objFrm[i].value.length;
					x= objFrm[i].value;
					for( p=0;p<bb11;p++)
					{
						z = x.substring(p,p+1);
						if (  (z >="1" && z <= "9") || (bb11 > 30 )||z=='"' || z=="'")
							{
								sChangedName = objFrm[i].name.substring(4);
								sChangedName = getFormattedmsg(sChangedName)
								alert("Please enter correct "+ sChangedName +".");
								objFrm[i].focus();
								objFrm[i].select();
								return false;
							}
					}
				}
	
				if((objDataTypeHolder=="TL_" || objDataTypeHolder=="TLN_")&& objFrm[i].value!='')
				{
					bb11= objFrm[i].value.length;
					x= objFrm[i].value;
					for( p=0;p<bb11;p++)
					{
						z = x.substring(p,p+1);
	//					alert(z);
						if (  isNaN(z) && z!='-' && z!=" ")
							{
								sChangedName = objFrm[i].name.substring(3);
								sChangedName = getFormattedmsg(sChangedName)
								alert("Only numbers, space & - are allowed in "+ sChangedName +".");
								objFrm[i].focus();
								objFrm[i].select();
								return false;
							}
					}
				}
	
				if(objDataTypeHolder=="TREF_" && objFrm[i].value=='')
				{
					sChangedName = objFrm[i].name.substring(5);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter "+ sChangedName +".");
	
	//				alert("Please enter email.");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
	
				if((objDataTypeHolder=="IR_" || objDataTypeHolder=="MR_" )&& (isNaN(objFrm[i].value)))
				{
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter numeric "+ sChangedName +".");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
				
				if((objDataTypeHolder=="IR_")&& (objFrm[i].value<0))
				{
					
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter valid "+ sChangedName +".");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
	
				if((objDataTypeHolder=="IN_" || objDataTypeHolder=="MN_" )&& (isNaN(objFrm[i].value) && objFrm[i].value!=''))
				{
					
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter numeric "+ sChangedName +".");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
	
				if((objDataTypeHolder=="IN_")&& (objFrm[i].value<=0 && objFrm[i].value!=''))
				{
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter valid "+ sChangedName +".");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
				
				if((objDataTypeHolder=="IR_" || objDataTypeHolder=="IN_" ) && (objFrm[i].value.indexOf(".")!=-1))
				{
					
					sChangedName = objFrm[i].name.substring(3);
					sChangedName = getFormattedmsg(sChangedName)
					alert("Please enter valid "+ sChangedName +".");
					objFrm[i].focus();
					objFrm[i].select();
					return false;
					break;
				}
	
				if((objDataTypeHolder=="TREF_") || (objDataTypeHolder=="TNEF_" && objFrm[i].value!='' ))
				{
					if(!ValidateEMail(objFrm[i].value))
					{
						sChangedName = objFrm[i].name.substring(5);
						sChangedName = getFormattedmsg(sChangedName)
	//					alert("Please enter valid "+ sChangedName +". (It should be an Email)");
	
						alert("Please enter valid email.");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
				
				//Checks for valid email if the field is username
				if((objDataTypeHolder=="TREFUN_")  && objFrm[i].value!='' )
				{
					if(!ValidateEMail(objFrm[i].value))
					{
						sChangedName = objFrm[i].name.substring(7);
						sChangedName = getFormattedmsg(sChangedName)
						alert("Please enter valid "+ sChangedName +". (It should be an Email)");
	
	//					alert("Please enter valid email.");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
				
				//ValidateNumber(objName)
				if((objDataTypeHolder=="MR_") || (objDataTypeHolder=="MN_" && objFrm[i].value!=''))
				{
					if(!ValidatePrice(objFrm[i].value))
					{
							
						sChangedName = objFrm[i].name.substring(3);
						sChangedName = getFormattedmsg(sChangedName)
						alert("Please enter valid "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
	
				if((objDataTypeHolder=="NR_"))
				{
					if(!ValidateNumber(objFrm[i].value))
					{
						objFrm[i].focus();
						return false;
						break;
					}
				}	
				if(objDataTypeHolder=="PHR_")
				{
					var val=objFrm[i].value;
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
	
	//					alert("Link cannot be left blank");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if( (objFrm[i].value!="" && !check_phone_no(objFrm[i].value)) )
					{
						alert("Please enter Valid "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}	
					//phoneNo=objFrm[i].value;
					
					//var phoneRE = /^\(*\d\d\d\) \d\d\d[-]\d\d\d\d$/; 
					//var phoneRE=/^\(*[0-9]{3}\)* [0-9]{3}-*[0-9]{4}$/;
						// if (phoneNo.match(phoneRE)) { 
						  // return true; 
						// } else { 
						//   alert("Please entered valid Phone no(like (XXX) XXX-XXXX or XXX XXX-XXXX )."); 
						//   return false; 
						// } 
						
	
	
					/*validphone=/^\(*[0-9]{3}\)*[[:space:]][0-9]{3}-*[0-9]{4}$/;
					//validphone=/^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,3})|(\(?\d{2,3}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/;
					if (str.match(validphone)) {
					alert("valid.....");
					return true;
					} else {
					alert("Not valid");
					return false;
					}
					if(!validphone(objFrm[i].value))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
					}*/
					/*if (checkInternationalPhone(objFrm[i].value)==false)
					{
						alert("Please Enter a Valid Phone Number")
						objFrm[i].focus();
						objFrm[i].select();
						return false;
					}*/
					//return true
				
				}
	
				//ValidateNumber(objName)
				if((objDataTypeHolder=="NR_"))
				{
					if(!ValidateNumber(objFrm[i].value))
					{
						objFrm[i].focus();
						return false;
						break;
					}
					if(parseFloat(objFrm[i].value)<=0)
					{
						objFrm[i].focus();	
						alert('Price should be greater then 0');
						return false;
					}
				}
				
				if(objDataTypeHolder=="PHN_")
				{
					
					
					var val=objFrm[i].value;
									
					var val=objFrm[i].value;
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					/*if(objFrm[i].value!="")
					{
						if (checkInternationalPhone(objFrm[i].value)==false)
						{
							alert("Please Enter a Valid Phone Number. The format should be (xxx) xxx-xxxx")
							objFrm[i].focus();
							objFrm[i].select();
							return false;
						}
					}*/
					if( (objFrm[i].value!="" && !check_phone_no(objFrm[i].value)) )
					{
						alert("Please enter Valid "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}	
					
					//return true;				
				}
				/*if((objDataTypeHolder=="IMG_") )
				{
					alert("hello");
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
	
	//					alert("Link cannot be left blank");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					//alert(isURL(objFrm[i].value));
					else if(!ValidateImg(objFrm[i].value,req))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(!checkImageSize(objFrm[i].value))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					else if(!imageExist(objFrm[i].value))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					
					
				}*/
				if((objDataTypeHolder=="IMGN_") || (objDataTypeHolder=="IMGR_") )
				{
					   sChangedName = objFrm[i].name.substring(5);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value!="")
					{
						//alert(ValidateImg(objFrm[i].value,req,sChangedName));
						//return false;
						if(!ValidateImg(objFrm[i].value,req,sChangedName))
						{
							//alert("Please enter Valid "+ sChangedName +".");
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
					
						
					}
				}
				if((objDataTypeHolder=="TRURL_") )
				{
					sChangedName = objFrm[i].name.substring(6);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value=="")
					{
						alert("Please enter "+ sChangedName +".");
	
	//					alert("Link cannot be left blank");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
					//alert(isURL(objFrm[i].value));
					if(!isURL(objFrm[i].value,sChangedName))
					{
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
	
				if((objDataTypeHolder=="TNURL_") )
				{
					sChangedName = objFrm[i].name.substring(6);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value!="")
					{
						//alert(isURL(objFrm[i].value));
						if(!isURL(objFrm[i].value,sChangedName))
						{
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
					}
				}
	
	
			if((objDataTypeHolder=="TRFN_"))
				{
					sChangedName = objFrm[i].name.substring(5);
					
					sChangedName = getFormattedmsg(sChangedName)
					
					if(!onlyString(objFrm[i].value))
					{
						alert("Please enter valid "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}	
				}
	
			if((objDataTypeHolder=="TNFN_") )
				{
					sChangedName = objFrm[i].name.substring(5);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value!="")
					{
						if(!onlyString(objFrm[i].value))
						{
							alert("Please enter valid "+ sChangedName +".");
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
					}
				}
				
				//subhash 
				//(To check Alpha nemeric and spaces only)
				if((objDataTypeHolder=="ANR_"))
				{
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					if(!AlphaNumeric(objFrm[i].value))
					{
						alert("Please enter Valid "+ sChangedName +".");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}	
				}
	
			if((objDataTypeHolder=="ANN_") )
				{
					sChangedName = objFrm[i].name.substring(4);
					sChangedName = getFormattedmsg(sChangedName)
					if(objFrm[i].value!="")
					{
						if(!AlphaNumeric(objFrm[i].value))
						{
							alert("Please enter Valid "+ sChangedName +".");
							objFrm[i].focus();
							objFrm[i].select();
							return false;
							break;
						}
					}
				}
				//(To check Alpha nemeric and spaces only)
				//subhash 
				
				
				//validate fax number
				if(objDataTypeHolder=="FXR_")
				{
					var val=objFrm[i].value;
					if (val!="")
					{
						for(var j=0; j < val.length;j++)
						{
							//Fax start with + sign
							if(val.charAt(0)!='+' && iAllowPlus==1)
							{
								sChangedName = objFrm[i].name.substring(4);
								sChangedName = getFormattedmsg(sChangedName)
								alert("Please enter valid "+ sChangedName +". Example '+1234567'");
								objFrm[i].focus();
								objFrm[i].select();
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
									sChangedName = objFrm[i].name.substring(4);
									sChangedName = getFormattedmsg(sChangedName)
									//alert("Please enter valid "+ sChangedName +".");
	//								alert("Enter your "+ sChangedName +" with no special chars other than ( ) - +");
									alert("Please enter numeric "+ sChangedName +" with no special chars other than ( ) - ");
	
		//							alert("Please enter valid Fax Number");
									objFrm[i].focus();
									objFrm[i].select();
									return false;
									break;
								}
							}
							if((val.charAt(j)==' ') && iAllowSpace==0)
							{
								sChangedName = objFrm[i].name.substring(4);
								sChangedName = getFormattedmsg(sChangedName)
								alert("Enter your "+ sChangedName +" with no spaces");
	
	//							alert("Please enter valid Fax Number");
								objFrm[i].focus();
								objFrm[i].select();
								return false;
								break;
							}
						}
					}
					else
					{
						sChangedName = objFrm[i].name.substring(4);
						sChangedName = getFormattedmsg(sChangedName)
						alert("Please Enter "+ sChangedName +".");
	
	//					alert("Please Enter Fax Number");
						objFrm[i].focus();
						objFrm[i].select();
						return false;
						break;
					}
				}
				//end of fax number
	/////////////////////////////////////////////////////////////////////////////
			}
		}
	}
	
	return true;
}

function FormatDate(d)
{
	var dd,mm;
	var l;
	l=d.indexOf("/");
	dd=d.substring(0,l);
	d=d.substring(l+1);
	l=d.indexOf("/");
	mm=d.substring(0,l);
	yy=d.substring(l+1);
	
	if (parseInt(dd) < 10)
		dd="0" + dd;
	if (parseInt(mm) < 10)
		mm="0" + mm;
	d= dd + "/" + mm + "/" + yy
	return d;
}

/*function ValidateImg(objImg, isRequired)
{
	if(isRequired ==1 && objImg=='')
	{
		alert("Please enter image.");
		//objImg.focus();
		return false;
	}
	if(objImg.length!=0)
	{
		if(objImg.length<5)
		{
			alert("Please enter valid image.");
			//objImg.focus();
			//objImg.select();
			return false;
		}
		var iPos = objImg.lastIndexOf(".")
		var sExt = objImg.substring(iPos);
		if((sExt.toUpperCase()=='.JPEG') || (sExt.toUpperCase()=='.JPG') || (sExt.toUpperCase()=='.GIF') || (sExt.toUpperCase()=='.BMP')||(sExt.toUpperCase()=='.PDF') )
		{
			return true;
		}
		else
		{
			alert("Please enter valid image.");
			//objImg.focus();
			//objImg.select();
			return false;
		}
	}
	return true;
}*/

function ValidateImg(objImg, isRequired, sChangedName)
{
	var sExt_old;
	if(isRequired ==1 && objImg=='')
	{
		alert("Please upload Image.");
	//	objImg.focus();
		return false;
	}
		
	if(objImg.length!=0)
	{
		if(objImg.length<5)
		{
			alert("Please upload valid Image.");
			
			return false;
		}
		
		var iPos = objImg.lastIndexOf(".")
		var sExt = objImg.substring(iPos);
		sExt=sExt.toLowerCase();
	   
		
		if((sExt=='.jpeg') || (sExt=='.jpg') || (sExt=='.gif'))
		{			
			return true;
		}
	   	else
		{
			  alert(sExt.toUpperCase()+" file type not allowed");
			   return false;

		}
	}
	return true;
}

function ValidateFile(objImg, isRequired, sChangedName)
{
	var sExt_old;
	if(isRequired ==1 && objImg=='')
	{
		alert("Please upload Image.");
	//	objImg.focus();
		return false;
	}
	
	arr=sChangedName.split("-");
	len=arr.length;
	len=len-2;
	
	
	if(objImg.length!=0)
	{
		if(objImg.length<5)
		{
			alert("Please upload valid Image.");
			
			return false;
		}
		var iPos = objImg.lastIndexOf(".")
		var sExt = objImg.substring(iPos);
		sExt=sExt.toLowerCase();
		
		
		
        for(i=0;i<=len;i++)
        {
	      
		  arr[i]=arr[i].toLowerCase();
		   
		   if(arr[i]=="img")
		   {
				if((sExt=='.jpeg') || (sExt=='.jpg') || (sExt=='.gif')  || (sExt=='.png'))
				{
					 sExt_old=sExt;
					 sExt="img";
			 
				}
		   }
		   else if(arr[i]=="fla")
		   {
				if((sExt=='.swf') || (sExt=='.fla'));
				sExt_old=sExt;
				sExt="fla";
							
		   }
		
	   
		switch(sExt)
        {
		   case ".doc":
		  	   if(arr[i]=='doc')
			   {
				  
		               return true;
			   }
              
           case "img":
			    if((sExt_old=='.jpeg') || (sExt_old=='.jpg') || (sExt_old=='.gif')  && (arr[i] =='img'))
		        {
		         	
					return true;
		        }
		       
            case ".xls":
			   if(arr[i] =='xls')
			   {
		               return true;
			   }
               
          case ".ppt":
			   if(arr[i] =='ppt')
			   {
		               return true;
			   }
               
           case ".pdf":
			   if(arr[i] =='pdf')
			   {
		               return true;
			   }
               
          case "fla":
			   if(((sExt_old=='.fla') ||(sExt_old=='.swf'))&& (arr[i] =='fla'))
			   {
		               return true;
			   }
               
          case ".txt":
		  
			   if(arr[i] =='txt')
			   {
		               return true;
			   }
			   
           default:
			    if((sExt!=arr[i]) && (i==len) )
			    {
		              alert(sExt.toUpperCase()+" file type not allowed");
				       return false;
				        break;
		        }
				
				
		}
		
       }
		
	}
	return true;
}

function ValidateNumber(objName)
{
	
		
	var h;
	var x;
	
	h=objName.length;
	x = objName;
	if (h==0)
	{
		alert("Price cannot be left blank");
		return false;
	}			
	for( i=0;i<h;i++)
	{
		z = x.substring(i,i+1);
		if ( z=="'"||z=='"' || (z >= "a" && z <= "z" ) || (z >= "A" && z <= "Z") )
		{
			alert("Price Can be numeric only");
			return false;
		}			
	}
	jj=x.indexOf(".");
	if (jj != "-1") 
		{
		hh=x.substring(jj);
		ll=hh.length;
		if (ll > 3) 
			{
			alert("Price Can have upto 2 decimal places");
			return false;
			}
		}
	return true;
	
}

function checkname(pn, dipname)
{
		var n,s,z;
		n=0;
		s=0;
		z=pn.value.length;
//		alert(pn.name + z);
		for(var i=0;i<z;i++)
		{		
			alert(pn.charCodeAt(i));
			if((pn.charCodeAt(i)>=48 && pn.charCodeAt(i)<=57))
				n=n+1;
			else
				s=s+1;
		}
//		alert(pn.name + ' '+ n + ' ' + s);
		if (s==0)
		{
			alert(dipname + ' cannot be just numbers!!');
			return false;
		}
		else
		{
			return true;
		}
}

function getFormattedmsg(sVal)
{
	
	while(sVal.indexOf("_")!=-1)
	{
		sVal = sVal.replace("_", " ")
	}
	
	var b;
	b=sVal.charAt(0).toUpperCase();
	b=b+sVal.substring(1);
	
	return b;
}

function isURL(argvalue,urlname)
{
    if (argvalue.indexOf(" ") != -1)
	{
		alert("Spaces not allowed in "+ urlname +"!");
	    return false;
	}
	else if (argvalue.indexOf("http://") && argvalue.indexOf("https://") == -1)
    {
		alert(urlname +" must begin with a http://");
	    return false;
	}
	else if (argvalue == "http://" && argvalue.indexOf("https://"))
    {
		alert("Please enter complete "+ urlname +"!");
	    return false;
	}
	else if (argvalue.indexOf("http://" && argvalue.indexOf("https://")) > 0)
    {
		alert("http:// must come in the beginning of a "+ urlname);
	    return false;
	}

	argvalue = argvalue.substring(7, argvalue.length);
	if (argvalue.indexOf(".") == -1)
	{
		alert("Please enter an extension like .com, .edu(etc) for "+ urlname +"!");
	    return false;
	}
	else if (argvalue.indexOf(".") == 0)
	{
		alert("Please enter correct "+ urlname +"!");
	    return false;
	}
	else if (argvalue.charAt(argvalue.length - 1) == ".")
    {
		alert("Please enter an extension after . like com, edu(etc) for "+ urlname +"!");
	    return false;
	}

	if (argvalue.indexOf("/") != -1) 
	{
		argvalue = argvalue.substring(0, argvalue.indexOf("/"));
		if (argvalue.charAt(argvalue.length - 1) == ".")
		{
			alert("Please enter correct "+ urlname +"!");
			return false;
		}
	}

	if (argvalue.indexOf(":") != -1) 
	{
		if (argvalue.indexOf(":") == (argvalue.length - 1))
		{
			alert("Please enter correct "+ urlname +"!");
		    return false;
		}
	    else if (argvalue.charAt(argvalue.indexOf(":") + 1) == ".")
		{
			alert("Please enter correct "+ urlname +"!");
			return false;
		}
		argvalue = argvalue.substring(0, argvalue.indexOf(":"));
		if (argvalue.charAt(argvalue.length - 1) == ".")
		{
			alert("Please enter correct "+ urlname +"!");
			return false;
		}
	}
	return true;
}

function ValidateItemName(objName)
{
			
	var h;
	var x;
	
	h=objName.length;
	x = objName;
	if (h==0)
	{
		alert("Item Name Cannot left blank");
		return false;
	}			
	for( i=0;i<h;i++)
	{
		z = x.substring(i,i+1);
		if ( z=="_" || z=="-" || z=="&" || z==" " || (z >= "a" && z <= "z" ) || (z >= "A" && z <= "Z") || (z >= "0" && z <= "9") )
		{
		}else{
			alert("Please enter Valid Item Name");
			return false;
		}
	}
	return true;
}

//Purpose	: This function is used to validate price. 
//Arguments : price object
function ValidatePrice(objName)
{
	var sobjValue;
	var iobjLength;
	
	if(parseInt(objName) < 0)
	{
		return false;
	}
	
	sobjValue=objName;
	iobjLength=sobjValue.length;
	iSposition=sobjValue.indexOf(".");
	iTmp=sobjValue.lastIndexOf(".");	
	iPosition=sobjValue.indexOf(",");
	iPos=sobjValue.indexOf(";");
	
	if ((iobjLength!=0))
	{
		
/*		if ((iSposition == -1))
		{
			return false;
		}
		else*/
		if(sobjValue.charAt(0)==".")
		{
			return false;				
		}
		else if(sobjValue.charAt(iobjLength)==".")
		{
			return false;				
		}	
		else if ((iTmp!=-1) && ((iobjLength-(iTmp+1)>2) || (iobjLength==(iTmp+1))))
		{
			return false;
		}
		else if ((iPosition!=-1) || (iPos!=-1))
		{
			return false;
		}
		else
		{
			return true;
		}		
	}		
}

function imageExist(obj)
{
	var iPos = obj.value.lastIndexOf(".")
	var sExt = obj.value.substring(iPos);
	if((sExt.toUpperCase()=='.JPEG') || (sExt.toUpperCase()=='.JPG') || (sExt.toUpperCase()=='.GIF') || (sExt.toUpperCase()=='.BMP') )
	{
		return true;
	}
	else
	{
		alert("Please enter valid image.");
		obj.focus();
		obj.select();
		return false;
	}
	return true;
}

function checkImageSize(obj)
{

	var vWidth=100;
	var vHeight=80;

	img = new Image();
	img.src = obj;
	var imWidth = img.width;
	var imHeight = img.height;
	if (imWidth == 0 || imHeight == 0) 
	{
		//return validate(document.frmBan);
		return false;
	}
	if((imWidth!=vWidth) || (imHeight!=vHeight))
	{
			alert("Please check the size of image with that you have selected.\n It should be "+vWidth+"x"+vHeight+" and your image size is "+imWidth+"x"+imHeight);
			return false;		
			
			
	}
	else
	{
		return true;
	}
	return false;
}

/*
Description: This Function checks that the string value passed to the function does contains some characters.
*/

function onlyno()
{
	if (event.keyCode < 45 || event.keyCode > 57) 
		event.returnValue = false;
}

//Description: This Function checks that the character entered is only character
function onlychar()
{
	if((event.keyCode >= 65 && event.keyCode <= 90) || (event.keyCode >= 97 && event.keyCode <= 122) || event.keyCode == 32 )
	{
	}
	else
	{
		event.returnValue = false;
	}
}

function check_Pwd(obj,fld_name)
{
	//x=obj.value;
	x=obj;
	flag=0;
	//temp_char="_";
	b=x.length;
	
	if(obj=="")
	{
		alert("Please enter "+ fld_name +".");

		return false;
	}
	
	if(obj.indexOf(" ")!=-1)
	{
		alert("Spaces are not allowed for " + fld_name);

		return false;
	}

	if(b<6)
	{
		alert(fld_name +" Should Be Of Minimum 6 Characters ");
		
		return false;
	}
		
	for( i=0;i < b;i++)
	{
		vAscii = x.charCodeAt(i)
			

		if((vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122) || (vAscii >= 45 && vAscii <= 57) || ( x.charAt(i)=="_"))
		{
			flag=1;		
		}
		else
		{
			flag=0;
			break;
		}
		
	}


	if(flag==0)
	{
		alert("Only Characters a-z,A-Z,0-9 and '_' are allowed for "+fld_name);
/*		obj.focus();
		obj.select();*/
		return false;
	}
	else
	{
		return true;
	}
}

//Description: This Function checks that the character entered is only character or space used in validate form function
function onlyString(TempString)
{
	bb11= TempString.length;
	x= TempString;
	flag=0;

	for( p=0;p<bb11;p++)
	{
		vAscii = x.charCodeAt(p)
		//z = x.substring(p,p+1);
		 if((vAscii >= 48 && vAscii <= 57) || (vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122) || (vAscii == 32) || ( x.charAt(p)=="'"))
			{
				flag=1;		
			}
			else
			{
				flag=0;
				break;
			}
	}
	if(flag==0)
	{
		return false;
	}
	else
	{
		return true;
	}
}


//Description: This Function checks that the character entered is character or space or number used in validate form function
function AlphaNumeric(TempString)
{
	bb11= TempString.length;
	x= TempString;
	flag=0;

	for( p=0;p<bb11;p++)
	{
		vAscii = x.charCodeAt(p)
		//alert(vAscii);
		//z = x.substring(p,p+1);
		 if((vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122) || (vAscii == 32) || (vAscii == 45) || (vAscii >= 45 && vAscii <= 57))
			{
				flag=1;		
			}
			else
			{
				flag=0;
				break;
			}
	}
	if(flag==0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function check_phone_no(TempString)
{
	bb11= TempString.length;
	x= TempString;
	flag=0;
	len=0;
	for( p=0;p<bb11;p++)
	{
		vAscii = x.charCodeAt(p)
		//alert(vAscii);
		//z = x.substring(p,p+1);
		/* if((vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122) || (vAscii == 32) || (vAscii == 40) || (vAscii == 41) || (vAscii == 43) || (vAscii == 45) || (vAscii >= 48 && vAscii <= 57))*/
		if ((vAscii >= 65 && vAscii <= 90) || (vAscii >= 97 && vAscii <= 122) || (vAscii >= 48 && vAscii <= 57))
		{
			len=len+1;
			flag=1;
		}
		else if((vAscii == 32) || (vAscii == 40) || (vAscii == 41) || (vAscii == 43) || (vAscii == 45))
		{
				flag=1;		
		}
		else
		{
				flag=0;
				break;
		}
	}
	if(flag==0 || len==0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function ValidateHTML(objName)
{
	var h;
	var x;
	
	h=objName.length;
	x = objName;
	if (h==0)
	{
		alert("Page Name Cannot left blank");
		return false;
	}			
	for( i=0;i<h;i++)
	{
		z = x.substring(i,i+1);
		if ( z=="." || z=="_" || z=="-" || (z >= "a" && z <= "z" ) || (z >= "A" && z <= "Z") || (z >= "0" && z <= "9") )
		{
		}else{
			alert("Please enter Valid Page Name");
			return false;
		}
	}
	if(x.indexOf('.php') ==-1 ){
		alert("Please enter Valid Page Name\nThe extension of the Page should be .php");
		return false;
	}
	if(x.indexOf('index.php') !=-1 ){
		alert("index.php already exists");
		return false;
	}
	if(x.indexOf('contactus.php') !=-1 ){
		alert("contactus.php already exists");
		return false;
	}
	return true;
	
}

function ValidateFolder(objName)
{
	var h;
	var x;
	
	h=objName.length;
	x = objName;
	if (h==0)
	{
		alert("Folder Name Cannot left blank");
		return false;
	}			
	for( i=0;i<h;i++)
	{
		z = x.substring(i,i+1);
		if ( z=="_" || z=="-" || (z >= "a" && z <= "z" ) || (z >= "A" && z <= "Z") || (z >= "0" && z <= "9") )
		{
		}else{
			alert("Please enter Valid Folder Name\nDo not enter any space and special characters");
			return false;
		}
	}
	return true;
	
}

//-------**********trim function **************--------------------
function LTrim(str)
{
	for (var i=0; str.charAt(i)==" "; i++);
	return str.substring(i,str.length);
}
function RTrim(str)
{
	for (var i=str.length-1; str.charAt(i)==" "; i--);
	return str.substring(0,i+1);
}
 
function Trim(str)
{
	return LTrim(RTrim(str));
}

 function replaceSubstring(inputString, fromString, toString) {
   // Goes through the inputString and replaces every occurrence of fromString with toString
   var temp = inputString;
   if (fromString == "") {
      return inputString;
   }
   if (toString.indexOf(fromString) == -1) { // If the string being replaced is not a part of the replacement string (normal situation)
      while (temp.indexOf(fromString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(fromString));
         var toTheRight = temp.substring(temp.indexOf(fromString)+fromString.length, temp.length);
         temp = toTheLeft + toString + toTheRight;
      }
   } else { // String being replaced is part of replacement string (like "+" being replaced with "++") - prevent an infinite loop
      var midStrings = new Array("~", "`", "_", "^", "#");
      var midStringLen = 1;
      var midString = "";
      // Find a string that doesn't exist in the inputString to be used
      // as an "inbetween" string
      while (midString == "") {
         for (var i=0; i < midStrings.length; i++) {
            var tempMidString = "";
            for (var j=0; j < midStringLen; j++) { tempMidString += midStrings[i]; }
            if (fromString.indexOf(tempMidString) == -1) {
               midString = tempMidString;
               i = midStrings.length + 1;
            }
         }
      } // Keep on going until we build an "inbetween" string that doesn't exist
      // Now go through and do two replaces - first, replace the "fromString" with the "inbetween" string
      while (temp.indexOf(fromString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(fromString));
         var toTheRight = temp.substring(temp.indexOf(fromString)+fromString.length, temp.length);
         temp = toTheLeft + midString + toTheRight;
      }
      // Next, replace the "inbetween" string with the "toString"
      while (temp.indexOf(midString) != -1) {
         var toTheLeft = temp.substring(0, temp.indexOf(midString));
         var toTheRight = temp.substring(temp.indexOf(midString)+midString.length, temp.length);
         temp = toTheLeft + toString + toTheRight;
      }
   } // Ends the check to see if the string being replaced is part of the replacement string or not
   return temp; // Send the updated string back to the user
} // Ends the "replaceSubstring" function

/* Here's the list of tokens we support:
   m (or M) : month number, one or two digits.
   mm (or MM) : month number, strictly two digits (i.e. April is 04).
   d (or D) : day number, one or two digits.
   dd (or DD) : day number, strictly two digits.
   y (or Y) : year, two or four digits.
   yy (or YY) : year, strictly two digits.
   yyyy (or YYYY) : year, strictly four digits.
   mon : abbreviated month name (April is apr, Apr, APR, etc.)
   Mon : abbreviated month name, mixed-case (i.e. April is Apr only).
   MON : abbreviated month name, all upper-case (i.e. April is APR only).
   mon_strict : abbreviated month name, all lower-case (i.e. April is apr 
         only).
   month : full month name (April is april, April, APRIL, etc.)
   Month : full month name, mixed-case (i.e. April only).
   MONTH: full month name, all upper-case (i.e. APRIL only).
   month_strict : full month name, all lower-case (i.e. april only).
   h (or H) : hour, one or two digits.
   hh (or HH) : hour, strictly two digits.
   min (or MIN): minutes, one or two digits.
   mins (or MINS) : minutes, strictly two digits.
   s (or S) : seconds, one or two digits.
   ss (or SS) : seconds, strictly two digits.
   ampm (or AMPM) : am/pm setting.  Valid values to match this token are
         am, pm, AM, PM, a.m., p.m., A.M., P.M.
*/
// Be careful with this pattern.  Longer tokens should be placed before shorter
// tokens to disambiguate them.  For example, parsing "mon_strict" should 
// result in one token "mon_strict" and not two tokens "mon" and a literal
// "_strict".

var tokPat=new RegExp("^month_strict|month|Month|MONTH|yyyy|YYYY|mins|MINS|mon_strict|ampm|AMPM|mon|Mon|MON|min|MIN|dd|DD|mm|MM|yy|YY|hh|HH|ss|SS|m|M|d|D|y|Y|h|H|s|S");

// lowerMonArr is used to map months to their numeric values.

var lowerMonArr={jan:1, feb:2, mar:3, apr:4, may:5, jun:6, jul:7, aug:8, sep:9, oct:10, nov:11, dec:12}

// monPatArr contains regular expressions used for matching abbreviated months
// in a date string.

var monPatArr=new Array();
monPatArr['mon_strict']=new RegExp(/jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec/);
monPatArr['Mon']=new RegExp(/Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec/);
monPatArr['MON']=new RegExp(/JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC/);
monPatArr['mon']=new RegExp("jan|feb|mar|apr|may|jun|jul|aug|sep|oct|nov|dec",'i');

// monthPatArr contains regular expressions used for matching full months
// in a date string.

var monthPatArr=new Array();
monthPatArr['month']=new RegExp(/^january|february|march|april|may|june|july|august|september|october|november|december/i);
monthPatArr['Month']=new RegExp(/^January|February|March|April|May|June|July|August|September|October|November|December/);
monthPatArr['MONTH']=new RegExp(/^JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER/);
monthPatArr['month_strict']=new RegExp(/^january|february|march|april|may|june|july|august|september|october|november|december/);

// cutoffYear is the cut-off for assigning "19" or "20" as century.  Any
// two-digit year >= cutoffYear will get a century of "19", and everything
// else gets a century of "20".

var cutoffYear=50;

// FormatToken is a datatype we use for storing extracted tokens from the
// format string.
function FormatToken (token, type) 
{
	this.token=token;
	this.type=type;
}

function parseFormatString (formatStr) 
{
	var tokArr=new Array;
	var tokInd=0;
	var strInd=0;
	var foundTok=0;
    
	while (strInd < formatStr.length) 
	{
		if (formatStr.charAt(strInd)=="%" && (matchArray=formatStr.substr(strInd+1).match(tokPat)) != null) 
		{
			strInd+=matchArray[0].length+1;
			tokArr[tokInd++]=new FormatToken(matchArray[0],"symbolic");
		} 
		else 
		{
			// No token matched current position, so current character should 
			// be saved as a required literal.
			if (tokInd>0 && tokArr[tokInd-1].type=="literal") 
			{
				// Literal tokens can be combined.Just add to the last token.
				tokArr[tokInd-1].token+=formatStr.charAt(strInd++);
			}
			else 
			{
				tokArr[tokInd++]=new FormatToken(formatStr.charAt(strInd++), "literal");
		    }
		}
	}
	return tokArr;
}

/* buildDate does all the real work.It takes a date string and format string,
 tries to match the two up, and returns a Date object (with the supplied date
 string value).If a date string doesn't contain all the fields that a Date
 object contains (for example, a date string with just the month), all
 unprovided fields are defaulted to those characteristics of the current
 date. Time fields that aren't provided default to 0.Thus, a date string
 like "3/30/2000" in "%mm/%dd/%yyyy" format results in a Date object for that
 date at midnight.formatStr is a free-form string that indicates special
 tokens via the % character.Here are some examples that will return a Date
 object:

 buildDate('3/30/2000','%mm/%dd/%y') // March 30, 2000
 buildDate('March 30, 2000','%Mon %d, %y') // Same as above.
 buildDate('Here is the date: 30-3-00','Here is the date: %dd-%m-%yy')

 If the format string does not match the string provided, an error message
 (i.e. String object) is returned.Thus, to see if buildDate succeeded, the
 caller can use the "typeof" command on the return value.For example,
 here's the dateCheck function, which returns true if a given date is
 valid,and false otherwise (and reports an error in the false case):

 function dateCheck(dateStr,formatStr) {
 var myObj=buildDate(dateStr,formatStr);
 if (typeof myObj=="object") {
 // We got a Date object, so good.
 return true;
 } else {
 // We got an error string.
 alert(myObj);
 return false;
 }
 }

*/

function buildDate(dateStr,formatStr) 
{
	// parse the format string first.
	var tokArr=parseFormatString(formatStr);
	var strInd=0;
	var tokInd=0;
	var intMonth;
	var intDay;
	var intYear;
	var intHour;
	var intMin;
	var intSec;
	var ampm="";
	var strOffset;

	// Create a date object with the current date so that if the user only
	// gives a month or day string, we can still return a valid date.

	var curdate=new Date();
	intMonth=curdate.getMonth()+1;
	intDay=curdate.getDate();
	intYear=curdate.getFullYear();

	// Default time to midnight, so that if given just date info, we return
	// a Date object for that date at midnight.

	intHour=0;
	intMin=0;
	intSec=0;

	// Walk across dateStr, matching the parsed formatStr until we find a 
	// mismatch or succeed.

	while (strInd < dateStr.length && tokInd < tokArr.length) 
	{
		// Start with the easy case of matching a literal.
		if (tokArr[tokInd].type=="literal") 
		{
			if (dateStr.indexOf(tokArr[tokInd].token,strInd)==strInd) 
			{
				// The current position in the string does match the format 
				// pattern.
				strInd+=tokArr[tokInd++].token.length;
				continue;
			}
			else 
			{
				// ACK! There was a mismatch; return error.
				return "\"" + dateStr + "\" does not conform to the expected format: " + formatStr;
			}
		}

		// If we get here, we're matching to a symbolic token.
		switch (tokArr[tokInd].token) 
		{
			case 'm':
			case 'M':
			case 'd':
			case 'D':
			case 'h':
			case 'H':
			case 'min':
			case 'MIN':
			case 's':
			case 'S':

			// Extract one or two characters from the date-time string and if 
			// it's a number, save it as the month, day, hour, or minute, as
			// appropriate.

			curChar=dateStr.charAt(strInd);
			nextChar=dateStr.charAt(strInd+1);
			matchArr=dateStr.substr(strInd).match(/^\d{1,2}/);
			if (matchArr==null) 
			{
				// First character isn't a number; there's a mismatch between
				// the pattern and date string, so return error.

				switch (tokArr[tokInd].token.toLowerCase()) 
				{
					case 'd': var unit="day"; break;
					case 'm': var unit="month"; break;
					case 'h': var unit="hour"; break;
					case 'min': var unit="minute"; break;
					case 's': var unit="second"; break;
				}
				return "Bad " + unit + " \"" + curChar + "\" or \"" + curChar +
				nextChar + "\".";
			}
			strOffset=matchArr[0].length;
			switch (tokArr[tokInd].token.toLowerCase()) 
			{
				case 'd': intDay=parseInt(matchArr[0],10); break;
				case 'm': intMonth=parseInt(matchArr[0],10); break;
				case 'h': intHour=parseInt(matchArr[0],10); break;
				case 'min': intMin=parseInt(matchArr[0],10); break;
				case 's': intSec=parseInt(matchArr[0],10); break;
			}
			break;
			case 'mm':
			case 'MM':
			case 'dd':
			case 'DD':
			case 'hh':
			case 'HH':
			case 'mins':
			case 'MINS':
			case 'ss':
			case 'SS':

			// Extract two characters from the date string and if it's a 
			// number, save it as the month, day, or hour, as appropriate.

			strOffset=2;
			matchArr=dateStr.substr(strInd).match(/^\d{2}/);
			if (matchArr==null) 
			{
				// The two characters aren't a number; there's a mismatch 
				// between the pattern and date string, so return an error
				// message.

				switch (tokArr[tokInd].token.toLowerCase()) 
				{
					case 'dd': var unit="day"; break;
					case 'mm': var unit="month"; break;
					case 'hh': var unit="hour"; break;
					case 'mins': var unit="minute"; break;
					case 'ss': var unit="second"; break;
				}
				return "Bad " + unit + " \"" + dateStr.substr(strInd,2) + 
				"\".";
			}
			switch (tokArr[tokInd].token.toLowerCase()) 
			{
				case 'dd': intDay=parseInt(matchArr[0],10); break;
				case 'mm': intMonth=parseInt(matchArr[0],10); break;
				case 'hh': intHour=parseInt(matchArr[0],10); break;
				case 'mins': intMin=parseInt(matchArr[0],10); break;
				case 'ss': intSec=parseInt(matchArr[0],10); break;
			}
			break;
			case 'y':
			case 'Y':
			// Extract two or four characters from the date string and if it's
			// a number, save it as the year.Convert two-digit years to four
			// digit years by assigning a century of '19' if the year is >= 
			// cutoffYear, and '20' otherwise.

			if (dateStr.substr(strInd,4).search(/\d{4}/) != -1) 
			{
				// Four digit year.
				intYear=parseInt(dateStr.substr(strInd,4),10);
				strOffset=4;
			}
			else 
			{
				if (dateStr.substr(strInd,2).search(/\d{2}/) != -1) 
				{
					// Two digit year.
					intYear=parseInt(dateStr.substr(strInd,2),10);
					if (intYear>=cutoffYear) 
					{
						intYear+=1900;
					}
					else 
					{
						intYear+=2000;
					}
					strOffset=2;
				}
				else 
				{
					// Bad year; return error.
					return "Bad year \"" + dateStr.substr(strInd,2) + "\". Must be two or four digits.";
				}
			}
			break;
			case 'yy':
			case 'YY':
			// Extract two characters from the date string and if it's a 
			// number, save it as the year.Convert two-digit years to four 
			// digit years by assigning a century of '19' if the year is >= 
			// cutoffYear, and '20' otherwise.

			if (dateStr.substr(strInd,2).search(/\d{2}/) != -1) 
			{
				// Two digit year.
				intYear=parseInt(dateStr.substr(strInd,2),10);
				if (intYear>=cutoffYear) 
				{
					intYear+=1900;
				}
				else 
				{
					intYear+=2000;
				}
				strOffset=2;
			} 
			else 
			{
				// Bad year; return error
				return "Bad year \"" + dateStr.substr(strInd,2) + "\". Must be two digits.";
			}
			break;
			case 'yyyy':
			case 'YYYY':
			// Extract four characters from the date string and if it's a 
			// number, save it as the year.
			if (dateStr.substr(strInd,4).search(/\d{4}/) != -1) 
			{
				// Four digit year.
				intYear=parseInt(dateStr.substr(strInd,4),10);
				strOffset=4;
			}
			else 
			{
				// Bad year; return error.
				return "Bad year \"" + dateStr.substr(strInd,4) + "\". Must be four digits.";
			}
			break;
			case 'mon':
			case 'Mon':
			case 'MON':
			case 'mon_strict':

			// Extract three characters from dateStr and parse them as 
			// lower-case, mixed-case, or upper-case abbreviated months,
			// as appropriate.
			monPat=monPatArr[tokArr[tokInd].token];
			if (dateStr.substr(strInd,3).search(monPat) != -1) 
			{
				intMonth=lowerMonArr[dateStr.substr(strInd,3).toLowerCase()];
			}
			else 
			{
				// Bad month, return error.
				switch (tokArr[tokInd].token) 
				{
					case 'mon_strict': caseStat="lower-case"; break;
					case 'Mon': caseStat="mixed-case"; break;
					case 'MON': caseStat="upper-case"; break;
					case 'mon': caseStat="between Jan and Dec"; break;
				}
				return "Bad month \"" + dateStr.substr(strInd,3) + "\". Must be " + caseStat + ".";
			}
			strOffset=3;
			break;
			case 'month':
			case 'Month':
			case 'MONTH':
			case 'month_strict':
			// Extract a full month name at strInd from dateStr if possible.

			monPat=monthPatArr[tokArr[tokInd].token];
			matchArray=dateStr.substr(strInd).match(monPat);
			if (matchArray==null) 
			{
				// Bad month, return error.
				return "Can't find a month beginning at \"" + dateStr.substr(strInd) + "\".";
			}

			// It's a good month.
			intMonth=lowerMonArr[matchArray[0].substr(0,3).toLowerCase()];
			strOffset=matchArray[0].length;
			break;
			case 'ampm':
			case 'AMPM':
			matchArr=dateStr.substr(strInd).match(/^(am|pm|AM|PM|a\.m\.|p\.m\.|A\.M\.|P\.M\.)/);
			if (matchArr==null) 
			{
				// There's no am/pm in the string.Return error msg.
				return "Missing am/pm designation.";
			}

			// Store am/pm value for later (as just am or pm, to make things
			// easier later).

			if (matchArr[0].substr(0,1).toLowerCase() == "a") 
			{
				// This is am.
				ampm = "am";
			}
			else 
			{
				ampm = "pm";
			}
			strOffset = matchArr[0].length;
			break;
		}
		strInd += strOffset;
		tokInd++;
	}
	if (tokInd != tokArr.length || strInd != dateStr.length) 

	{
		/* We got through the whole date string or format string, but there's 
	 more data in the other, so there's a mismatch. */

		return "\"" + dateStr + "\" is either missing desired information or has more information than the expected format: " + formatStr;
	}

	// Make sure all components are in the right ranges.

	if (intMonth < 1 || intMonth > 12) 
	{
		return "Month must be between 1 and 12.";
	}
	if (intDay < 1 || intDay > 31) 
	{
		return "Day must be between 1 and 31.";
	}

	// Make sure user doesn't put 31 for a month that only has 30 days
	if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && intDay == 31) 
	{
		return "Month "+intMonth+" doesn't have 31 days!";
	}

	// Check for February date validity (including leap years) 

	if (intMonth == 2) 
	{
		// figure out if "year" is a leap year; don't forget that
		// century years are only leap years if divisible by 400

		var isleap=(intYear%4==0 && (intYear%100!=0 || intYear%400==0));
		if (intDay > 29 || (intDay == 29 && !isleap)) 
		{
			return "February " + intYear + " doesn't have " + intDay + " days!";
		}
	}

	// Check that if am/pm is not provided, hours are between 0 and 23.
	if (ampm == "") 
	{
		if (intHour < 0 || intHour > 23) 
		{
			return "Hour must be between 0 and 23 for military time.";
		}
	}
	else 
	{
		// non-military time, so make sure it's between 1 and 12.

		if (intHour < 1|| intHour > 12) 
		{
			return "Hour must be between 1 and 12 for standard time.";
		}
	}

	// If user specified amor pm, convert intHour to military.
	if (ampm=="am" && intHour==12) 
	{
		intHour=0;
	}
	if (ampm=="pm" && intHour < 12) 
	{
		intHour += 12;
	}
	if (intMin < 0 || intMin > 59) 
	{
		return "Minute must be between 0 and 59.";
	}
	if (intSec < 0 || intSec > 59) 
	{
		return "Second must be between 0 and 59.";
	}
	return new Date(intYear,intMonth-1,intDay,intHour,intMin,intSec);
}


function dateCheck(dateStr,formatStr) 
{
	var myObj = buildDate(dateStr,formatStr);
	if (typeof myObj == "object") 
	{
		// We got a Date object, so good.
		return true;
	}
	else 
	{
		// We got an error string.
		//alert(myObj);
		return false;
	}
}

//Converts the First letter of each word to upper case and rest of the letters to lower case
function changeCase(frmObj) 
{
	var index;
	var tmpStr;
	var tmpChar;
	var preString;
	var postString;
	var strlen;
	tmpStr = frmObj.value.toLowerCase();
	strLen = tmpStr.length;
	if (strLen > 0)  
	{
		for (index = 0; index < strLen; index++)  
		{
			if (index == 0)  
			{
				tmpChar = tmpStr.substring(0,1).toUpperCase();
				postString = tmpStr.substring(1,strLen);
				tmpStr = tmpChar + postString;
			}
			else 
			{
				tmpChar = tmpStr.substring(index, index+1);
				if (tmpChar == " " && index < (strLen-1))  
				{
					
					tmpChar = tmpStr.substring(index+1, index+2).toUpperCase();
					preString = tmpStr.substring(0, index+1);
					postString = tmpStr.substring(index+2,strLen);
					tmpStr = preString + tmpChar + postString;
		        }
			}
		}
	}
	frmObj.value = tmpStr;
}


//Checks the text in text area has exceeded the Maximum length allowed for the field
function checkLength(control,maxLength)
{
	if(control.type=='textarea')
	{
		var str = control.value;
		var len = str.replace(/\r\n/g,'').length;
		var sChangedName = control.name.substring(3);
		sChangedName = getFormattedmsg(sChangedName);
		if(len>maxLength)
		{
			alert("Pleart Enter less than "+maxLength+" characters for "+sChangedName);
			control.focus();
			return false;
		}
		else
			return true;
	}
	else
		return false;
}

function isInteger(s)
{   var i;
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}

function stripCharsInBag(s, bag)
{   
	var i;
    var returnString = "";
    // Search through string's characters one by one.
    // If character is not in bag, append to returnString.
    for (i = 0; i < s.length; i++)
    {   
        // Check that current character isn't whitespace.
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1) returnString += c;
    }
    return returnString;
}

function checkInternationalPhone(strPhone){
	s=stripCharsInBag(strPhone,validWorldPhoneChars);
	return (isInteger(s) && s.length >= minDigitsInIPhoneNumber);
}

function validphone(str)
{
	validphone=/^\(*[0-9]{3}\)*[[:space:]][0-9]{3}-*[0-9]{4}$/;
	if (str.match(validphone)) {
		alert("valid");
   		return true;
 	} else {
		alert("Not valid");
 		return false;
 	}

}

function FormatNumber(num, decimalNum)
{
	return num.toFixed(decimalNum);
}

//Date Comparision
function dateCompare(stDate, etDate, dSeperator){

stDate = stDate.replace(/dSeperator/,"/");
stDate = stDate.replace(dSeperator,"/");
etDate = etDate.replace(dSeperator,'/');
etDate = etDate.replace(dSeperator,'/');

  var sDate = new Date(stDate);
  var eDate = new Date(etDate);
  if (sDate >eDate){
    return 1;
  }else if (sDate < eDate){
    return -1;
  }else{
	return 0;
  }
}

// ----------------------------------------------------------------------------------------------

///////////////////////////////////////////////////////////////////////////////////////////////////

function getDateObject(dateString,dateSeperator)
{
	//This function return a date object after accepting 
	//a date string ans dateseparator as arguments
	var curValue=dateString;
	var sepChar=dateSeperator;
	var curPos=0;
	var cDate,cMonth,cYear;

	//extract day portion
	curPos=dateString.indexOf(sepChar);
	cDate=dateString.substring(0,curPos);
	
	//extract month portion				
	endPos=dateString.indexOf(sepChar,curPos+1);			cMonth=dateString.substring(curPos+1,endPos);

	//extract year portion				
	curPos=endPos;
	endPos=curPos+5;			
	cYear=curValue.substring(curPos+1,endPos);
	
	//Create Date Object
	var dtObject='';
	if(dateString!='')
		dtObject=new Date(cYear,cMonth-1,cDate);	

	return dtObject;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
function href_window(param)
{
	window.location.href = param;
}

function validate_pagenumber(obj, cur_file , sort_by, sort_order , search_words , check_where , totalpages , param)
{
	if(isNaN(obj.page_number.value))
	{
		alert('Please enter Numeric value for Page Number.');
		obj.page_number.select();
		return false;
	}

	if(parseInt(obj.page_number.value) < 1 || parseInt(obj.page_number.value) > parseInt(totalpages))
	{
		alert('Please enter Valid value for Page Number.');
		obj.page_number.select();
		return false;
	}

	var loc_href = cur_file + '?page_number=' + obj.page_number.value + '&sort_by=' + sort_by + '&sort_order=' + sort_order + '&search_words=' + search_words + '&check_where=' + check_where + '&' + param;
	
	window.location.href = loc_href;
	return false;
}

function validate_pagenumber_key(obj, cur_file , sort_by, sort_order , search_words , check_where , totalpages , param)
{
	if (document.layers)
	  	document.captureEvents(Event.KEYPRESS);
			
	document.onkeypress = function (evt)
						{
							var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
							
							if (keyCode == 13)
							{
								validate_pagenumber(obj, cur_file , sort_by, sort_order , search_words , check_where , totalpages , param);
								return false;
							}
							else
								return true;
						};
}

function openclose(vals)
{
	if(vals=="general_poll"){
		document.getElementById('general_poll').style.display="block";
		document.getElementById('notes').style.display="block";
		document.getElementById('BabyPhoto').style.display="none";
		document.getElementById('TN_baby_image').value="";
		document.getElementById('picture_poll').style.display="none";
	}
	else if(vals=="picture_poll"){
		for(i=0;i<5;i++){
			if(document.getElementById('gen_choice'+i))
			document.getElementById('gen_choice'+i).value="";
		}
		document.getElementById('general_poll').style.display="none";
		document.getElementById('picture_poll').style.display="block";
		document.getElementById('notes').style.display="none";
		
	}
}

function closeall()
{
	for(i = 0; i < 50; i++)
	{
		var tab = document.getElementById('tbl' + i);
		
		if(tab)
		{
			tab.style.display = 'none';
		}
	}
}

function FocusFirstTextInput()
{
	for(var d=0; d<document.getElementsByTagName('input').length; d++)
	{
		if(document.getElementsByTagName('input')[d])
		{
			if(document.getElementsByTagName('input')[d].type == 'text' && document.getElementsByTagName('input')[d].disabled == false)
			{
				document.getElementsByTagName('input')[d].focus();
				break;
			}
		}
	}
}

//window.onload = FocusFirstTextInput;

// JavaScript Document

function move(f,bDir,sName) {

  var el = f.elements[sName];
  var idx = el.selectedIndex;
  if (idx==-1) 
    alert("You must first select the item to reorder.");
  else {
    var nxidx = idx+( bDir? -1 : 1);
	if((nxidx>-1) && (nxidx<el.length))
	{
    if (nxidx<0) nxidx=el.length-1;
    if (nxidx>=el.length) nxidx=0;
    var oldVal = el[idx].value;
    var oldText = el[idx].text;
    el[idx].value = el[nxidx].value;
    el[idx].text = el[nxidx].text;
    el[nxidx].value = oldVal;
    el[nxidx].text = oldText;
    el.selectedIndex = nxidx;
	}
  }

}

function processForm(f) {
    // If reorder listbox, then generate value for hidden field
     
	 var strIDs = "";
      for (var j=0;j<f.cat_id.options.length;j++)
	  {
    	if (strIDs=="")
			strIDs = f.cat_id.options[j].value;
		else
			strIDs += "," + f.cat_id.options[j].value;
	  }
	 document.frm.action="manage_contents_order.php?act=set&cat_ids="+strIDs;
	 document.frm.submit();
}

function doBlink()
{
	var blink = document.all.tags("BLINK");
	
	for (var i=0; i < blink.length; i++)
	{
		blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "";
	}	
}

function startBlink()
{
	if (document.all)
	{
		setInterval("doBlink()", 800);
	}	
}

//startBlink();

function mover(obj,list1,list2, move)
{
	var flag = false;
	
	if(move == 'a')
	{
		for(i=0; i<list1.length; i++)
		{
			if(list1.options[i].selected)
			{				
				var index = list2.options.length;
					
				list2.options[index] = new Option;

				list2.options[index].value = list1.options[i].value;

				list2.options[index].text = list1.options[i].text;				

				list1.options[i]=null;
				
				i=-1;
				
				flag = true;
			}
		}
		
		if(flag == false)
		{
			//alert('Please select at least one record to be moved to Selected Email list.');
		}
	}
	else if(move == 'r')
	{
		var str_cat;
		
		for(i=0; i<list2.length; i++)
		{
			if(list2.options[i].selected)
			{
				var index = list1.options.length;
				
				list1.options[index] = new Option;

				list1.options[index].value = list2.options[i].value;

				list1.options[index].text = list2.options[i].text;				

				list2.options[i]=null;
				
				i=-1;
				
				flag = true;
			}
		}
		
		if(flag == false)
		{
			//alert('Please select at least one record to be moved to Available Mailing list.');
		}
	}
}

function ShowPreview(obj,val,Imgval)
{
	if ( ValidateBanner(val))
	{
		var iPos = val.value.lastIndexOf(".")
		var sExt = val.value.substring(iPos);
		var altImg=eval('document.'+Imgval);
		
		altImg.src = val.value;
		altImg.style.display = "";
	
	}
}

function ValidateBanner(ctrl , type)
{
	if (ctrl.value.length)
	{
		var iPos = ctrl.value.lastIndexOf(".")
		var sExt = ctrl.value.substring(iPos);
		
		if(type == "i")
		{
			if((sExt.toUpperCase()=='.JPEG') || (sExt.toUpperCase()=='.JPG') || (sExt.toUpperCase()=='.GIF') || (sExt.toUpperCase()=='.BMP') || (sExt.toUpperCase()=='.PNG'))
			{
				return true;
			}
			else
			{
				alert("Please enter valid banner.");
				ctrl.focus();
				ctrl.select();
				return false;
			}
		}
		else if(type == "f")
		{
			if((sExt.toUpperCase()=='.SWF') || (sExt.toUpperCase()=='.FLA'))
			{
				return true;
			}
			else
			{
				alert("Please enter valid banner.");
				ctrl.focus();
				ctrl.select();
				return false;
			}
		}
	}
	else
	{
		alert("Please select the banner to be uploaded");
		ctrl.focus();
		ctrl.select();
		return false;
	}
}

function delete_list_record(chk_ids , page_number , sort_by , sort_order , search_words , check_where)
{
	if(confirm('Do you really want to delete the selected record(s)?\nIt will delete all the related record(s) under other modules.\nClick \'OK\' to continue and \'Cancel\' to stop.'))
	{
		var delete_location = '<?=$cur_file?>?task=Delete&chk_ids=' + chk_ids + '&page_number=' + page_number + '&sort_by=' + sort_by + '&sort_order=' + sort_order + '&search_words=' + search_words + '&check_where=' + check_where + '&<?=$param?>';

		window.location.href = delete_location;
	}
}
function SetMaxLength(obj ,id,val , Max_Char)
{
	var ctrl_length =val.length;

	var ctrlval = document.getElementById(id).value;
	
	
	if (ctrl_length <= Max_Char){
		if(document.getElementById('max_char')){
			document.getElementById('max_char').innerHTML = eval(Max_Char - ctrl_length);
		}
	}else{
		document.getElementById(id).value= ctrlval.substring(0 , Max_Char);
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



//<!-- TWO STEPS TO INSTALL VALIDATION (DATE):

//  1.  Copy the coding into the HEAD of your HTML document
//  2.  Add the last code into the BODY of your HTML document  -->

//<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

//<HEAD>

//<SCRIPT LANGUAGE="JavaScript">
//<!-- Original:  Mike Welagen (welagenm@hotmail.com) -->

//<!-- This script and many more are available free online at -->
//<!-- The JavaScript Source!! http://javascript.internet.com -->

//<!-- Begin
function checkdate(objName) {
var datefield = objName;
if (chkdate(objName) == false) {
datefield.select();
alert("That date is invalid.  Please try again.");
datefield.focus();
return false;
}
else {
return true;
   }
}
function chkdate(objName) {
var strDatestyle = "US"; //United States date style
//var strDatestyle = "EU";  //European date style
var strDate;
var strDateArray;
var strDay;
var strMonth;
var strYear;
var intday;
var intMonth;
var intYear;
var booFound = false;
var datefield = objName;
var strSeparatorArray = new Array("-"," ","/",".");
var intElementNr;
var err = 0;
var strMonthArray = new Array(12);
strMonthArray[0] = "Jan";
strMonthArray[1] = "Feb";
strMonthArray[2] = "Mar";
strMonthArray[3] = "Apr";
strMonthArray[4] = "May";
strMonthArray[5] = "Jun";
strMonthArray[6] = "Jul";
strMonthArray[7] = "Aug";
strMonthArray[8] = "Sep";
strMonthArray[9] = "Oct";
strMonthArray[10] = "Nov";
strMonthArray[11] = "Dec";
strDate = datefield.value;
if (strDate.length < 1) {
return true;
}
for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
strDateArray = strDate.split(strSeparatorArray[intElementNr]);
if (strDateArray.length != 3) {
err = 1;
return false;
}
else {
strDay = strDateArray[0];
strMonth = strDateArray[1];
strYear = strDateArray[2];
}
booFound = true;
   }
}
if (booFound == false) {
if (strDate.length>5) {
strDay = strDate.substr(0, 2);
strMonth = strDate.substr(2, 2);
strYear = strDate.substr(4);
   }
}
if (strYear.length == 2) {
strYear = '20' + strYear;
}
// US style
if (strDatestyle == "US") {
strTemp = strDay;
strDay = strMonth;
strMonth = strTemp;
}
intday = parseInt(strDay, 10);
if (isNaN(intday)) {
err = 2;
return false;
}
intMonth = parseInt(strMonth, 10);
if (isNaN(intMonth)) {
for (i = 0;i<12;i++) {
if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
intMonth = i+1;
strMonth = strMonthArray[i];
i = 12;
   }
}
if (isNaN(intMonth)) {
err = 3;
return false;
   }
}
intYear = parseInt(strYear, 10);
if (isNaN(intYear)) {
err = 4;
return false;
}
if (intMonth>12 || intMonth<1) {
err = 5;
return false;
}
if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
err = 6;
return false;
}
if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
err = 7;
return false;
}
if (intMonth == 2) {
if (intday < 1) {
err = 8;
return false;
}
if (LeapYear(intYear) == true) {
if (intday > 29) {
err = 9;
return false;
}
}
else {
if (intday > 28) {
err = 10;
return false;
}
}
}
if (strDatestyle == "US") {
datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
}
else {
datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
}
return true;
}
function LeapYear(intYear) {
if (intYear % 100 == 0) {
if (intYear % 400 == 0) { return true; }
}
else {
if ((intYear % 4) == 0) { return true; }
}
return false;
}
function doDateCheck(from, to) {
if (Date.parse(from.value) <= Date.parse(to.value)) {
alert("The dates are valid.");
}
else {
if (from.value == "" || to.value == "") 
alert("Both dates must be entered.");
else 
alert("To date must occur after the from date.");
   }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////